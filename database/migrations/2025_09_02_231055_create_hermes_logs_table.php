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
        Schema::create('hermes_logs', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_operacion'); // TATC, TSTC, SALIDA, CONSULTA
            $table->string('numero_documento'); // Número del TATC/TSTC/Salida
            $table->text('payload_enviado'); // JSON del payload enviado
            $table->text('respuesta_recibida')->nullable(); // JSON de la respuesta
            $table->string('estado'); // ENVIADO, EXITOSO, ERROR, PENDIENTE
            $table->string('codigo_respuesta')->nullable(); // Código de respuesta de HERMES
            $table->text('mensaje_error')->nullable(); // Mensaje de error si lo hay
            $table->string('endpoint'); // Endpoint al que se envió
            $table->string('api_key_utilizada'); // API key utilizada (para auditoría)
            $table->integer('intentos')->default(1); // Número de intentos
            $table->timestamp('ultimo_intento')->nullable(); // Timestamp del último intento
            $table->json('metadata')->nullable(); // Información adicional
            $table->timestamps();
            
            // Índices para consultas eficientes
            $table->index(['tipo_operacion', 'numero_documento']);
            $table->index(['estado', 'created_at']);
            $table->index('endpoint');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hermes_logs');
    }
};
