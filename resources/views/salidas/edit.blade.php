<x-layout>
    <x-navbars.sidebar activePage="salidas"></x-navbars.sidebar>
    
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Editar Salida"></x-navbars.navs.auth>
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>Editar Salida</h6>
                                <a href="{{ route('salidas.show', $salida) }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($salida->estado === 'Aprobado')
                                <div class="alert alert-warning" role="alert">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Advertencia:</strong> Esta salida ya está aprobada y no puede ser editada.
                                    <br>
                                    <small>Las salidas aprobadas mantienen la integridad de los datos del sistema.</small>
                                </div>
                                
                                <div class="text-center py-4">
                                    <a href="{{ route('salidas.show', $salida) }}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i> Ver Detalle de Salida
                                    </a>
                                    <a href="{{ route('salidas.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-list"></i> Lista de Salidas
                                    </a>
                                </div>
                            @else
                                <form action="{{ route('salidas.update', $salida) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-primary mb-3">Información General</h6>
                                            
                                            <div class="form-group">
                                                <label for="numero_salida" class="form-control-label">Número de Salida</label>
                                                <input type="text" class="form-control" id="numero_salida" name="numero_salida" value="{{ $salida->numero_salida }}" readonly>
                                                <small class="form-text text-muted">Este campo no se puede modificar</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="fecha_salida" class="form-control-label">Fecha de Salida *</label>
                                                <input type="date" class="form-control @error('fecha_salida') is-invalid @enderror" id="fecha_salida" name="fecha_salida" value="{{ $salida->fecha_salida ? \Carbon\Carbon::parse($salida->fecha_salida)->format('Y-m-d') : '' }}" required>
                                                @error('fecha_salida')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="tipo_salida" class="form-control-label">Tipo de Salida *</label>
                                                <select class="form-control @error('tipo_salida') is-invalid @enderror" id="tipo_salida" name="tipo_salida" required>
                                                    <option value="">Seleccione un tipo</option>
                                                    <option value="Declaración de Internación" {{ $salida->tipo_salida === 'Declaración de Internación' ? 'selected' : '' }}>Declaración de Internación</option>
                                                    <option value="Traspaso" {{ $salida->tipo_salida === 'Traspaso' ? 'selected' : '' }}>Traspaso</option>
                                                    <option value="Exportación" {{ $salida->tipo_salida === 'Exportación' ? 'selected' : '' }}>Exportación</option>
                                                    <option value="Otro" {{ $salida->tipo_salida === 'Otro' ? 'selected' : '' }}>Otro</option>
                                                </select>
                                                @error('tipo_salida')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="motivo_salida" class="form-control-label">Motivo de Salida</label>
                                                <textarea class="form-control @error('motivo_salida') is-invalid @enderror" id="motivo_salida" name="motivo_salida" rows="3">{{ $salida->motivo_salida }}</textarea>
                                                @error('motivo_salida')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <h6 class="text-primary mb-3">Información del Contenedor</h6>
                                            
                                            <div class="form-group">
                                                <label for="numero_contenedor" class="form-control-label">Número de Contenedor</label>
                                                <input type="text" class="form-control" id="numero_contenedor" value="{{ $salida->numero_contenedor }}" readonly>
                                                <small class="form-text text-muted">Este campo no se puede modificar</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="tipo_contenedor" class="form-control-label">Tipo de Contenedor</label>
                                                <input type="text" class="form-control" id="tipo_contenedor" value="{{ $salida->tipo_contenedor }}" readonly>
                                                <small class="form-text text-muted">Este campo no se puede modificar</small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="estado_contenedor" class="form-control-label">Estado del Contenedor</label>
                                                <select class="form-control @error('estado_contenedor') is-invalid @enderror" id="estado_contenedor" name="estado_contenedor">
                                                    <option value="">Seleccione un estado</option>
                                                    <option value="Bueno" {{ $salida->estado_contenedor === 'Bueno' ? 'selected' : '' }}>Bueno</option>
                                                    <option value="Regular" {{ $salida->estado_contenedor === 'Regular' ? 'selected' : '' }}>Regular</option>
                                                    <option value="Malo" {{ $salida->estado_contenedor === 'Malo' ? 'selected' : '' }}>Malo</option>
                                                </select>
                                                @error('estado_contenedor')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="aduana_salida" class="form-control-label">Aduana de Salida *</label>
                                                <select class="form-control @error('aduana_salida') is-invalid @enderror" id="aduana_salida" name="aduana_salida" required>
                                                    <option value="">Seleccione una aduana</option>
                                                    @foreach($aduanas as $aduana)
                                                        <option value="{{ $aduana->codigo }}" {{ $salida->aduana_salida == $aduana->codigo ? 'selected' : '' }}>
                                                            {{ $aduana->codigo }} - {{ $aduana->nombre_aduana }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('aduana_salida')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr class="my-4">
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-primary mb-3">Información del Transporte</h6>
                                            
                                            <div class="form-group">
                                                <label for="empresa_transportista_id" class="form-control-label">Empresa Transportista</label>
                                                <select class="form-control @error('empresa_transportista_id') is-invalid @enderror" id="empresa_transportista_id" name="empresa_transportista_id">
                                                    <option value="">Seleccione una empresa</option>
                                                    @foreach($empresasTransportistas as $empresa)
                                                        <option value="{{ $empresa->id }}" {{ $salida->empresa_transportista_id == $empresa->id ? 'selected' : '' }}>
                                                            {{ $empresa->nombre_empresa }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('empresa_transportista_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="rut_chofer" class="form-control-label">RUT del Chofer</label>
                                                <input type="text" class="form-control @error('rut_chofer') is-invalid @enderror" id="rut_chofer" name="rut_chofer" value="{{ $salida->rut_chofer }}">
                                                @error('rut_chofer')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="patente_camion" class="form-control-label">Patente del Camión</label>
                                                <input type="text" class="form-control @error('patente_camion') is-invalid @enderror" id="patente_camion" name="patente_camion" value="{{ $salida->patente_camion }}">
                                                @error('patente_camion')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <h6 class="text-primary mb-3">Información del Destino</h6>
                                            
                                            <div class="form-group">
                                                <label for="destino_final" class="form-control-label">Destino Final</label>
                                                <input type="text" class="form-control @error('destino_final') is-invalid @enderror" id="destino_final" name="destino_final" value="{{ $salida->destino_final }}">
                                                @error('destino_final')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="pais_destino" class="form-control-label">País de Destino</label>
                                                <input type="text" class="form-control @error('pais_destino') is-invalid @enderror" id="pais_destino" name="pais_destino" value="{{ $salida->pais_destino }}">
                                                @error('pais_destino')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="observaciones" class="form-control-label">Observaciones</label>
                                                <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones" rows="3">{{ $salida->observaciones }}</textarea>
                                                @error('observaciones')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr class="my-4">
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="text-primary mb-3">Información Adicional</h6>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="declaracion_internacion" class="form-control-label">Declaración de Internación</label>
                                                        <input type="text" class="form-control @error('declaracion_internacion') is-invalid @enderror" id="declaracion_internacion" name="declaracion_internacion" value="{{ $salida->declaracion_internacion }}">
                                                        @error('declaracion_internacion')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="tatc_destino" class="form-control-label">TATC Destino</label>
                                                        <input type="text" class="form-control @error('tatc_destino') is-invalid @enderror" id="tatc_destino" name="tatc_destino" value="{{ $salida->tatc_destino }}">
                                                        @error('tatc_destino')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="comentario_internacion" class="form-control-label">Comentario de Internación</label>
                                                        <textarea class="form-control @error('comentario_internacion') is-invalid @enderror" id="comentario_internacion" name="comentario_internacion" rows="3">{{ $salida->comentario_internacion }}</textarea>
                                                        @error('comentario_internacion')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="operador_destino" class="form-control-label">Operador Destino</label>
                                                        <input type="text" class="form-control @error('operador_destino') is-invalid @enderror" id="operador_destino" name="operador_destino" value="{{ $salida->operador_destino }}">
                                                        @error('operador_destino')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-4">
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Actualizar Salida
                                            </button>
                                            <a href="{{ route('salidas.show', $salida) }}" class="btn btn-secondary">
                                                <i class="fas fa-times"></i> Cancelar
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
