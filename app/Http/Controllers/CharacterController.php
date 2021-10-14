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
        
        Character::create($character);

        return redirect(route('characters.index'));
    }

    public function show(Character $character) {
        return view('character.show', [
            'character' => $character
        ]);
    }
}
