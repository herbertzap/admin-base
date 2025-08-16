<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='tipos-contenedores'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Tipos de Contenedores"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>Tipos de Contenedores</h6>
                                <a href="{{ route('tipo-contenedors.create') }}" class="btn btn-primary btn-sm">Nuevo Tipo</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Code</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Operador</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tipos as $tipo)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $tipo->codigo }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $tipo->descripcion }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if($tipo->operador)
                                                    <span class="badge badge-sm bg-gradient-info">{{ $tipo->operador->codigo }} | {{ $tipo->operador->nombre_operador }}</span>
                                                @else
                                                    <span class="text-muted">Sin operador</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                @if($tipo->estado == 'Activo')
                                                    <span class="badge badge-sm bg-gradient-success">Activo</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-secondary">Inactivo</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('tipo-contenedors.edit', $tipo) }}" class="btn btn-link text-secondary px-3 mb-0">
                                                        <i class="fas fa-pencil-alt text-xs me-2"></i>Editar
                                                    </a>
                                                    <form action="{{ route('tipo-contenedors.destroy', $tipo) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este tipo de contenedor?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger px-3 mb-0">
                                                            <i class="fas fa-trash text-xs me-2"></i>Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($tipos->hasPages())
                                <div class="card-footer">
                                    {{ $tipos->links() }}
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