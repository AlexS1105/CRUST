<?php

namespace App\Enums;

enum CharacterStat: string
{
    case Strength = 'strength';
    case Endurance = 'endurance';
    case Perception = 'perception';
    case Agility = 'agility';
    case Determination = 'determination';
    case Erudition = 'erudition';
    case Will = 'will';
    case Potential = 'potential';

    public function localized()
    {
        return __('stat.'.$this->value);
    }

    public function color()
    {
        return match($this->value) {
            'strength' => 'red-200',
            'endurance' => 'yellow-200',
            'perception', 'erudition' => 'blue-200',
            'agility' => 'green-200',
            'determination' => 'orange-200',
            'will' => 'cyan-200',
            'potential' => 'purple-200',
        };
    }

    public static function getBodyStats()
    {
        return ['strength', 'endurance', 'perception', 'agility'];
    }

    public static function getEssenceStats()
    {
        return ['determination', 'erudition', 'will', 'potential'];
    }

    public static function getCost($level)
    {
        $cost = 0;

        for ($i = 1; $i <= $level; $i++)
        {
            if ($i <= 10) {
                $cost++;
            } elseif ($i <= 15) {
                $cost += 2;
            } elseif ($i <= 20) {
                $cost += 3;
            } else {
                $cost += 4;
            }
        }

        return $cost;
    }

    public static function getSum($stats)
    {
        return array_reduce($stats, fn($sum, $stat) => $sum += CharacterStat::getCost($stat));
    }
}
