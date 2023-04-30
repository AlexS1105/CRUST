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
                }, $validated['stats']),
            ]);
        }

        $character->charsheet->save();

        if (isset($validated['perks'])) {
            $this->savePerks($character, $validated);
        }

        if (isset($validated['skills'])) {
            $this->saveSkills($character, $validated);
        }

        if (isset($validated['talents'])) {
            $this->saveTalents($character, $validated);
        }

        if (isset($validated['tides'])) {
            $this->saveTides($character, $validated);
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

            if (isset($validated['talent_points'])) {
                $character->talent_points = $validated['talent_points'];
            }

            if (isset($validated['estitence_reduce'])) {
                $character->estitence_reduce = $validated['estitence_reduce'];
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

    public function saveTalents(Character $character, $validated)
    {
        $character->talents()->sync(collect($validated['talents'] ?? [])->keys());

        info('Character talents updated', [
            'user' => auth()->user()?->login,
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

    public function convertPerks($perks)
    {
        if (empty($perks)) {
            return null;
        }

        return array_filter($perks, function ($perk) {
            return $perk['selected'] ?? 'off' == 'on';
        });
    }

    public function convertTalents($talents)
    {
        if (empty($talents)) {
            return null;
        }

        return array_filter($talents, function ($talent) {
            return $talent['selected'] ?? 'off' == 'on';
        });
    }

    public function convertSkills($skills)
    {
        if (empty($skills)) {
            return null;
        }

        return array_filter($skills, function ($skill) {
            return $skill != 0;
        });
    }

    public function saveTides($character, $validated)
    {
        $canUpdateLevel = auth()->user()->can('update-charsheet-gm', $character);

        foreach ($validated['tides'] as $tideData) {
            $tide = $character->tides()->firstWhere('tide', $tideData['tide']);

            if ($tide == null) {
                continue;
            }

            $tide->path = $tideData['path'];

            if ($canUpdateLevel) {
                $tide->level = $tideData['level'];
            }

            $tide->save();
        }

        info('Character tides updated', [
            'user' => auth()->user()?->login,
            'character' => $character->login,
        ]);
    }
}
