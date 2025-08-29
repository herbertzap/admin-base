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
                            <div class="row mx-3 mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline">
                                        <label class="form-label">Buscar...</label>
                                        <input type="text" id="searchInput" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select id="itemsPerPage" class="form-control">
                                        <option value="10">10 por página</option>
                                        <option value="25" selected>25 por página</option>
                                        <option value="50">50 por página</option>
                                        <option value="100">100 por página</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('control-plazos.exportar') }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-download"></i> Exportar
                                    </a>
                                </div>
                            </div>

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
                                                        {{ $traspaso->tatc->user->operador->nombre_operador ?? 'N/A' }}
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
                                                        {{ $traspaso->operador_destino ?? 'N/A' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <span class="badge badge-sm bg-gradient-info">
                                                        Traspasado
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
