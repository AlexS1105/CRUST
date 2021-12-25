<?php

namespace App\Http\Requests;

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

        foreach ($this->skills as $skill => $value) {
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
