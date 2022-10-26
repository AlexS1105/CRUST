<?php

namespace App\Observers;

use App\Models\Character;

class CharacterObserver
{
    /**
     * Handle the Character "created" event.
     *
     * @param Character $character
     * @return void
     */
    public function created(Character $character)
    {
        info('Character created', [
            'user' => $character->user,
            'character' => $character->login,
        ]);
    }

    /**
     * Handle the Character "updated" event.
     *
     * @param Character $character
     * @return void
     */
    public function updated(Character $character)
    {
        info('Character updated', [
            'user' => auth()->user()->login,
            'character' => $character->login,
        ]);
    }

    /**
     * Handle the Character "deleted" event.
     *
     * @param Character $character
     * @return void
     */
    public function deleted(Character $character)
    {
        $character->charsheet?->delete();

        \Storage::disk('characters')->deleteDirectory($character->id);
    }
}
