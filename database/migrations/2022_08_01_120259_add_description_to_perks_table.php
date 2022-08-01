<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToPerksTable extends Migration
{
    public function up()
    {
        Schema::table('perks', function (Blueprint $table) {
            Schema::table('perks', function (Blueprint $table) {
                $table->text('general_description')->nullable();
            });
        });
    }

    public function down()
    {
        Schema::table('perks', function (Blueprint $table) {
            $table->dropColumn('general_description');
        });
    }
}
