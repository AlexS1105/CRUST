<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class CharsheetSettings extends Settings
{
    public int $skill_points;

    public int $max_fates;

    public int $max_perks;

    public int $perk_points;

    public int $additional_perk_points;

    public int $min_estitence;

    public int $max_estitence;

    public int $safe_estitence;

    public int $default_estitence;

    public int $additional_estitence;

    public static function group(): string
    {
        return 'charsheet';
    }

    public function update($properties)
    {
        $this->fill($properties);
        $this->save();
    }
}
