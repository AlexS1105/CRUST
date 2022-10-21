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
        $charsheetService = app(CharsheetService::class);

        $this->merge([
            'perks' => $charsheetService->convertPerks($this->perks, true),
        ]);
    }

    public function rules()
    {
        return [
            'perks' => [new PerkPool(true)],
        ];
    }
}
