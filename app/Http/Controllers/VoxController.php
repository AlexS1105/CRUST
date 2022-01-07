<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoxRequest;
use App\Models\Character;
use App\Models\VoxLog;

class VoxController extends Controller
{
    public function index(Character $character)
    {
        $this->authorize('voxView', $character);

        return view('vox.index', [
            'character' => $character
        ]);
    }

    public function create(Character $character)
    {
        $this->authorize('voxCreate', $character);
        return view('vox.create', [
            'character' => $character
        ]);
    }

    public function store(VoxRequest $request, Character $character)
    {
        $this->authorize('voxCreate', $character);
        $validated = $request->validated();
        $character->giveVox($validated['delta'], $validated['reason']);

        return redirect()->route('characters.vox.index', $character);
    }
}
