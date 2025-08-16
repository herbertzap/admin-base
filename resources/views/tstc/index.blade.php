<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='actualizar-tstc'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Gestión de TSTC"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Listado de TSTCs</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('tstc.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Nuevo TSTC
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

                            @if($tstcs->count() > 0)
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Número TSTC</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Contenedor</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aduana</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Estado</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Usuario</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fecha</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tstcs as $tstc)
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
                                                        <p class="text-xs text-secondary mb-0">{{ $tstc->tipo_contenedor }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tstc->aduana_salida }}</p>
                                                    </td>
                                                    <td>
                                                        @if($tstc->estado == 'Pendiente')
                                                            <span class="badge badge-sm bg-warning">Pendiente</span>
                                                        @elseif($tstc->estado == 'Aprobado')
                                                            <span class="badge badge-sm bg-success">Aprobado</span>
                                                        @elseif($tstc->estado == 'Rechazado')
                                                            <span class="badge badge-sm bg-danger">Rechazado</span>
                                                        @else
                                                            <span class="badge badge-sm bg-secondary">{{ $tstc->estado }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tstc->user->name }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $tstc->created_at->format('d/m/Y') }}</p>
                                                        <p class="text-xs text-secondary mb-0">{{ $tstc->created_at->format('H:i') }}</p>
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
    function imprimirTstc(tstcId) {
        // Abrir ventana de impresión del TSTC
        window.open(`/tstc/${tstcId}/pdf`, '_blank');
    }
    
    // Configurar tooltips
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
