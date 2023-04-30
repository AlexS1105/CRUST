<?php

namespace App\Http\Requests;

use App\Enums\Tide;
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
            'skills' => $charsheetService->convertSkills($this->skills),
            'stats_handled' => $this->stats_handled === 'on',
            'talents' => $charsheetService->convertTalents($this->talents),
            'estitence_reduce' => $this->estitence_reduce === 'on',
        ]);
    }

    public function rules()
    {
        $character = $this->route('character');

        $rules = [
            'stats' => ['required', new StatPool($character)],
            'stats.*' => ['numeric', 'min:1'],
            'skills' => [new SkillPool($character)],
        ];

        if (! $character->registered) {
            $rules = array_merge($rules, [
                'perks' => [new PerkPool($character)],
                'perks.*.note' => ['max:1024'],
                'talents' => [new TalentPool($character)],
                'tides.*.path' => ['sometimes', 'max:512'],
                'tides.*.tide' => ['required', new In(array_map(fn ($tide) => $tide->value, Tide::cases()))],
            ]);
        }

        if (auth()->user()->can('update-charsheet-gm', $character)) {
            $rules = array_merge($rules, [
                'stats_handled' => ['sometimes', 'boolean'],
                'perk_points' => ['numeric', 'min:0', 'max:100'],
                'talent_points' => ['numeric', 'min:0', 'max:100'],
                'tides.*.level' => ['min:0', 'max:1000'],
                'estitence_reduce' => ['sometimes', 'boolean'],
            ]);
        }

        return $rules;
    }
}
