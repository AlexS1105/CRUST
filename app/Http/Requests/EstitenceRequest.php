<?php

namespace App\Http\Requests;

use App\Rules\Estitence;
use Illuminate\Foundation\Http\FormRequest;

class EstitenceRequest extends FormRequest
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
            'delta' => ['required', 'not_in:0', new Estitence($this->route('character'))],
        ];
    }
}
