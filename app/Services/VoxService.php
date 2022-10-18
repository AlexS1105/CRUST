<?php

namespace App\Services;

use App\Models\VoxLog;

class VoxService
{
    public function giveVox($character, $delta, $reason)
    {
        if ($delta !== 0) {
            VoxLog::create([
                'character_id' => $character->id,
                'issued_by' => auth()->user()->id,
                'before' => $character->vox,
                'after' => $character->vox + $delta,
                'reason' => $reason,
                'delta' => $delta,
            ]);

            $character->vox += $delta;
            $character->save();
        }
    }
}
