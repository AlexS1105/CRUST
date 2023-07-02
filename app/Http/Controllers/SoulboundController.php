<?php

namespace App\Http\Controllers;

use App\Http\Requests\SoulboundRequest;
use App\Models\Character;
use App\Models\Soulbound;

class SoulboundController extends Controller
{
    public function create(Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        return view('soulbound.create', compact('character'));
    }

    public function store(SoulboundRequest $request, Character $character)
    {
        $this->authorize('update-charsheet-gm', $character);

        $character->soulbounds()->create($request->validated());

        return to_route('characters.show', $character);
    }

    public function edit(Character $character, Soulbound $soulbound)
    {
        $this->authorize('update-charsheet-gm', $character);

        return view('soulbound.edit', compact('character', 'soulbound'));
    }

    public function update(SoulboundRequest $request, Character $character, Soulbound $soulbound)
    {
        $this->authorize('update-charsheet-gm', $character);

        $soulbound->update($request->validated());

        return to_route('characters.show', $character);
    }

    public function destroy(Character $character, Soulbound $soulbound)
    {
        $this->authorize('update-charsheet-gm', $character);

        $soulbound->delete();

        return to_route('characters.show', $character);
    }
}
