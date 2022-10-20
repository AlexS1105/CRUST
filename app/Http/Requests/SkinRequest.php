<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkinRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'skins' => ['array', 'required'],
            'prefix' => ['array', 'required'],
            'skins.*' => ['required', 'image', 'mimes:png'],
            'prefix.*' => ['nullable', 'max:100', 'alpha_dash'],
        ];
    }
}
