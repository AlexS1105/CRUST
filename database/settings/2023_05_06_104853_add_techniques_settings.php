<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('charsheet.technique_points', 5);
        $this->migrator->add('charsheet.additional_technique_points', 30);
        $this->migrator->add('charsheet.max_techniques', 10);
        $this->migrator->add('charsheet.technique_cost', 5);
    }
};
