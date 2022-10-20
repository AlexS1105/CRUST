<?php

namespace App\Http\Controllers;

use App\Enums\CharacterStatus;
use App\Http\Requests\CharacterRequest;
use App\Models\Character;
use App\Models\Perk;
use App\Services\CharacterService;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public $characterService;

    public function __construct(CharacterService $characterService)
    {
        $this->authorizeResource(Character::class, 'character');

        $this->characterService = $characterService;
    }

    public function index()
    {
        $characters = auth()->user()->characters;

        return view('characters.index', compact('characters'));
    }

    public function all(Request $request)
    {
        $this->authorize('view-any', Character::class);

        $characters = Character::filter($request)
            ->status(CharacterStatus::Approved)
            ->sortable()
            ->paginate(48);
        $search = request('search');
        $perks = Perk::all();
        $perk = request('perk');

        return view('characters.all', compact('characters', 'search', 'perks', 'perk'));
    }

    public function store(CharacterRequest $request)
    {
        $character = $this->characterService->create($request);

        return to_route('characters.charsheet.edit', $character->login);
    }

    public function create()
    {
        return view('characters.create');
    }

    public function show(Character $character)
    {
        return view('characters.show', compact('character'));
    }

    public function edit(Character $character)
    {
        return view('characters.edit', compact('character'));
    }

    public function update(CharacterRequest $request, Character $character)
    {
        $this->characterService->update($character, $request);

        return to_route(
            $request->user()->can('update-charsheet', $character)
                ? 'characters.charsheet.edit' : 'characters.show',
            $character
        );
    }

    public function destroy(Character $character)
    {
        $this->characterService->delete($character);

        return back();
    }

    public function restore(Character $character)
    {
        $this->characterService->restore($character);

        return back();
    }

    public function forceDestroy(Character $character)
    {
        $this->characterService->forceDelete($character);

        return to_route('characters.index');
    }
}
