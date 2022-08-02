<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:256'],
            'description' => ['max:512'],
            'value' => ['integer', 'min:0', 'max:10']
        ];
    }
}
