<?php

namespace App\Http\Requests;

use App\Rules\TalentPool;
use App\Services\CharsheetService;
use Illuminate\Foundation\Http\FormRequest;

class CharacterTalentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'perks' => app(CharsheetService::class)->convertTalents($this->talents),
        ]);
    }

    public function rules()
    {
        $character = $this->route('character');

        return [
            'talents' => [new TalentPool($character)],
            'talent_points' => ['numeric', 'min:0', 'max:200'],
        ];
    }
}
