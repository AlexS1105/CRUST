<?php

use App\Models\Perk;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::withoutForeignKeyConstraints(function () {
            Schema::dropIfExists('perk_variants');
        });
    }

    public function down()
    {
        Schema::create('perk_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Perk::class)->constrained()->onDelete('cascade');
            $table->text('description');
            $table->timestamps();
        });
    }
};
