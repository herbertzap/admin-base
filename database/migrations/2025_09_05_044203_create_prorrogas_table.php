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
        Schema::create('prorrogas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tatc_id');
            $table->string('numero_prorroga')->unique();
            $table->date('fecha_solicitud');
            $table->date('fecha_aprobacion')->nullable();
            $table->text('motivo');
            $table->enum('estado', ['Pendiente', 'Aprobado', 'Rechazado'])->default('Pendiente');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            $table->foreign('tatc_id')->references('id')->on('tatcs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prorrogas');
    }
};
