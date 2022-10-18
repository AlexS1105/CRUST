<?php

namespace App\Services;

use App\Http\Requests\IdeaRequest;
use App\Http\Requests\IdeaToSphereRequest;
use App\Models\Character;
use App\Models\Idea;

class IdeaService
{
    public function addIdea(Character $character, IdeaRequest $request)
    {
        $character->ideas()->create($request->validated());
        $user = $request->user();

        if (isset($user) && ! $user->can('manage-ideas-gm', $character)) {
            $character->last_idea = now();
            $character->save();
        }
    }

    public function toSphere(IdeaToSphereRequest $request, Character $character, Idea $idea)
    {
        $validated = $request->validated();

        $sphere = $character->spheres->find($validated['sphere']);
        $sphere->value += 1;
        $sphere->save();

        $idea->delete();
    }

    public function changeSpherePoints($sphere, $points)
    {
        $sphere->value += $points;
        $sphere->save();
    }

    public function sphereToExperience($validated, $character, $sphere)
    {
        $experience = $character->experiences->find($validated['experience']);
        $experience->increaseFromSphere($sphere, $validated);
    }
}
