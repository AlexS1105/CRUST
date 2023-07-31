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
            $character->stats_handled = $validated['stats_handled'];
            $character->estitence_reduce = $validated['estitence_reduce'];

            if (isset($validated['attunement_slots'])) {
                $character->attunement_slots = $validated['attunement_slots'];
            }

            if (isset($validated['modification_slots'])) {
                $character->modification_slots = $validated['modification_slots'];
            }

            $character->save();
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
            $character->update([
                'perk_points' => $validated['perk_points'],
                'perks_amount' => $validated['perks_amount'] ?? null,
            ]);
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
            $character->update([
                'talent_points' => $validated['talent_points'],
                'talents_amount' => $validated['talents_amount'] ?? null,
            ]);
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
            $character->update([
                'technique_points' => $validated['technique_points'],
                'techniques_amount' => $validated['techniques_amount'] ?? null,
            ]);
        }

        info('Character techniques updated', [
            'user' => auth()->user()?->login,
            'character' => $character->login,
        ]);
    }

    public function saveTides($character, $validated)
    {
        $isGm = auth()->user()->can('update-charsheet-gm', $character);

        $tides = $character->tides;

        foreach ($validated['tides'] as $id => $tideData) {
            $tide = $tides->firstWhere('id', $id);

            if ($tide == null) {
                continue;
            }

            if (isset($tideData['path'])) {
                $tide->path = $tideData['path'];
            }

            if ($isGm && isset($tideData['level'])) {
                $tide->level = intval($tideData['level']);
            }
        }

        foreach ($tides as $tide) {
            if ($tide->isDirty('level')) {
                $before = $tide->getOriginal('level');
                $after = $tide->level;

                $character->tideLogs()->create([
                    'issued_by' => auth()->user()?->id,
                    'before' => $before,
                    'after' => $after,
                    'reason' => $validated['reason'],
                    'delta' => $after - $before,
                    'tide' => $tide->tide,
                ]);
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
