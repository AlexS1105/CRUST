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
        $experience->level += $validated['value'];
        $experience->save();

        $sphere->value -= $this->getExperienceCost($this->value, $validated['value']);
        $sphere->save();
    }

    public function getExperienceCost($curValue, $inc)
    {
        $costPerPoint = 2;
        $costSum = 0;

        for ($i = $curValue; $i < $curValue + $inc; $i++) {
            $costSum += $i >= 5 ? $costPerPoint * 2 : $costPerPoint;
        }

        return $costSum;
    }
}
