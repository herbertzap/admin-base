<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='empresas-transportistas'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Empresas Transportistas"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Empresas Transportistas</h6>
                            <a href="{{ route('empresa-transportistas.create') }}" class="btn btn-primary btn-sm float-end">Nueva Empresa</a>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>RUT</th>
                                            <th>Ciudad</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                            <th>Contacto</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($empresas as $empresa)
                                        <tr>
                                            <td>{{ $empresa->nombre_empresa }}</td>
                                            <td>{{ $empresa->rut_empresa }}</td>
                                            <td>{{ $empresa->ciudad }}</td>
                                            <td>{{ $empresa->telefono }}</td>
                                            <td>{{ $empresa->email }}</td>
                                            <td>{{ $empresa->contacto_persona }}</td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-{{ $empresa->estado == 'Activo' ? 'success' : 'secondary' }}">
                                                    {{ $empresa->estado }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('empresa-transportistas.edit', $empresa) }}" class="btn btn-info btn-sm">Editar</a>
                                                <form action="{{ route('empresa-transportistas.destroy', $empresa) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta empresa?')">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $empresas->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout> 