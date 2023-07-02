<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SoulboundRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:256'],
            'description' => ['max:5096'],
            'cost' => ['numeric', 'min:0', 'max:100'],
        ];
    }
}
