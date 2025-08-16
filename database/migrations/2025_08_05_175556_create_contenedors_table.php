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
        Schema::create('contenedors', function (Blueprint $table) {
            $table->id();
            $table->string('numero_contenedor')->unique();
            $table->string('tipo_contenedor');
            $table->string('empresa_transportista');
            $table->string('estado_contenedor');
            $table->string('ubicacion_actual');
            $table->string('puerto_origen');
            $table->string('puerto_destino');
            $table->date('fecha_arribo');
            $table->date('fecha_salida')->nullable();
            $table->string('naviera');
            $table->string('buque');
            $table->string('viaje');
            $table->string('booking');
            $table->string('bl_awb');
            $table->text('descripcion_mercancia');
            $table->integer('peso_bruto');
            $table->integer('volumen');
            $table->integer('bultos');
            $table->string('tipo_mercancia');
            $table->string('estado_mercancia');
            $table->text('observaciones')->nullable();
            $table->string('estado')->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenedors');
    }
};
