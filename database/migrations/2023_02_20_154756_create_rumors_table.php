<?php

use App\Enums\Tide;
use App\Models\Character;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rumors', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Character::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\User::class)->constrained()->onDelete('cascade');
            $table->text('text');
            $table->enum('tide', array_map(fn($enum) => $enum->value, Tide::cases()));
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rumors');
    }
};
