<?php

namespace App\Http\Requests;

use App\Enums\CharacterCraft;
use App\Enums\CharacterSkill;
use App\Enums\FateType;
use App\Models\PerkVariant;
use App\Rules\CraftPool;
use App\Rules\Fates;
use App\Rules\NarrativeCraftsPool;
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
        $skills = [];

        foreach (CharacterSkill::getInstances() as $instance) {
            $skill = $instance->key();
            $value = $this->skills[$skill];

            $skills[$skill] = intval($value);
        }

        $crafts = [];

        foreach (CharacterCraft::getInstances() as $instance) {
            $craft = $instance->key();
            $value = $this->crafts[$craft];

            $crafts[$craft] = intval($value);
        }

        $narrative_crafts = [];

        if (isset($this->narrative_crafts)) {
            foreach($this->narrative_crafts as $craft) {
                array_push($narrative_crafts, $craft);
            }
        }
        
        $perksCollection = PerkVariant::with('perk')->get();
        $perks = [];

        if (isset($this->perks)) {
            foreach($this->perks as $perkId => $perkData) {
                if ($perkData['id'] != "-1") {
                    $perks[$perkId] = [
                        'variant' => $perksCollection->firstWhere('id', intval($perkData['id'])),
                        'note' => $perkData['note'],
                        'active' => isset($perkData['active']) && $perkData['active'] === 'on'
                    ];
                }
            }
        }

        $fates = [];

        if (isset($this->fates)) {
            foreach($this->fates as $fate) {
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
                    'type' => $fateType != FateType::None() ? $fateType : null
                ]);
            }
        }

        $this->merge([
            'skills' => $skills,
            'crafts' => $crafts,
            'narrative_crafts' => $narrative_crafts,
            'perks' => $perks,
            'fates' => $fates
        ]);
    }

    public function rules()
    {
        $rules = [
            'skills' => ['required', new SkillPool],
            'skills.*' => ['numeric', 'min:0', 'max:10'],
            'crafts' => [new CraftPool($this->skills, $this->narrative_crafts)],
            'crafts.*' => ['numeric', 'min:0', 'max:3'],
            'narrative_crafts.*.name' => ['required'],
            'narrative_crafts.*.description' => ['required']
        ];

        $character = $this->route('character');

        if (!$character->registered) {
            $rules = array_merge($rules, [
                'perks' => [new PerkPool(false)],
                'fates' => [new Fates(false)],
                'fates.*.text' => ['required', 'max:1024'],
                'fates.*.type' => ['required']
            ]);
        }

        return $rules;
    }
}
