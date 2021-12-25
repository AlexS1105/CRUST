<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class DeleteStartPointsSetting extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->delete('general.start_points');
    }
}
