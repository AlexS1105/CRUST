<?php

namespace App\Http\Controllers;

use App\Enums\PerkType;
use App\Http\Requests\CharsheetRequest;
use App\Models\Character;
use App\Models\Fate;
use App\Models\NarrativeCraft;
use App\Models\Perk;
use App\Models\RaceTrait;
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
            'traits' => RaceTrait::all(),
            'maxFates' =>  app(CharsheetSettings::class)->max_fates
        ]);
    }

    public function update(CharsheetRequest $request, Character $character)
    {
        $validated = $request->validated();
        $character->charsheet()->update($validated);
        
        if (count($validated['narrative_crafts'])) {
            $character->narrativeCrafts()->delete();
            $narrativeCrafts = [];
        
            foreach($validated['narrative_crafts'] as $craft) {
                $craft['character_id'] = $character->id;
                array_push($narrativeCrafts, new NarrativeCraft($craft));
            }
            
            $character->narrativeCrafts()->saveMany($narrativeCrafts);
        }

        if (isset($validated['perks']) && count($validated['perks'])) {
            $character->perkVariants()->detach();
            
            foreach($validated['perks'] as $perkVariant) {
                $id = $perkVariant['variant']->id;
                $character->perkVariants()->attach($id, ['cost_offset' => $perkVariant['cost_offset'], 'note' => $perkVariant['note']]);
            }
        }

        if (isset($validated['trait']) || isset($validated['subtrait'])) {
            $character->traits()->detach();

            if (isset($validated['trait'])) {
                $character->traits()->attach($validated['trait'], ['note' => $validated['note_trait']]);
            }

            if (isset($validated['subtrait'])) {
                $character->traits()->attach($validated['subtrait'], ['note' => $validated['note_subtrait']]);
            }
        }

        if (isset($validated['fates']) && count($validated['fates'])) {
            $character->fates()->delete();
            $fates = [];

            foreach($validated['fates'] as $fate) {
                $fate['character_id'] = $character->id;
                array_push($fates, new Fate($fate));
            }
            
            $character->fates()->saveMany($fates);
        }

        return redirect()->route('characters.show', $character->login);
    }
}
