<?php

namespace App\Http\Controllers;

use App\Http\Requests\NarrativeCraftRequest;
use App\Models\Character;
use App\Models\NarrativeCraft;

class NarrativeCraftController extends Controller
{
    public function create(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        return view('crafts.create', compact('character'));
    }

    public function store(NarrativeCraftRequest $request, Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $character->narrativeCrafts()->create($request->validated());

        return to_route('characters.show', $character);
    }

    public function edit(Character $character, NarrativeCraft $narrativeCraft)
    {
        $this->authorize('update', $character);

        return view('crafts.edit', compact('character', 'narrativeCraft'));
    }

    public function update(NarrativeCraftRequest $request, Character $character, NarrativeCraft $narrativeCraft)
    {
        $this->authorize('update', $character);

        $narrativeCraft->update($request->validated());

        return to_route('characters.show', $character);
    }

    public function destroy(Character $character, NarrativeCraft $narrativeCraft)
    {
        $this->authorize('update', $character);

        $narrativeCraft->delete();

        return to_route('characters.show', $character);
    }
}
