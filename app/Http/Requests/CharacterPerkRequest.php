<?php

namespace App\Http\Requests;

use App\Models\PerkVariant;
use App\Rules\PerkPool;
use Illuminate\Foundation\Http\FormRequest;

class CharacterPerkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $perksCollection = PerkVariant::with('perk')->get();
        $perks = [];

        if (isset($this->perks)) {
            foreach($this->perks as $perkId => $perkData) {
                if ($perkData['id'] != "-1") {
                    $perks[$perkId] = [
                        'variant' => $perksCollection->firstWhere('id', intval($perkData['id'])),
                        'active' => isset($perkData['active']) ? $perkData['active'] === 'on' : false,
                        'note' => $perkData['note']
                    ];
                }
            }
        }

        $this->merge([
            'perks' => $perks
        ]);
    }

    public function rules()
    {
        return [
            'perks' => [new PerkPool(true)]
        ];
    }
}
