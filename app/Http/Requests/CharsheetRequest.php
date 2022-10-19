<?php

namespace App\Http\Requests;

use App\Enums\FateType;
use App\Models\PerkVariant;
use App\Rules\CraftPool;
use App\Rules\FatesRule;
use App\Rules\PerkPool;
use App\Rules\SkillPool;
use App\Services\FateService;
use Illuminate\Foundation\Http\FormRequest;

class CharsheetRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        // TODO: rewrite perks input
        $perksCollection = PerkVariant::with('perk')->get();
        $perks = [];

        if (isset($this->perks)) {
            foreach ($this->perks as $perkId => $perkData) {
                if ($perkData['id'] !== '-1') {
                    $perks[$perkId] = [
                        'variant' => $perksCollection->firstWhere('id', intval($perkData['id'])),
                        'note' => $perkData['note'],
                        'active' => isset($perkData['active']) && $perkData['active'] === 'on',
                    ];
                }
            }
        }

        $fateService = resolve(FateService::class);

        $this->merge([
            'perks' => $perks,
            'fates' => $fateService->convertFateTypes($this->fates),
        ]);
    }

    public function rules()
    {
        $rules = [
            'skills' => ['required', new SkillPool()],
            'skills.*' => ['numeric', 'min:0', 'max:10'],
            'crafts' => [new CraftPool($this->skills, $this->narrative_crafts)],
            'crafts.*' => ['numeric', 'min:0', 'max:3'],
            'narrative_crafts.*.name' => ['required', 'max:256'],
            'narrative_crafts.*.description' => ['required', 'max:1024'],
        ];

        $character = $this->route('character');

        if (! $character->registered) {
            $rules = array_merge($rules, [
                'perks' => [new PerkPool(false)],
                'fates' => [new FatesRule(false)],
                'fates.*.text' => ['required', 'max:1024'],
                'fates.*.type' => ['required'],
            ]);
        }

        return $rules;
    }
}
