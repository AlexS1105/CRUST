<?php

namespace App\Http\Requests;

use App\Rules\SphereHasEnough;
use Illuminate\Foundation\Http\FormRequest;

class SphereSpendRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'value' => ['required', 'min:1', 'max:100', new SphereHasEnough($this->sphere)],
        ];
    }
}
