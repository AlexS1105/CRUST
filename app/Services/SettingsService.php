<?php

namespace App\Services;

use App\Http\Requests\CharsheetSettingsRequest;
use App\Models\Character;
use App\Settings\CharsheetSettings;

class SettingsService
{
    public function __construct(protected CharacterService $characterService)
    {
    }

    public function update(CharsheetSettings $settings, CharsheetSettingsRequest $request)
    {
        $settings->update($request->validated());

        Character::where('registered', 0)
            ->get()
            ->each(function ($character) {
                $this->characterService->resetStartPoints($character);
            });
    }
}
