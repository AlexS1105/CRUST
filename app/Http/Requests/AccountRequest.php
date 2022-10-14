<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login' => [
                'required',
                'regex:/^\w{3,16}$/',
                'min:3',
                'max:16',
                Rule::unique('accounts', 'login'),
                Rule::unique('characters', 'login'),
            ],
        ];
    }
}
