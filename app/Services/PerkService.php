<?php

namespace App\Services;

use App\Http\Requests\PerkRequest;
use App\Models\Perk;

class PerkService
{
    public function createPerk(PerkRequest $request)
    {
        $validated = $request->validated();

        $perk = Perk::create($validated);

        $perk->variants()->create([
            'description' => $validated['description'],
        ]);
    }
}
