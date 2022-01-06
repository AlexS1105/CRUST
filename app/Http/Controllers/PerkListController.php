<?php

namespace App\Http\Controllers;

use App\Enums\PerkType;
use App\Models\Perk;
class PerkListController extends Controller
{
    public function __invoke()
    {
        $perkType = request('perk_type');
        $search = request('search');
        $costOrder = request('cost_order');
        $perks = Perk::with('variants')->where('perks.name', 'like', '%'.$search.'%')->notHasFlag('perks.type', PerkType::Unique);

        if (isset($perkType)) {
            $perkType = PerkType::fromValue(intval($perkType));

            if ($perkType->value == PerkType::None) {
                $perks->notHasFlag('perks.type', PerkType::Combat);
            } else {
                $perks->hasFlag('perks.type', $perkType);
            }
        }

        if (isset($costOrder)) {
            if ($costOrder == 'asc') {
                $perks->orderBy('cost');
            } else {
                $perks->orderBy('cost', 'desc');
            }
        }

        return view('perks.list', [
            'perks' => $perks->paginate(10),
            'search' => $search,
            'perkType' => $perkType
        ]);
    }
}
