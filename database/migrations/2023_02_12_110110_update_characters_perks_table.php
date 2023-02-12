<?php

use App\Models\Perk;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('characters_perks', function (Blueprint $table) {
            $table->dropForeign('characters_perks_perk_variant_id_foreign');
            $table->dropColumn('perk_variant_id');
            $table->dropColumn('active');
            $table->foreignIdFor(Perk::class)->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('characters_perks', function (Blueprint $table) {
            $table->foreignId('perk_variant_id')->constrained()->onDelete('cascade');
            $table->dropForeignIdFor(Perk::class);
            $table->boolean('active')->nullable();
        });
    }
};
