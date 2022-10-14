<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NarrativeCraftRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:256'],
            'description' => ['max:1024'],
        ];
    }
}
