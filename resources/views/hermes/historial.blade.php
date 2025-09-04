<x-layout>
    <x-navbars.sidebar activePage="hermes"></x-navbars.sidebar>
    
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Historial HERMES"></x-navbars.navs.auth>
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>
                                    <i class="fas fa-history text-primary"></i> 
                                    Historial Completo de Mensajes HERMES
                                </h6>
                                <div>
                                    <a href="{{ route('hermes.monitor') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-arrow-left"></i> Volver al Monitor
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Filtros -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label for="tipo_operacion" class="form-label">Tipo de Operación</label>
                                    <select class="form-control" id="tipo_operacion" name="tipo_operacion">
                                        <option value="">Todos los tipos</option>
                                        @foreach($tiposOperacion as $tipo)
                                            <option value="{{ $tipo }}" {{ request('tipo_operacion') == $tipo ? 'selected' : '' }}>
                                                {{ $tipo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-control" id="estado" name="estado">
                                        <option value="">Todos los estados</option>
                                        @foreach($estados as $estado)
                                            <option value="{{ $estado }}" {{ request('estado') == $estado ? 'selected' : '' }}>
                                                {{ $estado }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="fecha_desde" class="form-label">Fecha Desde</label>
                                    <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" 
                                           value="{{ request('fecha_desde') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                                    <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" 
                                           value="{{ request('fecha_hasta') }}">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary" onclick="aplicarFiltros()">
                                        <i class="fas fa-filter"></i> Aplicar Filtros
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="limpiarFiltros()">
                                        <i class="fas fa-times"></i> Limpiar Filtros
                                    </button>
                                </div>
                            </div>

                            <!-- Tabla de Historial -->
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Tipo de Operación</th>
                                            <th>Número de Documento</th>
                                            <th>Estado</th>
                                            <th>Mensaje ID</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($logs as $log)
                                            <tr>
                                                <td>{{ $log->id }}</td>
                                                <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                                <td>
                                                    <span class="badge bg-info">{{ $log->tipo_operacion }}</span>
                                                </td>
                                                <td>
                                                    @if($log->tatc)
                                                        <strong>TATC:</strong> {{ $log->tatc->numero_tatc }}
                                                    @elseif($log->tstc)
                                                        <strong>TSTC:</strong> {{ $log->tstc->numero_tstc }}
                                                    @elseif($log->salida)
                                                        <strong>Salida:</strong> {{ $log->salida->numero_salida }}
                                                    @else
                                                        {{ $log->numero_documento ?? 'N/A' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($log->estado === 'Exitoso')
                                                        <span class="badge bg-success">{{ $log->estado }}</span>
                                                    @elseif($log->estado === 'Error')
                                                        <span class="badge bg-danger">{{ $log->estado }}</span>
                                                    @elseif($log->estado === 'Pendiente')
                                                        <span class="badge bg-warning">{{ $log->estado }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $log->estado }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($log->hermes_message_id)
                                                        <code>{{ $log->hermes_message_id }}</code>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('hermes.show', $log->id) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">
                                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                                    <p>No hay registros en el historial</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            @if($logs->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $logs->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

@push('scripts')
<script>
    function aplicarFiltros() {
        const tipoOperacion = document.getElementById('tipo_operacion').value;
        const estado = document.getElementById('estado').value;
        const fechaDesde = document.getElementById('fecha_desde').value;
        const fechaHasta = document.getElementById('fecha_hasta').value;
        
        let url = '{{ route("hermes.historial") }}?';
        const params = new URLSearchParams();
        
        if (tipoOperacion) params.append('tipo_operacion', tipoOperacion);
        if (estado) params.append('estado', estado);
        if (fechaDesde) params.append('fecha_desde', fechaDesde);
        if (fechaHasta) params.append('fecha_hasta', fechaHasta);
        
        window.location.href = url + params.toString();
    }
    
    function limpiarFiltros() {
        window.location.href = '{{ route("hermes.historial") }}';
    }
</script>
@endpush
