<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;

class ReadChecklistAcreditacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aduana:read-checklist {file=docs/aduana/CheckList Autoevaluacion OC TATC TSTC v1.xlsx}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Leer y analizar el checklist de acreditación de Aduanas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');
        
        if (!file_exists($filePath)) {
            $this->error("❌ El archivo no existe: {$filePath}");
            return 1;
        }

        $this->info("📋 Leyendo checklist de acreditación: {$filePath}");
        
        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            
            $this->info("📊 Información del archivo:");
            $this->info("  - Hojas disponibles: " . implode(', ', $spreadsheet->getSheetNames()));
            $this->info("  - Hoja activa: " . $worksheet->getTitle());
            
            // Leer las primeras filas para entender la estructura
            $this->info("\n📝 Contenido del checklist:");
            
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            
            $this->info("  - Filas: {$highestRow}");
            $this->info("  - Columnas: {$highestColumn}");
            
            // Leer las primeras 20 filas para entender la estructura
            $maxRows = min(20, $highestRow);
            
            for ($row = 1; $row <= $maxRows; $row++) {
                $rowData = [];
                for ($col = 'A'; $col <= $highestColumn; $col++) {
                    $cellValue = $worksheet->getCell($col . $row)->getValue();
                    if ($cellValue !== null && $cellValue !== '') {
                        $rowData[] = $cellValue;
                    }
                }
                
                if (!empty($rowData)) {
                    $this->line("  Fila {$row}: " . implode(' | ', $rowData));
                }
            }
            
            // Analizar requisitos específicos
            $this->analyzeRequirements($worksheet, $highestRow, $highestColumn);
            
        } catch (\Exception $e) {
            $this->error("❌ Error al leer el archivo: " . $e->getMessage());
            Log::error('Error leyendo checklist de acreditación', [
                'file' => $filePath,
                'error' => $e->getMessage()
            ]);
            return 1;
        }
        
        $this->info("\n✅ Análisis del checklist completado.");
        return 0;
    }
    
    /**
     * Analizar requisitos específicos del checklist
     */
    private function analyzeRequirements($worksheet, $highestRow, $highestColumn)
    {
        $this->info("\n🔍 Analizando requisitos específicos...");
        
        $requirements = [
            'TATC' => [],
            'TSTC' => [],
            'Salidas' => [],
            'Control Plazos' => [],
            'Control Inventarios' => [],
            'Control Fiscalizacion' => [],
            'HERMES' => [],
            'Seguridad' => [],
            'Documentacion' => []
        ];
        
        // Buscar palabras clave en el contenido
        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 'A'; $col <= $highestColumn; $col++) {
                $cellValue = $worksheet->getCell($col . $row)->getValue();
                
                if (is_string($cellValue)) {
                    $cellValue = strtolower($cellValue);
                    
                    if (strpos($cellValue, 'tatc') !== false || strpos($cellValue, 'admisión') !== false) {
                        $requirements['TATC'][] = "Fila {$row}, Columna {$col}: " . $worksheet->getCell($col . $row)->getValue();
                    }
                    
                    if (strpos($cellValue, 'tstc') !== false || strpos($cellValue, 'salida') !== false) {
                        $requirements['TSTC'][] = "Fila {$row}, Columna {$col}: " . $worksheet->getCell($col . $row)->getValue();
                    }
                    
                    if (strpos($cellValue, 'hermes') !== false || strpos($cellValue, 'api') !== false) {
                        $requirements['HERMES'][] = "Fila {$row}, Columna {$col}: " . $worksheet->getCell($col . $row)->getValue();
                    }
                    
                    if (strpos($cellValue, 'seguridad') !== false || strpos($cellValue, 'acceso') !== false) {
                        $requirements['Seguridad'][] = "Fila {$row}, Columna {$col}: " . $worksheet->getCell($col . $row)->getValue();
                    }
                }
            }
        }
        
        // Mostrar resultados del análisis
        foreach ($requirements as $category => $items) {
            if (!empty($items)) {
                $this->info("\n  📋 {$category}:");
                foreach (array_slice($items, 0, 5) as $item) { // Mostrar solo los primeros 5
                    $this->line("    - {$item}");
                }
                if (count($items) > 5) {
                    $this->line("    ... y " . (count($items) - 5) . " más");
                }
            }
        }
    }
}
