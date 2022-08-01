<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPerkCostColumns extends Migration
{
    public function up()
    {
        Schema::table('perks', function(Blueprint $table) {
            $table->dropColumn('cost');
        });

        Schema::table('characters_perks', function (Blueprint $table) {
            $table->dropColumn('cost_offset');
        });
    }

    public function down()
    {
        Schema::table('perks', function(Blueprint $table) {
            $table->integer('cost')->nullable();
        });

        Schema::table('characters_perks', function (Blueprint $table) {
            $table->integer('cost_offset')->nullable();
        });
    }
}
