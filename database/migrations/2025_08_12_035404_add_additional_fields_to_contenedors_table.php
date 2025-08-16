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
            // Campos adicionales basados en Mitac
            
            // TATC Asociado
            $table->string('origen_tatc')->nullable()->after('tatc');
            $table->string('destino_tatc')->nullable()->after('origen_tatc');
            $table->string('tatc_emisor')->nullable()->after('destino_tatc');
            $table->string('tatc_ingreso')->nullable()->after('tatc_emisor');
            $table->enum('tipo_ingreso', ['1', '2'])->nullable()->after('tatc_ingreso'); // 1=Desembarque, 2=Traspaso
            $table->string('eir')->nullable()->after('tipo_ingreso');
            $table->text('comentario_tatc')->nullable()->after('eir');
            
            // Datos Extras
            $table->string('extra_proveedor_nombre')->nullable()->after('comentario_tatc');
            $table->string('extra_proveedor_factura')->nullable()->after('extra_proveedor_nombre');
            $table->string('extra_proveedor_valor')->nullable()->after('extra_proveedor_factura');
            $table->date('extra_proveedor_fecha')->nullable()->after('extra_proveedor_valor');
            $table->string('extra_panama_factura')->nullable()->after('extra_proveedor_fecha');
            $table->string('extra_panama_valor')->nullable()->after('extra_panama_factura');
            $table->date('extra_panama_fecha')->nullable()->after('extra_panama_valor');
            $table->string('extra_cym_factura')->nullable()->after('extra_panama_fecha');
            $table->string('extra_cym_valor')->nullable()->after('extra_cym_factura');
            $table->date('extra_cym_fecha')->nullable()->after('extra_cym_valor');
            $table->string('extra_boxtam_factura')->nullable()->after('extra_cym_fecha');
            $table->date('extra_boxtam_fecha')->nullable()->after('extra_boxtam_factura');
            $table->string('extra_ciudad')->nullable()->after('extra_boxtam_fecha');
            $table->string('extra_tipo')->nullable()->after('extra_ciudad'); // Semana (CMA)
            
            // Campos adicionales de facturación
            $table->string('factura_oc')->nullable()->after('orden_compra'); // Orden de Compra
            $table->text('factura_comentario')->nullable()->after('comentario_facturacion');
            
            // Campos adicionales de transporte
            $table->string('transporte_documento')->nullable()->after('documento_transporte');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contenedors', function (Blueprint $table) {
            // Eliminar campos adicionales
            $table->dropColumn([
                'origen_tatc', 'destino_tatc', 'tatc_emisor', 'tatc_ingreso', 'tipo_ingreso', 'eir', 'comentario_tatc',
                'extra_proveedor_nombre', 'extra_proveedor_factura', 'extra_proveedor_valor', 'extra_proveedor_fecha',
                'extra_panama_factura', 'extra_panama_valor', 'extra_panama_fecha', 'extra_cym_factura', 'extra_cym_valor', 'extra_cym_fecha',
                'extra_boxtam_factura', 'extra_boxtam_fecha', 'extra_ciudad', 'extra_tipo',
                'factura_oc', 'factura_comentario', 'transporte_documento'
            ]);
        });
    }
};
