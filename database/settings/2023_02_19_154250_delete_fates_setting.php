<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class DeleteFatesSetting extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->delete('charsheet.max_fates');
    }
}
