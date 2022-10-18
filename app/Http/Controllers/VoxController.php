<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoxRequest;
use App\Models\Character;
use App\Services\VoxService;

class VoxController extends Controller
{
    public function index(Character $character)
    {
        $this->authorize('voxView', $character);

        return view('vox.index', compact('character'));
    }

    public function create(Character $character)
    {
        $this->authorize('voxCreate', $character);

        return view('vox.create', compact('character'));
    }

    public function store(VoxService $voxService, VoxRequest $request, Character $character)
    {
        $this->authorize('voxCreate', $character);

        $voxService->giveVox($character, ...$request->validated());

        return to_route('characters.vox.index', $character);
    }
}
