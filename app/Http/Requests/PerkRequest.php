<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PerkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'combat' => $this->combat === 'on' || $this->attack === 'on' || $this->defence === 'on',
            'attack' => $this->attack === 'on',
            'defence' => $this->defence === 'on'
        ]);
    }

    public function rules()
    {
        $rules = [
            'name' => ['required', 'max:256', Rule::unique('perks')->ignore($this->name, 'name')],
            'combat' => ['present'],
            'attack' => ['present'],
            'defence' => ['present']
        ];

        if ($this->method() != 'PATCH') {
            $rules['description'] = ['required', 'max:5096'];
        }

        return $rules;
    }
}
