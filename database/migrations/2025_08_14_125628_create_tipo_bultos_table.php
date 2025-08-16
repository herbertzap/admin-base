<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tipo_bultos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->unique();
            $table->string('descripcion');
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });

        // Insertar los tipos de bulto de Mitac
        $tiposBulto = [
            ['codigo' => '01', 'descripcion' => 'Granel Solido, Particulas Finas (Polvo)'],
            ['codigo' => '02', 'descripcion' => 'Granel Solido, Particulas Granulares (Granos)'],
            ['codigo' => '03', 'descripcion' => 'Granel Solido, Particulas Grandes (Nodulos)'],
            ['codigo' => '04', 'descripcion' => 'Granel Liquido'],
            ['codigo' => '05', 'descripcion' => 'Granel Gaseoso'],
            ['codigo' => '10', 'descripcion' => 'Piezas'],
            ['codigo' => '11', 'descripcion' => 'Tubos'],
            ['codigo' => '12', 'descripcion' => 'Cilindro'],
            ['codigo' => '13', 'descripcion' => 'Rollos'],
            ['codigo' => '16', 'descripcion' => 'Barras'],
            ['codigo' => '17', 'descripcion' => 'Lingotes'],
            ['codigo' => '18', 'descripcion' => 'Troncos'],
            ['codigo' => '19', 'descripcion' => 'Bloque'],
            ['codigo' => '20', 'descripcion' => 'Rollizo'],
            ['codigo' => '21', 'descripcion' => 'Cajon'],
            ['codigo' => '22', 'descripcion' => 'Cajas De Carton'],
            ['codigo' => '23', 'descripcion' => 'Fardo'],
            ['codigo' => '24', 'descripcion' => 'Baul'],
            ['codigo' => '25', 'descripcion' => 'Cofre'],
            ['codigo' => '26', 'descripcion' => 'Armazon'],
            ['codigo' => '27', 'descripcion' => 'Bandeja'],
            ['codigo' => '28', 'descripcion' => 'Caja De Madera'],
            ['codigo' => '29', 'descripcion' => 'Cajas De Lata'],
            ['codigo' => '31', 'descripcion' => 'Botella De Gas'],
            ['codigo' => '32', 'descripcion' => 'Botella'],
            ['codigo' => '33', 'descripcion' => 'Jaulas'],
            ['codigo' => '34', 'descripcion' => 'Bidon'],
            ['codigo' => '35', 'descripcion' => 'Jabas'],
            ['codigo' => '36', 'descripcion' => 'Cestas'],
            ['codigo' => '37', 'descripcion' => 'Barrilete'],
            ['codigo' => '38', 'descripcion' => 'Tonel'],
            ['codigo' => '39', 'descripcion' => 'Pipas'],
            ['codigo' => '40', 'descripcion' => 'Cajas No Especificadas'],
            ['codigo' => '41', 'descripcion' => 'Jarro'],
            ['codigo' => '42', 'descripcion' => 'Frasco'],
            ['codigo' => '43', 'descripcion' => 'Damajuana'],
            ['codigo' => '44', 'descripcion' => 'Barril'],
            ['codigo' => '45', 'descripcion' => 'Tambor'],
            ['codigo' => '46', 'descripcion' => 'Cuñetes'],
            ['codigo' => '47', 'descripcion' => 'Tarros'],
            ['codigo' => '51', 'descripcion' => 'Cubo'],
            ['codigo' => '61', 'descripcion' => 'Paquete'],
            ['codigo' => '62', 'descripcion' => 'Sacos'],
            ['codigo' => '63', 'descripcion' => 'Maleta'],
            ['codigo' => '64', 'descripcion' => 'Bolsa'],
            ['codigo' => '65', 'descripcion' => 'Bala'],
            ['codigo' => '66', 'descripcion' => 'Red'],
            ['codigo' => '67', 'descripcion' => 'Sobres'],
            ['codigo' => '73', 'descripcion' => 'Contenedor De 20 Pies Dry'],
            ['codigo' => '74', 'descripcion' => 'Contenedor De 40 Pies Dry'],
            ['codigo' => '75', 'descripcion' => 'Contenedor Refrigerado 20 Pies'],
            ['codigo' => '76', 'descripcion' => 'Contenedor Refrigerado 40 Pies'],
            ['codigo' => '77', 'descripcion' => 'Estanque (No Utilizar Para Contenedor Tank)'],
            ['codigo' => '78', 'descripcion' => 'Contenedor No Especificado (Open Top, Tank, Flat Rack, Etc.)'],
            ['codigo' => '80', 'descripcion' => 'Pallet'],
            ['codigo' => '81', 'descripcion' => 'Tablero'],
            ['codigo' => '82', 'descripcion' => 'Laminas'],
            ['codigo' => '83', 'descripcion' => 'Carrete'],
            ['codigo' => '85', 'descripcion' => 'Automotor'],
            ['codigo' => '86', 'descripcion' => 'Ataud'],
            ['codigo' => '88', 'descripcion' => 'Maquinaria'],
            ['codigo' => '89', 'descripcion' => 'Planchas'],
            ['codigo' => '90', 'descripcion' => 'Atados'],
            ['codigo' => '91', 'descripcion' => 'Bobina'],
            ['codigo' => '93', 'descripcion' => 'Otros Bultos No Especificados'],
            ['codigo' => '98', 'descripcion' => 'No Existe Bulto'],
            ['codigo' => '99', 'descripcion' => 'Sin Embalar'],
        ];

        foreach ($tiposBulto as $tipo) {
            DB::table('tipo_bultos')->insert([
                'codigo' => $tipo['codigo'],
                'descripcion' => $tipo['descripcion'],
                'estado' => 'Activo',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_bultos');
    }
};
