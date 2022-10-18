<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class SkinService
{
    public function upload($character, $request)
    {
        $validated = $request->validated();

        $skin = $character->skins()->updateOrCreate([
            'prefix' => $validated['prefix'],
            'character_id' => $character->id,
        ], $validated);

        $this->saveSkin($request->file('skin'), $skin);
    }

    public function saveSkin($file, $skin)
    {
        Storage::delete('characters/skins/'.basename($skin->skin));

        $skin->skin = str_replace(
            'public/',
            'storage/',
            $file->storePubliclyAs('characters/skins', (isset($skin->prefix) ? $skin->prefix.'_' : '').$skin->character->login.'.'.$file->extension())
        );
        $skin->save();
    }
}
