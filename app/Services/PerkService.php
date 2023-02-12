<?php

namespace App\Services;

use App\Http\Requests\PerkRequest;
use App\Models\Perk;

class PerkService
{
    public function createPerk(PerkRequest $request)
    {
        Perk::create($request->validated());
    }
}
