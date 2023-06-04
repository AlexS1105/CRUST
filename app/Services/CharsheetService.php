<?php

namespace App\Services;

use App\Models\Character;

class CharsheetService
{
    public function update($character, $validated)
    {
        $this->saveStats($character, $validated);
        $this->savePerks($character, $validated);
        $this->saveSkills($character, $validated);
        $this->saveTalents($character, $validated);
        $this->saveTechniques($character, $validated);
        $this->saveTides($character, $validated);

        info('Charsheet updated', [
            'user' => auth()->user()->login,
            'character' => $character->login,
        ]);
    }

    public function saveStats($character, $validated)
    {
        $character->charsheet->update([
            'stats' => array_map('intval', $validated['stats']),
        ]);

        if (auth()->user()->can('update-charsheet-gm', $character)) {
            $character->update([
                'stats_handled' => $validated['stats_handled'],
                'estitence_reduce' => $validated['estitence_reduce'],
            ]);
        }

        info('Character stats updated', [
            'user' => auth()->user()?->login,
            'character' => $character->login,
        ]);
    }

    public function savePerks(Character $character, $validated)
    {
        $character->perks()->sync(collect($validated['perks'] ?? [])->mapWithKeys(function ($perk, $id) {
            return [$id => ['note' => $perk['note']]];
        }));

        if (auth()->user()->can('update-charsheet-gm', $character)) {
            $character->update(['perk_points' => $validated['perk_points']]);
        }

        info('Character perks updated', [
            'user' => auth()->user()?->login,
            'character' => $character->login,
        ]);
    }

    public function saveSkills($character, $validated)
    {
        $character->skills()->sync(collect($validated['skills'] ?? [])->mapWithKeys(function ($skill, $id) {
            return [$id => ['level' => $skill]];
        }));

        if (auth()->user()->can('update-charsheet-gm', $character)) {
            $character->update(['skill_points' => $validated['skill_points']]);
        }

        info('Character skills updated', [
            'user' => auth()->user()?->login,
            'character' => $character->login,
        ]);
    }

    public function saveTalents(Character $character, $validated)
    {
        $character->talents()->sync(collect($validated['talents'] ?? [])->keys());

        if (auth()->user()->can('update-charsheet-gm', $character)) {
            $character->update(['talent_points' => $validated['talent_points']]);
        }

        info('Character talents updated', [
            'user' => auth()->user()?->login,
            'character' => $character->login,
        ]);
    }

    public function saveTechniques($character, $validated)
    {
        $character->techniques()->sync(collect($validated['techniques'] ?? [])->keys());

        if (auth()->user()->can('update-charsheet-gm', $character)) {
            $character->update(['technique_points' => $validated['technique_points']]);
        }

        info('Character techniques updated', [
            'user' => auth()->user()?->login,
            'character' => $character->login,
        ]);
    }

    public function saveTides($character, $validated, $isGm = false)
    {
        $isGm = auth()->user()->can('update-charsheet-gm', $character);

        foreach ($validated['tides'] as $id => $tideData) {
            $tide = $character->tides()->find($id);

            if ($tide == null) {
                continue;
            }

            if (isset($tideData['path'])) {
                $tide->path = $tideData['path'];
            }

            if ($isGm && isset($tideData['level'])) {
                $tide->level = $tideData['level'];
            }

            $tide->save();
        }

        info('Character tides updated', [
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

    public function convertTechniques($techniques)
    {
        if (empty($techniques)) {
            return null;
        }

        return array_filter($techniques, function ($technique) {
            return $technique['selected'] ?? 'off' == 'on';
        });
    }
}
