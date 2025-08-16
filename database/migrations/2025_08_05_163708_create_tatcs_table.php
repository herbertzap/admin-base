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
        Schema::create('tatcs', function (Blueprint $table) {
            $table->id();
            
            // Datos básicos del TATC
            $table->string('numero_tatc')->unique();
            $table->string('codigo_operador');
            $table->string('nombre_operador');
            $table->string('rut_operador');
            $table->string('resolucion_operador');
            
            // Datos del contenedor
            $table->string('numero_contenedor');
            $table->string('tipo_contenedor');
            $table->string('tara_contenedor')->nullable();
            $table->string('capacidad_contenedor')->nullable();
            
            // Datos del buque/nave
            $table->string('nombre_buque');
            $table->string('viaje_buque');
            $table->string('bandera_buque')->nullable();
            
            // Datos del puerto
            $table->string('puerto_origen');
            $table->string('puerto_destino');
            $table->string('puerto_arribo');
            
            // Datos de la carga
            $table->text('descripcion_carga');
            $table->decimal('peso_bruto', 10, 2);
            $table->integer('cantidad_bultos');
            $table->string('tipo_bultos')->nullable();
            
            // Datos del consignatario
            $table->string('nombre_consignatario');
            $table->string('rut_consignatario');
            $table->string('direccion_consignatario')->nullable();
            
            // Datos del transportista
            $table->string('nombre_transportista')->nullable();
            $table->string('rut_transportista')->nullable();
            $table->string('patente_vehiculo')->nullable();
            
            // Datos del lugar de depósito
            $table->string('lugar_deposito')->nullable();
            $table->string('direccion_deposito')->nullable();
            
            // Fechas importantes
            $table->date('fecha_arribo');
            $table->date('fecha_vencimiento');
            $table->date('fecha_retiro')->nullable();
            
            // Estado y control
            $table->enum('estado', ['Pendiente', 'Aprobado', 'Rechazado', 'Vencido', 'Cancelado'])->default('Pendiente');
            $table->text('observaciones')->nullable();
            
            // Campos para integración con API Hermes
            $table->json('hermes_request')->nullable();
            $table->json('hermes_response')->nullable();
            $table->string('hermes_status')->nullable();
            $table->string('hermes_message_id')->nullable();
            $table->timestamp('hermes_sent_at')->nullable();
            $table->timestamp('hermes_processed_at')->nullable();
            
            // Usuario que creó/modificó
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tatcs');
    }
};
