<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='logistica'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Ingreso de Contenedor (Logística)"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Ingreso de Contenedor (Logística)</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('logistica.store') }}" method="POST">
                                @csrf
                                
                                <!-- Tabs -->
                                <ul class="nav nav-tabs" id="contenedorTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="datos-tab" data-bs-toggle="tab" data-bs-target="#datos" type="button" role="tab" aria-controls="datos" aria-selected="true">Datos Contenedor</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="facturacion-tab" data-bs-toggle="tab" data-bs-target="#facturacion" type="button" role="tab" aria-controls="facturacion" aria-selected="false">Facturación</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="transporte-tab" data-bs-toggle="tab" data-bs-target="#transporte" type="button" role="tab" aria-controls="transporte" aria-selected="false">Transporte</button>
                                    </li>
                                </ul>
                                
                                <div class="tab-content mt-3" id="contenedorTabContent">
                                    <!-- Tab Datos Contenedor -->
                                    <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Operador</label>
                                                <input type="text" class="form-control bg-light" value="{{ $userOperador ? $userOperador->codigo . ' | ' . $userOperador->rut_operador . ' | ' . $userOperador->nombre_operador : 'Sin operador asignado' }}" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Fecha de Ingreso *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    <input type="date" name="fecha_ingreso" class="form-control bg-white text-dark border @error('fecha_ingreso') is-invalid @enderror" value="{{ old('fecha_ingreso', date('Y-m-d')) }}" required>
                                                </div>
                                                @error('fecha_ingreso')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nº Contenedor *</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                    <input type="text" name="numero_contenedor" id="numero_contenedor" class="form-control bg-white text-dark border @error('numero_contenedor') is-invalid @enderror" value="{{ old('numero_contenedor') }}" placeholder="Número de Contenedor" maxlength="12" minlength="12" required>
                                                </div>
                                                @error('numero_contenedor')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Asociar a TATC</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                                    <input type="text" name="tatc" id="tatc" class="form-control bg-white text-dark border @error('tatc') is-invalid @enderror" value="{{ old('tatc') }}" placeholder="Ingrese TATC existente" maxlength="12" minlength="12">
                                                </div>
                                                @error('tatc')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tipo de Contenedor *</label>
                                                <select name="tipo_contenedor_id" class="form-control bg-white text-dark border @error('tipo_contenedor_id') is-invalid @enderror" required>
                                                    <option value="">Seleccionar tipo</option>
                                                    @foreach($tiposContenedores as $tipo)
                                                        <option value="{{ $tipo->id }}" {{ old('tipo_contenedor_id') == $tipo->id ? 'selected' : '' }}>
                                                            {{ $tipo->descripcion }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('tipo_contenedor_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Lugar de Deposito (Stock) *</label>
                                                <select name="lugardeposito_id" class="form-control bg-white text-dark border @error('lugardeposito_id') is-invalid @enderror" required>
                                                    <option value="">Seleccionar lugar</option>
                                                    @foreach($lugaresDeposito as $lugar)
                                                        <option value="{{ $lugar->id }}" {{ old('lugardeposito_id') == $lugar->id ? 'selected' : '' }}>
                                                            {{ $lugar->nombre_deposito }} ({{ $lugar->direccion }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('lugardeposito_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tamaño Contenedor *</label>
                                                <div class="form-check">
                                                    <input type="radio" name="tamano_contenedor" value="20" class="form-check-input" {{ old('tamano_contenedor', '20') == '20' ? 'checked' : '' }} required>
                                                    <label class="form-check-label">20 Pies</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" name="tamano_contenedor" value="40" class="form-check-input" {{ old('tamano_contenedor') == '40' ? 'checked' : '' }}>
                                                    <label class="form-check-label">40 Pies</label>
                                                </div>
                                                @error('tamano_contenedor')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Estado del Contenedor *</label>
                                                <select name="estado_contenedor" class="form-control bg-white text-dark border @error('estado_contenedor') is-invalid @enderror" required>
                                                    <option value="">Seleccione un estado</option>
                                                    @foreach($estadosContenedor as $estado)
                                                        <option value="{{ $estado }}" {{ old('estado_contenedor') == $estado ? 'selected' : '' }}>
                                                            {{ $estado }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('estado_contenedor')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Documento de Ingreso</label>
                                                <input type="text" name="ingreso_doc" class="form-control bg-white text-dark border @error('ingreso_doc') is-invalid @enderror" value="{{ old('ingreso_doc') }}" placeholder="Documento de Ingreso" maxlength="255">
                                                @error('ingreso_doc')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tara Contenedor</label>
                                                <input type="text" name="tara_contenedor" id="tara_contenedor" class="form-control bg-white text-dark border @error('tara_contenedor') is-invalid @enderror" value="{{ old('tara_contenedor') }}" placeholder="Ingrese del Contenedor" maxlength="4">
                                                @error('tara_contenedor')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">País</label>
                                                <select name="pais_id" class="form-control bg-white text-dark border @error('pais_id') is-invalid @enderror">
                                                    <option value="">Seleccionar país</option>
                                                    <option value="46" {{ old('pais_id') == '46' ? 'selected' : '' }}>Chile</option>
                                                    <!-- Agregar más países según necesidad -->
                                                </select>
                                                @error('pais_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Año Fabricación</label>
                                                <input type="text" name="anofab_contenedor" id="anofab_contenedor" class="form-control bg-white text-dark border @error('anofab_contenedor') is-invalid @enderror" value="{{ old('anofab_contenedor') }}" placeholder="Ingrese año fabricación" maxlength="4">
                                                @error('anofab_contenedor')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Aduana de Ingreso</label>
                                                <select name="aduana_ingreso_id" class="form-control bg-white text-dark border @error('aduana_ingreso_id') is-invalid @enderror">
                                                    <option value="">Sin especificar</option>
                                                    @foreach($aduanasChile as $aduana)
                                                        <option value="{{ $aduana->id }}" {{ old('aduana_ingreso_id') == $aduana->id ? 'selected' : '' }}>
                                                            {{ $aduana->nombre_aduana }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('aduana_ingreso_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Comentario</label>
                                                <textarea name="comentario" class="form-control bg-white text-dark border @error('comentario') is-invalid @enderror" rows="3" placeholder="Ingrese comentarios">{{ old('comentario') }}</textarea>
                                                @error('comentario')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tab Facturación -->
                                    <div class="tab-pane fade" id="facturacion" role="tabpanel" aria-labelledby="facturacion-tab">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">RUT Factura</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                    <input type="text" name="rut_factura" id="rut_factura" class="form-control bg-white text-dark border @error('rut_factura') is-invalid @enderror" value="{{ old('rut_factura') }}" placeholder="Ingrese Rut Factura">
                                                </div>
                                                @error('rut_factura')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nombre Factura</label>
                                                <input type="text" name="nombre_factura" class="form-control bg-white text-dark border @error('nombre_factura') is-invalid @enderror" value="{{ old('nombre_factura') }}" placeholder="Ingrese Nombre de la Factura">
                                                @error('nombre_factura')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Dirección Factura</label>
                                                <input type="text" name="direccion_factura" class="form-control bg-white text-dark border @error('direccion_factura') is-invalid @enderror" value="{{ old('direccion_factura') }}" placeholder="Ingrese Dirección Factura">
                                                @error('direccion_factura')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Giro Factura</label>
                                                <input type="text" name="giro_factura" class="form-control bg-white text-dark border @error('giro_factura') is-invalid @enderror" value="{{ old('giro_factura') }}" placeholder="Ingrese Giro Factura">
                                                @error('giro_factura')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Fecha Factura</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                    <input type="date" name="fecha_factura" class="form-control bg-white text-dark border @error('fecha_factura') is-invalid @enderror" value="{{ old('fecha_factura') }}">
                                                </div>
                                                @error('fecha_factura')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Reserva Nombre</label>
                                                <input type="text" name="reserva_nombre" class="form-control bg-white text-dark border @error('reserva_nombre') is-invalid @enderror" value="{{ old('reserva_nombre') }}" placeholder="Ingrese Nombre de la reserva">
                                                @error('reserva_nombre')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Orden de Compra</label>
                                                <input type="text" name="orden_compra" class="form-control bg-white text-dark border @error('orden_compra') is-invalid @enderror" value="{{ old('orden_compra') }}" placeholder="Ingrese Orden de Compra">
                                                @error('orden_compra')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tipo de Pago</label>
                                                <input type="text" name="tipo_pago" class="form-control bg-white text-dark border @error('tipo_pago') is-invalid @enderror" value="{{ old('tipo_pago') }}" placeholder="Ingrese Tipo de Pago">
                                                @error('tipo_pago')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Valor Factura</label>
                                                <input type="number" name="valor_factura" class="form-control bg-white text-dark border @error('valor_factura') is-invalid @enderror" value="{{ old('valor_factura') }}" placeholder="Ingrese Valor en Pesos" min="0">
                                                @error('valor_factura')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Comentario</label>
                                                <textarea name="comentario_facturacion" class="form-control bg-white text-dark border @error('comentario_facturacion') is-invalid @enderror" rows="3" placeholder="Ingrese comentarios de la facturación">{{ old('comentario_facturacion') }}</textarea>
                                                @error('comentario_facturacion')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tab Transporte -->
                                    <div class="tab-pane fade" id="transporte" role="tabpanel" aria-labelledby="transporte-tab">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Empresa Transportista</label>
                                                <select name="empresa_transportista_id" class="form-control bg-white text-dark border @error('empresa_transportista_id') is-invalid @enderror">
                                                    <option value="">--</option>
                                                    @foreach($empresasTransportistas as $empresa)
                                                        <option value="{{ $empresa->id }}" {{ old('empresa_transportista_id') == $empresa->id ? 'selected' : '' }}>
                                                            {{ $empresa->nombre_empresa }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('empresa_transportista_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Rut del Chofer</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                    <input type="text" name="rut_chofer" id="rut_chofer" class="form-control bg-white text-dark border @error('rut_chofer') is-invalid @enderror" value="{{ old('rut_chofer') }}" placeholder="Rut del Chofer">
                                                </div>
                                                @error('rut_chofer')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Patente Camión</label>
                                                <input type="text" name="patente_camion" id="patente_camion" class="form-control bg-white text-dark border @error('patente_camion') is-invalid @enderror" value="{{ old('patente_camion') }}" placeholder="Ingrese Patente del Camión">
                                                @error('patente_camion')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Documento de Transporte</label>
                                                <input type="text" name="documento_transporte" class="form-control bg-white text-dark border @error('documento_transporte') is-invalid @enderror" value="{{ old('documento_transporte') }}" placeholder="Ingrese Documento de Transporte">
                                                @error('documento_transporte')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Estado del Contenedor -->
                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-success">Estado del Contenedor</label>
                                        <select name="estado" class="form-control bg-white text-dark border @error('estado') is-invalid @enderror" required>
                                            <option value="">Seleccionar estado</option>
                                            <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Disponible en Stock</option>
                                            <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Vendido</option>
                                        </select>
                                        @error('estado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check"></i> Agregar
                                        </button>
                                        <a href="{{ route('logistica.index') }}" class="btn btn-secondary">Cancelar</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout>

@push('js')
<script src="{{ asset('js/contenedor-validations.js') }}"></script>
@endpush 