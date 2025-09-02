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
        Schema::create('tatc_import_historials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tatc_id')->constrained('tatcs')->onDelete('cascade');
            $table->string('archivo_origen'); // Nombre del archivo Excel de origen
            $table->string('operador')->nullable();
            $table->string('tipo_ingreso')->nullable();
            $table->date('fecha_ingreso_pais')->nullable();
            $table->date('fecha_ingreso_deposito')->nullable();
            $table->string('numero_contenedor')->nullable();
            $table->string('aduana')->nullable();
            $table->string('numero_tatc')->nullable();
            $table->string('eir')->nullable();
            $table->string('tatc_origen')->nullable();
            $table->string('tatc_destino')->nullable();
            $table->string('tipo_contenedor')->nullable();
            $table->string('tamano_contenedor')->nullable();
            $table->string('documento_ingreso')->nullable();
            $table->string('puerto_ingreso')->nullable();
            $table->string('tatc_emisor')->nullable();
            $table->string('tatc_ingreso')->nullable();
            $table->date('fecha_traspaso')->nullable();
            $table->decimal('tara_contenedor', 10, 2)->nullable();
            $table->integer('anio_fabricacion')->nullable();
            $table->string('estado_contenedor')->nullable();
            $table->string('tipo_bulto')->nullable();
            $table->decimal('valor_cif', 15, 2)->nullable();
            $table->text('comentario')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->string('usuario_registro')->nullable();
            $table->string('estado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tatc_import_historials');
    }
};
