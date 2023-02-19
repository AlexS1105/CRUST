<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
