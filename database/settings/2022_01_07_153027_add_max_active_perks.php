<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddMaxActivePerks extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('charsheet.max_active_perks', 3);
    }
}
