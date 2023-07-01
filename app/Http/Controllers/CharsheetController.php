<?php

namespace App\Http\Controllers;

use App\Enums\CharacterStat;
use App\Http\Requests\CharacterExperienceRequest;
use App\Http\Requests\CharacterPerkRequest;
use App\Http\Requests\CharacterSkillsRequest;
use App\Http\Requests\CharacterStatsRequest;
use App\Http\Requests\CharacterTalentRequest;
use App\Http\Requests\CharacterTechniqueRequest;
use App\Http\Requests\CharacterTideRequest;
use App\Http\Requests\CharsheetRequest;
use App\Models\Character;
use App\Models\Perk;
use App\Models\Skill;
use App\Models\Talent;
use App\Models\Technique;
use App\Services\CharsheetService;
use App\Services\ExperienceService;
use App\Settings\CharsheetSettings;

class CharsheetController extends Controller
{
    public $settings;
    public $charsheetService;

    public function __construct(CharsheetSettings $settings, CharsheetService $charsheetService)
    {
        $this->settings = $settings;
        $this->charsheetService = $charsheetService;
    }

    public function edit(Character $character)
    {
        $this->authorize('update-charsheet', $character);

        $perks = Perk::forCharacter($character)->orderBy('name')->get();
        $skills = Skill::all()
            ->groupBy('stat.value')
            ->sortBy(fn ($skills, $stat) => CharacterStat::from($stat)->order());
        $talents = Talent::forCharacter($character)->orderBy('name')->get();
        $techniques = Technique::forCharacter($character)->orderBy('name')->get();
        $settings = $this->settings;

        return view('characters.charsheet', compact(
            'character',
            'perks',
            'settings',
            'skills',
            'talents',
            'techniques',
        ));
    }

    public function update(CharsheetRequest $request, Character $character)
    {
        $this->authorize('update-charsheet', $character);

        $this->charsheetService->update($character, $request->validated());

        return to_route('characters.show', $character);
    }

    public function editPerks(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $perks = Perk::forCharacter($character)->get();
        $settings = $this->settings;

        return view('characters.perks', compact('character', 'perks', 'settings'));
    }

    public function updatePerks(CharacterPerkRequest $request, Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $this->charsheetService->savePerks($character, $request->validated());

        return to_route('characters.show', $character);
    }

    public function editStats(Character $character)
    {
        $this->authorize('update-stats', $character);

        return view('characters.stats', compact('character'));
    }

    public function updateStats(CharacterStatsRequest $request, Character $character)
    {
        $this->authorize('update-stats', $character);

        $this->charsheetService->saveStats($character, $request->validated());

        return to_route('characters.show', $character);
    }

    public function editSkills(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $skills = Skill::all()
            ->groupBy('stat.value')
            ->sortBy(fn ($skills, $stat) => CharacterStat::from($stat)->order());

        return view('characters.skills', compact('character', 'skills'));
    }

    public function updateSkills(CharacterSkillsRequest $request, Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $this->charsheetService->saveSkills($character, $request->validated());

        return to_route('characters.show', $character);
    }

    public function editTalents(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $talents = Talent::forCharacter($character)->get();
        $settings = $this->settings;

        return view('characters.talents', compact('character', 'talents', 'settings'));
    }

    public function updateTalents(CharacterTalentRequest $request, Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $this->charsheetService->saveTalents($character, $request->validated());

        return to_route('characters.show', $character);
    }

    public function editTechniques(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $techniques = Technique::forCharacter($character)->get();
        $settings = $this->settings;

        return view('characters.techniques', compact('character', 'techniques', 'settings'));
    }

    public function updateTechniques(CharacterTechniqueRequest $request, Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $this->charsheetService->saveTechniques($character, $request->validated());

        return to_route('characters.show', $character);
    }

    public function editTides(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        return view('characters.tides', compact('character'));
    }

    public function updateTides(CharacterTideRequest $request, Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $this->charsheetService->saveTides($character, $request->validated());

        return to_route('characters.show', $character);
    }

    public function editExperience(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        return view('characters.experience.index', compact('character'));
    }

    public function updateExperience(ExperienceService $service, CharacterExperienceRequest $request, Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $service->changeExperience($character, ...$request->validated());

        return to_route('characters.show', $character);
    }
}
