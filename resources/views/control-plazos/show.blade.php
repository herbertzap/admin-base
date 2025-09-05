<x-layout>
    <x-navbars.sidebar activePage="plazos-vigencia"></x-navbars.sidebar>
    
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Detalle de {{ strtoupper($tipo) }}"></x-navbars.navs.auth>
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>Detalle de {{ strtoupper($tipo) }}</h6>
                                <div>
                                    <a href="{{ route('control-plazos.plazos-vigencia') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($tipo === 'tatc')
                                <!-- Información del TATC -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">Información General</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-bold">Número TATC:</td>
                                                <td>{{ $registro->numero_tatc }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Número de Contenedor:</td>
                                                <td>{{ $registro->numero_contenedor }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Tipo de Contenedor:</td>
                                                <td>{{ $registro->tipo_contenedor }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Tipo de Ingreso:</td>
                                                <td>{{ $registro->tipo_ingreso }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Estado Interno:</td>
                                                <td>
                                                    <span class="badge bg-{{ $registro->estado === 'Aprobado' ? 'success' : ($registro->estado === 'Pendiente' ? 'warning' : 'secondary') }}">
                                                        {{ $registro->estado }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Estado HERMES:</td>
                                                <td>
                                                    @if($registro->hermes_sent_at)
                                                        <span class="badge bg-{{ $registro->hermes_status === 'Aprobado' ? 'success' : ($registro->hermes_status === 'Error' ? 'danger' : 'info') }}">
                                                            {{ $registro->hermes_status ?? 'Enviado' }}
                                                        </span>
                                                        <small class="text-muted d-block">
                                                            Enviado: {{ $registro->hermes_sent_at->format('d/m/Y H:i') }}
                                                        </small>
                                                    @else
                                                        <span class="badge bg-secondary">
                                                            No enviado
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Vigencia:</td>
                                                <td>
                                                    @php
                                                        // Verificar si tiene salidas por cancelación
                                                        $tieneCancelacion = $registro->salidas()->where('tipo_salida', 'Cancelación')->where('estado', 'Aprobado')->exists();
                                                        $tieneInternacion = $registro->salidas()->where('tipo_salida', 'Declaración de Internación')->where('estado', 'Aprobado')->exists();
                                                        $tieneTraspaso = $registro->salidas()->where('tipo_salida', 'Traspaso')->where('estado', 'Aprobado')->exists();
                                                        
                                                        // Verificar si tiene prórroga aprobada
                                                        $tieneProrroga = $registro->prorrogas()->where('estado', 'Aprobado')->exists();
                                                        $prorrogaAprobada = $registro->prorrogas()->where('estado', 'Aprobado')->first();
                                                        
                                                        if ($tieneCancelacion) {
                                                            $estadoVigencia = 'Cancelado';
                                                            $claseBadge = 'bg-danger';
                                                            $icono = 'fas fa-ban';
                                                            $textoVigencia = 'Cancelado por salida';
                                                        } elseif ($tieneInternacion) {
                                                            $estadoVigencia = 'Internado';
                                                            $claseBadge = 'bg-info';
                                                            $icono = 'fas fa-check-circle';
                                                            $textoVigencia = 'Internado';
                                                        } elseif ($tieneTraspaso) {
                                                            $estadoVigencia = 'Traspasado';
                                                            $claseBadge = 'bg-warning';
                                                            $icono = 'fas fa-exchange-alt';
                                                            $textoVigencia = 'Traspasado';
                                                        } elseif ($tieneProrroga) {
                                                            // Tiene prórroga aprobada
                                                            $fechaVencimiento = $registro->created_at->addYear();
                                                            $diasRestantes = floor(now()->diffInDays($fechaVencimiento, false));
                                                            $estadoVigencia = 'Vigente con Prórroga';
                                                            $claseBadge = 'bg-success';
                                                            $icono = 'fas fa-clock';
                                                            $textoVigencia = 'Vigente con prórroga hasta ' . $fechaVencimiento->format('d/m/Y') . ' (' . $diasRestantes . ' días)';
                                                        } else {
                                                            // Solo calcular vigencia si no tiene salidas ni prórrogas
                                                            $fechaVencimiento = $registro->created_at->addYear();
                                                            $diasRestantes = floor(now()->diffInDays($fechaVencimiento, false));
                                                            $estaVencido = $diasRestantes < 0;
                                                            $porVencer = $diasRestantes <= 30 && $diasRestantes >= 0;
                                                            
                                                            if ($estaVencido) {
                                                                $estadoVigencia = 'Vencido';
                                                                $claseBadge = 'bg-danger';
                                                                $icono = 'fas fa-exclamation-triangle';
                                                                $textoVigencia = 'Vencido desde ' . $fechaVencimiento->format('d/m/Y');
                                                            } elseif ($porVencer) {
                                                                $estadoVigencia = 'Por vencer';
                                                                $claseBadge = 'bg-warning';
                                                                $icono = 'fas fa-clock';
                                                                $textoVigencia = 'Vigente hasta ' . $fechaVencimiento->format('d/m/Y') . ' (' . $diasRestantes . ' días)';
                                                            } else {
                                                                $estadoVigencia = 'Vigente';
                                                                $claseBadge = 'bg-success';
                                                                $icono = 'fas fa-check-circle';
                                                                $textoVigencia = 'Vigente hasta ' . $fechaVencimiento->format('d/m/Y') . ' (' . $diasRestantes . ' días)';
                                                            }
                                                        }
                                                    @endphp
                                                    
                                                    <span class="badge {{ $claseBadge }}">
                                                        <i class="{{ $icono }}"></i> {{ $textoVigencia }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @if($tipo === 'tatc' && !$tieneProrroga && !$tieneCancelacion && !$tieneInternacion && !$tieneTraspaso)
                                            <tr>
                                                <td class="fw-bold">Acciones:</td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#solicitarProrrogaModal">
                                                        <i class="fas fa-clock"></i> Solicitar Prórroga
                                                    </button>
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">Información de Ingreso</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-bold">País de Ingreso:</td>
                                                <td>{{ $registro->ingreso_pais ? \Carbon\Carbon::parse($registro->ingreso_pais)->format('d/m/Y') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Depósito de Ingreso:</td>
                                                <td>{{ $registro->ingreso_deposito ? \Carbon\Carbon::parse($registro->ingreso_deposito)->format('d/m/Y') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Fecha de Traspaso:</td>
                                                <td>{{ $registro->fecha_traspaso ? \Carbon\Carbon::parse($registro->fecha_traspaso)->format('d/m/Y') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Puerto de Ingreso:</td>
                                                <td>{{ $registro->puerto_ingreso }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Aduana de Ingreso:</td>
                                                <td>{{ $registro->aduana->nombre_aduana ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <hr class="my-4">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">Información del Usuario</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-bold">Usuario Responsable:</td>
                                                <td>{{ $registro->user->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Operador:</td>
                                                <td>{{ $registro->user->operador->nombre_operador ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Fecha de Creación:</td>
                                                <td>{{ $registro->created_at ? \Carbon\Carbon::parse($registro->created_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Última Actualización:</td>
                                                <td>{{ $registro->updated_at ? \Carbon\Carbon::parse($registro->updated_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">Información del Contenedor</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-bold">Tara del Contenedor:</td>
                                                <td>{{ $registro->tara_contenedor ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Tipo de Bulto:</td>
                                                <td>{{ $registro->tipo_bulto ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Valor FOB:</td>
                                                <td>{{ $registro->valor_fob ? '$' . number_format($registro->valor_fob, 0, ',', '.') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Valor CIF:</td>
                                                <td>{{ $registro->valor_cif ? '$' . number_format($registro->valor_cif, 0, ',', '.') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Ubicación Física:</td>
                                                <td>{{ $registro->ubicacion_fisica ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                @if($registro->historialImportacion && $registro->historialImportacion->count() > 0)
                                    <hr class="my-4">
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="text-primary mb-3">Historial de Importación</h6>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Estado</th>
                                                            <th>Comentario</th>
                                                            <th>Archivo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($registro->historialImportacion as $historial)
                                                            <tr>
                                                                <td>{{ $historial->created_at ? \Carbon\Carbon::parse($historial->created_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $historial->estado === 'Salida por DI' ? 'success' : 'info' }}">
                                                                        {{ $historial->estado }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $historial->comentario ?? 'N/A' }}</td>
                                                                <td>{{ $historial->archivo_origen ?? 'N/A' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($registro->salidas && $registro->salidas->count() > 0)
                                    <hr class="my-4">
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="text-primary mb-3">Salidas Registradas</h6>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Número de Salida</th>
                                                            <th>Fecha de Salida</th>
                                                            <th>Tipo de Salida</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($registro->salidas as $salida)
                                                            <tr>
                                                                <td>{{ $salida->numero_salida }}</td>
                                                                <td>{{ $salida->fecha_salida ? \Carbon\Carbon::parse($salida->fecha_salida)->format('d/m/Y') : 'N/A' }}</td>
                                                                <td>{{ $salida->tipo_salida }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{ $salida->estado === 'Aprobado' ? 'success' : 'warning' }}">
                                                                        {{ $salida->estado }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                            @elseif($tipo === 'tstc')
                                <!-- Información del TSTC -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">Información General</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-bold">Número TSTC:</td>
                                                <td>{{ $registro->numero_tstc }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Número de Contenedor:</td>
                                                <td>{{ $registro->numero_contenedor }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Tipo de Contenedor:</td>
                                                <td>{{ $registro->tipo_contenedor }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Estado:</td>
                                                <td>
                                                    <span class="badge bg-{{ $registro->estado === 'activo' ? 'success' : 'secondary' }}">
                                                        {{ $registro->estado }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">Información de Salida</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-bold">Fecha de Emisión:</td>
                                                <td>{{ $registro->fecha_emision_tstc ? \Carbon\Carbon::parse($registro->fecha_emision_tstc)->format('d/m/Y') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Fecha de Salida del País:</td>
                                                <td>{{ $registro->fecha_salida_pais ? \Carbon\Carbon::parse($registro->fecha_salida_pais)->format('d/m/Y') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Destino del Contenedor:</td>
                                                <td>{{ $registro->destino_contenedor ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Aduana de Salida:</td>
                                                <td>{{ $registro->aduana->nombre_aduana ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <hr class="my-4">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">Información del Usuario</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-bold">Usuario Responsable:</td>
                                                <td>{{ $registro->user->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Operador:</td>
                                                <td>{{ $registro->operador->nombre_operador ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Fecha de Creación:</td>
                                                <td>{{ $registro->created_at ? \Carbon\Carbon::parse($registro->created_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">Información del Contenedor</h6>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-bold">Tara del Contenedor:</td>
                                                <td>{{ $registro->tara_contenedor ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Valor FOB:</td>
                                                <td>{{ $registro->valor_fob ? '$' . number_format($registro->valor_fob, 0, ',', '.') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Tamaño del Contenedor:</td>
                                                <td>{{ $registro->tamano_contenedor ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Año de Fabricación:</td>
                                                <td>{{ $registro->anio_fabricacion ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                @if($registro->historial && $registro->historial->count() > 0)
                                    <hr class="my-4">
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="text-primary mb-3">Historial de Cambios</h6>
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Campo</th>
                                                            <th>Valor Anterior</th>
                                                            <th>Valor Nuevo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($registro->historial as $historial)
                                                            <tr>
                                                                <td>{{ $historial->created_at ? \Carbon\Carbon::parse($historial->created_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                                                                <td>{{ $historial->campo ?? 'N/A' }}</td>
                                                                <td>{{ $historial->valor_anterior ?? 'N/A' }}</td>
                                                                <td>{{ $historial->valor_nuevo ?? 'N/A' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Modal para Solicitar Prórroga -->
    <div class="modal fade" id="solicitarProrrogaModal" tabindex="-1" aria-labelledby="solicitarProrrogaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="solicitarProrrogaModalLabel">
                        <i class="fas fa-clock text-warning"></i> Solicitar Prórroga de Vigencia
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('control-plazos.solicitar-prorroga') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tatc_id" value="{{ $registro->id }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">TATC</label>
                                    <input type="text" class="form-control" value="{{ $registro->numero_tatc }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_solicitud" class="form-label">Fecha de Solicitud</label>
                                    <input type="date" name="fecha_solicitud" id="fecha_solicitud" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="motivo" class="form-label">Motivo de la Prórroga</label>
                            <textarea name="motivo" id="motivo" class="form-control" rows="4" placeholder="Describa el motivo por el cual solicita la prórroga de vigencia..." required></textarea>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Información:</strong> La solicitud de prórroga será enviada a HERMES para su aprobación. 
                            Una vez aprobada, el TATC tendrá vigencia extendida según los términos establecidos.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-paper-plane"></i> Enviar Solicitud a HERMES
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</x-layout>
