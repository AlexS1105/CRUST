<?php

namespace App\Http\Controllers;

use App\Http\Requests\TalentRequest;
use App\Models\Talent;

class TalentController extends Controller
{
    public function index()
    {
        $talents = Talent::all();

        return view('talents.index', compact('talents'));
    }

    public function all()
    {
        $talents = Talent::all();

        return view('talents.list', compact('talents'));
    }

    public function create()
    {
        return view('talents.create');
    }

    public function store(TalentRequest $request)
    {
        Talent::create($request->validated());

        return to_route('talents.index');
    }

    public function edit(Talent $talent)
    {
        return view('talents.edit', compact('talent'));
    }

    public function update(TalentRequest $request, Talent $talent)
    {
        $talent->update($request->validated());

        return to_route('talents.index');
    }

    public function destroy(Talent $talent)
    {
        $talent->delete();

        return to_route('talents.index');
    }
}
