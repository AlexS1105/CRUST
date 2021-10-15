<?php

use App\Enums\CharacterStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description');
            $table->string('login');
            $table->foreignId('user_id');
            $table->foreignId('registrar_id')->nullable();
            $table->unsignedInteger('status')->default(CharacterStatus::Blank);
            $table->string('reference')->default('storage/characters/references/_default.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
}
