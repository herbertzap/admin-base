<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='aduanas-chile'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Aduanas de Chile"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Aduanas de Chile</h6>
                            <a href="{{ route('aduana-chiles.create') }}" class="btn btn-primary btn-sm float-end">Nueva Aduana</a>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Ubicación</th>
                                            <th>Región</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($aduanas as $aduana)
                                        <tr>
                                            <td>{{ $aduana->codigo }}</td>
                                            <td>{{ $aduana->nombre_aduana }}</td>
                                            <td>{{ $aduana->ubicacion }}</td>
                                            <td>{{ $aduana->region }}</td>
                                            <td>{{ $aduana->telefono }}</td>
                                            <td>{{ $aduana->email }}</td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-{{ $aduana->estado == 'Activo' ? 'success' : 'secondary' }}">
                                                    {{ $aduana->estado }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('aduana-chiles.edit', $aduana) }}" class="btn btn-info btn-sm">Editar</a>
                                                <form action="{{ route('aduana-chiles.destroy', $aduana) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta aduana?')">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $aduanas->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout> 