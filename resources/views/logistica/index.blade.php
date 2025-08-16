<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='logistica'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Gestión Logística"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Gestión de Contenedores</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('logistica.create') }}" class="btn btn-primary btn-sm">
                                        <i class="material-icons">add</i> Ingreso de Contenedor
                                    </a>
                                    <a href="{{ route('inventario') }}" class="btn btn-info btn-sm">
                                        <i class="material-icons">inventory</i> Revisar Inventario
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Contenedor</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tipo</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Operador</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lugar Depósito</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Estado</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fecha Ingreso</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($contenedores as $contenedor)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $contenedor->numero_contenedor }}</h6>
                                                        @if($contenedor->tatc)
                                                            <p class="text-xs text-secondary mb-0">TATC: {{ $contenedor->tatc }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    @if($contenedor->tipoContenedor)
                                                        {{ $contenedor->tipoContenedor->descripcion }}
                                                    @else
                                                        <span class="text-muted">Sin tipo</span>
                                                    @endif
                                                </p>
                                                <p class="text-xs text-secondary mb-0">{{ $contenedor->tamano_contenedor }} Pies</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    @if($contenedor->operador)
                                                        {{ $contenedor->operador->codigo }} | {{ $contenedor->operador->nombre_operador }}
                                                    @else
                                                        <span class="text-muted">Sin operador</span>
                                                    @endif
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    @if($contenedor->lugarDeposito)
                                                        {{ $contenedor->lugarDeposito->nombre_deposito }}
                                                    @else
                                                        <span class="text-muted">Sin depósito</span>
                                                    @endif
                                                </p>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-{{ $contenedor->estado_contenedor == 'OP' ? 'success' : 'danger' }}">
                                                    {{ $contenedor->estado_contenedor == 'OP' ? 'Operativo' : 'Dañado' }}
                                                </span>
                                                <br>
                                                <span class="badge badge-sm bg-gradient-{{ $contenedor->estado == 'Activo' ? 'info' : 'secondary' }}">
                                                    {{ $contenedor->estado == 'Activo' ? 'Disponible' : 'Vendido' }}
                                                </span>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    @if($contenedor->fecha_ingreso)
                                                        {{ $contenedor->fecha_ingreso->format('d/m/Y') }}
                                                    @else
                                                        <span class="text-muted">Sin fecha</span>
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('logistica.show', $contenedor) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Ver">
                                                    <i class="material-icons">visibility</i>
                                                </a>
                                                <a href="{{ route('logistica.edit', $contenedor) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Editar">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <form action="{{ route('logistica.destroy', $contenedor) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('¿Está seguro de eliminar este contenedor?')">
                                                        <i class="material-icons">delete</i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <p class="text-sm text-secondary mb-0">No hay contenedores registrados</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $contenedores->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout> 