<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterFateRequest;
use App\Http\Requests\CharacterPerkRequest;
use App\Http\Requests\CharsheetRequest;
use App\Models\Character;
use App\Models\Fate;
use App\Models\NarrativeCraft;
use App\Models\Perk;
use App\Models\PerkVariant;
use App\Services\CharsheetService;
use App\Settings\CharsheetSettings;
use Exception;

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
        $perks = Perk::with('variants')->get();
        $settings = $this->settings;

        return view('characters.charsheet', compact('character', 'perks', 'settings'));
    }

    public function update(CharsheetRequest $request, Character $character)
    {
        $this->charsheetService->update($character, $request->validated());

        return to_route('characters.show', $character);
    }

    public function editPerks(Character $character)
    {
        $perks = Perk::with('variants')->get();
        $settings = $this->settings;

        return view('characters.perks', compact('character', 'perks', 'settings'));
    }

    public function updatePerks(CharacterPerkRequest $request, Character $character)
    {
        $this->charsheetService->savePerks($character, $request->validated());

        return to_route('characters.show', $character);
    }

    public function editFates(Character $character)
    {
        $settings = $this->settings;

        return view('characters.fates', compact('character', 'settings'));
    }

    public function updateFates(CharacterFateRequest $request, Character $character)
    {
        $this->charsheetService->saveFates($character, $request->validated());

        return to_route('characters.show', $character);
    }

    public function togglePerk(Character $character, PerkVariant $perkVariant)
    {
        return $this->charsheetService->togglePerk($character, $perkVariant);
    }
}
