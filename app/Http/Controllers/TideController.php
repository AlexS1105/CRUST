<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterExperienceRequest;
use App\Http\Requests\CharacterTideRequest;
use App\Models\Character;
use App\Services\CharsheetService;
use App\Services\ExperienceService;

class TideController extends Controller
{
    public function index(Character $character)
    {
        $this->authorize('see-player-only-info', $character);

        return view('tides.index', compact('character'));
    }

    public function edit(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        return view('tides.edit', compact('character'));
    }

    public function update(CharsheetService $service, CharacterTideRequest $request, Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $service->saveTides($character, $request->validated());

        return to_route('characters.tides.index', $character);
    }
}
