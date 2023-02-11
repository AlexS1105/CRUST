<?php

namespace App\Rules;

use App\Enums\CharacterStat;
use Illuminate\Contracts\Validation\Rule;

class StatUpdate implements Rule
{
    public $character;

    public function __construct($character)
    {
        $this->character = $character;
    }

    public function passes($attribute, $value)
    {
        if (auth()->user()->can('update-charsheet-gm', $this->character)) {
            return true;
        }

        $inequality = $this->character->stats_inequality;
        $absInequality = abs($inequality);
        $freePoints = max($inequality, 0);
        $difference = 0;
        $additionsPointsSpent = 0;

        foreach ($this->character->charsheet->stats as $stat => $oldValue) {
            $newValue = $value[$stat] ?? 0;
            $oldCost = CharacterStat::getCost($oldValue);
            $newCost = CharacterStat::getCost($newValue);

            if ($newValue < $oldValue) {
                if ($inequality > 0) {
                    return false;
                }

                $difference += $oldValue - $newValue;

                if ($difference > $absInequality) {
                    return false;
                }

                $costDifference = $oldCost - $newCost;

                if ($costDifference > 1) {
                    $freePoints += $costDifference - $absInequality;
                }
            } elseif ($newValue > $oldValue) {
                $additionsPointsSpent = $newCost - $oldCost;
            }
        }

        return $additionsPointsSpent <= $freePoints;
    }

    public function message()
    {
        return __('validation.stat.update');
    }
}
