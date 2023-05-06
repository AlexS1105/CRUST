<?php

namespace App\Http\Controllers;

use App\Http\Requests\TechniqueRequest;
use App\Models\Technique;

class TechniqueController extends Controller
{
    public function index()
    {
        $techniques = Technique::all();

        return view('techniques.index', compact('techniques'));
    }

    public function all()
    {
        $techniques = Technique::all();

        return view('techniques.list', compact('techniques'));
    }

    public function create()
    {
        return view('techniques.create');
    }

    public function store(TechniqueRequest $request)
    {
        Technique::create($request->validated());

        return to_route('techniques.index');
    }

    public function edit(Technique $technique)
    {
        return view('techniques.edit', compact('technique'));
    }

    public function update(TechniqueRequest $request, Technique $technique)
    {
        $technique->update($request->validated());

        return to_route('techniques.index');
    }

    public function destroy(Technique $technique)
    {
        $technique->delete();

        return to_route('techniques.index');
    }
}
