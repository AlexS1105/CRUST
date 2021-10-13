<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharsheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb2')->dropIfExists('charsheets');
        Schema::connection('mongodb2')->create('charsheets', function (Blueprint $table) {
            $table->id();
            $table->string('character');
            $table->timestamps();

            $table->foreign('character')
                ->references('login')
                ->on('characters')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mongodb2')->dropIfExists('charsheets');
    }
}
