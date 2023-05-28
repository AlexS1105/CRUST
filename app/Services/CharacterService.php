<?php

namespace App\Services;

use App\Enums\CharacterStat;
use App\Enums\CharacterStatus;
use App\Enums\Tide;
use App\Events\CharacterCompletelyDeleted;
use App\Events\CharacterDeleted;
use App\Models\Character;
use App\Models\Skill;
use App\Settings\CharsheetSettings;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CharacterService
{
    public function __construct(protected CharsheetSettings $settings)
    {
    }

    public function create($request)
    {
        $validated = $request->validated();
        $character = $request->user()->characters()->create($validated);
        $character->charsheet()->create();
        $character->tides()->createMany(array_map(fn ($tide) => [
            'tide' => $tide->value,
            'level' => 0,
        ], Tide::cases()));

        $this->saveReference($character, $validated);
        $this->resetStartPoints($character);

        return $character;
    }

    public function saveReference($character, $validated)
    {
        if (isset($validated['reference'])) {
            $this->deleteReferences($character);
            $file = $validated['reference'];
            Storage::disk('characters')->putFileAs($character->id, $file, 'reference');
        }
    }

    public function deleteReferences($character)
    {
        $disk = Storage::disk('characters');

        foreach ($disk->files($character->id) as $file) {
            if (Str::startsWith(basename($file), 'reference')) {
                $disk->delete($file);
            }
        }
    }

    public function delete($character)
    {
        $character->status = CharacterStatus::Deleting;
        $character->save();

        event(new CharacterDeleted($character));
    }

    public function resizeReference($fileName, $size)
    {
        $type = mime_content_type(public_path('storage/characters/' . $fileName));
        $disk = Storage::disk('characters');
        $img = Image::make($disk->get($fileName));
        $img->resize($size, $size, function ($constraint) {
            $constraint->aspectRatio();
        });
        $disk->put($fileName.'_'.$size, $img->encode($type));
    }

    public function update($character, $request)
    {
        $validated = $request->validated();

        $character->update($validated);

        $this->saveReference($character, $validated);

        if (! $character->registered && $character->wasChanged('origin')) {
            $this->resetStartPoints($character);
        }
    }

    public function restore($character)
    {
        $character->status = CharacterStatus::Blank;
        $character->save();
    }

    public function forceDelete($character)
    {
        event(new CharacterCompletelyDeleted($character));

        $character->delete();
    }

    public function resetStartPoints($character)
    {
        if ($character->registered) {
            return;
        }

        $character->estitence = $this->settings->default_estitence;

        if ($character->should_receive_additional_estitence) {
            $character->estitence += $this->settings->additional_estitence;
        }

        $character->estitence += $character->estitenceLogs->sum('delta');

        $character->perk_points = $this->settings->perk_points;

        if ($character->should_receive_additional_perk_points) {
            $character->perk_points += $this->settings->additional_perk_points;
        }

        $character->skill_points = $this->settings->skill_points;

        if ($character->should_receive_additional_skill_points) {
            $character->skill_points += $this->settings->additional_skill_points;
        }

        $character->talent_points = $this->settings->talent_points;

        if ($character->should_receive_additional_talent_points) {
            $character->talent_points += $this->settings->additional_talent_points;
        }

        $character->technique_points = $this->settings->technique_points;

        if ($character->should_receive_additional_technique_points) {
            $character->technique_points += $this->settings->additional_technique_points;
        }

        $character->save();
    }

    public function syncCharsheet(Character $character)
    {
        $charsheet = $character->charsheet;

        if ($charsheet == null) {
            return;
        }

        $characterSkills = $character->skills;

        $charsheet->estitence = $character->estitence;
        $charsheet->skills = Skill::all()->sortByStat()->map(function ($skill) use ($characterSkills) {
            $characterSkill = $characterSkills->firstWhere('id', $skill->id);

            if ($characterSkill == null && $skill->proficiency) {
                return null;
            }

            if ($characterSkill != null) {
                $skill = $characterSkill;
            }

            return [
                'name' => $skill->name,
                'level' => $skill->pivot?->level ?? 0,
                'stat' => $skill->stat->toMore(),
                'proficiency' => boolval($skill->proficiency),
            ];
        })->values()->toArray();
        $charsheet->save();
    }

    public function getSkills(Character $character)
    {
        $characterSkillsIds = $character->skills->pluck('id');
        $characterSkills = Skill::with('advantages')
            ->where('proficiency', false)
            ->orWhereIn('id', $characterSkillsIds)
            ->get()
            ->groupBy('stat.value')
            ->sortBy(fn ($items, $key) => CharacterStat::from($key)->order());

        foreach ($characterSkills as $stat => $skills) {
            $characterSkills->put($stat, $skills->sortBy('name')
                ->sortByDesc(fn ($item) => $characterSkillsIds->contains($item->id)));
        }

        return $characterSkills;
    }
}
