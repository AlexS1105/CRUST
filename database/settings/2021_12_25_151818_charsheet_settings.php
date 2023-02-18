<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CharsheetSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('charsheet.skill_points', 16);
        $this->migrator->add('charsheet.perk_points', 20);
    }
}
