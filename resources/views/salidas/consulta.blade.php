<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="consulta-salidas"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Consulta de Salidas"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Consulta de Salidas</h6>
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
                                    <a href="{{ route('salidas.exportar') }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-download"></i> Exportar
                                    </a>
                                </div>
                            </div>

                            <!-- Tabla de Salidas -->
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
                                                Tipo Salida
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Fecha Salida
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Operador
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
                                        @forelse($salidas as $salida)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $salida->tatc->numero_tatc ?? 'N/A' }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $salida->numero_contenedor }}</p>
                                                </td>
                                                <td>
                                                    <span class="badge badge-sm bg-gradient-info">
                                                        @switch($salida->tipo_salida)
                                                            @case('internacion')
                                                                Internación
                                                                @break
                                                            @case('cancelacion')
                                                                Cancelación
                                                                @break
                                                            @case('traspaso')
                                                                Traspaso
                                                                @break
                                                            @default
                                                                {{ ucfirst($salida->tipo_salida) }}
                                                        @endswitch
                                                    </span>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $salida->fecha_salida ? \Carbon\Carbon::parse($salida->fecha_salida)->format('d/m/Y') : 'N/A' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $salida->tatc->operador->nombre_operador ?? 'N/A' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $salida->tatc->aduana->nombre_aduana ?? 'N/A' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <span class="badge badge-sm bg-gradient-{{ $salida->estado == 'activo' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($salida->estado) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('salidas.show', $salida->id) }}" 
                                                           class="btn btn-link text-secondary mb-0" 
                                                           data-bs-toggle="tooltip" 
                                                           data-bs-placement="top" 
                                                           title="Ver Detalles">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </a>
                                                        <a href="{{ route('salidas.edit', $salida->id) }}" 
                                                           class="btn btn-link text-secondary mb-0" 
                                                           data-bs-toggle="tooltip" 
                                                           data-bs-placement="top" 
                                                           title="Editar">
                                                            <i class="fas fa-edit text-xs"></i>
                                                        </a>
                                                        <form action="{{ route('salidas.destroy', $salida->id) }}" 
                                                              method="POST" 
                                                              style="display: inline;"
                                                              onsubmit="return confirm('¿Está seguro de que desea eliminar esta salida?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-link text-danger mb-0" 
                                                                    data-bs-toggle="tooltip" 
                                                                    data-bs-placement="top" 
                                                                    title="Eliminar">
                                                                <i class="fas fa-trash text-xs"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <p class="text-sm text-secondary mb-0">No se encontraron salidas registradas</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            @if($salidas->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $salidas->links() }}
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
