<?php

namespace App\Http\Requests;

use App\Enums\CharacterStat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class TalentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:256', Rule::unique('skills')->ignore($this->name, 'name')],
            'description' => ['required', 'max:2048'],
            'cost' => ['required', 'min:1', 'max:100'],
        ];
    }
}
