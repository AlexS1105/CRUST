<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('advantages', function (Blueprint $table) {
            $table->boolean('no_estitence_reduce_required')->default(false);
        });
    }

    public function down()
    {
        Schema::table('advantages', function (Blueprint $table) {
            $table->dropColumn('no_estitence_reduce_required');
        });
    }
};
