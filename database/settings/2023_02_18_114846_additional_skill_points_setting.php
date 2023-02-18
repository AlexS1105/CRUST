<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AdditionalSkillPointsSetting extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('charsheet.additional_skill_points', 32);
    }
}
