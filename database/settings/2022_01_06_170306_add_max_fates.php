<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddMaxFates extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('charsheet.max_fates', 3);
    }
}
