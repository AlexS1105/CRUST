<?php

namespace App\Services;

class ExperienceService
{
    public function changeExperience($character, $delta, $reason)
    {
        if ($delta !== 0) {
            $character->experienceLogs()->create([
                'issued_by' => auth()->user()?->id,
                'before' => $character->experience,
                'after' => $character->experience + $delta,
                'reason' => $reason,
                'delta' => $delta,
            ]);

            $character->experience += $delta;
            $character->save();
        }
    }
}
