<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstitenceRequest;
use App\Models\Character;
use App\Services\EstitenceService;

class EstitenceController extends Controller
{
    public function index(Character $character)
    {
        $this->authorize('estitenceView', $character);

        return view('estitence.index', compact('character'));
    }

    public function create(Character $character)
    {
        $this->authorize('estitenceCreate', $character);

        return view('estitence.create', compact('character'));
    }

    public function store(EstitenceService $estitenceService, EstitenceRequest $request, Character $character)
    {
        $this->authorize('estitenceCreate', $character);

        $estitenceService->changeEstitence($character, ...$request->validated());

        return to_route('characters.estitence.index', $character);
    }
}
