<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="registro-traspaso"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Registro de Traspaso"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Registro de Traspaso - TATC/TSTC con Traspasos</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <!-- Filtros -->
                            <form action="{{ route('control-plazos.registro-traspaso') }}" method="GET" class="mx-3 mb-3">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-3">
                                        <label for="searchInput" class="form-label">Buscar</label>
                                        <input
                                            type="text"
                                            id="searchInput"
                                            name="search"
                                            class="form-control"
                                            placeholder="TATC, contenedor, operador"
                                            value="{{ old('search', $search) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="fecha_traspaso_desde" class="form-label">Fecha de traspaso desde</label>
                                        <input
                                            type="date"
                                            id="fecha_traspaso_desde"
                                            name="fecha_traspaso_desde"
                                            class="form-control"
                                            value="{{ old('fecha_traspaso_desde', $fechaTraspasoDesde) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="fecha_traspaso_hasta" class="form-label">Fecha de traspaso hasta</label>
                                        <input
                                            type="date"
                                            id="fecha_traspaso_hasta"
                                            name="fecha_traspaso_hasta"
                                            class="form-control"
                                            value="{{ old('fecha_traspaso_hasta', $fechaTraspasoHasta) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="aduana" class="form-label">Aduana</label>
                                        <select id="aduana" name="aduana" class="form-control">
                                            <option value="">Todas las aduanas</option>
                                            @foreach($aduanas as $aduanaItem)
                                                <option value="{{ $aduanaItem->codigo }}" {{ $aduana === $aduanaItem->codigo ? 'selected' : '' }}>
                                                    {{ $aduanaItem->codigo }} - {{ $aduanaItem->nombre_aduana }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row g-3 align-items-end mt-3">
                                    <div class="col-md-3">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select id="estado" name="estado" class="form-control">
                                            <option value="">Todos los estados</option>
                                            @foreach($estadosDisponibles as $estadoItem)
                                                <option value="{{ $estadoItem }}" {{ $estado === $estadoItem ? 'selected' : '' }}>
                                                    {{ $estadoItem }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="itemsPerPage" class="form-label">Registros por página</label>
                                        <select id="itemsPerPage" name="per_page" class="form-control">
                                            @foreach([10, 25, 50, 100] as $option)
                                                <option value="{{ $option }}" {{ (int) $perPage === $option ? 'selected' : '' }}>
                                                    {{ $option }} por página
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="fas fa-filter"></i> Aplicar filtros
                                        </button>
                                        <a href="{{ route('control-plazos.registro-traspaso') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-undo"></i> Limpiar
                                        </a>
                                    </div>
                                    <div class="col-md-3 text-md-end">
                                        <a href="{{ route('control-plazos.exportar', ['tipo' => 'tatc']) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-download"></i> Exportar Traspasos
                                        </a>
                                    </div>
                                </div>
                            </form>

                            <!-- Tabla de Traspasos -->
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                TATC/TSTC
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Contenedor
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Operador Origen
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Fecha Traspaso
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                TATC Destino
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Operador Destino
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Estado
                                            </th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($traspasos as $traspaso)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $traspaso->tatc->numero_tatc ?? 'N/A' }}</h6>
                                                            <small class="text-muted">TATC</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $traspaso->numero_contenedor }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        @if($traspaso->tatc && $traspaso->tatc->user && $traspaso->tatc->user->operador)
                                                            {{ $traspaso->tatc->user->operador->codigo ?? '' }} - {{ $traspaso->tatc->user->operador->nombre_operador ?? 'N/A' }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $traspaso->fecha_salida ? \Carbon\Carbon::parse($traspaso->fecha_salida)->format('d/m/Y') : 'N/A' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $traspaso->tatc_destino ?? 'N/A' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        @if($traspaso->operador_destino)
                                                            {{ $traspaso->operador_destino }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </p>
                                                </td>
                                                <td>
                                                    @php
                                                        $estadoColor = match($traspaso->estado) {
                                                            'Aprobado' => 'success',
                                                            'Pendiente' => 'warning',
                                                            'Rechazado' => 'danger',
                                                            'Cancelado' => 'secondary',
                                                            default => 'info'
                                                        };
                                                    @endphp
                                                    <span class="badge badge-sm bg-gradient-{{ $estadoColor }}">
                                                        {{ $traspaso->estado ?? 'Traspasado' }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('control-plazos.show', ['tipo' => 'tatc', 'id' => $traspaso->tatc->id]) }}" 
                                                           class="btn btn-link text-secondary mb-0" 
                                                           data-bs-toggle="tooltip" 
                                                           data-bs-placement="top" 
                                                           title="Ver Detalles">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </a>
                                                        <a href="{{ route('salidas.edit', $traspaso->id) }}" 
                                                           class="btn btn-link text-secondary mb-0" 
                                                           data-bs-toggle="tooltip" 
                                                           data-bs-placement="top" 
                                                           title="Editar Traspaso">
                                                            <i class="fas fa-edit text-xs"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <p class="text-sm text-secondary mb-0">No se encontraron traspasos registrados</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            @if($traspasos->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $traspasos->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
