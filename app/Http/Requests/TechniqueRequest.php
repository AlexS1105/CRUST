<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TechniqueRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:256', Rule::unique('techniques')->ignore($this->name, 'name')],
            'description' => ['required', 'max:2048'],
        ];
    }
}
