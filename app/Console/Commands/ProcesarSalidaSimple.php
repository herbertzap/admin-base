<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tatc;
use App\Models\Salida;
use App\Models\User;

class ProcesarSalidaSimple extends Command
{
    protected $signature = 'mitac:salida-simple';
    protected $description = 'Procesa la salida del TATC 34246000001 de forma simple';

    public function handle()
    {
        $this->info('🚀 Procesando salida simple para TATC 34246000001');
        
        // Buscar el TATC
        $tatc = Tatc::where('numero_tatc', '34246000001')->first();
        
        if (!$tatc) {
            $this->error('❌ TATC no encontrado');
            return 1;
        }
        
        $this->info("✅ TATC encontrado: {$tatc->numero_contenedor}");
        
        // Obtener usuario
        $usuario = User::first();
        
        // Generar número de salida único
        $numeroSalida = 'DI' . now()->format('YmdHis');
        
        // Crear salida con datos mínimos
        $salida = Salida::create([
            'tatc_id' => $tatc->id,
            'numero_salida' => $numeroSalida,
            'fecha_salida' => '2017-08-31',
            'tipo_salida' => 'internacion',
            'numero_contenedor' => $tatc->numero_contenedor,
            'tipo_contenedor' => $tatc->tipo_contenedor,
            'aduana_salida' => $tatc->aduana_ingreso,
            'estado' => 'Aprobado',
            'user_id' => $usuario->id,
            'declaracion_internacion' => '3370005048-9',
            'comentario_internacion' => 'factura agencia 1997',
        ]);
        
        // Actualizar estado del TATC
        $tatc->update(['estado' => 'Con Salida']);
        
        $this->info('✅ Salida procesada exitosamente');
        $this->info("   - Número de salida: {$salida->numero_salida}");
        $this->info("   - Tipo: {$salida->tipo_salida}");
        $this->info("   - Estado TATC: {$tatc->estado}");
        
        return 0;
    }
}
