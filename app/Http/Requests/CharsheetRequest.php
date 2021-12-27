<?php

namespace App\Http\Requests;

use App\Enums\CharacterCraft;
use App\Enums\CharacterSkill;
use App\Rules\CraftPool;
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

        $this->merge([
            'skills' => $skills,
            'crafts' => $crafts
        ]);
    }

    public function rules()
    {
        return [
            'skills' => ['required', new SkillPool],
            'skills.*' => ['numeric', 'min:0', 'max:10'],
            'crafts' => ['required', new CraftPool($this->skills)],
            'crafts.*' => ['numeric', 'min:0', 'max:3']
        ];
    }
}
