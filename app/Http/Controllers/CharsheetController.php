<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharsheetRequest;
use App\Models\Character;

class CharsheetController extends Controller
{
    public function edit(Character $character)
    {
        return view('characters.charsheet', [
            'character' => $character
        ]);
    }

    public function update(CharsheetRequest $request, Character $character)
    {
        $validated = $request->validated();
        $character->charsheet()->update($validated);
        return redirect()->route('characters.show', $character->login);
    }
}
