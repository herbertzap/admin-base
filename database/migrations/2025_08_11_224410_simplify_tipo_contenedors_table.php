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
        Schema::table('tipo_contenedors', function (Blueprint $table) {
            // Eliminar campos innecesarios
            $table->dropColumn([
                'capacidad',
                'dimensiones', 
                'peso_maximo',
                'tipo',
                'observaciones'
            ]);
            
            // Agregar operador_id
            $table->unsignedBigInteger('operador_id')->nullable()->after('estado');
            $table->foreign('operador_id')->references('id')->on('operadors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipo_contenedors', function (Blueprint $table) {
            // Eliminar foreign key
            $table->dropForeign(['operador_id']);
            $table->dropColumn('operador_id');
            
            // Restaurar campos eliminados
            $table->string('capacidad')->nullable();
            $table->string('dimensiones')->nullable();
            $table->string('peso_maximo')->nullable();
            $table->enum('tipo', ['20', '40', '40HC', '45', 'Otro'])->default('20');
            $table->text('observaciones')->nullable();
        });
    }
};
