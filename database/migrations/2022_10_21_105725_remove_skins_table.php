<?php

use App\Models\Character;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::dropIfExists('skins');
    }

    public function down()
    {
        Schema::create('skins', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Character::class)->constrained()->onDelete('cascade');
            $table->text('skin');
            $table->text('prefix')->nullable();
            $table->timestamps();
        });
    }
};
