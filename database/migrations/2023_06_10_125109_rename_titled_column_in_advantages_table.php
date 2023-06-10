<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('advantages', function (Blueprint $table) {
            $table->renameColumn('no_estitence_reduce_required', 'titled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advantages', function (Blueprint $table) {
            $table->renameColumn('titled', 'no_estitence_reduce_required');
        });
    }
};
