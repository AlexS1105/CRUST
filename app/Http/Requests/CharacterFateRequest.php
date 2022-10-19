<?php

namespace App\Http\Requests;

use App\Enums\FateType;
use App\Rules\FatesRule;
use App\Services\FateService;
use Illuminate\Foundation\Http\FormRequest;

class CharacterFateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $fateService = resolve(FateService::class);

        $this->merge([
            'fates' => $fateService->convertFateTypes($this->fates),
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
