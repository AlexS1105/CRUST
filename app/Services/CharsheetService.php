<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Fate;
use App\Models\NarrativeCraft;
use App\Models\PerkVariant;
use App\Rules\PerkPool;
use Exception;
use Illuminate\Support\Facades\Validator;

class CharsheetService
{
    function update($character, $validated)
    {
        $character->charsheet()->update($validated);

        $character->narrativeCrafts()->delete();

        if (isset($validated['narrative_crafts'])) {
            $character->narrativeCrafts()->createMany($validated['narrative_crafts']);
        }

        $this->savePerks($character, $validated);
        $this->saveFates($character, $validated);

        info('Charsheet updated', [
            'user' => auth()->user()->login,
            'character' => $character->login,
        ]);
    }

    public function savePerks(Character $character, $validated)
    {
        if (isset($validated['perks']) && count($validated['perks'])) {
            $character->perkVariants()->detach();

            foreach ($validated['perks'] as $perkVariant) {
                $id = $perkVariant['variant']->id;
                $character->perkVariants()->attach($id, ['active' => true, 'note' => $perkVariant['note']]);
            }

            info('Character perks updated', [
                'user' => auth()->user()->login,
                'character' => $character->login,
            ]);
        }
    }

    public function saveFates($character, $validated)
    {
        if (isset($validated['fates']) && count($validated['fates'])) {
            $character->fates()->delete();
            $fates = [];

            foreach ($validated['fates'] as $fate) {
                $fate['character_id'] = $character->id;
                array_push($fates, new Fate($fate));
            }

            $character->fates()->saveMany($fates);

            info('Character fates updated', [
                'user' => auth()->user()->login,
                'character' => $character->login,
            ]);
        }
    }

    public function togglePerk(Character $character, PerkVariant $perkVariant)
    {
        try {
            $perkVariant = $character->perkVariants->firstWhere('id', $perkVariant->id);
            $pivot = $perkVariant->pivot;

            if ($character->vox <= 0 && ! $pivot->active) {
                throw new Exception('validation.vox.not_enough');
            }

            $perks = [];

            foreach ($character->perkVariants as $variant) {
                $perks[$variant->perk_id] = [
                    'variant' => $variant,
                    'active' => $variant->id === $perkVariant->id ? ! $pivot->active : $variant->pivot->active,
                    'note' => $variant->pivot->note,
                ];
            }

            $validator = Validator::make([
                'perks' => $perks,
            ], [
                'perks' => new PerkPool(true),
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            if (! $pivot->active) {
                $character->takeVox(1, 'Активация перка '.$perkVariant->perk->name);
            }

            $character->perkVariants()->detach($perkVariant->id);
            $character->perkVariants()->attach($perkVariant, ['active' => ! $pivot->active, 'note' => $pivot->note]);

            info('Character perk '.($pivot->active ? 'deactivated' : 'activated'), [
                'user' => auth()->user()->login,
                'character' => $character->login,
                'perk' => $perkVariant->perk->name,
            ]);

            return back();
        } catch (Exception $e) {
            return back()->withErrors([
                'vox' => __($e->getMessage()),
            ]);
        }
    }
}
