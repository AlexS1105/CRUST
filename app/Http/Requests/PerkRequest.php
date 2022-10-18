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
        $type = PerkType::None();

        if ($this->combat === 'on') {
            $type->addFlag(PerkType::Combat);
        }

        if ($this->attack === 'on') {
            $type->addFlag(PerkType::Attack);
        }

        if ($this->defence === 'on') {
            $type->addFlag(PerkType::Defence);
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
