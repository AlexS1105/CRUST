<?php

namespace App\Http\Requests;

use App\Models\RaceTrait as ModelsRaceTrait;
use App\Rules\RaceTrait;
use App\Rules\Subtrait;
use Illuminate\Foundation\Http\FormRequest;

class TraitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'trait' => isset($this->trait) ? ModelsRaceTrait::find(intval($this->trait)) : null,
            'subtrait' => isset($this->subtrait) ? ModelsRaceTrait::find(intval($this->subtrait)) : null,
        ]);
    }

    public function rules()
    {
        return [
            'trait' => ['required', new RaceTrait],
            'subtrait' => [new Subtrait],
            'note_trait' => ['max:256'],
            'note_subtrait' => ['max:256']
        ];
    }
}
