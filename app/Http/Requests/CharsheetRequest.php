<?php

namespace App\Http\Requests;

use App\Enums\CharacterCraft;
use App\Enums\CharacterSkill;
use App\Enums\FateType;
use App\Models\PerkVariant;
use App\Rules\CraftPool;
use App\Rules\Fates;
use App\Rules\PerkPool;
use App\Rules\SkillPool;
use Illuminate\Foundation\Http\FormRequest;

class CharsheetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $perksCollection = PerkVariant::with('perk')->get();
        $perks = [];

        if (isset($this->perks)) {
            foreach ($this->perks as $perkId => $perkData) {
                if ($perkData['id'] !== '-1') {
                    $perks[$perkId] = [
                        'variant' => $perksCollection->firstWhere('id', intval($perkData['id'])),
                        'note' => $perkData['note'],
                        'active' => isset($perkData['active']) && $perkData['active'] === 'on',
                    ];
                }
            }
        }

        $fates = [];

        if (isset($this->fates)) {
            foreach ($this->fates as $fate) {
                $fateType = FateType::None();

                if (isset($fate['continious']) && $fate['continious'] === 'on') {
                    $fateType->addFlag(FateType::Continious);
                }

                if (isset($fate['ambition']) && $fate['ambition'] === 'on') {
                    $fateType->addFlag(FateType::Ambition);
                }

                if (isset($fate['flaw']) && $fate['flaw'] === 'on') {
                    $fateType->addFlag(FateType::Flaw);
                }

                array_push($fates, [
                    'text' => $fate['text'],
                    'type' => $fateType !== FateType::None() ? $fateType : null,
                ]);
            }
        }

        $this->merge([
            'perks' => $perks,
            'fates' => $fates,
        ]);
    }

    public function rules()
    {
        $rules = [
            'skills' => ['required', new SkillPool()],
            'skills.*' => ['numeric', 'min:0', 'max:10'],
            'crafts' => [new CraftPool($this->skills, $this->narrative_crafts)],
            'crafts.*' => ['numeric', 'min:0', 'max:3'],
            'narrative_crafts.*.name' => ['required', 'max:256'],
            'narrative_crafts.*.description' => ['required', 'max:1024'],
        ];

        $character = $this->route('character');

        if (! $character->registered) {
            $rules = array_merge($rules, [
                'perks' => [new PerkPool(false)],
                'fates' => [new Fates(false)],
                'fates.*.text' => ['required', 'max:1024'],
                'fates.*.type' => ['required'],
            ]);
        }

        return $rules;
    }
}
