<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="plazos-vigencia"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Plazos de Vigencia"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Plazos de Vigencia - TATC/TSTC Activos</h6>
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

                            <!-- Tabs para TATC y TSTC -->
                            <ul class="nav nav-tabs mx-3" id="vigenciaTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="tatc-tab" data-bs-toggle="tab" data-bs-target="#tatc" type="button" role="tab">
                                        TATC Vigentes ({{ $tatcsVigentes->total() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tstc-tab" data-bs-toggle="tab" data-bs-target="#tstc" type="button" role="tab">
                                        TSTC Vigentes ({{ $tstcsVigentes->total() }})
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="vigenciaTabsContent">
                                <!-- Tab TATC -->
                                <div class="tab-pane fade show active" id="tatc" role="tabpanel">
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        TATC
                                                    </th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Contenedor
                                                    </th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Operador
                                                    </th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Fecha Ingreso
                                                    </th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Aduana
                                                    </th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Estado
                                                    </th>
                                                    <th class="text-secondary opacity-7"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($tatcsVigentes as $tatc)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm">{{ $tatc->numero_tatc }}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">{{ $tatc->numero_contenedor }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $tatc->user->operador->nombre_operador ?? 'N/A' }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $tatc->ingreso_pais ? \Carbon\Carbon::parse($tatc->ingreso_pais)->format('d/m/Y') : 'N/A' }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $tatc->aduana->nombre_aduana ?? 'N/A' }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-sm bg-gradient-success">
                                                                Vigente
                                                            </span>
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('control-plazos.show', ['tipo' => 'tatc', 'id' => $tatc->id]) }}" 
                                                                   class="btn btn-link text-secondary mb-0" 
                                                                   data-bs-toggle="tooltip" 
                                                                   data-bs-placement="top" 
                                                                   title="Ver Detalles">
                                                                    <i class="fas fa-eye text-xs"></i>
                                                                </a>
                                                                <a href="{{ route('tatc.edit', $tatc->id) }}" 
                                                                   class="btn btn-link text-secondary mb-0" 
                                                                   data-bs-toggle="tooltip" 
                                                                   data-bs-placement="top" 
                                                                   title="Editar">
                                                                    <i class="fas fa-edit text-xs"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">No se encontraron TATC vigentes</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Paginación TATC -->
                                    @if($tatcsVigentes->hasPages())
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $tatcsVigentes->links() }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Tab TSTC -->
                                <div class="tab-pane fade" id="tstc" role="tabpanel">
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        TSTC
                                                    </th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Contenedor
                                                    </th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Operador
                                                    </th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Fecha Salida
                                                    </th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Aduana
                                                    </th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Estado
                                                    </th>
                                                    <th class="text-secondary opacity-7"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($tstcsVigentes as $tstc)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm">{{ $tstc->numero_tstc }}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">{{ $tstc->numero_contenedor }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $tstc->user->operador->nombre_operador ?? 'N/A' }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $tstc->fecha_salida ? \Carbon\Carbon::parse($tstc->fecha_salida)->format('d/m/Y') : 'N/A' }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0">
                                                                {{ $tstc->aduana->nombre_aduana ?? 'N/A' }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-sm bg-gradient-success">
                                                                Vigente
                                                            </span>
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('control-plazos.show', ['tipo' => 'tstc', 'id' => $tstc->id]) }}" 
                                                                   class="btn btn-link text-secondary mb-0" 
                                                                   data-bs-toggle="tooltip" 
                                                                   data-bs-placement="top" 
                                                                   title="Ver Detalles">
                                                                    <i class="fas fa-eye text-xs"></i>
                                                                </a>
                                                                <a href="{{ route('tstc.edit', $tstc->id) }}" 
                                                                   class="btn btn-link text-secondary mb-0" 
                                                                   data-bs-toggle="tooltip" 
                                                                   data-bs-placement="top" 
                                                                   title="Editar">
                                                                    <i class="fas fa-edit text-xs"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center py-4">
                                                            <p class="text-sm text-secondary mb-0">No se encontraron TSTC vigentes</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Paginación TSTC -->
                                    @if($tstcsVigentes->hasPages())
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $tstcsVigentes->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
