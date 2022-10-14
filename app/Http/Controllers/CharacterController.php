<?php

namespace App\Http\Controllers;

use App\Enums\CharacterStatus;
use App\Events\CharacterCompletelyDeleted;
use App\Events\CharacterDeleted;
use App\Http\Requests\CharacterRequest;
use App\Models\Character;
use App\Models\Perk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CharacterController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Character::class, 'character');
    }

    public function index()
    {
        return view('characters.index', [
            'characters' => auth()->user()->characters,
        ]);
    }

    public function all(Request $request)
    {
        $this->authorize('view-any', Character::class);

        $characters = Character::filter($request)
            ->where('status', CharacterStatus::Approved)
            ->sortable()
            ->paginate(48);
        $search = request('search');
        $perks = Perk::all();
        $perk = request('perk');

        return view('characters.all', compact('characters', 'search', 'perks', 'perk'));
    }

    public function create()
    {
        return view('characters.create');
    }

    public function store(CharacterRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        unset($validated['reference']);

        $character = Character::create($validated);

        $this->saveReference($character, $request);

        $character->charsheet()->create();

        return redirect()->route('characters.charsheet.edit', $character->login);
    }

    public function show(Character $character)
    {
        return view('characters.show', [
            'character' => $character,
        ]);
    }

    public function edit(Character $character)
    {
        return view('characters.edit', [
            'character' => $character,
        ]);
    }

    public function update(CharacterRequest $request, Character $character)
    {
        $charsheet = $character->charsheet;
        $validated = $request->validated();
        unset($validated['reference']);
        $character->update($validated);

        if ($charsheet->character !== $character->login) {
            $charsheet->character = $character->login;
            $charsheet->save();
        }

        $this->saveReference($character, $request);

        if ($request->user()->can('updateCharsheet', $character)) {
            return redirect()->route('characters.charsheet.edit', $character);
        }
        return redirect()->route('characters.show', $character);
    }

    public function destroy(Character $character)
    {
        $character->setStatus(CharacterStatus::Deleting());

        event(new CharacterDeleted($character));

        return back();
    }

    public function restore(Character $character)
    {
        $character->setStatus(CharacterStatus::Blank());
        return back();
    }

    public function forceDestroy(Character $character)
    {
        event(new CharacterCompletelyDeleted($character));

        $character->delete();

        return redirect()->route('characters.index');
    }

    private function saveReference(Character $character, CharacterRequest $request)
    {
        $file = $request->file('reference');

        if ($file) {
            if ($character->reference !== 'storage/characters/references/_default.png') {
                Storage::delete('characters/references/'.basename($character->reference));
            }

            $character->reference = str_replace(
                'public/',
                'storage/',
                $file->storePubliclyAs('characters/references', $character->login.'.'.$file->extension())
            );
            $character->save();
        } elseif ($character->reference === 'storage/characters/references/_default.png') {
            $character->reference = 'characters/references/_default.png';
            $character->save();
        }
    }
}
