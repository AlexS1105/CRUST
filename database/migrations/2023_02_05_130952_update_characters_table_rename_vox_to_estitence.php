<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->renameColumn('vox', 'estitence');
        });
    }

    public function down()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->renameColumn('estitence', 'vox');
        });
    }
};
