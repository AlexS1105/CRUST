<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerkRequest;
use App\Models\Perk;
use App\Models\PerkVariant;

class PerkController extends Controller
{
    public function index()
    {
        return view('perks.index', [
            'perks' => Perk::with('variants')
                ->paginate(10)
        ]);
    }

    public function create()
    {
        return view('perks.create');
    }

    public function store(PerkRequest $request)
    {
        $perk = $request->validated();
        $perk = Perk::create($perk);
        $perkVariant = PerkVariant::create(['perk_id' => $perk->id, 'description' => $perk->description]);

        return redirect()->route('perks.index');
    }

    public function edit(Perk $perk)
    {
        return view('perks.edit', [
            'perk' => $perk
        ]);
    }

    public function update(PerkRequest $request, Perk $perk)
    {
        $perk->update($request->validated());

        return redirect()->route('perks.index');
    }

    public function destroy(Perk $perk)
    {
        $perk->delete();

        return redirect()->route('perks.index');
    }
}
