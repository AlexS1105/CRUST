<?php

namespace App\Http\Requests;

use App\Rules\CraftPool;
use App\Rules\FatesRule;
use App\Rules\PerkPool;
use App\Rules\StatPool;
use App\Services\CharsheetService;
use Illuminate\Foundation\Http\FormRequest;

class CharsheetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $charsheetService = resolve(CharsheetService::class);

        $this->merge([
            'perks' => $charsheetService->convertPerks($this->perks),
            'fates' => $charsheetService->convertFates($this->fates),
        ]);
    }

    public function rules()
    {
        $character = $this->route('character');

        $rules = [
            'stats' => ['required', new StatPool($character)],
            'stats.*' => ['numeric', 'min:1'],
            'crafts' => [new CraftPool($this->skills, $this->narrative_crafts)],
            'crafts.*' => ['numeric', 'min:0', 'max:3'],
            'narrative_crafts.*.name' => ['required', 'max:256'],
            'narrative_crafts.*.description' => ['required', 'max:1024'],
        ];

        if (! $character->registered) {
            $rules = array_merge($rules, [
                'perks' => [new PerkPool(false)],
                'fates' => [new FatesRule()],
                'fates.*.text' => ['required', 'max:1024'],
                'fates.*.ambition' => ['required_without:fates.*.flaw', 'nullable'],
                'fates.*.flaw' => ['required_without:fates.*.ambition', 'nullable'],
            ]);
        }

        if (auth()->user()->can('update-charsheet-gm', $character)) {
            $rules['stats_handled'] = ['boolean'];
        }

        return $rules;
    }
}
