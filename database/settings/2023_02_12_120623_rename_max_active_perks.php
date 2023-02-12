<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class RenameMaxActivePerks extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->deleteIfExists('charsheet.max_active_perks');
        $this->migrator->add('charsheet.max_perks', 8);
    }
}
