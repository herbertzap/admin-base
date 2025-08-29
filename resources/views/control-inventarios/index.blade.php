<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='control-inventarios'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Control de Inventarios"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">
                                    <i class="fas fa-boxes"></i> Control de Inventario
                                </h6>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <!-- Resumen de Contenedores -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="card bg-gradient-info">
                                        <div class="card-body text-center">
                                            <h4 class="text-white mb-0">{{ $totalContenedores }}</h4>
                                            <p class="text-white mb-0">Contenedores Vigentes en Stock</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-gradient-success">
                                        <div class="card-body text-center">
                                            <h4 class="text-white mb-0">{{ $tatcs->total() }}</h4>
                                            <p class="text-white mb-0">TATCs Vigentes</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-gradient-warning">
                                        <div class="card-body text-center">
                                            <h4 class="text-white mb-0">0</h4>
                                            <p class="text-white mb-0">TSTCs Vigentes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Filtros -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0"><i class="fas fa-filter"></i> Filtros de Búsqueda</h6>
                                        </div>
                                        <div class="card-body">
                                            <form method="GET" action="{{ route('control-inventarios.index') }}">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="aduana" class="form-label">Aduana</label>
                                                        <select name="aduana" id="aduana" class="form-select">
                                                            <option value="">Todas las aduanas</option>
                                                            @foreach($aduanas as $aduana)
                                                                <option value="{{ $aduana->codigo }}" {{ $request->aduana == $aduana->codigo ? 'selected' : '' }}>
                                                                    {{ $aduana->codigo }} - {{ $aduana->nombre_aduana }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="operador" class="form-label">Operador</label>
                                                        <select name="operador" id="operador" class="form-select">
                                                            <option value="">Todos los operadores</option>
                                                            @foreach($operadores as $operador)
                                                                <option value="{{ $operador->id }}" {{ $request->operador == $operador->id ? 'selected' : '' }}>
                                                                    {{ $operador->codigo_operador }} - {{ $operador->nombre_operador }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="tipo_contenedor" class="form-label">Tipo Contenedor</label>
                                                        <select name="tipo_contenedor" id="tipo_contenedor" class="form-select">
                                                            <option value="">Todos</option>
                                                            <option value="HC" {{ $request->tipo_contenedor == 'HC' ? 'selected' : '' }}>HC</option>
                                                            <option value="GP" {{ $request->tipo_contenedor == 'GP' ? 'selected' : '' }}>GP</option>
                                                            <option value="RF" {{ $request->tipo_contenedor == 'RF' ? 'selected' : '' }}>RF</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="estado_contenedor" class="form-label">Estado</label>
                                                        <select name="estado_contenedor" id="estado_contenedor" class="form-select">
                                                            <option value="">Todos</option>
                                                            <option value="[OP] Operativo" {{ $request->estado_contenedor == '[OP] Operativo' ? 'selected' : '' }}>Operativo</option>
                                                            <option value="[DM] Dañado" {{ $request->estado_contenedor == '[DM] Dañado' ? 'selected' : '' }}>Dañado</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="buscar" class="form-label">Buscar</label>
                                                        <input type="text" name="buscar" id="buscar" class="form-control" 
                                                               value="{{ $request->buscar }}" placeholder="Contenedor o TATC/TSTC">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-search"></i> Buscar
                                                        </button>
                                                        <a href="{{ route('control-inventarios.index') }}" class="btn btn-secondary">
                                                            <i class="fas fa-times"></i> Limpiar
                                                        </a>
                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportModal">
                                                            <i class="fas fa-download"></i> Exportar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de Contenedores -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-list"></i> Contenedores Vigentes en Stock</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <i class="fas fa-sort"></i> Contenedor
                                                    </th>
                                                    <th>
                                                        <i class="fas fa-sort"></i> Tipo / Tamaño
                                                    </th>
                                                    <th>
                                                        <i class="fas fa-sort"></i> Tipo
                                                    </th>
                                                    <th>
                                                        <i class="fas fa-sort"></i> TATC / TSTC
                                                    </th>
                                                    <th>
                                                        <i class="fas fa-sort"></i> Fecha Emisión
                                                    </th>
                                                    <th>
                                                        <i class="fas fa-sort"></i> Valor CIF
                                                    </th>
                                                    <th>
                                                        <i class="fas fa-sort"></i> Ubicación Física
                                                    </th>
                                                    <th>
                                                        <i class="fas fa-sort"></i> Estado Contenedor
                                                    </th>
                                                    <th>Ver</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($tatcs as $tatc)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $tatc->numero_contenedor }}</strong>
                                                        </td>
                                                        <td>
                                                            {{ $tatc->tipo_contenedor }} / {{ $tatc->tamano_contenedor ?? 'N/A' }}
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-sm bg-gradient-info">TATC</span>
                                                        </td>
                                                        <td>
                                                            <strong>{{ $tatc->numero_tatc }}</strong>
                                                        </td>
                                                        <td>
                                                            {{ $tatc->created_at ? $tatc->created_at->format('d/m/Y') : 'N/A' }}
                                                        </td>
                                                        <td>
                                                            {{ $tatc->valor_cif ? '$' . number_format($tatc->valor_cif, 2) : 'N/A' }}
                                                        </td>
                                                        <td>
                                                            {{ $tatc->ubicacion_fisica ?? 'N/A' }}
                                                        </td>
                                                        <td>
                                                            @if($tatc->estado_contenedor == '[OP] Operativo')
                                                                <span class="badge badge-sm bg-gradient-success">Operativo</span>
                                                            @elseif($tatc->estado_contenedor == '[DM] Dañado')
                                                                <span class="badge badge-sm bg-gradient-danger">Dañado</span>
                                                            @else
                                                                <span class="badge badge-sm bg-gradient-secondary">{{ $tatc->estado_contenedor ?? 'N/A' }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('tatc.show', $tatc->id) }}" class="btn btn-sm btn-info">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <!-- No hay TATCs -->
                                                @endforelse


                                            </tbody>
                                        </table>
                                    </div>

                                    @if($tatcs->total() == 0)
                                        <div class="text-center py-4">
                                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No hay resultados para la búsqueda realizada.</h5>
                                            <p class="text-muted small">Se muestran los TATC/TSTC vigentes que no tienen salidas registradas.</p>
                                        </div>
                                    @endif

                                    <!-- Paginación -->
                                    @if($tatcs->hasPages())
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $tatcs->appends($request->query())->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de Exportación -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">
                        <i class="fas fa-download"></i> Exportar Inventario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('control-inventarios.exportar') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Documento</label>
                            <select name="tipo" id="tipo" class="form-select" required>
                                <option value="todos">Todos (TATC + TSTC)</option>
                                <option value="tatc">Solo TATC</option>
                                <option value="tstc">Solo TSTC</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="formato" class="form-label">Formato de Exportación</label>
                            <select name="formato" id="formato" class="form-select" required>
                                <option value="excel">Excel (.xlsx)</option>
                                <option value="csv">CSV (.csv)</option>
                                <option value="pdf">PDF (.pdf)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-footers.auth></x-footers.auth>
</main>
</x-layout>

<script>
    // Auto-submit form when filters change
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelects = document.querySelectorAll('select[name="aduana"], select[name="operador"], select[name="tipo_contenedor"], select[name="estado_contenedor"]');
        
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    });
</script>
