<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='actualizar-tstc'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Actualizar TSTC"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Actualizar TSTC #{{ $tstc->numero_tstc }}</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tstc.update', $tstc) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <!-- Tabs -->
                                <ul class="nav nav-tabs" id="tstcTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="nuevo-tab" data-bs-toggle="tab" data-bs-target="#nuevo" type="button" role="tab" aria-controls="nuevo" aria-selected="true">Actualizar TSTC</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="transporte-tab" data-bs-toggle="tab" data-bs-target="#transporte" type="button" role="tab" aria-controls="transporte" aria-selected="false">Transporte</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="historial-tab" data-bs-toggle="tab" data-bs-target="#historial" type="button" role="tab" aria-controls="historial" aria-selected="false">Historial</button>
                                    </li>
                                </ul>
                                
                                <div class="tab-content mt-3" id="tstcTabContent">
                                    <!-- Tab Nuevo TSTC -->
                                    <div class="tab-pane fade show active" id="nuevo" role="tabpanel" aria-labelledby="nuevo-tab">
                                        <div class="row">
                                            <!-- Columna Izquierda -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Operador</label>
                                                    <input type="text" class="form-control bg-light" value="{{ Auth::user()->operador ? Auth::user()->operador->codigo . ' | ' . Auth::user()->operador->nombre_operador : 'Sin operador asignado' }}" readonly>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Tipo de Salida *</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="tipo_salida" id="tipo_salida_traspaso" value="traspaso" {{ old('tipo_salida', $tstc->tipo_salida) == 'traspaso' ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="tipo_salida_traspaso">
                                                            Traspaso
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="tipo_salida" id="tipo_salida_embarque" value="embarque" {{ old('tipo_salida', $tstc->tipo_salida) == 'embarque' ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="tipo_salida_embarque">
                                                            Embarque
                                                        </label>
                                                    </div>
                                                    @error('tipo_salida')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Salida País *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                        <input type="text" name="salida_pais" class="form-control bg-white text-dark border @error('salida_pais') is-invalid @enderror" value="{{ old('salida_pais', $tstc->salida_pais ? \Carbon\Carbon::parse($tstc->salida_pais)->format('d/m/Y H:i') : '') }}" placeholder="dd/mm/yyyy hh:mm" required>
                                                    </div>
                                                    @error('salida_pais')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Nº Contenedor *</label>
                                                    <input type="text" name="numero_contenedor" id="numero_contenedor" class="form-control bg-white text-dark border @error('numero_contenedor') is-invalid @enderror" value="{{ old('numero_contenedor', $tstc->numero_contenedor) }}" required>
                                                    @error('numero_contenedor')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">TSTC Origen</label>
                                                    <input type="text" name="tstc_origen" class="form-control bg-white text-dark border @error('tstc_origen') is-invalid @enderror" value="{{ old('tstc_origen', $tstc->tstc_origen) }}">
                                                    @error('tstc_origen')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Tipo de Contenedor *</label>
                                                    <select name="tipo_contenedor" class="form-control bg-white text-dark border @error('tipo_contenedor') is-invalid @enderror" required>
                                                        <option value="">Seleccionar...</option>
                                                        @foreach($tiposContenedor as $tipo)
                                                            <option value="{{ $tipo->codigo }}" {{ old('tipo_contenedor', $tstc->tipo_contenedor) == $tipo->codigo ? 'selected' : '' }}>
                                                                {{ $tipo->codigo }} - {{ $tipo->descripcion }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('tipo_contenedor')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">TSTC Destino</label>
                                                    <input type="text" name="tstc_destino" class="form-control bg-white text-dark border @error('tstc_destino') is-invalid @enderror" value="{{ old('tstc_destino', $tstc->tstc_destino) }}">
                                                    @error('tstc_destino')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Documento de Salida</label>
                                                    <input type="text" name="documento_salida" class="form-control bg-white text-dark border @error('documento_salida') is-invalid @enderror" value="{{ old('documento_salida', $tstc->documento_salida) }}">
                                                    @error('documento_salida')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Fecha de Traspaso</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                        <input type="text" name="fecha_traspaso" class="form-control bg-white text-dark border @error('fecha_traspaso') is-invalid @enderror" value="{{ old('fecha_traspaso', $tstc->fecha_traspaso ? \Carbon\Carbon::parse($tstc->fecha_traspaso)->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy">
                                                    </div>
                                                    @error('fecha_traspaso')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Tara del Contenedor</label>
                                                    <input type="number" name="tara_contenedor" step="0.01" class="form-control bg-white text-dark border @error('tara_contenedor') is-invalid @enderror" value="{{ old('tara_contenedor', $tstc->tara_contenedor) }}">
                                                    @error('tara_contenedor')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <!-- Columna Derecha -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tipo de Bulto</label>
                                                    <select name="tipo_bulto" class="form-control bg-white text-dark border @error('tipo_bulto') is-invalid @enderror">
                                                        <option value="">Seleccionar...</option>
                                                        <option value="carga_suelta" {{ old('tipo_bulto', $tstc->tipo_bulto) == 'carga_suelta' ? 'selected' : '' }}>Carga Suelta</option>
                                                        <option value="pallet" {{ old('tipo_bulto', $tstc->tipo_bulto) == 'pallet' ? 'selected' : '' }}>Pallet</option>
                                                        <option value="contenedor" {{ old('tipo_bulto', $tstc->tipo_bulto) == 'contenedor' ? 'selected' : '' }}>Contenedor</option>
                                                    </select>
                                                    @error('tipo_bulto')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Valor FOB</label>
                                                    <input type="number" name="valor_fob" step="0.01" class="form-control bg-white text-dark border @error('valor_fob') is-invalid @enderror" value="{{ old('valor_fob', $tstc->valor_fob) }}">
                                                    @error('valor_fob')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Comentario</label>
                                                    <textarea name="comentario" rows="3" class="form-control bg-white text-dark border @error('comentario') is-invalid @enderror">{{ old('comentario', $tstc->comentario) }}</textarea>
                                                    @error('comentario')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Aduana de Salida *</label>
                                                    <select name="aduana_salida" class="form-control bg-white text-dark border @error('aduana_salida') is-invalid @enderror" required>
                                                        <option value="">Seleccionar...</option>
                                                        @foreach($aduanasChile as $aduana)
                                                            <option value="{{ $aduana->codigo }}" {{ old('aduana_salida', $tstc->aduana_salida) == $aduana->codigo ? 'selected' : '' }}>
                                                                {{ $aduana->codigo }} - {{ $aduana->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('aduana_salida')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">EIR</label>
                                                    <input type="text" name="eir" class="form-control bg-white text-dark border @error('eir') is-invalid @enderror" value="{{ old('eir', $tstc->eir) }}">
                                                    @error('eir')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Tamaño del Contenedor</label>
                                                    <select name="tamano_contenedor" class="form-control bg-white text-dark border @error('tamano_contenedor') is-invalid @enderror">
                                                        <option value="">Seleccionar...</option>
                                                        <option value="20" {{ old('tamano_contenedor', $tstc->tamano_contenedor) == '20' ? 'selected' : '' }}>20 pies</option>
                                                        <option value="40" {{ old('tamano_contenedor', $tstc->tamano_contenedor) == '40' ? 'selected' : '' }}>40 pies</option>
                                                        <option value="45" {{ old('tamano_contenedor', $tstc->tamano_contenedor) == '45' ? 'selected' : '' }}>45 pies</option>
                                                    </select>
                                                    @error('tamano_contenedor')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Puerto de Salida</label>
                                                    <input type="text" name="puerto_salida" class="form-control bg-white text-dark border @error('puerto_salida') is-invalid @enderror" value="{{ old('puerto_salida', $tstc->puerto_salida) }}">
                                                    @error('puerto_salida')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Estado del Contenedor</label>
                                                    <select name="estado_contenedor" class="form-control bg-white text-dark border @error('estado_contenedor') is-invalid @enderror">
                                                        <option value="">Seleccionar...</option>
                                                        @foreach($estadosContenedor as $estado)
                                                            <option value="{{ $estado }}" {{ old('estado_contenedor', $tstc->estado_contenedor) == $estado ? 'selected' : '' }}>
                                                                {{ $estado }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('estado_contenedor')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Año de Fabricación</label>
                                                    <input type="number" name="anio_fabricacion" min="1900" max="{{ date('Y') + 1 }}" class="form-control bg-white text-dark border @error('anio_fabricacion') is-invalid @enderror" value="{{ old('anio_fabricacion', $tstc->anio_fabricacion) }}">
                                                    @error('anio_fabricacion')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Ubicación Física</label>
                                                    <select name="ubicacion_fisica" class="form-control bg-white text-dark border @error('ubicacion_fisica') is-invalid @enderror">
                                                        <option value="">Seleccionar...</option>
                                                        @foreach($lugaresDeposito as $lugar)
                                                            <option value="{{ $lugar->codigo }}" {{ old('ubicacion_fisica', $tstc->ubicacion_fisica) == $lugar->codigo ? 'selected' : '' }}>
                                                                {{ $lugar->codigo }} - {{ $lugar->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('ubicacion_fisica')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Valor CIF</label>
                                                    <input type="number" name="valor_cif" step="0.01" class="form-control bg-white text-dark border @error('valor_cif') is-invalid @enderror" value="{{ old('valor_cif', $tstc->valor_cif) }}">
                                                    @error('valor_cif')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tab Transporte -->
                                    <div class="tab-pane fade" id="transporte" role="tabpanel" aria-labelledby="transporte-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Empresa Transportista</label>
                                                    <select name="empresa_transportista_id" class="form-control bg-white text-dark border @error('empresa_transportista_id') is-invalid @enderror">
                                                        <option value="">Seleccionar...</option>
                                                        @foreach($empresasTransportistas as $empresa)
                                                            <option value="{{ $empresa->id }}" {{ old('empresa_transportista_id', $tstc->empresa_transportista_id) == $empresa->id ? 'selected' : '' }}>
                                                                {{ $empresa->nombre_empresa }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('empresa_transportista_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">RUT del Chofer</label>
                                                    <input type="text" name="rut_chofer" class="form-control bg-white text-dark border @error('rut_chofer') is-invalid @enderror" value="{{ old('rut_chofer', $tstc->rut_chofer) }}" placeholder="12.345.678-9">
                                                    @error('rut_chofer')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Patente del Camión</label>
                                                    <input type="text" name="patente_camion" class="form-control bg-white text-dark border @error('patente_camion') is-invalid @enderror" value="{{ old('patente_camion', $tstc->patente_camion) }}" placeholder="ABCD12">
                                                    @error('patente_camion')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Documento de Transporte</label>
                                                    <input type="text" name="documento_transporte" class="form-control bg-white text-dark border @error('documento_transporte') is-invalid @enderror" value="{{ old('documento_transporte', $tstc->documento_transporte) }}">
                                                    @error('documento_transporte')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tab Historial -->
                                    <div class="tab-pane fade" id="historial" role="tabpanel" aria-labelledby="historial-tab">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Usuario</th>
                                                        <th>Acción</th>
                                                        <th>Detalles</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($tstc->historial as $historial)
                                                        <tr>
                                                            <td>{{ $historial->created_at->format('d/m/Y H:i') }}</td>
                                                            <td>{{ $historial->user->name }}</td>
                                                            <td>{{ $historial->accion }}</td>
                                                            <td>{{ $historial->detalles }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center">No hay historial disponible</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-end mt-3">
                                    <a href="{{ route('tstc.index') }}" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Actualizar TSTC</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

@push('js')
<script>
    // Configurar máscaras de entrada
    $j(document).ready(function() {
        // Máscara para RUT
        $j('input[name="rut_chofer"]').inputmask('99.999.999-9');
        
        // Máscara para patente
        $j('input[name="patente_camion"]').inputmask('AAAA99');
        
        // Máscaras para fechas
        $j('input[name="salida_pais"]').inputmask('99/99/9999 99:99');
        $j('input[name="fecha_traspaso"]').inputmask('99/99/9999');
        
        // Calcular CIF automáticamente cuando cambie FOB
        $j('input[name="valor_fob"]').on('input', function() {
            var fob = parseFloat($j(this).val()) || 0;
            var cif = fob * 1.05; // 5% de gastos adicionales
            $j('input[name="valor_cif"]').val(cif.toFixed(2));
        });
    });
</script>
@endpush
