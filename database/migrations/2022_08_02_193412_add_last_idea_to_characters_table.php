<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastIdeaToCharactersTable extends Migration
{
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->timestamp('last_idea')->nullable();
        });
    }

    public function down()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn('last_idea');
        });
    }
}
