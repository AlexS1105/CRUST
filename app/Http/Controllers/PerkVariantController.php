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
            'perk' => $perk,
        ]);
    }

    public function store(PerkVariantRequest $request, Perk $perk)
    {
        $variant = $request->validated();
        $variant['perk_id'] = $perk->id;
        PerkVariant::create($variant);

        return redirect()->route('perks.index');
    }

    public function edit(Perk $perk, PerkVariant $variant)
    {
        return view('perks.variants.edit', [
            'perk' => $perk,
            'variant' => $variant,
        ]);
    }

    public function update(PerkVariantRequest $request, Perk $perk, PerkVariant $variant)
    {
        $variant->update($request->validated());

        return redirect()->route('perks.index');
    }

    public function destroy(Perk $perk, PerkVariant $variant)
    {
        $variant->delete();

        return redirect()->route('perks.index');
    }
}
