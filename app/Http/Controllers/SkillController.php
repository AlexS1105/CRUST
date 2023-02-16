<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkillRequest;
use App\Models\Skill;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::all();

        return view('skills.index', compact('skills'));
    }

    public function all()
    {
        $skills = Skill::all();

        return view('skills.list', compact('skills'));
    }

    public function create()
    {
        return view('skills.create');
    }

    public function store(SkillRequest $request)
    {
        Skill::create($request->validated());

        return to_route('skills.index');
    }

    public function edit(Skill $skill)
    {
        return view('skills.edit', compact('skill'));
    }

    public function update(SkillRequest $request, Skill $skill)
    {
        $skill->update($request->validated());

        return to_route('skills.index');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return to_route('skills.index');
    }
}
