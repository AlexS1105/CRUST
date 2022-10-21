<?php

namespace App\Http\Requests;

use App\Rules\FatesRule;
use App\Services\CharsheetService;
use Illuminate\Foundation\Http\FormRequest;

class CharacterFateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $charsheetService = app(CharsheetService::class);

        $this->merge([
            'fates' => $charsheetService->convertFates($this->fates),
        ]);
    }

    public function rules()
    {
        return [
            'fates' => [new FatesRule()],
            'fates.*.text' => ['required', 'max:1024'],
            'fates.*.ambition' => ['required_without:fates.*.flaw', 'nullable'],
            'fates.*.flaw' => ['required_without:fates.*.ambition', 'nullable'],
        ];
    }
}
