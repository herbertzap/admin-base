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
        Schema::create('operadors', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('rut_operador');
            $table->string('nombre_operador');
            $table->string('nombre_fantasia')->nullable();
            $table->string('direccion_operador')->nullable();
            $table->string('resolucion_operador')->nullable();
            $table->string('logo_operador')->nullable(); // path archivo
            $table->string('firma_operador')->nullable(); // path archivo
            $table->string('rut_representante')->nullable();
            $table->string('nombre_representante')->nullable();
            $table->string('cargo_representante')->nullable();
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->date('fecha_creacion')->nullable();
            $table->dateTime('fecha_actualizacion')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable(); // usuario que creó/actualizó
            // Datos de email
            $table->string('nombre_remitente')->nullable();
            $table->string('email_remitente')->nullable();
            $table->string('email_copia')->nullable();
            $table->boolean('valida_ingreso_aduana')->default(false);
            $table->string('email_notificaciones')->nullable();
            $table->timestamps();
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operadors');
    }
};
