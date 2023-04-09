<?php

namespace App\Http\Requests;

use App\Enums\Tide;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class CharacterExperienceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'experience' => ['required', 'min:0'],
        ];
    }
}
