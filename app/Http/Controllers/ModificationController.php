<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModificationRequest;
use App\Models\Character;
use App\Models\Modification;

class ModificationController extends Controller
{
    public function create(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        return view('modification.create', compact('character'));
    }

    public function store(ModificationRequest $request, Character $character)
    {
        $this->authorize('add-modification', $character);

        $character->modifications()->create($request->validated());

        return to_route('characters.show', $character);
    }

    public function edit(Character $character, Modification $modification)
    {
        $this->authorize('update-charsheet-gm', $character);

        return view('modification.edit', compact('character', 'modification'));
    }

    public function update(ModificationRequest $request, Character $character, Modification $modification)
    {
        $this->authorize('update-charsheet-gm', $character);

        $modification->update($request->validated());

        return to_route('characters.show', $character);
    }

    public function destroy(Character $character, Modification $modification)
    {
        $this->authorize('update-charsheet-gm', $character);

        $modification->delete();

        return to_route('characters.show', $character);
    }
}
