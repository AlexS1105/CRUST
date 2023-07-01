<?php

namespace App\Http\Requests;

use App\Rules\TalentPool;
use App\Rules\TechniquePool;
use App\Services\CharsheetService;
use Illuminate\Foundation\Http\FormRequest;

class CharacterTechniqueRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'techniques' => app(CharsheetService::class)->convertTechniques($this->techniques),
        ]);
    }

    public function rules()
    {
        $character = $this->route('character');

        return [
            'techniques' => [new TechniquePool($character)],
            'technique_points' => ['numeric', 'min:0', 'max:200'],
            'techniques_amount' => ['sometimes', 'min:0', 'max:100'],
        ];
    }
}
