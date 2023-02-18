<?php

namespace App\Http\Requests;

use App\Rules\SkillPool;
use App\Services\CharsheetService;
use Illuminate\Foundation\Http\FormRequest;

class CharacterSkillsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'skills' => app(CharsheetService::class)->convertSkills($this->skills),
        ]);
    }

    public function rules()
    {
        $character = $this->route('character');

        return [
            'skills' => [new SkillPool($character)],
            'skill_points' => ['numeric', 'min:0', 'max:200'],
        ];
    }
}
