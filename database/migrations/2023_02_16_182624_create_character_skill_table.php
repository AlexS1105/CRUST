<?php

use App\Models\Character;
use App\Models\Skill;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('character_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Character::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Skill::class)->constrained()->onDelete('cascade');
            $table->tinyInteger('level')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('character_skill');
    }
};
