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
        Schema::create('tstc_historials', function (Blueprint $table) {
            $table->id();
            
            // Relación con TSTC
            $table->unsignedBigInteger('tstc_id');
            $table->unsignedBigInteger('user_id');
            
            // Información del cambio
            $table->string('accion'); // crear, actualizar, eliminar
            $table->text('detalles');
            
            // Datos del cambio
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->string('estado_anterior')->nullable();
            $table->string('estado_nuevo')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Índices
            $table->index('tstc_id');
            $table->index('user_id');
            $table->index('accion');
            
            // Foreign keys
            $table->foreign('tstc_id')->references('id')->on('tstcs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tstc_historials');
    }
};
