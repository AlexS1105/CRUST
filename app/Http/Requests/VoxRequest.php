<?php

namespace App\Http\Requests;

use App\Rules\Vox;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VoxRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'delta' => intval($this->delta)
        ]);
    }

    public function rules()
    {
        return [
            'reason' => ['required', 'max:256'],
            'delta' => ['required', 'not_in:0', new Vox($this->route('character'))]
        ];
    }
}
