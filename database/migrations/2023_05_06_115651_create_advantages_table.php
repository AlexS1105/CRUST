<?php

use App\Models\Skill;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('advantages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Skill::class)->constrained()->onDelete('cascade');
            $table->unsignedInteger('level');
            $table->text('description');
            $table->boolean('is_penalty')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('advantages');
    }
};
