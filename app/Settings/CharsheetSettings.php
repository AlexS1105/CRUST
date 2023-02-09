<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class CharsheetSettings extends Settings
{
    public int $skill_points;

    public int $max_fates;

    public int $max_active_perks;

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
