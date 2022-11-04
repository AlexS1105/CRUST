<?php

namespace App\Services;

class BanService
{
    public function ban($user, $validated)
    {
        $validated['banned_by'] = auth()->id();
        $validated['user_id'] = $user->id;

        $user->ban()->updateOrCreate(['user_id' => $user->id], $validated);
    }
}
