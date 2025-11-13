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
        Schema::table('tstcs', function (Blueprint $table) {
            $table->string('codigo_operador_destino_oc')->nullable()->after('operador_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tstcs', function (Blueprint $table) {
            $table->dropColumn('codigo_operador_destino_oc');
        });
    }
};
