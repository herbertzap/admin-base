<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='consulta-tstc'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Consulta General de TSTC"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Consulta General de TSTC</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('tstc.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Nuevo TSTC
                                    </a>
                                    <button class="btn btn-secondary btn-sm" onclick="location.reload()">
                                        <i class="fas fa-refresh"></i> Actualizar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <!-- Filtros de búsqueda -->
                            <div class="row mx-3 mb-3">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por contenedor, TSTC...">
                                        <button class="btn btn-outline-secondary" type="button" onclick="buscar()">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <select id="itemsPerPage" class="form-control" onchange="cambiarItemsPorPagina()">
                                        <option value="10">Mostrar 10</option>
                                        <option value="25">Mostrar 25</option>
                                        <option value="50">Mostrar 50</option>
                                        <option value="100">Mostrar 100</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-outline-secondary" onclick="limpiarFiltros()">
                                        <i class="fas fa-times"></i> Limpiar
                                    </button>
                                </div>
                            </div>

                            @if($tstcs->count() > 0)
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Operador</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Contenedor</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Emisión TSTC</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Salida del País</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Salida Por</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aduana</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">TSTC</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tipo</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tamaño</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Estado</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tstcs as $tstc)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $tstc->user->operador->nombre_operador ?? 'N/A' }}</h6>
                                                                <p class="text-xs text-secondary mb-0">{{ $tstc->user->operador->codigo ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tstc->numero_contenedor }}</p>
                                                        <p class="text-xs text-secondary mb-0">{{ $tstc->tipo_contenedor }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tstc->created_at->format('d/m/Y') }}</p>
                                                        <p class="text-xs text-secondary mb-0">{{ $tstc->created_at->format('H:i') }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tstc->salida_pais ? \Carbon\Carbon::parse($tstc->salida_pais)->format('d/m/Y') : 'N/A' }}</p>
                                                        <p class="text-xs text-secondary mb-0">{{ $tstc->salida_pais ? \Carbon\Carbon::parse($tstc->salida_pais)->format('H:i') : '' }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ ucfirst($tstc->tipo_salida) }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tstc->aduana_salida }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tstc->numero_tstc }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tstc->tipo_contenedor }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tstc->tamano_contenedor ?? 'N/A' }}</p>
                                                    </td>
                                                    <td>
                                                        @if($tstc->estado == 'activo')
                                                            <span class="badge badge-sm bg-success">Activo</span>
                                                        @elseif($tstc->estado == 'inactivo')
                                                            <span class="badge badge-sm bg-danger">Inactivo</span>
                                                        @elseif($tstc->estado == 'en_transito')
                                                            <span class="badge badge-sm bg-warning">En Tránsito</span>
                                                        @else
                                                            <span class="badge badge-sm bg-secondary">{{ $tstc->estado }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('tstc.show', $tstc) }}" class="btn btn-info btn-sm" title="Ver Registro">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('tstc.edit', $tstc) }}" class="btn btn-warning btn-sm" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-primary btn-sm" title="Imprimir TSTC" onclick="imprimirTstc({{ $tstc->id }})">
                                                                <i class="fas fa-print"></i>
                                                            </button>
                                                            <form action="{{ route('tstc.destroy', $tstc) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este TSTC?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-muted">No hay TSTCs registrados</p>
                                    <a href="{{ route('tstc.create') }}" class="btn btn-primary">Crear primer TSTC</a>
                                </div>
                            @endif

                            @if($tstcs->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $tstcs->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout>

<script>
    function buscar() {
        var searchTerm = document.getElementById('searchInput').value;
        var currentUrl = new URL(window.location);
        currentUrl.searchParams.set('search', searchTerm);
        window.location.href = currentUrl.toString();
    }

    function limpiarFiltros() {
        document.getElementById('searchInput').value = '';
        window.location.href = window.location.pathname;
    }

    function cambiarItemsPorPagina() {
        var itemsPerPage = document.getElementById('itemsPerPage').value;
        var currentUrl = new URL(window.location);
        currentUrl.searchParams.set('per_page', itemsPerPage);
        window.location.href = currentUrl.toString();
    }

    function imprimirTstc(tstcId) {
        // Abrir ventana de impresión del TSTC
        window.open(`/tstc/${tstcId}/pdf`, '_blank');
    }

    // Configurar tooltips
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
