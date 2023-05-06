<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdvantageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'is_penalty' => $this->is_penalty === 'on',
        ]);
    }

    public function rules()
    {
        $skill = $this->route('skill');

        return [
            'description' => ['required', 'max:2048'],
            'level' => [
                'required',
                'min:0',
                'max:100',
                Rule::unique('advantages')
                    ->where(fn ($query) => $query->where([
                        ['level', $this->level],
                        ['skill_id', $skill->id],
                    ])),
            ],
            'is_penalty' => ['boolean'],
        ];
    }
}
