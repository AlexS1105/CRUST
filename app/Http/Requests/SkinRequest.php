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
            'skin' => ['required','image', 'mimes:png'],
            'prefix' => ['nullable', 'max:100'],
        ];
    }
}
