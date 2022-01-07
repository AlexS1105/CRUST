<?php

namespace App\Http\Requests;

use App\Enums\FateType;
use App\Models\PerkVariant;
use App\Rules\Fates;
use Illuminate\Foundation\Http\FormRequest;

class CharacterFateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $fates = [];

        if (isset($this->fates)) {
            foreach($this->fates as $fate) {
                $fateType = FateType::None();

                if (isset($fate['continious']) && $fate['continious'] === 'on') {
                    $fateType->addFlag(FateType::Continious);
                }

                if (isset($fate['ambition']) && $fate['ambition'] === 'on') {
                    $fateType->addFlag(FateType::Ambition);
                }

                if (isset($fate['flaw']) && $fate['flaw'] === 'on') {
                    $fateType->addFlag(FateType::Flaw);
                }

                array_push($fates, [
                    'text' => $fate['text'],
                    'type' => $fateType != FateType::None() ? $fateType : null
                ]);
            }
        }

        $this->merge([
            'fates' => $fates
        ]);
    }

    public function rules()
    {
        return [
            'fates' => [new Fates(true)],
            'fates.*.text' => ['required', 'max:1024'],
            'fates.*.type' => ['required']
        ];
    }
}
