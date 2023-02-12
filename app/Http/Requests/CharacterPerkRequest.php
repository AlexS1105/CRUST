<?php

namespace App\Http\Requests;

use App\Rules\PerkPool;
use App\Services\CharsheetService;
use Illuminate\Foundation\Http\FormRequest;

class CharacterPerkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'perks' => app(CharsheetService::class)->convertPerks($this->perks, true),
        ]);
    }

    public function rules()
    {
        $character = $this->route('character');

        return [
            'perks' => [new PerkPool($character)],
        ];
    }
}
