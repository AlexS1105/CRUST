<?php

namespace App\Http\Controllers;

use App\Enums\CharacterStatus;
use App\Events\CharacterDeleted;
use App\Events\CharacterCompletelyDeleted;
use App\Http\Requests\CharacterRequest;
use App\Models\Character;

class CharacterController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Character::class, 'character');
    }

    public function index()
    {
        return view('characters.index', [
            'characters' => auth()->user()->characters
        ]);
    }

    public function create()
    {
        return view('characters.create');
    }

    public function store(CharacterRequest $request)
    {
        $character = $request->validated();
        $character['user_id'] = auth()->id();
        
        $character = Character::create($character);
        
        $this->saveReference($character, $request);
        
        $character->charsheet()->create();

        return redirect(route('characters.index'));
    }

    public function show(Character $character)
    {
        return view('characters.show', [
            'character' => $character
        ]);
    }

    public function edit(Character $character)
    {
        return view('characters.edit', [
            'character' => $character
        ]);
    }

    public function update(CharacterRequest $request, Character $character)
    {
        $character->update($request->validated());

        $this->saveReference($character, $request);

        return redirect(route('characters.show', $character->login));
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

        return redirect(route('characters.index'));
    }

    private function saveReference(Character $character, CharacterRequest $request)
    {
        $file = $request->file('reference');

        if ($file) {
            // TODO: Existing references deleting

            $character->reference = str_replace('public/', 'storage/', 
                $file->storePubliclyAs('public/characters/references', $character->login.'.'.$file->extension()));
            $character->save();
        }
    }
}
