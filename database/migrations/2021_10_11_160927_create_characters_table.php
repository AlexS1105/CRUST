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
            $table->unsignedInteger('gender');
            $table->text('race');
            $table->text('age');
            $table->text('appearance')->nullable();
            $table->text('background')->nullable();
            $table->boolean('info_hidden')->default(true);
            $table->boolean('bio_hidden')->default(true);
            $table->string('login');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('registrar_id')->nullable()->constrained('users')->onDelete('set null');
            $table->tinyInteger('status')->default(CharacterStatus::Blank->value);
            $table->timestamp('status_updated_at')->nullable();
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
