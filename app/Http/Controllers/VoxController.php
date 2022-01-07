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
        
        $validated['character_id'] = $character->id;
        $validated['issued_by'] = $request->user()->id;
        $validated['before'] = $character->vox;
        $validated['after'] = $character->vox + $validated['delta'];

        VoxLog::create($validated);
        $character->vox += $validated['delta'];
        $character->save();

        return redirect()->route('characters.vox.index', $character);
    }
}
