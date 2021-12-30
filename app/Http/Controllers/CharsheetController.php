<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharsheetRequest;
use App\Models\Character;
use App\Models\NarrativeCraft;
use App\Settings\CharsheetSettings;

class CharsheetController extends Controller
{
    public function edit(Character $character)
    {
        return view('characters.charsheet', [
            'character' => $character,
            'maxSkills' => app(CharsheetSettings::class)->skill_points
        ]);
    }

    public function update(CharsheetRequest $request, Character $character)
    {
        $validated = $request->validated();
        $character->charsheet()->update($validated);

        $narrativeCrafts = [];
        
        foreach($validated['narrative_crafts'] as $craft) {
            $craft['character_id'] = $character->id;
            array_push($narrativeCrafts, new NarrativeCraft($craft));
        }

        $character->narrativeCrafts()->delete();
        $character->narrativeCrafts()->saveMany($narrativeCrafts);
        return redirect()->route('characters.show', $character->login);
    }
}
