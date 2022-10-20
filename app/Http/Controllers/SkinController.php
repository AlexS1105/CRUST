<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkinRequest;
use App\Models\Character;
use App\Models\Skin;
use App\Services\SkinService;
use Illuminate\Support\Facades\Request;

class SkinController extends Controller
{
    protected $skinService;

    public function __construct(SkinService $skinService)
    {
        $this->skinService = $skinService;
    }

    public function index(Character $character)
    {
        $this->authorize('see-player-only-info', $character);

        $skins = $this->skinService->getSkins($character);

        return view('skins.index', compact('character', 'skins'));
    }

    public function create(Character $character)
    {
        $this->authorize('update', $character);

        return view('skins.create', compact('character'));
    }

    public function store(SkinRequest $request, Character $character)
    {
        $this->authorize('update', $character);

        $this->skinService->upload($character, $request);

        return to_route('characters.skins.index', $character);
    }

    public function destroy(Character $character)
    {
        $this->authorize('update', $character);

        $this->skinService->deleteSkin($character, request('prefix'));

        return to_route('characters.skins.index', $character);
    }
}
