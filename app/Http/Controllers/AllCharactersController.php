<?php

namespace App\Http\Controllers;

use App\Enums\CharacterStatus;
use App\Models\Character;
use App\Models\Perk;

class AllCharactersController extends Controller
{
    public function __invoke()
    {
        $search = request('search');
        $created_at = request('created_at', 'asc');
        $updated_at = request('updated_at');
        $perk = request('perk');
        $characters = Character::where('characters.name', 'like', '%'.$search.'%')
            ->where('characters.status', CharacterStatus::Approved);

        if (isset($perk)) {
            $characters->whereHas('perkVariants', function ($query) use ($perk) {
                $query->where('perk_id', $perk);
            });
        }

        if (isset($updated_at)) {
            if ($updated_at == 'asc') {
                $characters->latest('updated_at');
            } else {
                $characters->oldest('updated_at');
            }
        } else {
            if ($created_at == 'asc') {
                $characters->latest('created_at');
            } else {
                $characters->oldest('created_at');
            }
        }

        return view('characters.all', [
            'search' => $search,
            'characters' => $characters->paginate(48),
            'perks' => Perk::all(),
            'perk' => $perk
        ]);
    }
}
