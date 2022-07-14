<?php

namespace App\Http\Controllers;

use App\Enums\CharacterStatus;
use App\Models\Character;

class AllCharactersController extends Controller
{
    public function __invoke()
    {
        $search = request('search');
        $created_at = request('created_at', 'asc');
        $updated_at = request('updated_at');
        $characters = Character::where('characters.name', 'like', '%'.$search.'%')
            ->where('characters.status', CharacterStatus::Approved);

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
            'characters' => $characters->paginate(3)
        ]);
    }
}
