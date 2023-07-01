<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterExperienceRequest;
use App\Models\Character;
use App\Services\ExperienceService;

class ExperienceController extends Controller
{
    public function index(Character $character)
    {
        $this->authorize('see-player-only-info', $character);

        return view('experience.index', compact('character'));
    }

    public function create(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        return view('experience.create', compact('character'));
    }

    public function store(ExperienceService $service, CharacterExperienceRequest $request, Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $service->changeExperience($character, ...$request->validated());

        return to_route('characters.experience.index', $character);
    }
}
