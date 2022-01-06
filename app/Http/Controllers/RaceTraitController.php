<?php

namespace App\Http\Controllers;

use App\Http\Requests\RaceTraitRequest;
use App\Models\RaceTrait;

class RaceTraitController extends Controller
{
    public function index()
    {
        return view('traits.index', [
            'traits' => RaceTrait::paginate(10)
        ]);
    }

    public function create()
    {
        return view('traits.create');
    }

    public function store(RaceTraitRequest $request)
    {
        RaceTrait::create($request->validated());

        return redirect()->route('traits.index');
    }

    public function edit(RaceTrait $trait)
    {
        return view('traits.edit', [
            'trait' => $trait
        ]);
    }

    public function update(RaceTraitRequest $request, RaceTrait $trait)
    {
        $trait->update($request->validated());

        return redirect()->route('traits.index');
    }

    public function destroy(RaceTrait $trait)
    {
        $trait->delete();

        return redirect()->route('traits.index');
    }
}
