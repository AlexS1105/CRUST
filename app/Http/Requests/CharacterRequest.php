<?php

namespace App\Http\Requests;

use App\Enums\CharacterOrigin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CharacterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'info_hidden' => $this->info_hidden === 'on',
            'bio_hidden' => $this->bio_hidden === 'on',
        ]);
    }

    public function rules()
    {
        $rules = [
            'name' => ['required', 'max:100'],
            'description' => ['required', 'max:512'],
            'reference' => ['nullable', 'mimes:png,jpg,jpeg,bmp,svg,webp'],
            'origin' => ['required', new Enum(CharacterOrigin::class)],
            'race' => ['required', 'max:100'],
            'age' => ['required', 'max:100'],
            'legacy' => ['required', 'max:100'],
            'appearance' => ['max:10000'],
            'personality' => ['nullable'],
            'background' => ['nullable'],
            'info_hidden' => ['boolean'],
            'bio_hidden' => ['boolean'],
            'player_only_info' => ['nullable'],
            'gm_only_info' => ['nullable'],
        ];

        $character = $this->route('character');

        if ($this->isMethod('POST') || ! $character->registered) {
            $rules['login'] = [
                $this->isMethod('POST') ? 'required' : 'sometimes',
                'regex:/^\w{3,16}$/',
                'min:3',
                'max:16',
                $this->isMethod('PATCH') ?
                    Rule::unique('characters', 'login')->ignore($character->id) :
                    Rule::unique('characters', 'login'),
                Rule::unique('accounts', 'login'),
            ];
        }

        return $rules;
    }
}
