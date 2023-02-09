<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddEstitenceSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('charsheet.min_estitence', 0);
        $this->migrator->add('charsheet.max_estitence', 100);
        $this->migrator->add('charsheet.safe_estitence', 20);
        $this->migrator->add('charsheet.default_estitence', 50);
        $this->migrator->add('charsheet.additional_estitence', 10);
    }
}
