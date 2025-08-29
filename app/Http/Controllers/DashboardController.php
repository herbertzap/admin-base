<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tatc;
use App\Models\Tstc;
use App\Models\Salida;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas principales como Mitac
        $stats = [
            'tatc_registrados' => Tatc::count(),
            'salidas_registradas' => Salida::where('estado', 'Aprobado')->count(),
            'tstc_registrados' => Tstc::count(),
            'tickets' => Ticket::count(),
        ];

        // Datos para gráfico del último año
        $fechaInicio = Carbon::now()->subYear();
        $fechaFin = Carbon::now();
        
        $datosGrafico = $this->obtenerDatosGrafico($fechaInicio, $fechaFin);

        // Últimos TATCs creados
        $ultimosTatcs = Tatc::with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Últimas salidas registradas
        $ultimasSalidas = Salida::with(['tatc', 'user'])
            ->where('estado', 'Aprobado')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Últimos usuarios conectados
        $ultimosUsuarios = User::orderBy('last_login_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'stats', 
            'datosGrafico', 
            'ultimosTatcs', 
            'ultimasSalidas', 
            'ultimosUsuarios'
        ));
    }

    private function obtenerDatosGrafico($fechaInicio, $fechaFin)
    {
        $datos = [];
        
        // Generar datos mensuales para el último año
        for ($i = 0; $i < 12; $i++) {
            $fecha = $fechaInicio->copy()->addMonths($i);
            $mes = $fecha->format('m/Y');
            
            $tatcCount = Tatc::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
                
            $tstcCount = Tstc::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->count();
                
            $salidasCount = Salida::whereYear('created_at', $fecha->year)
                ->whereMonth('created_at', $fecha->month)
                ->where('estado', 'Aprobado')
                ->count();
            
            $datos[] = [
                'mes' => $fecha->format('M Y'),
                'tatc' => $tatcCount,
                'tstc' => $tstcCount,
                'salidas' => $salidasCount
            ];
        }
        
        return $datos;
    }
}
