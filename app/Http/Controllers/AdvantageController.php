<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvantageRequest;
use App\Models\Advantage;
use App\Models\Skill;

class AdvantageController extends Controller
{
    public function create(Skill $skill)
    {
        return view('advantages.create', compact('skill'));
    }

    public function store(AdvantageRequest $request, Skill $skill)
    {
        $skill->advantages()->create($request->validated());

        return to_route('skills.index');
    }

    public function edit(Skill $skill, Advantage $advantage)
    {
        return view('advantages.edit', compact('skill', 'advantage'));
    }

    public function update(AdvantageRequest $request, Skill $skill, Advantage $advantage)
    {
        $advantage->update($request->validated());

        return to_route('skills.index');
    }

    public function destroy(Skill $skill, Advantage $advantage)
    {
        $advantage->delete();

        return to_route('skills.index');
    }
}
