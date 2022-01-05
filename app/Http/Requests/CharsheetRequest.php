<?php

namespace App\Http\Requests;

use App\Enums\CharacterCraft;
use App\Enums\CharacterSkill;
use App\Models\PerkVariant;
use App\Rules\CraftPool;
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
        
        $perks = [];

        if (isset($this->perks)) {
            foreach($this->perks as $perkId => $perkData) {
                if ($perkData['id'] != "-1") {
                    $perks[$perkId] = [
                        'variant' => PerkVariant::with('perk')->find(intval($perkData['id'])),
                        'cost_offset' => intval($perkData['cost_offset']),
                        'note' => $perkData['note']
                    ];
                }
            }
        }

        $this->merge([
            'skills' => $skills,
            'crafts' => $crafts,
            'narrative_crafts' => $narrative_crafts,
            'perks' => $perks
        ]);
    }

    public function rules()
    {
        return [
            'skills' => ['required', new SkillPool],
            'skills.*' => ['numeric', 'min:0', 'max:10'],
            'crafts' => ['required', new CraftPool($this->skills)],
            'crafts.*' => ['numeric', 'min:0', 'max:3'],
            'narrative_crafts' => [new NarrativeCraftsPool($this->skills)],
            'narrative_crafts.*.name' => ['required'],
            'narrative_crafts.*.description' => ['required'],
            'perks' => ['required', new PerkPool]
        ];
    }
}
