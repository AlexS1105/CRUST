<?php

namespace App\Services;

use App\Enums\CharacterStatus;
use App\Events\CharacterCompletelyDeleted;
use App\Events\CharacterDeleted;
use App\Models\Character;
use Illuminate\Support\Facades\Storage;

class CharacterService
{
    public function create($request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        unset($validated['reference']);

        $character = Character::create($validated);

        $this->saveReference($character, $request);

        $character->charsheet()->create();

        return $character;
    }

    public function update($character, $request)
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
    }

    public function saveReference($character, $request)
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

    public function delete($character)
    {
        $character->status = CharacterStatus::Deleting;
        $character->save();

        event(new CharacterDeleted($character));
    }

    public function restore($character)
    {
        $character->status = CharacterStatus::Blank;
        $character->save();
    }

    public function forceDelete($character)
    {
        event(new CharacterCompletelyDeleted($character));

        $character->delete();
    }
}
