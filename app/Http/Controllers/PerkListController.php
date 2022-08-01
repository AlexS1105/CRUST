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
        $perks = Perk::with('variants')->where('perks.name', 'like', '%'.$search.'%')->notHasFlag('perks.type', PerkType::Unique);

        if (isset($perkType)) {
            $perkType = PerkType::fromValue(intval($perkType));

            if ($perkType->value == PerkType::None) {
                $perks->notHasFlag('perks.type', PerkType::Combat);
            } else {
                $perks->hasFlag('perks.type', $perkType);
            }
        }

        return view('perks.list', [
            'perks' => $perks->paginate(20),
            'search' => $search,
            'perkType' => $perkType
        ]);
    }
}
