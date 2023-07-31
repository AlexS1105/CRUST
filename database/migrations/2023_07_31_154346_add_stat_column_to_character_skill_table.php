<?php

use App\Enums\CharacterStat;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('character_skill', function (Blueprint $table) {
            $table->enum('stat', [
                'strength',
                'endurance',
                'perception',
                'agility',
                'determination',
                'erudition',
                'will',
                'potential',
            ])->nullable();
        });
    }

    public function down()
    {
        Schema::table('character_skill', function (Blueprint $table) {
            $table->dropColumn('stat');
        });
    }
};
