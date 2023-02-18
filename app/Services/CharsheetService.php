<?php

namespace App\Services;

use App\Enums\FateType;
use App\Models\Character;

class CharsheetService
{
    public function update($character, $validated)
    {
        if (isset($validated['stats'])) {
            $character->charsheet->fill([
                'stats' => array_map(function ($value) {
                    return intval($value);
                }, $validated['stats'])
            ]);
        }

        if (isset($validated['crafts'])) {
            $character->charsheet->fill([
                'crafts' => array_map(function ($value) {
                    return intval($value);
                }, $validated['crafts']),
            ]);
        }

        $character->charsheet->save();

        $character->narrativeCrafts()->delete();

        if (isset($validated['narrative_crafts'])) {
            $character->narrativeCrafts()->createMany($validated['narrative_crafts']);
        }

        if (isset($validated['fates'])) {
            $this->saveFates($character, $validated);
        }

        if (isset($validated['perks'])) {
            $this->savePerks($character, $validated);
        }

        if (isset($validated['skills'])) {
            $this->saveSkills($character, $validated);
        }

        if (auth()->user()->can('update-charsheet-gm', $character)) {
            if (isset($validated['stats_handled'])) {
                $character->stats_handled = $validated['stats_handled'];
            }

            if (isset($validated['perk_points'])) {
                $character->perk_points = $validated['perk_points'];
            }

            if (isset($validated['skill_points'])) {
                $character->skill_points = $validated['skill_points'];
            }

            $character->save();
        }

        info('Charsheet updated', [
            'user' => auth()->user()->login,
            'character' => $character->login,
        ]);
    }

    public function savePerks(Character $character, $validated)
    {
        $character->perks()->sync(collect($validated['perks'] ?? [])->mapWithKeys(function ($perk, $id) {
            return [$id => ['note' => $perk['note']]];
        }));

        info('Character perks updated', [
            'user' => auth()->user()?->login,
            'character' => $character->login,
        ]);
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

    public function saveSkills($character, $validated)
    {
        $character->skills()->sync(collect($validated['skills'] ?? [])->mapWithKeys(function ($skill, $id) {
            return [$id => ['level' => $skill]];
        }));

        info('Character skills updated', [
            'user' => auth()->user()?->login,
            'character' => $character->login,
        ]);
    }

    public function togglePerk(Character $character, PerkVariant $perkVariant)
    {
        return back();
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

    public function convertPerks($perks)
    {
        return array_filter($perks, function ($perk) {
            return $perk['selected'] ?? 'off' == 'on';
        });
    }

    public function convertSkills($skills)
    {
        return array_filter($skills, function ($skill) {
            return $skill != 0;
        });
    }
}
