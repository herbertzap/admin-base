<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Movimientos - CONTENEDORES DAVI E.I.R.L.</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #e75034;
            padding-bottom: 10px;
        }
        
        .header h1 {
            color: #e75034;
            margin: 0;
            font-size: 18px;
        }
        
        .header h2 {
            color: #666;
            margin: 5px 0;
            font-size: 14px;
        }
        
        .filtros {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        
        .filtros h3 {
            margin: 0 0 10px 0;
            color: #e75034;
            font-size: 12px;
        }
        
        .filtros-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .filtro-item {
            display: flex;
            justify-content: space-between;
        }
        
        .filtro-label {
            font-weight: bold;
            color: #666;
        }
        
        .filtro-value {
            color: #333;
        }
        
        .resumen {
            background-color: #e8f4fd;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
        
        .resumen strong {
            color: #e75034;
            font-size: 12px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th {
            background-color: #e75034;
            color: white;
            padding: 8px 4px;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
            border: 1px solid #ddd;
        }
        
        td {
            padding: 6px 4px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 8px;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .text-left {
            text-align: left;
        }
        
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INFORME DE MOVIMIENTOS</h1>
        <h2>CONTENEDORES DAVI E.I.R.L.</h2>
        <p>Generado el: {{ $fecha_generacion }}</p>
    </div>
    
    <div class="filtros">
        <h3>Parámetros de Búsqueda Aplicados</h3>
        <div class="filtros-grid">
            <div class="filtro-item">
                <span class="filtro-label">Tipo de Título:</span>
                <span class="filtro-value">
                    @if($filtros['tipo'] == '*')
                        Todos
                    @elseif($filtros['tipo'] == '1')
                        TATC
                    @elseif($filtros['tipo'] == '2')
                        TSTC
                    @endif
                </span>
            </div>
            <div class="filtro-item">
                <span class="filtro-label">Tipo de Movimiento:</span>
                <span class="filtro-value">
                    @if($filtros['estado'] == '*')
                        Todos
                    @elseif($filtros['estado'] == '0')
                        Ingresados
                    @elseif($filtros['estado'] == '1')
                        Salida por DI
                    @elseif($filtros['estado'] == '2')
                        Salida por Cancelación
                    @elseif($filtros['estado'] == '3')
                        Salida por Traspaso
                    @endif
                </span>
            </div>
            <div class="filtro-item">
                <span class="filtro-label">Filtrar Por:</span>
                <span class="filtro-value">
                    @if($filtros['filtro'] == '0')
                        Fecha de Ingreso
                    @else
                        Fecha de Salida
                    @endif
                </span>
            </div>
            <div class="filtro-item">
                <span class="filtro-label">Rango de Fechas:</span>
                <span class="filtro-value">{{ $filtros['fecha_desde'] }} - {{ $filtros['fecha_hasta'] }}</span>
            </div>
            <div class="filtro-item">
                <span class="filtro-label">Aduana de Ingreso:</span>
                <span class="filtro-value">{{ $filtros['aduana_ingreso'] == '*' ? 'Todas' : $filtros['aduana_ingreso'] }}</span>
            </div>
            <div class="filtro-item">
                <span class="filtro-label">Aduana de Salida:</span>
                <span class="filtro-value">{{ $filtros['aduana_salida'] == '*' ? 'Todas' : $filtros['aduana_salida'] }}</span>
            </div>
        </div>
    </div>
    
    <div class="resumen">
        <strong>Total de registros encontrados: {{ $resultados->count() }}</strong>
    </div>
    
    @if($resultados->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Nro Contenedor</th>
                    <th>Fecha Ingreso</th>
                    <th>Aduana Ingreso</th>
                    <th>Aduana Salida</th>
                    <th>Tipo Salida</th>
                    <th>Fecha Salida</th>
                    <th>DI / Aduana / Oper.</th>
                    <th>Tipo</th>
                    <th>TATC / TSTC</th>
                    <th>Tipo Contenedor</th>
                    <th>Tamaño</th>
                    <th>Lugar de Depósito</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resultados as $resultado)
                    <tr>
                        <td class="text-left">{{ $resultado['numero_contenedor'] }}</td>
                        <td>{{ $resultado['fecha_ingreso'] }}</td>
                        <td>{{ $resultado['aduana_ingreso'] }}</td>
                        <td>{{ $resultado['aduana_salida'] }}</td>
                        <td>{{ $resultado['tipo_salida'] }}</td>
                        <td>{{ $resultado['fecha_salida'] }}</td>
                        <td class="text-left">{{ $resultado['di_aduana_oper'] }}</td>
                        <td>{{ $resultado['tipo'] }}</td>
                        <td>{{ $resultado['numero_tatc'] }}</td>
                        <td>{{ $resultado['tipo_contenedor'] }}</td>
                        <td>{{ $resultado['tamano_contenedor'] }}</td>
                        <td class="text-left">{{ $resultado['lugar_deposito'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="resumen">
            <p>No se encontraron registros con los filtros aplicados.</p>
        </div>
    @endif
    
    <div class="footer">
        <p>Informe generado automáticamente por el Sistema MITATC - {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>CONTENEDORES DAVI E.I.R.L. - Sistema de Gestión de Contenedores</p>
    </div>
</body>
</html>
