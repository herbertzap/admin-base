<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='registrar-salida'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Registrar Salida"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>TATC/TSTC Vigentes CONTENEDORES DAVI E.I.R.L.</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('salidas.index') }}">Registro de Salidas</a></li>
                                            <li class="breadcrumb-item active">Listado</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Barra de búsqueda y filtros -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <select class="form-control bg-white text-dark border" id="mostrar">
                                        <option value="10">Mostrar 10</option>
                                        <option value="25">Mostrar 25</option>
                                        <option value="50">Mostrar 50</option>
                                        <option value="100">Mostrar 100</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-white text-dark border" id="searchTatc" placeholder="¿Que desea buscar?">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <button class="btn btn-primary" id="btnRegistrarSalida" disabled>
                                        <i class="fa fa-plus"></i> Registrar Salida
                                    </button>
                                </div>
                            </div>

                            <!-- Tabla de TATC/TSTC Vigentes -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="tatcTable">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th width="50">
                                                <input type="checkbox" id="selectAll">
                                            </th>
                                            <th>Contenedor</th>
                                            <th>Fecha Ingreso</th>
                                            <th>Tipo</th>
                                            <th>Ingreso Por</th>
                                            <th>Aduana</th>
                                            <th>TATC/TSTC</th>
                                            <th>Tipo</th>
                                            <th>Tamaño</th>
                                            <th>Creado por</th>
                                            <th width="120">Dar Salida</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tatcsVigentes as $tatc)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="select-tatc" value="{{ $tatc->id }}" data-tatc="{{ $tatc->numero_tatc }}" data-contenedor="{{ $tatc->numero_contenedor }}">
                                            </td>
                                            <td>{{ $tatc->numero_contenedor }}</td>
                                            <td>{{ $tatc->ingreso_pais ? \Carbon\Carbon::parse($tatc->ingreso_pais)->format('d/m/Y') : '-' }}</td>
                                            <td>TATC</td>
                                            <td>{{ $tatc->tipo_ingreso }}</td>
                                            <td>{{ $tatc->aduana_ingreso }}</td>
                                            <td>{{ $tatc->numero_tatc }}</td>
                                            <td>{{ $tatc->tipo_contenedor }}</td>
                                            <td>{{ $tatc->tamano_contenedor }}</td>
                                            <td>{{ $tatc->user->name ?? '-' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('salidas.registrar', $tatc->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-sign-out-alt"></i> Dar Salida
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11" class="text-center">
                                                <div class="alert alert-info">
                                                    <i class="fa fa-info-circle"></i> No hay resultados para la búsqueda realizada.
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            @if($tatcsVigentes->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $tatcsVigentes->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>

    <script>
        var $j = jQuery.noConflict();
        
        $j(document).ready(function() {
            // Búsqueda en tiempo real
            $j('#searchTatc').on('keyup', function() {
                var value = $j(this).val().toLowerCase();
                $j('#tatcTable tbody tr').filter(function() {
                    $j(this).toggle($j(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</x-layout>
