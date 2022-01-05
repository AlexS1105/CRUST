<?php

use App\Models\Character;
use App\Models\PerkVariant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersPerksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters_perks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Character::class)->onDelete('cascade');
            $table->foreignIdFor(PerkVariant::class)->onDelete('cascade');
            $table->integer('cost_offset')->nullable();
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters_perks');
    }
}
