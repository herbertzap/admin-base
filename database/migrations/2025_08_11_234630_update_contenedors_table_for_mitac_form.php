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
            $table->integer('tara_contenedor')->nullable()->after('tamano_contenedor');
            $table->integer('anofab_contenedor')->nullable()->after('tara_contenedor');
            $table->unsignedBigInteger('pais_id')->nullable()->after('anofab_contenedor');
            $table->string('ingreso_doc')->nullable()->after('pais_id');
            $table->text('comentario')->nullable()->after('ingreso_doc');
            $table->date('fecha_ingreso')->nullable()->after('comentario');
            $table->string('tatc', 12)->nullable()->after('fecha_ingreso');
            $table->unsignedBigInteger('lugardeposito_id')->nullable()->after('tatc');
            $table->unsignedBigInteger('aduana_ingreso_id')->nullable()->after('lugardeposito_id');
            $table->unsignedBigInteger('operador_id')->nullable()->after('aduana_ingreso_id');
            
            // Facturación
            $table->string('rut_factura')->nullable()->after('operador_id');
            $table->string('nombre_factura')->nullable()->after('rut_factura');
            $table->string('direccion_factura')->nullable()->after('nombre_factura');
            $table->string('giro_factura')->nullable()->after('direccion_factura');
            $table->date('fecha_factura')->nullable()->after('giro_factura');
            $table->string('orden_compra')->nullable()->after('fecha_factura');
            $table->string('tipo_pago')->nullable()->after('orden_compra');
            $table->integer('valor_factura')->nullable()->after('tipo_pago');
            $table->string('reserva_nombre')->nullable()->after('valor_factura');
            $table->text('comentario_facturacion')->nullable()->after('reserva_nombre');
            
            // Transporte
            $table->unsignedBigInteger('empresa_transportista_id')->nullable()->after('comentario_facturacion');
            $table->string('rut_chofer')->nullable()->after('empresa_transportista_id');
            $table->string('patente_camion')->nullable()->after('rut_chofer');
            $table->string('documento_transporte')->nullable()->after('patente_camion');
            
            // Foreign keys
            $table->foreign('tipo_contenedor_id')->references('id')->on('tipo_contenedors')->onDelete('set null');
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
