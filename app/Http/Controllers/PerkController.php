<?php

namespace App\Http\Controllers;

use App\Enums\PerkType;
use App\Http\Requests\PerkRequest;
use App\Models\Perk;
use App\Models\PerkVariant;

class PerkController extends Controller
{
    public function index()
    {
        return view('perks.index', [
            'perks' => Perk::with('variants')
                ->paginate(30)
        ]);
    }

    public function create()
    {
        return view('perks.create');
    }

    public function store(PerkRequest $request)
    {
        $validated = $request->validated();
        $validated = $this->setFlags($validated);

        $perk = Perk::create([
            'name' => $validated['name'],
            'general_description' => $validated['general_description'],
            'type' => $validated['type']
        ]);
        
        PerkVariant::create(['perk_id' => $perk->id, 'description' => $validated['description']]);

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
        $validated = $request->validated();
        $validated = $this->setFlags($validated);
        $perk->update($validated);

        return redirect()->route('perks.index');
    }

    public function destroy(Perk $perk)
    {
        $perk->delete();

        return redirect()->route('perks.index');
    }

    private function setFlags($validated)
    {
        $validated['type'] = PerkType::None();

        if ($validated['combat']) {
            $validated['type']->addFlag(PerkType::Combat);
        }

        unset($validated['combat']);

        if ($validated['attack']) {
            $validated['type']->addFlag(PerkType::Attack);
        }

        unset($validated['attack']);

        if ($validated['defence']) {
            $validated['type']->addFlag(PerkType::Defence);
        }
        
        unset($validated['defence']);

        return $validated;
    }
}
