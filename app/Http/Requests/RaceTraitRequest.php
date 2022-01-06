<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RaceTraitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'subtrait' => $this->subtrait === 'on'
        ]);
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:256', Rule::unique('race_traits')->ignore($this->name, 'name')],
            'description' => ['required', 'max:1024'],
            'races' => ['required', 'max:512'],
            'subtrait' => ['present']
        ];
    }
}
