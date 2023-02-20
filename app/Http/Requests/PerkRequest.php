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

    public function rules()
    {
        return [
            'name' => ['required', 'max:256', Rule::unique('perks')->ignore($this->name, 'name')],
            'cost' => ['numeric', 'min:0', 'max:100'],
            'description' => ['max:5096'],
        ];
    }
}
