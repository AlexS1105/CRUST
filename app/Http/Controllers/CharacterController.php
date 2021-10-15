<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterRequest;
use App\Models\Character;

class CharacterController extends Controller
{
    public function index() {
        return view('character.index', [
            'characters' => auth()->user()->characters
        ]);
    }

    public function create() {
        return view('character.create');
    }

    public function store(CharacterRequest $request) {
        $character = $request->validated();
        $character['user_id'] = auth()->id();
        
        $character = Character::create($character);
        $character->charsheet()->create();

        return redirect(route('characters.index'));
    }

    public function show(Character $character) {
        return view('character.show', [
            'character' => $character
        ]);
    }

    public function edit(Character $character) {
        return view('character.edit', [
            'character' => $character
        ]);
    }

    public function update(CharacterRequest $request, Character $character) {
        $file = $request->file('reference');

        if ($file) {
            $character->reference = str_replace('public/', 'storage/', 
                $file->storePubliclyAs('public/characters/references', $character->login.'.'.$file->extension()));
        }

        $character->update($request->validated());

        return redirect(route('characters.show', $character->login));
    }

    public function destroy(Character $character) {
        $character->delete();
        return redirect(route('characters.index'));
    }
}
