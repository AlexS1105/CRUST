<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerkVariantRequest;
use App\Models\Perk;
use App\Models\PerkVariant;

class PerkVariantController extends Controller
{
    public function create(Perk $perk)
    {
        return view('perks.variants.create', [
            'perk' => $perk
        ]);
    }

    public function store(PerkVariantRequest $request, Perk $perk)
    {
        $perkVariant = $request->validated();
        $perkVariant['perk_id'] = $perk->id;
        Perk::create($perkVariant);

        return redirect()->route('perks.index');
    }

    public function edit(PerkVariant $perkVariant, Perk $perk)
    {
        return view('perks.variants.edit', [
            'perk' => $perk,
            'perkVariant' => $perkVariant
        ]);
    }

    public function update(PerkVariantRequest $request, PerkVariant $perkVariant, Perk $perk)
    {
        return redirect()->route('perks.index');
    }

    public function destroy(PerkVariant $perkVariant)
    {
        return redirect()->route('perks.index');
    }
}
