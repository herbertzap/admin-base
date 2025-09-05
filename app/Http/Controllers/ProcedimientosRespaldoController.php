<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProcedimientosRespaldoController extends Controller
{
    /**
     * Mostrar la página de procedimientos de respaldo
     */
    public function index()
    {
        return view('procedimientos-respaldo.index')
            ->with('titlePage', 'Procedimientos de Respaldo');
    }

    /**
     * Generar PDF de procedimientos de respaldo
     */
    public function pdf()
    {
        $data = [
            'fecha' => now()->format('d/m/Y'),
            'version' => '2.0'
        ];

        $pdf = Pdf::loadView('procedimientos-respaldo.pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('Procedimientos_Respaldo_Contenedores_Pricer_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Ejecutar respaldo de base de datos
     */
    public function respaldarBaseDatos()
    {
        try {
            $fecha = now()->format('Y-m-d_H-i-s');
            $archivo = "backup_db_{$fecha}.sql";
            $ruta = storage_path("app/backups/{$archivo}");
            
            // Crear directorio si no existe
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }
            
            // Configuración de la base de datos
            $host = config('database.connections.mysql.host');
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            
            // Comando mysqldump
            $comando = "mysqldump -h {$host} -u {$username} -p{$password} {$database} > {$ruta}";
            
            // Ejecutar comando
            exec($comando, $output, $return_var);
            
            if ($return_var === 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Respaldo de base de datos creado exitosamente',
                    'archivo' => $archivo,
                    'ruta' => $ruta
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear respaldo de base de datos'
                ], 500);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ejecutar respaldo de archivos
     */
    public function respaldarArchivos()
    {
        try {
            $fecha = now()->format('Y-m-d_H-i-s');
            $archivo = "backup_files_{$fecha}.tar.gz";
            $ruta = storage_path("app/backups/{$archivo}");
            
            // Crear directorio si no existe
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }
            
            // Directorios a respaldar
            $directorios = [
                'storage/app/public',
                'storage/logs',
                'config',
                'database/migrations',
                'database/seeders'
            ];
            
            $comando = "tar -czf {$ruta}";
            foreach ($directorios as $dir) {
                if (file_exists(base_path($dir))) {
                    $comando .= " -C " . base_path() . " {$dir}";
                }
            }
            
            // Ejecutar comando
            exec($comando, $output, $return_var);
            
            if ($return_var === 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Respaldo de archivos creado exitosamente',
                    'archivo' => $archivo,
                    'ruta' => $ruta
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear respaldo de archivos'
                ], 500);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Listar respaldos disponibles
     */
    public function listarRespaldos()
    {
        try {
            $directorio = storage_path('app/backups');
            $respaldos = [];
            
            if (file_exists($directorio)) {
                $archivos = scandir($directorio);
                foreach ($archivos as $archivo) {
                    if ($archivo !== '.' && $archivo !== '..') {
                        $rutaCompleta = $directorio . '/' . $archivo;
                        $respaldos[] = [
                            'nombre' => $archivo,
                            'tamaño' => filesize($rutaCompleta),
                            'fecha' => date('d/m/Y H:i:s', filemtime($rutaCompleta)),
                            'tipo' => strpos($archivo, 'db_') !== false ? 'Base de Datos' : 'Archivos'
                        ];
                    }
                }
            }
            
            // Ordenar por fecha (más recientes primero)
            usort($respaldos, function($a, $b) {
                return strtotime($b['fecha']) - strtotime($a['fecha']);
            });
            
            return response()->json([
                'success' => true,
                'respaldos' => $respaldos
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Descargar respaldo
     */
    public function descargarRespaldo($archivo)
    {
        try {
            $ruta = storage_path("app/backups/{$archivo}");
            
            if (!file_exists($ruta)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Archivo no encontrado'
                ], 404);
            }
            
            return response()->download($ruta);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}