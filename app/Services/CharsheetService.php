<?php

namespace App\Services;

use App\Enums\FateType;
use App\Models\Character;
use App\Models\PerkVariant;
use App\Rules\PerkPool;
use Exception;
use Illuminate\Support\Facades\Validator;

class CharsheetService
{
    public function update($character, $validated)
    {
        $character->charsheet()->update([
            'skills' => array_map(function ($value) { return intval($value); }, $validated['skills']),
            'crafts' => array_map(function ($value) { return intval($value); }, $validated['crafts']),
        ]);

        $character->narrativeCrafts()->delete();

        if (isset($validated['narrative_crafts'])) {
            $character->narrativeCrafts()->createMany($validated['narrative_crafts']);
        }

        if (isset($validated['fates'])) {
            $this->savePerks($character, $validated);
        }

        if (isset($validated['perks'])) {
            $this->saveFates($character, $validated);
        }

        info('Charsheet updated', [
            'user' => auth()->user()->login,
            'character' => $character->login,
        ]);
    }

    public function savePerks(Character $character, $validated)
    {
        $character->perkVariants()->detach();

        if (isset($validated['perks'])) {
            foreach ($validated['perks'] as $perkVariant) {
                $id = $perkVariant['variant']->id;
                $character->perkVariants()->attach(
                    $id,
                    ['active' => $perkVariant['active'], 'note' => $perkVariant['note']]
                );
            }

            info('Character perks updated', [
                'user' => auth()->user()->login,
                'character' => $character->login,
            ]);
        }
    }

    public function saveFates($character, $validated)
    {
        $character->fates()->delete();

        if (isset($validated['fates'])) {
            $character->fates()->createMany($validated['fates']);
        }

        info('Character fates updated', [
            'user' => auth()->user()->login,
            'character' => $character->login,
        ]);
    }

    public function togglePerk(Character $character, PerkVariant $perkVariant)
    {
        try {
            $perkVariant = $character->perkVariants->firstWhere('id', $perkVariant->id);
            $pivot = $perkVariant->pivot;
            $active = $pivot->active;

            if ($character->vox <= 0 && ! $active) {
                throw new Exception('validation.vox.not_enough');
            }

            $perks = $character->perkVariants->mapWithKeys(function ($variant) use ($perkVariant, $active) {
                return [
                    $variant->perk_id => [
                        'variant' => $variant,
                        'active' => $variant->is($perkVariant) ? ! $active : $variant->pivot->active,
                        'note' => $variant->pivot->note,
                    ],
                ];
            });

            $validator = Validator::make([
                'perks' => $perks,
            ], [
                'perks' => new PerkPool(true),
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            if (! $pivot->active) {
                app(VoxService::class)->giveVox(
                    $character,
                    -1,
                    __('vox.perk_activation', ['perk' => $perkVariant->perk->name])
                );
            }

            $character->perkVariants()->updateExistingPivot($perkVariant->id, ['active' => ! $active]);

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

    public function convertFates($fates)
    {
        if (isset($fates)) {
            foreach ($fates as &$fate) {
                $fate['type'] = 0;

                if (isset($fate['ambition'])) {
                    $fate['type'] = FateType::set($fate['type'], FateType::Ambition);
                }

                if (isset($fate['flaw'])) {
                    $fate['type'] = FateType::set($fate['type'], FateType::Flaw);
                }

                if (isset($fate['continuous'])) {
                    $fate['type'] = FateType::set($fate['type'], FateType::Continuous);
                }
            }
        }

        return $fates;
    }

    public function convertPerks($perks, $edit = false)
    {
        $perkVariants = PerkVariant::with('perk')->get();
        $perksCollection = [];

        if (isset($perks)) {
            foreach ($perks as $perkId => $perkData) {
                if ($perkData['id'] !== '-1') {
                    $perksCollection[$perkId] = [
                        'variant' => $perkVariants->firstWhere('id', $perkData['id']),
                        'note' => $perkData['note'],
                        'active' => ! $edit || isset($perkData['active']),
                    ];
                }
            }
        }

        return $perksCollection;
    }
}
