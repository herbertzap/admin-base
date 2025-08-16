<x-layout>
    <x-navbars.sidebar activePage="inventario"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Inventario y Stock"></x-navbars.navs.auth>
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Inventario y Stock - {{ Auth::user()->operador ? Auth::user()->operador->nombre_operador : 'Sin operador asignado' }}</h6>
                        </div>
                        <div class="card-body">
                            <!-- Filtros -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Parámetros de Filtro</h6>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Lugar de Depósito (Stock)</label>
                                    <select name="lugar_deposito" class="form-control bg-white text-dark border">
                                        <option value="">Todos</option>
                                        @foreach($lugaresDeposito as $lugar)
                                            <option value="{{ $lugar->id }}">{{ $lugar->nombre_deposito }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Filtrar Por</label>
                                    <div class="form-check">
                                        <input type="radio" name="filtro_fecha" value="fecha_ingreso" class="form-check-input" checked>
                                        <label class="form-check-label">Fecha Ingreso Contenedor</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="filtro_fecha" value="fecha_factura" class="form-check-input">
                                        <label class="form-check-label">Por Fecha de Factura</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Número de Contenedor</label>
                                    <input type="text" name="numero_contenedor" class="form-control bg-white text-dark border" placeholder="Número de Contenedor">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Estado Contenedor</label>
                                    <select name="estado_contenedor" class="form-control bg-white text-dark border">
                                        <option value="">Todos</option>
                                        @foreach($estadosContenedor as $estado)
                                            <option value="{{ $estado }}">{{ $estado }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">País Contenedor</label>
                                    <select name="pais_id" class="form-control bg-white text-dark border">
                                        <option value="">Todos</option>
                                        <option value="CL">Chile</option>
                                        <option value="US">Estados Unidos</option>
                                        <option value="CN">China</option>
                                        <option value="DE">Alemania</option>
                                        <option value="JP">Japón</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Selección de Fechas</label>
                                    <input type="text" name="rango_fechas" class="form-control bg-white text-dark border" placeholder="01/01/1982 - 12/08/2025">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">RUT Factura (Cliente)</label>
                                    <input type="text" name="rut_cliente" class="form-control bg-white text-dark border" placeholder="Rut del Cliente">
                                </div>
                                
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary" onclick="filtrarInventario()">
                                        <i class="fas fa-search"></i> Filtrar
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="limpiarFiltros()">
                                        <i class="fas fa-times"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Resultados -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-flush" id="tablaInventario">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>N° Contenedor</th>
                                                    <th>Tipo</th>
                                                    <th>Estado</th>
                                                    <th>Lugar Depósito</th>
                                                    <th>Fecha Ingreso</th>
                                                    <th>TATC</th>
                                                    <th>Operador</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($contenedores as $contenedor)
                                                    <tr>
                                                        <td>{{ $contenedor->numero_contenedor }}</td>
                                                        <td>{{ $contenedor->tipoContenedor ? $contenedor->tipoContenedor->descripcion : 'N/A' }}</td>
                                                        <td>
                                                            <span class="badge badge-sm bg-gradient-{{ $contenedor->estado_contenedor == 'Disponible en Stock' ? 'success' : ($contenedor->estado_contenedor == 'Vendido' ? 'info' : 'warning') }}">
                                                                {{ $contenedor->estado_contenedor }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $contenedor->lugarDeposito ? $contenedor->lugarDeposito->nombre_deposito : 'N/A' }}</td>
                                                        <td>{{ $contenedor->fecha_ingreso ? $contenedor->fecha_ingreso->format('d/m/Y') : 'N/A' }}</td>
                                                        <td>{{ $contenedor->tatc ?? 'N/A' }}</td>
                                                        <td>{{ $contenedor->operador ? $contenedor->operador->codigo : 'N/A' }}</td>
                                                        <td>
                                                            <a href="{{ route('logistica.edit', $contenedor) }}" class="btn btn-info btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="{{ route('logistica.show', $contenedor) }}" class="btn btn-primary btn-sm">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center">No se encontraron contenedores</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    @if($contenedores->hasPages())
                                        <div class="d-flex justify-content-center">
                                            {{ $contenedores->links() }}
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
    <x-footers.auth></x-footers.auth>
</x-layout>

@push('js')
<script>
function filtrarInventario() {
    // Implementar lógica de filtrado
    console.log('Filtrando inventario...');
}

function limpiarFiltros() {
    // Limpiar todos los campos de filtro
    document.querySelectorAll('input[type="text"], select').forEach(input => {
        input.value = '';
    });
    document.querySelector('input[name="filtro_fecha"][value="fecha_ingreso"]').checked = true;
}
</script>
@endpush 