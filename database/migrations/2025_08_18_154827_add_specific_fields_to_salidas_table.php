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
        Schema::table('salidas', function (Blueprint $table) {
            // Campos específicos para Declaración de Internación
            $table->string('declaracion_internacion', 50)->nullable();
            $table->string('comentario_internacion', 200)->nullable();
            
            // Campos específicos para Cancelación
            $table->string('aduana_ingreso_cancelacion', 10)->nullable();
            $table->text('documento_cancelacion')->nullable();
            
            // Campos específicos para Traspaso
            $table->string('tatc_destino', 50)->nullable();
            $table->string('operador_destino', 50)->nullable();
            $table->string('lugar_deposito_origen', 200)->nullable();
            $table->string('lugar_deposito_destino', 200)->nullable();
            $table->decimal('valor_contenedor_traspaso', 15, 2)->nullable();
            $table->string('tipo_bulto_traspaso', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salidas', function (Blueprint $table) {
            $table->dropColumn([
                'declaracion_internacion',
                'comentario_internacion',
                'aduana_ingreso_cancelacion',
                'documento_cancelacion',
                'tatc_destino',
                'operador_destino',
                'lugar_deposito_origen',
                'lugar_deposito_destino',
                'valor_contenedor_traspaso',
                'tipo_bulto_traspaso',
            ]);
        });
    }
};
