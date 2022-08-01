<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class RemovePerkPoints extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->delete('charsheet.perk_points');
    }
}
