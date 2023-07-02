<?php

use App\Models\Character;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('soulbounds', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Character::class);
            $table->text('name');
            $table->text('description');
            $table->unsignedInteger('cost');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('soulbounds');
    }
};
