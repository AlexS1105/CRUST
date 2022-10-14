<?php

namespace App\Http\Controllers;

use App\Http\Requests\SphereRequest;
use App\Models\Character;
use App\Models\Sphere;
use App\Rules\SphereHasEnough;
use App\Rules\SphereToExperience;
use Illuminate\Http\Request;

class SphereController extends Controller
{
    public function create(Character $character)
    {
        $this->authorize('addSphere', $character);

        return view('spheres.create', [
            'character' => $character,
        ]);
    }

    public function store(SphereRequest $request, Character $character)
    {
        $this->authorize('addSphere', $character);
        $validated = $request->validated();
        $character->spheres()->create($validated);

        return redirect()->route('characters.show', $character);
    }

    public function edit(Character $character, Sphere $sphere)
    {
        $this->authorize('manageIdeas', $character);

        return view('spheres.edit', [
            'character' => $character,
            'sphere' => $sphere,
        ]);
    }

    public function update(SphereRequest $request, Character $character, Sphere $sphere)
    {
        $this->authorize('manageIdeas', $character);
        $validated = $request->validated();
        $sphere->update($validated);

        return redirect()->route('characters.show', $character);
    }

    public function destroy(Character $character, Sphere $sphere)
    {
        $this->authorize('manageIdeas', $character);
        $sphere->delete();

        return redirect()->route('characters.show', $character);
    }

    public function spendView(Character $character, Sphere $sphere)
    {
        $this->authorize('manageIdeas', $character);

        return view('spheres.spend', [
            'character' => $character,
            'sphere' => $sphere,
        ]);
    }

    public function spend(Request $request, Character $character, Sphere $sphere)
    {
        $this->authorize('manageIdeas', $character);
        $validated = $request->validate([
            'value' => ['required', 'min:1', 'max:100', new SphereHasEnough($sphere)],
        ]);

        $sphere->value -= $validated['value'];
        $sphere->save();

        return redirect()->route('characters.show', $character);
    }

    public function addView(Character $character, Sphere $sphere)
    {
        $this->authorize('manageIdeasGm', $character);

        return view('spheres.add', [
            'character' => $character,
            'sphere' => $sphere,
        ]);
    }

    public function add(Request $request, Character $character, Sphere $sphere)
    {
        $this->authorize('manageIdeasGm', $character);
        $validated = $request->validate([
            'value' => ['required', 'min:1', 'max:100'],
        ]);

        $sphere->value += $validated['value'];
        $sphere->save();

        return redirect()->route('characters.show', $character);
    }

    public function experienceView(Character $character, Sphere $sphere)
    {
        $this->authorize('manageIdeas', $character);

        return view('spheres.experience', [
            'character' => $character,
            'sphere' => $sphere,
        ]);
    }

    public function experience(Request $request, Character $character, Sphere $sphere)
    {
        $this->authorize('manageIdeas', $character);
        $validated = $request->validate([
            'experience' => ['required', 'exists:experiences,id', new SphereToExperience($sphere, $request->get('value', 1))],
            'value' => ['required', 'integer'],
        ]);

        $experience = $character->experiences->find($validated['experience']);
        $experience->increaseFromSphere($sphere, $validated);

        return redirect()->route('characters.show', $character);
    }
}
