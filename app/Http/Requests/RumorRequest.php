<?php

namespace App\Http\Requests;

use App\Enums\Tide;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class RumorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'text' => ['required', 'max:256'],
            'tide' => ['required', new In(array_map(fn ($tide) => $tide->value, Tide::cases()))],
        ];
    }
}
