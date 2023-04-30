<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->boolean('estitence_reduce')->default(true);
        });
    }

    public function down()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn('estitence_reduce');
        });
    }
};
