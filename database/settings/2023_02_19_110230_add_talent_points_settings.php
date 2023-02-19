<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddTalentPointsSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('charsheet.talent_points', 12);
        $this->migrator->add('charsheet.additional_talent_points', 30);
    }
}
