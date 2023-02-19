<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::rename('vox_logs', 'estitence_logs');
    }

    public function down()
    {
        Schema::rename('estitence_logs', 'vox_logs');
    }
};
