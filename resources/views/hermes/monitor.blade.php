<x-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0">
                <i class="fas fa-satellite-dish text-primary"></i> 
                Monitor HERMES
            </h2>
            <div>
                <a href="{{ route('hermes.historial') }}" class="btn btn-outline-primary">
                    <i class="fas fa-history"></i> Historial Completo
                </a>
                <button class="btn btn-warning" onclick="reintentarMensajes()">
                    <i class="fas fa-redo"></i> Reintentar Fallidos
                </button>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid px-4">
        <!-- Tarjetas de Estadísticas -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Mensajes
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-mensajes">
                                    {{ $estadisticas['total_mensajes'] }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-envelope fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Mensajes Exitosos
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="mensajes-exitosos">
                                    {{ $estadisticas['mensajes_exitosos'] }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Mensajes con Error
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="mensajes-error">
                                    {{ $estadisticas['mensajes_error'] }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Tasa de Éxito
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="tasa-exito">
                                    {{ $estadisticas['tasa_exito'] }}%
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-percentage fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Gráfico de Estadísticas por Tipo -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-pie"></i> Estadísticas por Tipo de Operación
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Total</th>
                                        <th>Exitosos</th>
                                        <th>Errores</th>
                                        <th>Tasa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($estadisticasPorTipo as $estadistica)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">{{ $estadistica->tipo_operacion }}</span>
                                            </td>
                                            <td>{{ $estadistica->total }}</td>
                                            <td>
                                                <span class="text-success">{{ $estadistica->exitosos }}</span>
                                            </td>
                                            <td>
                                                <span class="text-danger">{{ $estadistica->errores }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $tasa = $estadistica->total > 0 
                                                        ? round(($estadistica->exitosos / $estadistica->total) * 100, 1) 
                                                        : 0;
                                                @endphp
                                                <span class="badge bg-{{ $tasa >= 80 ? 'success' : ($tasa >= 60 ? 'warning' : 'danger') }}">
                                                    {{ $tasa }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Estados -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-chart-bar"></i> Distribución por Estado
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach($estadisticasPorEstado as $estadistica)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span class="font-weight-bold">
                                        @switch($estadistica->estado)
                                            @case('EXITOSO')
                                                <i class="fas fa-check-circle text-success"></i> Exitosos
                                                @break
                                            @case('ERROR')
                                                <i class="fas fa-exclamation-triangle text-danger"></i> Con Error
                                                @break
                                            @case('ENVIADO')
                                                <i class="fas fa-clock text-warning"></i> Pendientes
                                                @break
                                            @default
                                                <i class="fas fa-question-circle text-secondary"></i> {{ $estadistica->estado }}
                                        @endswitch
                                    </span>
                                    <span class="badge bg-primary">{{ $estadistica->total }}</span>
                                </div>
                                <div class="progress">
                                    @php
                                        $porcentaje = $estadisticas['total_mensajes'] > 0 
                                            ? round(($estadistica->total / $estadisticas['total_mensajes']) * 100, 1) 
                                            : 0;
                                    @endphp
                                    <div class="progress-bar 
                                        @switch($estadistica->estado)
                                            @case('EXITOSO') bg-success @break
                                            @case('ERROR') bg-danger @break
                                            @case('ENVIADO') bg-warning @break
                                            @default bg-secondary
                                        @endswitch" 
                                        role="progressbar" 
                                        style="width: {{ $porcentaje }}%"
                                        aria-valuenow="{{ $porcentaje }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                        {{ $porcentaje }}%
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Últimos Mensajes -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-list"></i> Últimos Mensajes Enviados
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Documento</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ultimosMensajes as $mensaje)
                                        <tr>
                                            <td>
                                                <small class="text-muted">{{ $mensaje->created_at->format('d/m/Y') }}</small><br>
                                                <strong>{{ $mensaje->created_at->format('H:i:s') }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $mensaje->tipo_operacion }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ $mensaje->numero_documento }}</strong><br>
                                                <small class="text-muted">{{ $mensaje->endpoint }}</small>
                                            </td>
                                            <td>
                                                @switch($mensaje->estado)
                                                    @case('EXITOSO')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check"></i> Exitoso
                                                        </span>
                                                        @break
                                                    @case('ERROR')
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times"></i> Error
                                                        </span>
                                                        @break
                                                    @case('ENVIADO')
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-clock"></i> Pendiente
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $mensaje->estado }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="{{ route('hermes.show', $mensaje->id) }}" 
                                                   class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                                <p>No hay mensajes para mostrar</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mensajes con Error -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-danger">
                            <i class="fas fa-exclamation-triangle"></i> Mensajes con Error
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($mensajesError as $mensaje)
                            <div class="alert alert-danger alert-sm mb-2">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $mensaje->tipo_operacion }}</strong><br>
                                        <small>{{ $mensaje->numero_documento }}</small><br>
                                        <small class="text-muted">{{ $mensaje->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <a href="{{ route('hermes.show', $mensaje->id) }}" 
                                       class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                                @if($mensaje->mensaje_error)
                                    <small class="d-block mt-1">{{ Str::limit($mensaje->mensaje_error, 100) }}</small>
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-muted">
                                <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                                <p>No hay mensajes con error</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Actualizar estadísticas cada 30 segundos
        setInterval(function() {
            fetch('{{ route("hermes.estadisticas") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-mensajes').textContent = data.total_mensajes;
                    document.getElementById('mensajes-exitosos').textContent = data.mensajes_exitosos;
                    document.getElementById('mensajes-error').textContent = data.mensajes_error;
                    document.getElementById('tasa-exito').textContent = data.tasa_exito + '%';
                })
                .catch(error => console.error('Error actualizando estadísticas:', error));
        }, 30000);

        // Función para reintentar mensajes fallidos
        function reintentarMensajes() {
            if (confirm('¿Estás seguro de que deseas reintentar todos los mensajes fallidos?')) {
                fetch('{{ route("hermes.reintentar") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Proceso de reintento iniciado correctamente');
                        location.reload();
                    } else {
                        alert('Error al iniciar el reintento: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al procesar la solicitud');
                });
            }
        }
    </script>
    @endpush
</x-layout>
