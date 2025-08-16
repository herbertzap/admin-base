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
        Schema::table('tatcs', function (Blueprint $table) {
            // Eliminar campos antiguos
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
                'observaciones'
            ]);

            // Agregar nuevos campos
            $table->string('tipo_ingreso')->after('numero_contenedor');
            $table->datetime('ingreso_pais')->after('tipo_ingreso');
            $table->datetime('ingreso_deposito')->after('ingreso_pais');
            $table->string('tatc_origen', 12)->nullable()->after('ingreso_deposito');
            $table->string('tatc_destino', 12)->nullable()->after('tatc_origen');
            $table->string('documento_ingreso', 50)->nullable()->after('tatc_destino');
            $table->date('fecha_traspaso')->after('documento_ingreso');
            $table->string('tipo_bulto', 10)->nullable()->after('tara_contenedor');
            $table->decimal('valor_fob', 15, 2)->nullable()->after('tipo_bulto');
            $table->text('comentario')->nullable()->after('valor_fob');
            $table->string('aduana_ingreso', 10)->after('comentario');
            $table->string('eir', 50)->nullable()->after('aduana_ingreso');
            $table->enum('tamano_contenedor', ['20', '40', '45'])->after('eir');
            $table->string('puerto_ingreso', 100)->after('tamano_contenedor');
            $table->enum('estado_contenedor', ['OP', 'DM'])->after('puerto_ingreso');
            $table->string('anio_fabricacion', 4)->nullable()->after('estado_contenedor');
            $table->string('ubicacion_fisica', 255)->after('anio_fabricacion');
            $table->decimal('valor_cif', 15, 2)->nullable()->after('ubicacion_fisica');
            $table->foreignId('empresa_transportista_id')->nullable()->after('valor_cif')->constrained('empresa_transportistas');
            $table->string('rut_chofer', 20)->nullable()->after('empresa_transportista_id');
            $table->string('patente_camion', 20)->nullable()->after('rut_chofer');
            $table->string('documento_transporte', 50)->nullable()->after('patente_camion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tatcs', function (Blueprint $table) {
            // Eliminar nuevos campos
            $table->dropForeign(['empresa_transportista_id']);
            $table->dropColumn([
                'tipo_ingreso',
                'ingreso_pais',
                'ingreso_deposito',
                'tatc_origen',
                'tatc_destino',
                'documento_ingreso',
                'fecha_traspaso',
                'tipo_bulto',
                'valor_fob',
                'comentario',
                'aduana_ingreso',
                'eir',
                'tamano_contenedor',
                'puerto_ingreso',
                'estado_contenedor',
                'anio_fabricacion',
                'ubicacion_fisica',
                'valor_cif',
                'empresa_transportista_id',
                'rut_chofer',
                'patente_camion',
                'documento_transporte'
            ]);

            // Restaurar campos antiguos
            $table->string('codigo_operador')->after('numero_tatc');
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
            $table->text('observaciones')->nullable()->after('fecha_retiro');
        });
    }
};
