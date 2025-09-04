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
        Schema::table('tatcs', function (Blueprint $table) {
            $table->date('fecha_emision_tatc')->nullable()->after('fecha_traspaso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tatcs', function (Blueprint $table) {
            $table->dropColumn('fecha_emision_tatc');
        });
    }
};
