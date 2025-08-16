<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='operadores'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Gestión de Operadores"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Gestión de Operadores</h6>
                            <a href="{{ route('operadores.create') }}" class="btn btn-primary btn-sm float-end">Nuevo Operador</a>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Creación</th>
                                            <th>Vencimiento</th>
                                            <th>Vigencia</th>
                                            <th>Código</th>
                                            <th>Rut</th>
                                            <th>Nombre</th>
                                            <th>Abrev.</th>
                                            <th>Representante</th>
                                            <th>Estado</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($operadores as $operador)
                                        <tr>
                                            <td>{{ $operador->fecha_creacion ? $operador->fecha_creacion->format('d/m/Y') : '' }}</td>
                                            <td>{{ $operador->fecha_actualizacion ? $operador->fecha_actualizacion->format('d/m/Y') : '' }}</td>
                                            <td>--</td>
                                            <td>{{ $operador->codigo }}</td>
                                            <td>{{ $operador->rut_operador }}</td>
                                            <td>{{ $operador->nombre_operador }}</td>
                                            <td>{{ $operador->nombre_fantasia }}</td>
                                            <td>{{ $operador->nombre_representante }}</td>
                                            <td>{{ $operador->estado }}</td>
                                            <td>
                                                <a href="{{ route('operadores.edit', $operador) }}" class="btn btn-info btn-sm">Editar</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout> 