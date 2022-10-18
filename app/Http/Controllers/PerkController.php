<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerkRequest;
use App\Models\Perk;
use App\Services\PerkService;
use Illuminate\Http\Request;

class PerkController extends Controller
{
    public function index()
    {
        $perks = Perk::with('variants')->paginate(30);

        return view('perks.index', compact('perks'));
    }

    public function all(Request $request)
    {
        $perkType = $request->perk_type;
        $search = $request->search;
        $perks = Perk::with('variants')
            ->type($perkType)
            ->search($search)
            ->paginate(20);

        return view('perks.list', [
            'perks' => $perks,
            'search' => $search,
            'perkType' => $perkType,
        ]);
    }

    public function create()
    {
        return view('perks.create');
    }

    public function store(PerkService $perkService, PerkRequest $request)
    {
        $perkService->createPerk($request);

        return to_route('perks.index');
    }

    public function edit(Perk $perk)
    {
        return view('perks.edit', compact('perk'));
    }

    public function update(PerkRequest $request, Perk $perk)
    {
        $perk->update($request->validated());

        return to_route('perks.index');
    }

    public function destroy(Perk $perk)
    {
        $perk->delete();

        return to_route('perks.index');
    }
}
