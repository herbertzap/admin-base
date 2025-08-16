<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='lugares-deposito'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Lugares de Depósito"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Lugares de Depósito</h6>
                            <a href="{{ route('lugar-depositos.create') }}" class="btn btn-primary btn-sm float-end">Nuevo Lugar</a>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Ciudad</th>
                                            <th>Región</th>
                                            <th>Capacidad</th>
                                            <th>Operador</th>
                                            <th>Teléfono</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lugares as $lugar)
                                        <tr>
                                            <td>{{ $lugar->codigo }}</td>
                                            <td>{{ $lugar->nombre_deposito }}</td>
                                            <td>{{ $lugar->ciudad }}</td>
                                            <td>{{ $lugar->region }}</td>
                                            <td>{{ $lugar->capacidad }}</td>
                                            <td>{{ $lugar->operador ? $lugar->operador->nombre_operador : 'N/A' }}</td>
                                            <td>{{ $lugar->telefono }}</td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-{{ $lugar->estado == 'Activo' ? 'success' : 'secondary' }}">
                                                    {{ $lugar->estado }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('lugar-depositos.edit', $lugar) }}" class="btn btn-info btn-sm">Editar</a>
                                                <form action="{{ route('lugar-depositos.destroy', $lugar) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este lugar de depósito?')">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $lugares->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout> 