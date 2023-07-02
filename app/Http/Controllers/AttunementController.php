<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttunementRequest;
use App\Models\Attunement;
use App\Models\Character;

class AttunementController extends Controller
{
    public function create(Character $character)
    {
        $this->authorize('add-attunement', $character);

        return view('attunement.create', compact('character'));
    }

    public function store(AttunementRequest $request, Character $character)
    {
        $this->authorize('add-attunement', $character);

        $character->attunements()->create($request->validated());

        return to_route('characters.show', $character);
    }

    public function edit(Character $character, Attunement $attunement)
    {
        $this->authorize('update-charsheet-gm', $character);

        return view('attunement.edit', compact('character', 'attunement'));
    }

    public function update(AttunementRequest $request, Character $character, Attunement $attunement)
    {
        $this->authorize('update-charsheet-gm', $character);

        $attunement->update($request->validated());

        return to_route('characters.show', $character);
    }

    public function destroy(Character $character, Attunement $attunement)
    {
        $this->authorize('update-charsheet-gm', $character);

        $attunement->delete();

        return to_route('characters.show', $character);
    }
}
