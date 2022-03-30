<?php

namespace App\Http\Requests;

use App\Enums\CharacterGender;
use Illuminate\Foundation\Http\FormRequest;
use BenSampo\Enum\Rules\Enum;

class CharacterRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'gender' => CharacterGender::fromKey($this->gender),
            'info_hidden' => $this->info_hidden === 'on',
            'bio_hidden' => $this->bio_hidden === 'on'
        ]);
    }

    public function rules()
    {
        $rules = [
            'name' => ['required', 'max:100'],
            'description' => ['required', 'max:512'],
            'reference' => ['image'],
            'gender' => ['required', new Enum(CharacterGender::class)],
            'race' => ['required', 'max:100'],
            'age' => ['required', 'max:100'],
            'appearance' => ['max:10000'],
            'personality' => ['nullable'],
            'background' => ['nullable'],
            'info_hidden' => ['boolean'],
            'bio_hidden' => ['boolean'],
            'player_only_info' => ['nullable'],
            'gm_only_info' => ['nullable']
        ];
        
        $character = $this->route('character');

        if ($this->method() == 'POST' || !$character->registered) {
            $rules['login'] = ['required', 'unique:characters,login', 'max:16'];
        }

        return $rules;
    }
}
