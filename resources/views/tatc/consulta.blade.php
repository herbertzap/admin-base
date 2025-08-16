<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='tatc'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Consulta General de TATC"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Consulta General de TATC</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('tatc.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Nuevo TATC
                                    </a>
                                    <a href="{{ route('tatc.consulta') }}" class="btn btn-secondary btn-sm" title="Actualizar">
                                        <i class="fas fa-refresh"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <!-- Filtros de búsqueda -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <form method="GET" action="{{ route('tatc.consulta') }}" id="formList">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <select name="mostrar" id="mostrar" class="form-control">
                                                    <option value="10" {{ request('mostrar') == '10' ? 'selected' : '' }}>Mostrar 10</option>
                                                    <option value="25" {{ request('mostrar') == '25' ? 'selected' : '' }}>Mostrar 25</option>
                                                    <option value="50" {{ request('mostrar') == '50' ? 'selected' : '' }}>Mostrar 50</option>
                                                    <option value="100" {{ request('mostrar') == '100' ? 'selected' : '' }}>Mostrar 100</option>
                                                </select>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <input type="text" name="buscar" id="buscar" class="form-control" placeholder="¿Qué desea buscar?" value="{{ request('buscar') }}">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-outline-secondary w-100" onclick="limpiarFiltros()">
                                                    <i class="fas fa-times"></i> Limpiar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @if($tatcs->count() > 0)
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Operador</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Contenedor</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Emisión TATC</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ingreso al País</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ingreso Por</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aduana</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">TATC</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tipo</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tamaño</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Estado</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tatcs as $tatc)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $tatc->user->operador->nombre_operador ?? 'Sin operador' }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tatc->numero_contenedor }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tatc->created_at->format('d/m/Y H:i:s') }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tatc->ingreso_pais ? \Carbon\Carbon::parse($tatc->ingreso_pais)->format('d/m/Y H:i') : '-' }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ ucfirst($tatc->tipo_ingreso) }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tatc->aduana_ingreso }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tatc->numero_tatc }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tatc->tipo_contenedor }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tatc->tamano_contenedor }} Pies</p>
                                                    </td>
                                                    <td>
                                                        @if($tatc->estado == 'Pendiente')
                                                            <span class="badge badge-sm bg-warning">Pendiente</span>
                                                        @elseif($tatc->estado == 'Aprobado')
                                                            <span class="badge badge-sm bg-success">Aprobado</span>
                                                        @elseif($tatc->estado == 'Rechazado')
                                                            <span class="badge badge-sm bg-danger">Rechazado</span>
                                                        @else
                                                            <span class="badge badge-sm bg-secondary">{{ $tatc->estado }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('tatc.show', $tatc) }}" class="btn btn-info btn-sm" title="Ver Registro">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('tatc.edit', $tatc) }}" class="btn btn-warning btn-sm" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-primary btn-sm" title="Imprimir TATC" onclick="imprimirTatc({{ $tatc->id }})">
                                                                <i class="fas fa-print"></i>
                                                            </button>
                                                            <form action="{{ route('tatc.destroy', $tatc) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este TATC?')">
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
                                
                                <!-- Paginación -->
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $tatcs->appends(request()->query())->links() }}
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No se encontraron TATCs</h5>
                                    <p class="text-muted">Intente con otros criterios de búsqueda</p>
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
function limpiarFiltros() {
    document.getElementById('buscar').value = '';
    document.getElementById('mostrar').value = '10';
    document.getElementById('formList').submit();
}

function imprimirTatc(tatcId) {
    // Abrir ventana de impresión del TATC
    window.open(`/tatc/${tatcId}/pdf`, '_blank');
}

// Actualizar búsqueda si el usuario cambia la cantidad de paginado
document.getElementById('mostrar').addEventListener('change', function() {
    document.getElementById('formList').submit();
});
</script>
