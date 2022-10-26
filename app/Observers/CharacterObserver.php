<?php

namespace App\Observers;

use App\Jobs\ExportCharacter;
use App\Models\Character;
use App\Services\NotionService;

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
            'user' => auth()->user() !== null ? auth()->user()->login : null,
            'character' => $character->login,
        ]);

        if ($character->registered) {
            ExportCharacter::dispatch($character);
        }
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
