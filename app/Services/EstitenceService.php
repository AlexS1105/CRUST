<?php

namespace App\Services;

use App\Models\EstitenceLog;

class EstitenceService
{
    public function changeEstitence($character, $delta, $reason)
    {
        if ($delta !== 0) {
            EstitenceLog::create([
                'character_id' => $character->id,
                'issued_by' => auth()->user()?->id,
                'before' => $character->estitence,
                'after' => $character->estitence + $delta,
                'reason' => $reason,
                'delta' => $delta,
            ]);

            $character->estitence += $delta;
            $character->save();
        }
    }
}
