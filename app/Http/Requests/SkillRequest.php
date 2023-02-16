<?php

namespace App\Http\Requests;

use App\Enums\CharacterStat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class SkillRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'proficiency' => $this->proficiency === 'on',
        ]);
    }

    public function rules()
    {
        return [
            'proficiency' => ['boolean'],
            'name' => ['required', 'max:256', Rule::unique('skills')->ignore($this->name, 'name')],
            'description' => ['required', 'max:2048'],
            'stat' => ['required', new Enum(CharacterStat::class)],
        ];
    }
}
