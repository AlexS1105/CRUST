<?php

namespace App\Services;

use App\Enums\FateType;

class FateService
{
    public function convertFateTypes($fates)
    {
        foreach ($fates as &$fate) {
            $fate['type'] = 0;

            if (isset($fate['ambition'])) {
                $fate['type'] = FateType::set($fate['type'], FateType::Ambition);
            }

            if (isset($fate['flaw'])) {
                $fate['type'] = FateType::set($fate['type'], FateType::Flaw);
            }

            if (isset($fate['continuous'])) {
                $fate['type'] = FateType::set($fate['type'], FateType::Continuous);
            }
        }

        return $fates;
    }
}
