<?php

namespace App\Http\Requests;

use App\Enums\Tide;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class CharacterTideRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $character = $this->route('character');

        $rules = [
            'tides.*.path' => ['sometimes', 'max:512'],
            'tides.*.tide' => ['required', new In(array_map(fn($tide) => $tide->value, Tide::cases()))],
        ];

        if (auth()->user()->can('update-charsheet-gm', $character)) {
            $rules = array_merge($rules, [
                'tides.*.level' => ['min:0', 'max:1000'],
            ]);
        }

        return $rules;
    }
}
