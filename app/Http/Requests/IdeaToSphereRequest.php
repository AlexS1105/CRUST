<?php

namespace App\Http\Requests;

use App\Rules\IdeaToSphere;
use Illuminate\Foundation\Http\FormRequest;

class IdeaToSphereRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sphere' => ['required', 'exists:spheres,id', new IdeaToSphere($this->route('character'))],
        ];
    }
}
