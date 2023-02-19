<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CharsheetSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'max_perks' => ['integer', 'min:0'],
            'perk_points' => ['integer', 'min:0'],
            'additional_perk_points' => ['integer', 'min:0'],
            'skill_points' => ['integer', 'min:0'],
            'additional_skill_points' => ['integer', 'min:0'],
            'talent_points' => ['integer', 'min:0'],
            'additional_talent_points' => ['integer', 'min:0'],
            'min_estitence' => ['integer'],
            'max_estitence' => ['integer'],
            'safe_estitence' => ['integer'],
            'default_estitence' => ['integer'],
            'additional_estitence' => ['integer'],
        ];
    }
}
