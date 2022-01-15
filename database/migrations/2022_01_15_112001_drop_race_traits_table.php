<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropRaceTraitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('race_traits');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('race_traits', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description');
            $table->text('races');
            $table->boolean('subtrait')->default(false);
            $table->timestamps();
        });
    }
}
