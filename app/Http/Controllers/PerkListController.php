<?php

namespace App\Http\Controllers;

use App\Enums\PerkType;
use App\Models\Perk;
class PerkListController extends Controller
{
    public function __invoke()
    {
        $search = request('search');
        $cost_order = request('cost_order');
        $perks = Perk::with('variants')->where('perks.name', 'like', '%'.$search.'%')->notHasFlag('perks.type', PerkType::Unique);

        if (isset($cost_order)) {
            if ($cost_order == 'asc') {
                $perks->orderBy('cost');
            } else {
                $perks->orderBy('cost', 'desc');
            }
        }

        return view('perks.list', [
            'perks' => $perks->paginate(10),
            'search' => $search
        ]);
    }
}
