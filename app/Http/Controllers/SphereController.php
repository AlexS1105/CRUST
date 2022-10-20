<?php

namespace App\Http\Controllers;

use App\Http\Requests\SphereAddRequest;
use App\Http\Requests\SphereRequest;
use App\Http\Requests\SphereSpendRequest;
use App\Http\Requests\SphereToExperienceRequest;
use App\Models\Character;
use App\Models\Sphere;
use App\Services\IdeaService;

class SphereController extends Controller
{
    public function store(SphereRequest $request, Character $character)
    {
        $this->authorize('add-sphere', $character);

        $character->spheres()->create($request->validated());

        return to_route('characters.show', $character);
    }

    public function create(Character $character)
    {
        $this->authorize('add-sphere', $character);

        return view('spheres.create', compact('character'));
    }

    public function edit(Character $character, Sphere $sphere)
    {
        $this->authorize('manage-ideas', $character);

        return view('spheres.edit', compact('character', 'sphere'));
    }

    public function update(SphereRequest $request, Character $character, Sphere $sphere)
    {
        $this->authorize('manage-ideas', $character);

        $sphere->update($request->validated());

        return to_route('characters.show', $character);
    }

    public function destroy(Character $character, Sphere $sphere)
    {
        $this->authorize('manage-ideas', $character);

        $sphere->delete();

        return to_route('characters.show', $character);
    }

    public function spendView(Character $character, Sphere $sphere)
    {
        $this->authorize('manage-ideas', $character);

        return view('spheres.spend', compact('character', 'sphere'));
    }

    public function spend(IdeaService $ideaService, SphereSpendRequest $request, Character $character, Sphere $sphere)
    {
        $this->authorize('manage-ideas', $character);

        $ideaService->changeSpherePoints($sphere, -$request->validated('value'));

        return to_route('characters.show', $character);
    }

    public function addView(Character $character, Sphere $sphere)
    {
        $this->authorize('manage-ideasGm', $character);

        return view('spheres.add', compact('character', 'sphere'));
    }

    public function add(IdeaService $ideaService, SphereAddRequest $request, Character $character, Sphere $sphere)
    {
        $this->authorize('manage-ideas-gm', $character);

        $ideaService->changeSpherePoints($sphere, $request->validated('value'));

        return to_route('characters.show', $character);
    }

    public function experienceView(Character $character, Sphere $sphere)
    {
        $this->authorize('manage-ideas', $character);

        return view('spheres.experience', compact('character', 'sphere'));
    }

    public function experience(
        IdeaService $ideaService,
        SphereToExperienceRequest $request,
        Character $character,
        Sphere $sphere
    ) {
        $this->authorize('manage-ideas', $character);

        $ideaService->sphereToExperience($request->validated(), $character, $sphere);

        return to_route('characters.show', $character);
    }
}
