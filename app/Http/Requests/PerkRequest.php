<?php

namespace App\Http\Requests;

use App\Enums\PerkType;
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
        $type = 0;

        if (isset($this->combat)) {
            $type = PerkType::set($type, PerkType::Combat);
        }

        if (isset($this->attack)) {
            $type = PerkType::set($type, PerkType::Attack);
        }

        if (isset($this->defence)) {
            $type = PerkType::set($type, PerkType::Defence);
        }

        $this->merge([
            'type' => $type,
        ]);
    }

    public function rules()
    {
        $rules = [
            'name' => ['required', 'max:256', Rule::unique('perks')->ignore($this->name, 'name')],
            'general_description' => ['max:5096'],
            'type' => ['required'],
        ];

        if (! $this->isMethod('PATCH')) {
            $rules['description'] = ['required', 'max:5096'];
        }

        return $rules;
    }
}
