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
        Schema::table('users', function (Blueprint $table) {
            // Campos adicionales para el usuario
            $table->string('fotografia')->nullable()->after('email');
            $table->string('rut_usuario')->nullable()->after('fotografia');
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo')->after('rut_usuario');
            $table->timestamp('ultimo_movimiento')->nullable()->after('estado');
            $table->timestamp('fecha_renovacion_password')->nullable()->after('ultimo_movimiento');
            $table->boolean('cambio_password_requerido')->default(false)->after('fecha_renovacion_password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'fotografia',
                'rut_usuario', 
                'estado',
                'ultimo_movimiento',
                'fecha_renovacion_password',
                'cambio_password_requerido'
            ]);
        });
    }
};
