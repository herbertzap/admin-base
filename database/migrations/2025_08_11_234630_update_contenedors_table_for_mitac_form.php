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
        Schema::table('contenedors', function (Blueprint $table) {
            // Agregar campos nuevos organizados por tabs
            
            // Datos Contenedor
            $table->integer('tara_contenedor')->nullable();
            $table->integer('anofab_contenedor')->nullable();
            $table->unsignedBigInteger('pais_id')->nullable();
            $table->string('ingreso_doc')->nullable();
            $table->text('comentario')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->string('tatc', 12)->nullable();
            $table->unsignedBigInteger('lugardeposito_id')->nullable();
            $table->unsignedBigInteger('aduana_ingreso_id')->nullable();
            $table->unsignedBigInteger('operador_id')->nullable();
            
            // Facturación
            $table->string('rut_factura')->nullable();
            $table->string('nombre_factura')->nullable();
            $table->string('direccion_factura')->nullable();
            $table->string('giro_factura')->nullable();
            $table->date('fecha_factura')->nullable();
            $table->string('orden_compra')->nullable();
            $table->string('tipo_pago')->nullable();
            $table->integer('valor_factura')->nullable();
            $table->string('reserva_nombre')->nullable();
            $table->text('comentario_facturacion')->nullable();
            
            // Transporte
            $table->unsignedBigInteger('empresa_transportista_id')->nullable();
            $table->string('rut_chofer')->nullable();
            $table->string('patente_camion')->nullable();
            $table->string('documento_transporte')->nullable();
        });
        
        // Agregar foreign keys después de crear las columnas
        Schema::table('contenedors', function (Blueprint $table) {
            // Comentado temporalmente - estas columnas no existen en la tabla actual
            // $table->foreign('tipo_contenedor_id')->references('id')->on('tipo_contenedors')->onDelete('set null');
            $table->foreign('lugardeposito_id')->references('id')->on('lugar_depositos')->onDelete('set null');
            $table->foreign('empresa_transportista_id')->references('id')->on('empresa_transportistas')->onDelete('set null');
            $table->foreign('aduana_ingreso_id')->references('id')->on('aduana_chiles')->onDelete('set null');
            $table->foreign('operador_id')->references('id')->on('operadors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contenedors', function (Blueprint $table) {
            // Eliminar foreign keys
            $table->dropForeign(['tipo_contenedor_id']);
            $table->dropForeign(['lugardeposito_id']);
            $table->dropForeign(['empresa_transportista_id']);
            $table->dropForeign(['aduana_ingreso_id']);
            $table->dropForeign(['operador_id']);
            
            // Eliminar campos nuevos
            $table->dropColumn([
                'tara_contenedor',
                'anofab_contenedor',
                'pais_id',
                'ingreso_doc',
                'comentario',
                'fecha_ingreso',
                'tatc',
                'lugardeposito_id',
                'aduana_ingreso_id',
                'operador_id',
                'rut_factura',
                'nombre_factura',
                'direccion_factura',
                'giro_factura',
                'fecha_factura',
                'orden_compra',
                'tipo_pago',
                'valor_factura',
                'reserva_nombre',
                'comentario_facturacion',
                'empresa_transportista_id',
                'rut_chofer',
                'patente_camion',
                'documento_transporte'
            ]);
        });
    }
};
