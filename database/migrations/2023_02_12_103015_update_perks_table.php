<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('perks', function (Blueprint $table) {
            $table->renameColumn('general_description', 'description');
            $table->dropColumn('type');
            $table->integer('cost');
        });
    }

    public function down()
    {
        Schema::table('perks', function (Blueprint $table) {
            $table->renameColumn('description', 'general_description');
            $table->binary('type');
            $table->dropColumn('cost');
        });
    }
};
