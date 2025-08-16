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
        Schema::table('tstcs', function (Blueprint $table) {
            // Eliminar campos que no están en el formulario de Mitac
            $table->dropColumn([
                'codigo_operador',
                'nombre_operador', 
                'rut_operador',
                'resolucion_operador',
                'capacidad_contenedor',
                'nombre_buque',
                'viaje_buque',
                'bandera_buque',
                'puerto_origen',
                'puerto_destino',
                'puerto_arribo',
                'descripcion_carga',
                'peso_bruto',
                'cantidad_bultos',
                'tipo_bultos',
                'nombre_consignatario',
                'rut_consignatario',
                'direccion_consignatario',
                'nombre_transportista',
                'rut_transportista',
                'patente_vehiculo',
                'lugar_deposito',
                'direccion_deposito',
                'fecha_arribo',
                'fecha_vencimiento',
                'fecha_retiro',
                'hermes_request',
                'hermes_response',
                'hermes_status',
                'hermes_message_id',
                'hermes_sent_at',
                'hermes_processed_at'
            ]);
        });

        Schema::table('tstcs', function (Blueprint $table) {
            // Agregar campos que están en el formulario de Mitac
            $table->unsignedBigInteger('operador_id')->after('numero_tstc');
            $table->date('fecha_emision_tstc')->after('operador_id');
            $table->string('destino_contenedor')->nullable()->after('tipo_contenedor');
            $table->decimal('valor_fob', 15, 2)->nullable()->after('destino_contenedor');
            $table->text('comentario')->nullable()->after('valor_fob');
            $table->date('ingreso_deposito')->after('comentario');
            $table->string('aduana_salida')->after('ingreso_deposito');
            $table->datetime('fecha_salida_pais')->after('aduana_salida');
            $table->enum('tamano_contenedor', ['20 Pies', '40 Pies'])->after('fecha_salida_pais');
            $table->enum('estado_contenedor', ['[OP] Operativo', '[DM] Dañado'])->after('tamano_contenedor');
            $table->string('codigo_tipo_bulto')->after('estado_contenedor');
            $table->string('anio_fabricacion')->nullable()->after('codigo_tipo_bulto');
            $table->unsignedBigInteger('empresa_transportista_id')->nullable()->after('anio_fabricacion');
            $table->string('rut_chofer')->nullable()->after('empresa_transportista_id');
            $table->string('patente_camion')->nullable()->after('rut_chofer');
            $table->string('documento_transporte')->nullable()->after('patente_camion');

            // Foreign keys
            $table->foreign('operador_id')->references('id')->on('operadors')->onDelete('cascade');
            $table->foreign('empresa_transportista_id')->references('id')->on('empresa_transportistas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tstcs', function (Blueprint $table) {
            // Eliminar foreign keys
            $table->dropForeign(['operador_id']);
            $table->dropForeign(['empresa_transportista_id']);
            
            // Eliminar campos nuevos
            $table->dropColumn([
                'operador_id',
                'fecha_emision_tstc',
                'destino_contenedor',
                'valor_fob',
                'comentario',
                'ingreso_deposito',
                'aduana_salida',
                'fecha_salida_pais',
                'tamano_contenedor',
                'estado_contenedor',
                'codigo_tipo_bulto',
                'anio_fabricacion',
                'empresa_transportista_id',
                'rut_chofer',
                'patente_camion',
                'documento_transporte'
            ]);
        });

        Schema::table('tstcs', function (Blueprint $table) {
            // Restaurar campos originales
            $table->string('codigo_operador')->after('numero_tstc');
            $table->string('nombre_operador')->after('codigo_operador');
            $table->string('rut_operador')->after('nombre_operador');
            $table->string('resolucion_operador')->after('rut_operador');
            $table->string('capacidad_contenedor')->nullable()->after('tara_contenedor');
            $table->string('nombre_buque')->after('capacidad_contenedor');
            $table->string('viaje_buque')->after('nombre_buque');
            $table->string('bandera_buque')->nullable()->after('viaje_buque');
            $table->string('puerto_origen')->after('bandera_buque');
            $table->string('puerto_destino')->after('puerto_origen');
            $table->string('puerto_arribo')->after('puerto_destino');
            $table->text('descripcion_carga')->after('puerto_arribo');
            $table->decimal('peso_bruto', 10, 2)->after('descripcion_carga');
            $table->integer('cantidad_bultos')->after('peso_bruto');
            $table->string('tipo_bultos')->nullable()->after('cantidad_bultos');
            $table->string('nombre_consignatario')->after('tipo_bultos');
            $table->string('rut_consignatario')->after('nombre_consignatario');
            $table->string('direccion_consignatario')->nullable()->after('rut_consignatario');
            $table->string('nombre_transportista')->nullable()->after('direccion_consignatario');
            $table->string('rut_transportista')->nullable()->after('nombre_transportista');
            $table->string('patente_vehiculo')->nullable()->after('rut_transportista');
            $table->string('lugar_deposito')->nullable()->after('patente_vehiculo');
            $table->string('direccion_deposito')->nullable()->after('lugar_deposito');
            $table->date('fecha_arribo')->after('direccion_deposito');
            $table->date('fecha_vencimiento')->after('fecha_arribo');
            $table->date('fecha_retiro')->nullable()->after('fecha_vencimiento');
            $table->json('hermes_request')->nullable()->after('observaciones');
            $table->json('hermes_response')->nullable()->after('hermes_request');
            $table->string('hermes_status')->nullable()->after('hermes_response');
            $table->string('hermes_message_id')->nullable()->after('hermes_status');
            $table->timestamp('hermes_sent_at')->nullable()->after('hermes_message_id');
            $table->timestamp('hermes_processed_at')->nullable()->after('hermes_sent_at');
        });
    }
};
