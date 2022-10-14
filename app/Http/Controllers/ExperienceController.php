<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExperienceRequest;
use App\Models\Character;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function create(Character $character)
    {
        $this->authorize('updateCharsheetGm', $character);
        return view('experiences.create', [
            'character' => $character,
        ]);
    }

    public function store(ExperienceRequest $request, Character $character)
    {
        $this->authorize('updateCharsheetGm', $character);
        $validated = $request->validated();
        $character->experiences()->create($validated);

        return redirect()->route('characters.show', $character);
    }

    public function edit(Character $character, Experience $experience)
    {
        $this->authorize('update', $character);
        return view('experiences.edit', [
            'character' => $character,
            'experience' => $experience,
        ]);
    }

    public function update(ExperienceRequest $request, Character $character, Experience $experience)
    {
        $this->authorize('update', $character);
        $validated = $request->validated();
        $experience->update($validated);

        return redirect()->route('characters.show', $character);
    }

    public function destroy(Character $character, Experience $experience)
    {
        $this->authorize('update', $character);
        $experience->delete();

        return redirect()->route('characters.show', $character);
    }

    public function setView(Character $character, Experience $experience)
    {
        $this->authorize('updateCharsheetGm', $character);
        return view('experiences.set', [
            'character' => $character,
            'experience' => $experience,
        ]);
    }

    public function set(Request $request, Character $character, Experience $experience)
    {
        $this->authorize('updateCharsheetGm', $character);
        $validated = $request->validate([
            'level' => ['min:1', 'max:10'],
        ]);

        $experience->update($validated);

        return redirect()->route('characters.show', $character);
    }
}
