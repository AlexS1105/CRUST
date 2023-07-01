<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->unsignedInteger('perks_amount')->nullable();
            $table->unsignedInteger('talents_amount')->nullable();
            $table->unsignedInteger('techniques_amount')->nullable();
        });
    }

    public function down()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn([
                'perks_amount',
                'talents_amount',
                'techniques_amount',
            ]);
        });
    }
};
