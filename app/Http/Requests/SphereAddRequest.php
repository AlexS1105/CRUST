<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SphereAddRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'value' => ['required', 'min:1', 'max:100'],
        ];
    }
}
