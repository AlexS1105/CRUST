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

    public function prepareForValidation()
    {
        $this->merge([
            'discord_notify' => $this->discord_notify == 'on',
        ]);
    }

    public function rules()
    {
        return [
            'login' => ['required', 'max:255', Rule::unique('users')->ignore($this->user->login, 'login')],
            'discord_notify' => ['boolean']
        ];
    }
}
