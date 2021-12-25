<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class CharsheetSettings extends Settings
{
    public int $skill_points;

    public int $perk_points;


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
