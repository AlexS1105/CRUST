<?php

namespace App\Http\Requests;

use App\Enums\Tide;
use App\Rules\Estitence;
use App\Rules\Experience;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class CharacterExperienceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'delta' => intval($this->delta),
        ]);
    }

    public function rules()
    {
        return [
            'reason' => ['required', 'max:256'],
            'delta' => ['required', 'not_in:0', new Experience($this->route('character'))],
        ];
    }
}
