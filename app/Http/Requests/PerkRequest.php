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
            'combat' => $this->combat === 'on',
            'native' => $this->native === 'on',
            'unique' => $this->unique === 'on'
        ]);
    }

    public function rules()
    {
        $rules = [
            'name' => ['required', 'max:256', Rule::unique('perks')->ignore($this->name, 'name')],
            'cost' => ['required', 'min:0', 'max:50', 'numeric'],
            'combat' => ['present'],
            'native' => ['present'],
            'unique' => ['present']
        ];

        if ($this->method() != 'PATCH') {
            $rules['description'] = ['required', 'max:1024'];
        }

        return $rules;
    }
}
