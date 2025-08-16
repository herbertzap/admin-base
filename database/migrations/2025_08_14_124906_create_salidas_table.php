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
        Schema::create('salidas', function (Blueprint $table) {
            $table->id();
            
            // Relación con TATC
            $table->unsignedBigInteger('tatc_id');
            $table->foreign('tatc_id')->references('id')->on('tatcs')->onDelete('cascade');
            
            // Datos de la salida
            $table->string('numero_salida')->unique();
            $table->date('fecha_salida');
            $table->string('tipo_salida'); // Nacionalización, Exportación, etc.
            $table->string('motivo_salida')->nullable();
            
            // Datos del contenedor
            $table->string('numero_contenedor');
            $table->string('tipo_contenedor');
            $table->string('estado_contenedor')->nullable();
            
            // Datos de la aduana
            $table->string('aduana_salida');
            $table->string('documento_aduana')->nullable();
            $table->string('numero_documento')->nullable();
            
            // Datos del transportista
            $table->unsignedBigInteger('empresa_transportista_id')->nullable();
            $table->foreign('empresa_transportista_id')->references('id')->on('empresa_transportistas')->onDelete('set null');
            $table->string('rut_chofer')->nullable();
            $table->string('patente_camion')->nullable();
            
            // Datos del destino
            $table->string('destino_final')->nullable();
            $table->string('pais_destino')->nullable();
            
            // Observaciones y estado
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['Pendiente', 'Aprobado', 'Rechazado', 'Cancelado'])->default('Pendiente');
            
            // Usuario que registró la salida
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->timestamps();
            
            // Índices
            $table->index('numero_salida');
            $table->index('fecha_salida');
            $table->index('tipo_salida');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salidas');
    }
};
