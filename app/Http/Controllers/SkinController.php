<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkinRequest;
use App\Models\Character;
use App\Models\Skin;
use Illuminate\Support\Facades\Storage;

class SkinController extends Controller
{
    public function index(Character $character)
    {
        $this->authorize('seePlayerOnlyInfo', $character);

        return view('skins.index', [
            'character' => $character
        ]);
    }

    public function create(Character $character)
    {
        $this->authorize('update', $character);

        return view('skins.create', [
            'character' => $character
        ]);
    }

    public function store(SkinRequest $request, Character $character)
    {
        $this->authorize('update', $character);
        $validated = $request->validated();
        $validated['character_id'] = $character->id;
        $skin = Skin::firstOrCreate([
            'prefix' => $validated['prefix']
        ], $validated);
        $this->saveSkin($request, $skin);

        return redirect()->route('characters.skins.index', $character);
    }

    public function destroy(Character $character, Skin $skin)
    {
        $this->authorize('update', $character);
        $skin->delete();

        return redirect()->route('characters.skins.index', $character);
    }

    private function saveSkin($request, $skin)
    {
        $file = $request->file('skin');

        if ($file) {
            Storage::delete('characters/skins/'.basename($skin->skin));

            $skin->skin = str_replace('public/', 'storage/', 
                $file->storePubliclyAs('characters/skins', (isset($skin->prefix) ? $skin->prefix.'_' : '').$skin->character->login.'.'.$file->extension()));
            $skin->save();
        }
    }
}
