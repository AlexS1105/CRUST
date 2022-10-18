<?php

namespace App\Http\Controllers;

use App\Http\Requests\IdeaRequest;
use App\Http\Requests\IdeaToSphereRequest;
use App\Models\Character;
use App\Models\Idea;
use App\Services\IdeaService;

class IdeaController extends Controller
{
    public function create(Character $character)
    {
        $this->authorize('add-idea', $character);

        return view('ideas.create', compact('character'));
    }

    public function store(IdeaService $ideaService, IdeaRequest $request, Character $character)
    {
        $this->authorize('add-idea', $character);

        $ideaService->addIdea($character, $request);

        return to_route('characters.show', $character);
    }

    public function edit(Character $character, Idea $idea)
    {
        $this->authorize('manage-ideas', $character);

        return view('ideas.edit', compact('character', 'idea'));
    }

    public function update(IdeaRequest $request, Character $character, Idea $idea)
    {
        $this->authorize('manage-ideas', $character);

        $idea->update($request->validated());

        return to_route('characters.show', $character);
    }

    public function destroy(Character $character, Idea $idea)
    {
        $this->authorize('manage-ideas', $character);

        $idea->delete();

        return to_route('characters.show', $character);
    }

    public function sphereView(Character $character, Idea $idea)
    {
        $this->authorize('manage-ideas', $character);

        return view('ideas.sphere', compact('character', 'idea'));
    }

    public function sphere(IdeaService $ideaService, IdeaToSphereRequest $request, Character $character, Idea $idea)
    {
        $this->authorize('manage-ideas', $character);

        $ideaService->toSphere($request, $character, $idea);

        return to_route('characters.show', $character);
    }
}
