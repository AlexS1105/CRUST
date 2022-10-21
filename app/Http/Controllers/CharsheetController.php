<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterFateRequest;
use App\Http\Requests\CharacterPerkRequest;
use App\Http\Requests\CharsheetRequest;
use App\Models\Character;
use App\Models\Perk;
use App\Models\PerkVariant;
use App\Services\CharsheetService;
use App\Settings\CharsheetSettings;

class CharsheetController extends Controller
{
    public $settings;
    public $charsheetService;

    public function __construct(CharsheetSettings $settings, CharsheetService $charsheetService)
    {
        $this->settings = $settings;
        $this->charsheetService = $charsheetService;
    }

    public function edit(Character $character)
    {
        $this->authorize('update-charsheet', $character);

        $perks = Perk::with('variants')->get();
        $settings = $this->settings;

        return view('characters.charsheet', compact('character', 'perks', 'settings'));
    }

    public function update(CharsheetRequest $request, Character $character)
    {
        $this->authorize('update-charsheet', $character);

        $this->charsheetService->update($character, $request->validated());

        return to_route('characters.show', $character);
    }

    public function editPerks(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $perks = Perk::with('variants')->get();
        $settings = $this->settings;

        return view('characters.perks', compact('character', 'perks', 'settings'));
    }

    public function updatePerks(CharacterPerkRequest $request, Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $this->charsheetService->savePerks($character, $request->validated());

        return to_route('characters.show', $character);
    }

    public function editFates(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $settings = $this->settings;

        return view('characters.fates', compact('character', 'settings'));
    }

    public function updateFates(CharacterFateRequest $request, Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $this->charsheetService->saveFates($character, $request->validated());

        return to_route('characters.show', $character);
    }

    public function togglePerk(Character $character, PerkVariant $perkVariant)
    {
        $this->authorize('toggle-perks', $character);

        return $this->charsheetService->togglePerk($character, $perkVariant);
    }
}
