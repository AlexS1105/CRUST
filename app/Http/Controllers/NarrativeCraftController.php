<?php

namespace App\Http\Controllers;

use App\Http\Requests\NarrativeCraftRequest;
use App\Models\Character;
use App\Models\NarrativeCraft;
use Illuminate\Http\Request;

class NarrativeCraftController extends Controller
{
    public function create(Character $character)
    {
        $this->authorize('updateCharsheetGm', $character);
        return view('crafts.create', [
            'character' => $character
        ]);
    }

    public function store(NarrativeCraftRequest $request, Character $character)
    {
        $this->authorize('updateCharsheetGm', $character);
        $validated = $request->validated();
        $character->narrativeCrafts()->create($validated);

        return redirect()->route('characters.show', $character);
    }

    public function edit(Character $character, NarrativeCraft $narrativeCraft)
    {
        $this->authorize('update', $character);
        return view('crafts.edit', [
            'character' => $character,
            'narrativeCraft' => $narrativeCraft
        ]);
    }

    public function update(NarrativeCraftRequest $request, Character $character, NarrativeCraft $narrativeCraft)
    {
        $this->authorize('update', $character);
        $validated = $request->validated();
        $narrativeCraft->update($validated);

        return redirect()->route('characters.show', $character);
    }

    public function destroy(Character $character, NarrativeCraft $narrativeCraft)
    {
        $this->authorize('update', $character);
        $this->authorize('manageIdeas', $character);
        $narrativeCraft->delete();

        return redirect()->route('characters.show', $character);
    }
}
