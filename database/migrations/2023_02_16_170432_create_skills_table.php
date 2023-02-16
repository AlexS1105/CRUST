<?php

use App\Enums\CharacterStat;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->boolean('proficiency')->default(0);
            $table->text('name');
            $table->text('description');
            $table->enum('stat', array_map(fn($enum) => $enum->value, CharacterStat::cases()));
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skills');
    }
};
