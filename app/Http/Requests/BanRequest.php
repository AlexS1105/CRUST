<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'expires' => 'required|after:now',
            'reason' => 'required|max:256'
        ];
    }
}
