<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='actualizar-salidas'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Actualizar Salidas"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>TATC con Salida / Traspaso CONTENEDORES DAVI E.I.R.L.</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('salidas.create') }}">Registro de Salidas</a></li>
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
                                        <input type="text" class="form-control bg-white text-dark border" id="buscar" placeholder="¿Que desea buscar?">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <a href="{{ route('salidas.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Registrar Salida
                                    </a>
                                </div>
                            </div>

                            <!-- Tabla de Salidas -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nro Contenedor</th>
                                            <th>Tipo Salida</th>
                                            <th>Fecha Salida</th>
                                            <th>DI/Aduana / Oper.</th>
                                            <th>Tipo TATC/TSTC</th>
                                            <th>Tipo Contenedor</th>
                                            <th>Tamaño</th>
                                            <th>Comentario / TATC Destino</th>
                                            <th width="120">Modificar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($salidas as $salida)
                                        <tr>
                                            <td>{{ $salida->tatc->numero_contenedor ?? 'N/A' }}</td>
                                            <td>
                                                @if($salida->tipo_salida === 'internacion')
                                                    Salida por DI
                                                @elseif($salida->tipo_salida === 'cancelacion')
                                                    Salida por Cancelación
                                                @elseif($salida->tipo_salida === 'traspaso')
                                                    Salida por Traspaso
                                                @else
                                                    {{ ucfirst($salida->tipo_salida) }}
                                                @endif
                                            </td>
                                            <td>{{ $salida->fecha_salida ? $salida->fecha_salida->format('d/m/Y') : 'N/A' }}</td>
                                            <td>
                                                @if($salida->tipo_salida === 'internacion')
                                                    {{ $salida->declaracion_internacion ?? 'N/A' }}
                                                @elseif($salida->tipo_salida === 'cancelacion')
                                                    {{ $salida->aduana_ingreso_cancelacion ?? 'N/A' }}
                                                @elseif($salida->tipo_salida === 'traspaso')
                                                    {{ $salida->tatc_destino ?? 'N/A' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>TATC</td>
                                            <td>{{ $salida->tatc->tipo_contenedor ?? 'N/A' }}</td>
                                            <td>{{ $salida->tatc->tamano_contenedor ?? 'N/A' }}</td>
                                            <td>
                                                @if($salida->tipo_salida === 'internacion')
                                                    {{ $salida->comentario_internacion ?? 'N/A' }}
                                                @elseif($salida->tipo_salida === 'cancelacion')
                                                    {{ Str::limit($salida->documento_cancelacion, 50) ?? 'N/A' }}
                                                @elseif($salida->tipo_salida === 'traspaso')
                                                    {{ $salida->operador_destino ?? 'N/A' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('salidas.edit', $salida) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-edit"></i> Modificar
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center">
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
                            @if($salidas->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $salidas->links() }}
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

<!-- JavaScript para búsqueda -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof $j === 'undefined') {
        console.error('ERROR: $j no está disponible');
        return;
    }
    
    // Búsqueda en tiempo real
    $j('#buscar').on('keyup', function() {
        var valor = $j(this).val().toLowerCase();
        $j('tbody tr').each(function() {
            var texto = $j(this).text().toLowerCase();
            $j(this).toggle(texto.indexOf(valor) > -1);
        });
    });
    
    console.log('=== FIN CONFIGURACIÓN SALIDAS INDEX ===');
});
</script>
