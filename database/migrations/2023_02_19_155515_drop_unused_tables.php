<?php

use App\Models\Character;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('fates');
        Schema::dropIfExists('ideas');
        Schema::dropIfExists('narrative_crafts');
        Schema::dropIfExists('spheres');
    }

    public function down()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description')->nullable();
            $table->integer('level')->default(1);
            $table->foreignIdFor(Character::class)->constrained()->onDelete('cascade');
            $table->boolean('native')->default(false);
            $table->timestamps();
        });

        Schema::create('fates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Character::class)->constrained()->onDelete('cascade');
            $table->text('text');
            $table->binary('type');
            $table->timestamps();
        });

        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description')->nullable();
            $table->foreignIdFor(Character::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('narrative_crafts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Character::class);
            $table->text('name');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('spheres', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description')->nullable();
            $table->integer('value')->default(0);
            $table->foreignIdFor(Character::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
};
