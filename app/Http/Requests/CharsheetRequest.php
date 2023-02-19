<?php

namespace App\Http\Requests;

use App\Enums\Tide;
use App\Rules\CraftPool;
use App\Rules\FatesRule;
use App\Rules\PerkPool;
use App\Rules\SkillPool;
use App\Rules\StatPool;
use App\Rules\TalentPool;
use App\Services\CharsheetService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class CharsheetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $charsheetService = resolve(CharsheetService::class);

        $this->merge([
            'perks' => $charsheetService->convertPerks($this->perks),
            'fates' => $charsheetService->convertFates($this->fates),
            'skills' => $charsheetService->convertSkills($this->skills),
            'stats_handled' => $this->stats_handled === 'on',
            'talents' => $charsheetService->convertTalents($this->talents),
        ]);
    }

    public function rules()
    {
        $character = $this->route('character');

        $rules = [
            'stats' => ['required', new StatPool($character)],
            'stats.*' => ['numeric', 'min:1'],
            'crafts' => [new CraftPool($this->skills, $this->narrative_crafts)],
            'crafts.*' => ['numeric', 'min:0', 'max:3'],
            'narrative_crafts.*.name' => ['required', 'max:256'],
            'narrative_crafts.*.description' => ['required', 'max:1024'],
            'skills' => [new SkillPool($character)],
        ];

        if (! $character->registered) {
            $rules = array_merge($rules, [
                'perks' => [new PerkPool($character)],
                'perks.*.note' => ['max:1024'],
                'fates' => [new FatesRule()],
                'fates.*.text' => ['required', 'max:1024'],
                'fates.*.ambition' => ['required_without:fates.*.flaw', 'nullable'],
                'fates.*.flaw' => ['required_without:fates.*.ambition', 'nullable'],
                'talents' => [new TalentPool($character)],
                'tides.*.path' => ['sometimes', 'max:512'],
                'tides.*.tide' => ['required', new In(array_map(fn($tide) => $tide->value, Tide::cases()))],
            ]);
        }

        if (auth()->user()->can('update-charsheet-gm', $character)) {
            $rules = array_merge($rules, [
                'stats_handled' => ['sometimes', 'boolean'],
                'perk_points' => ['numeric', 'min:0', 'max:100'],
                'talent_points' => ['numeric', 'min:0', 'max:100'],
                'tides.*.level' => ['min:0', 'max:1000'],
            ]);
        }

        return $rules;
    }
}
