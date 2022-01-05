<?php

namespace App\Http\Controllers;

use App\Enums\PerkType;
use App\Http\Requests\CharsheetRequest;
use App\Models\Character;
use App\Models\NarrativeCraft;
use App\Models\Perk;
use App\Settings\CharsheetSettings;

class CharsheetController extends Controller
{
    public function edit(Character $character)
    {
        return view('characters.charsheet', [
            'character' => $character,
            'maxSkills' => app(CharsheetSettings::class)->skill_points,
            'perks' => Perk::with('variants')->notHasFlag('perks.type', PerkType::Unique)->get(),
            'maxPerks' => app(CharsheetSettings::class)->perk_points,
        ]);
    }

    public function update(CharsheetRequest $request, Character $character)
    {
        $validated = $request->validated();
        $character->charsheet()->update($validated);

        $character->narrativeCrafts()->delete();
        
        if (count($validated['narrative_crafts']) > 0) {
            $narrativeCrafts = [];
        
            foreach($validated['narrative_crafts'] as $craft) {
                $craft['character_id'] = $character->id;
                array_push($narrativeCrafts, new NarrativeCraft($craft));
            }
            
            $character->narrativeCrafts()->saveMany($narrativeCrafts);
        }

        if (count($validated['perks']) > 0) {
            foreach($validated['perks'] as $perkVariant) {
                $character->perkVariants()->attach($perkVariant['variant']->id, ['cost_offset' => $perkVariant['cost_offset'], 'note' => $perkVariant['note']]);
            }
        }

        return redirect()->route('characters.show', $character->login);
    }
}
