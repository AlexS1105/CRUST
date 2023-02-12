<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddPerkPoints extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('charsheet.perk_points', 24);
        $this->migrator->add('charsheet.additional_perk_points', 12);
    }
}
