<?php

namespace App\Http\Requests;

use App\Rules\SphereToExperience;
use Illuminate\Foundation\Http\FormRequest;

class SphereToExperienceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'experience' => [
                'required',
                'exists:experiences,id',
                new SphereToExperience($this->sphere, $this->get('value', 1)),
            ],
            'value' => ['required', 'integer'],
        ];
    }
}
