<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkinRequest;
use App\Models\Character;
use App\Models\Skin;
use App\Services\SkinService;

class SkinController extends Controller
{
    public function index(Character $character)
    {
        $this->authorize('see-player-only-info', $character);

        return view('skins.index', compact('character'));
    }

    public function create(Character $character)
    {
        $this->authorize('update', $character);

        return view('skins.create', compact('character'));
    }

    public function store(SkinService $skinService, SkinRequest $request, Character $character)
    {
        $this->authorize('update', $character);

        $skinService->upload($character, $request);

        return to_route('characters.skins.index', $character);
    }

    public function destroy(Character $character, Skin $skin)
    {
        $this->authorize('update', $character);

        $skin->delete();

        return to_route('characters.skins.index', $character);
    }
}
