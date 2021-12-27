<?php

namespace App\Http\Requests;

use App\Enums\CharacterSkill;
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

        $this->merge([
            'skills' => $skills
        ]);
    }

    public function rules()
    {
        return [
            'skills' => ['required', new SkillPool],
            'skills.*' => ['numeric', 'min:0', 'max:10']
        ];
    }
}
