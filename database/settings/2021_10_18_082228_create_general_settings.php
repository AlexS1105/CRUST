<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.start_points', 36);
        $this->migrator->add('general.max_characters', 3);
    }
}
