<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdeaRequest;
use App\Models\Character;
use App\Models\Idea;
use App\Rules\IdeaToSphere;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function create(Character $character)
    {
        $this->authorize('addIdea', $character);
        return view('ideas.create', [
            'character' => $character
        ]);
    }

    public function store(IdeaRequest $request, Character $character)
    {
        $this->authorize('addIdea', $character);
        $validated = $request->validated();
        $character->ideas()->create($validated);
        $user = $request->user();

        if (isset($user) && !$user->can('manageIdeasGm', $character)) {
            $character->last_idea = now();
            $character->save();
        }

        return redirect()->route('characters.show', $character);
    }

    public function edit(Character $character, Idea $idea)
    {
        $this->authorize('manageIdeas', $character);
        return view('ideas.edit', [
            'character' => $character,
            'idea' => $idea
        ]);
    }

    public function update(IdeaRequest $request, Character $character, Idea $idea)
    {
        $this->authorize('manageIdeas', $character);
        $validated = $request->validated();
        $idea->update($validated);

        return redirect()->route('characters.show', $character);
    }

    public function destroy(Character $character, Idea $idea)
    {
        $this->authorize('manageIdeas', $character);
        $idea->delete();

        return redirect()->route('characters.show', $character);
    }

    public function sphereView(Character $character, Idea $idea)
    {
        $this->authorize('manageIdeas', $character);
        return view('ideas.sphere', [
            'character' => $character,
            'idea' => $idea
        ]);
    }

    public function sphere(Request $request, Character $character, Idea $idea)
    {
        $this->authorize('manageIdeas', $character);
        $validated = $request->validate([
            'sphere' => ['required', 'exists:spheres,id', new IdeaToSphere($character)]
        ]);

        $sphere = $character->spheres->find($validated['sphere']);
        $sphere->value += 1;
        $sphere->save();

        $idea->delete();

        return redirect()->route('characters.show', $character);
    }
}
