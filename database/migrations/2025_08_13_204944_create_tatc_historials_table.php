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
        Schema::create('tatc_historials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tatc_id')->constrained('tatcs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->string('accion'); // Creación, Modificación, Salida por DI, etc.
            $table->text('detalles')->nullable(); // Detalles de la acción
            $table->json('datos_anteriores')->nullable(); // Datos antes del cambio
            $table->json('datos_nuevos')->nullable(); // Datos después del cambio
            $table->string('estado_anterior')->nullable();
            $table->string('estado_nuevo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tatc_historials');
    }
};
