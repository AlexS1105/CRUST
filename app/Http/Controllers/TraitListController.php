<?php

namespace App\Http\Controllers;

use App\Models\RaceTrait;
use Illuminate\Http\Request;

class TraitListController extends Controller
{
    public function __invoke(Request $request)
    {
        $subtrait = request('subtrait');
        $search = request('search');
        $traits = RaceTrait::where('name', 'like', '%'.$search.'%');

        if (isset($subtrait)) {
            $traits->where('subtrait', boolval($subtrait));
        }

        return view('traits.list', [
            'traits' => $traits->paginate(20),
            'search' => $search,
            'subtrait' => $subtrait
        ]);
    }
}
