<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="registro-prorrogas"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Registro de Prórrogas"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Registro de Prórrogas - TATC/TSTC con Prórrogas</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <!-- Filtros -->
                            <form action="{{ route('control-plazos.registro-prorrogas') }}" method="GET" class="mx-3 mb-3">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-3">
                                        <label for="searchInput" class="form-label">Buscar</label>
                                        <input
                                            type="text"
                                            id="searchInput"
                                            name="search"
                                            class="form-control"
                                            placeholder="Prórroga, TATC, contenedor, operador"
                                            value="{{ old('search', $search) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="fecha_prorroga_desde" class="form-label">Fecha de prórroga desde</label>
                                        <input
                                            type="date"
                                            id="fecha_prorroga_desde"
                                            name="fecha_prorroga_desde"
                                            class="form-control"
                                            value="{{ old('fecha_prorroga_desde', $fechaProrrogaDesde) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="fecha_prorroga_hasta" class="form-label">Fecha de prórroga hasta</label>
                                        <input
                                            type="date"
                                            id="fecha_prorroga_hasta"
                                            name="fecha_prorroga_hasta"
                                            class="form-control"
                                            value="{{ old('fecha_prorroga_hasta', $fechaProrrogaHasta) }}">
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
                                        <a href="{{ route('control-plazos.registro-prorrogas') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-undo"></i> Limpiar
                                        </a>
                                    </div>
                                    <div class="col-md-3 text-md-end">
                                    <a href="{{ route('control-plazos.exportar', ['tipo' => 'tatc']) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-download"></i> Exportar Prórrogas
                                    </a>
                                </div>
                            </div>
                            </form>

                            <!-- Tabla de Prórrogas -->
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
                                                Operador
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Fecha Prórroga
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Aduana
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Motivo
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Estado
                                            </th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($prorrogas as $prorroga)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $prorroga->tatc->numero_tatc ?? 'N/A' }}</h6>
                                                            <small class="text-muted">TATC</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $prorroga->tatc->numero_contenedor ?? 'N/A' }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $prorroga->tatc->user->operador->nombre_operador ?? 'N/A' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $prorroga->fecha_solicitud ? $prorroga->fecha_solicitud->format('d/m/Y') : 'N/A' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $prorroga->tatc->aduana->nombre_aduana ?? 'N/A' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                        {{ $prorroga->motivo ?? 'N/A' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <span class="badge badge-sm bg-gradient-{{ $prorroga->estado === 'Aprobado' ? 'success' : ($prorroga->estado === 'Pendiente' ? 'warning' : 'danger') }}">
                                                        {{ $prorroga->estado === 'Aprobado' ? 'Prórroga Aprobada' : $prorroga->estado }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('control-plazos.show', ['tipo' => 'tatc', 'id' => $prorroga->tatc->id]) }}" 
                                                           class="btn btn-link text-secondary mb-0" 
                                                           data-bs-toggle="tooltip" 
                                                           data-bs-placement="top" 
                                                           title="Ver Detalles">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <p class="text-sm text-secondary mb-0">No se encontraron prórrogas registradas</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            @if($prorrogas->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $prorrogas->links() }}
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
