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
            'skill_points' => ['integer', 'min:0'],
            'max_fates' => ['integer', 'min:0'],
            'max_perks' => ['integer', 'min:0'],
            'perk_points' => ['integer', 'min:0'],
            'additional_perk_points' => ['integer', 'min:0'],
            'min_estitence' => ['integer'],
            'max_estitence' => ['integer'],
            'safe_estitence' => ['integer'],
            'default_estitence' => ['integer'],
            'additional_estitence' => ['integer'],
        ];
    }
}
