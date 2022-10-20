<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExperienceRequest;
use App\Http\Requests\ExperienceSetRequest;
use App\Models\Character;
use App\Models\Experience;

class ExperienceController extends Controller
{
    public function store(ExperienceRequest $request, Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $character->experiences()->create($request->validated());

        return to_route('characters.show', $character);
    }

    public function create(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        return view('experiences.create', compact('character'));
    }

    public function edit(Character $character, Experience $experience)
    {
        $this->authorize('update', $character);

        return view('experiences.edit', compact('character', 'experience'));
    }

    public function destroy(Character $character, Experience $experience)
    {
        $this->authorize('update', $character);

        $experience->delete();

        return to_route('characters.show', $character);
    }

    public function setView(Character $character, Experience $experience)
    {
        $this->authorize('update-charsheet-gm', $character);

        return view('experiences.set', compact('character', 'experience'));
    }

    public function set(ExperienceSetRequest $request, Character $character, Experience $experience)
    {
        $this->authorize('update-charsheet-gm', $character);

        $experience->update($request->validated());

        return to_route('characters.show', $character);
    }

    public function update(ExperienceRequest $request, Character $character, Experience $experience)
    {
        $this->authorize('update', $character);

        $experience->update($request->validated());

        return to_route('characters.show', $character);
    }
}
