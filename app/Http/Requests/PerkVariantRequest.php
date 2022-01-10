<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerkVariantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => ['required', 'max:5096']
        ];
    }
}
