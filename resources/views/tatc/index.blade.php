<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='tatc'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Gestión de TATC"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Listado de TATCs</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('tatc.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Nuevo TATC
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show mx-3" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if($tatcs->count() > 0)
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Número TATC</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Contenedor</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aduana</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Estado</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Usuario</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fecha</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tatcs as $tatc)
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
                                                        <p class="text-xs text-secondary mb-0">{{ $tatc->tipo_contenedor }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tatc->aduana_ingreso }}</p>
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
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tatc->user->name }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tatc->created_at->format('d/m/Y') }}</p>
                                                        <p class="text-xs text-secondary mb-0">{{ $tatc->created_at->format('H:i') }}</p>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('tatc.show', $tatc) }}" class="btn btn-info btn-sm" title="Ver Registro">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('tatc.edit', $tatc) }}" class="btn btn-warning btn-sm" title="Editar">
                                                                <i class="fa-solid fa-edit"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-primary btn-sm" title="Imprimir TATC" onclick="imprimirTatc({{ $tatc->id }})">
                                                                <i class="fa-solid fa-print"></i>
                                                            </button>
                                                            <form action="{{ route('tatc.destroy', $tatc) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este TATC?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                                    <i class="fa-solid fa-trash"></i>
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
                                    {{ $tatcs->links() }}
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No hay TATCs registrados</h5>
                                    <p class="text-muted">Comience creando su primer TATC</p>
                                    <a href="{{ route('tatc.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Crear TATC
                                    </a>
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
function imprimirTatc(tatcId) {
    // Abrir ventana de impresión del TATC
    window.open(`/tatc/${tatcId}/pdf`, '_blank');
}

// Configurar tooltips
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
