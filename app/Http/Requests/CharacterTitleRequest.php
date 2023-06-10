<?php

namespace App\Http\Requests;

use App\Enums\CharacterTitle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CharacterTitleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title' => ['required', new Enum(CharacterTitle::class)],
        ];
    }
}
