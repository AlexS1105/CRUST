<?php

namespace App\Observers;

use App\Models\Character;
use App\Services\CharacterService;
use App\Services\SkinService;

class CharacterObserver
{
    /**
     * Handle the Character "created" event.
     *
     * @param  \App\Models\Character  $character
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
     * @param  \App\Models\Character  $character
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
     * @param  \App\Models\Character  $character
     * @return void
     */
    public function deleted(Character $character)
    {
        $character->charsheet?->delete();

        app(CharacterService::class)->deleteReferences($character);
        app(SkinService::class)->deleteSkin($character, 'default');
    }
}
