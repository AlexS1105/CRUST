<?php

namespace App\Http\Controllers;

use App\Enums\PerkType;
use App\Http\Requests\CharacterFateRequest;
use App\Http\Requests\CharacterPerkRequest;
use App\Http\Requests\CharsheetRequest;
use App\Models\Character;
use App\Models\Fate;
use App\Models\NarrativeCraft;
use App\Models\Perk;
use App\Models\PerkVariant;
use App\Settings\CharsheetSettings;
use Exception;

class CharsheetController extends Controller
{
    public function edit(Character $character)
    {
        return view('characters.charsheet', [
            'character' => $character,
            'maxSkills' => app(CharsheetSettings::class)->skill_points,
            'perks' => Perk::with('variants')->notHasFlag('perks.type', PerkType::Unique)->get(),
            'maxPerks' => app(CharsheetSettings::class)->perk_points,
            'maxFates' =>  app(CharsheetSettings::class)->max_fates,
            'maxActivePerks' => app(CharsheetSettings::class)->max_active_perks,
        ]);
    }

    public function update(CharsheetRequest $request, Character $character)
    {
        $validated = $request->validated();
        $character->charsheet()->update($validated);
        $character->narrativeCrafts()->delete();
        
        if (isset($validated['narrative_crafts'])) {
            $narrativeCrafts = [];
        
            foreach($validated['narrative_crafts'] as $craft) {
                $craft['character_id'] = $character->id;
                array_push($narrativeCrafts, new NarrativeCraft($craft));
            }
            
            $character->narrativeCrafts()->saveMany($narrativeCrafts);
        }

        $this->savePerks($character, $validated);
        $this->saveFates($character, $validated);

        info('Charsheet updated', [
            'user' => auth()->user()->login,
            'character' => $character->login
        ]);

        return redirect()->route('characters.show', $character);
    }

    public function editPerks(Character $character)
    {
        return view('characters.perks', [
            'character' => $character,
            'perks' => Perk::with('variants')->get(),
            'maxActivePerks' => app(CharsheetSettings::class)->max_active_perks,
        ]);
    }

    public function updatePerks(CharacterPerkRequest $request, Character $character)
    {
        $this->savePerks($character, $request->validated());

        return redirect()->route('characters.show', $character);
    }

    private function savePerks(Character $character, $validated)
    {
        if (isset($validated['perks']) && count($validated['perks'])) {
            $character->perkVariants()->detach();
            
            foreach($validated['perks'] as $perkVariant) {
                $id = $perkVariant['variant']->id;
                $character->perkVariants()->attach($id, ['active' => $perkVariant['active'], 'note' => $perkVariant['note']]);
            }

            info('Character perks updated', [
                'user' => auth()->user()->login,
                'character' => $character->login
            ]);
        }
    }

    public function editFates(Character $character)
    {
        return view('characters.fates', [
            'character' => $character,
            'maxFates' =>  app(CharsheetSettings::class)->max_fates
        ]);
    }

    public function updateFates(CharacterFateRequest $request, Character $character)
    {
        $this->saveFates($character, $request->validated());

        return redirect()->route('characters.show', $character);
    }

    private function saveFates($character, $validated)
    {
        if (isset($validated['fates']) && count($validated['fates'])) {
            $character->fates()->delete();
            $fates = [];

            foreach($validated['fates'] as $fate) {
                $fate['character_id'] = $character->id;
                array_push($fates, new Fate($fate));
            }
            
            $character->fates()->saveMany($fates);

            info('Character fates updated', [
                'user' => auth()->user()->login,
                'character' => $character->login
            ]);
        }
    }

    public function togglePerk(Character $character, PerkVariant $perkVariant)
    {
        try {
            $character->togglePerk($perkVariant);
            
            return back();
        } catch (Exception $e) {
            return back()->withErrors([
                'vox' => __($e->getMessage())
            ]);
        }
    }
}
