<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public int $start_points;

    public int $max_characters;

    public static function group(): string
    {
        return 'general';
    }

    public function update($properties) {
        $this->fill($properties);
        $this->save();
    }
}
