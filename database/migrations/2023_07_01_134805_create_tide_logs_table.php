<?php

use App\Enums\Tide;
use App\Models\Character;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tide_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Character::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class, 'issued_by')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('tide', array_map(fn($enum) => $enum->value, Tide::cases()));
            $table->integer('before');
            $table->integer('after');
            $table->integer('delta');
            $table->text('reason');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tide_logs');
    }
};
