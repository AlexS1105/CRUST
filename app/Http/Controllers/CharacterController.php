<?php

namespace App\Http\Controllers;

use App\Models\Character;

class CharacterController extends Controller
{
    public function index() {
        return view('character.index', [
            'characters' => auth()->user()->characters
        ]);
    }

    public function show(Character $character) {
        return view('character.show', [
            'character' => $character
        ]);
    }
}
