<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('athlete_discipline', function (Blueprint $table) {
            $table->enum('medal_type', ['gold', 'silver', 'bronze', 'none'])->default('none')->after('discipline_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('athlete_discipline', function (Blueprint $table) {
            $table->dropColumn('medal_type');
        });
    }
};
