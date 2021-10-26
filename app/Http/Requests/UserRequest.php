<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login' => ['required', 'max:255', Rule::unique('users')->ignore($this->user->login, 'login')],
        ];
    }
}
