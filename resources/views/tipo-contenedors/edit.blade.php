<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='tipos-contenedores'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Editar Tipo de Contenedor"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Tipos de Contenedores</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tipo-contenedors.update', $tipoContenedor) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <!-- Tabs -->
                                <ul class="nav nav-tabs" id="tipoContenedorTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="datos-tab" data-bs-toggle="tab" data-bs-target="#datos" type="button" role="tab" aria-controls="datos" aria-selected="true">Actualizar Tipo de Contenedor</button>
                                    </li>
                                </ul>
                                
                                <div class="tab-content mt-3" id="tipoContenedorTabContent">
                                    <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Operador</label>
                                                <select name="operador_id" class="form-control bg-white text-dark border @error('operador_id') is-invalid @enderror" {{ Auth::user()->hasOperador() ? 'disabled' : '' }}>
                                                    <option value="">Sin operador asignado</option>
                                                    @foreach($operadores as $operador)
                                                        <option value="{{ $operador->id }}" {{ old('operador_id', $tipoContenedor->operador_id) == $operador->id ? 'selected' : '' }}>
                                                            {{ $operador->codigo }} | {{ $operador->nombre_operador }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('operador_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if(Auth::user()->hasOperador())
                                                    <small class="form-text text-muted">Operador asignado automáticamente</small>
                                                @endif
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Code *</label>
                                                <input type="text" name="codigo" class="form-control bg-white text-dark border @error('codigo') is-invalid @enderror" value="{{ old('codigo', $tipoContenedor->codigo) }}" required>
                                                @error('codigo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nombre *</label>
                                                <input type="text" name="descripcion" class="form-control bg-white text-dark border @error('descripcion') is-invalid @enderror" value="{{ old('descripcion', $tipoContenedor->descripcion) }}" required>
                                                @error('descripcion')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Estado *</label>
                                                <select name="estado" class="form-control bg-white text-dark border @error('estado') is-invalid @enderror" required>
                                                    <option value="">Seleccionar estado</option>
                                                    <option value="Activo" {{ old('estado', $tipoContenedor->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                                    <option value="Inactivo" {{ old('estado', $tipoContenedor->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                                </select>
                                                @error('estado')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <!-- Información del sistema -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Creado / Actualizado</label>
                                                <input type="text" class="form-control bg-light" value="{{ $tipoContenedor->updated_at ? $tipoContenedor->updated_at->format('d/m/Y H:i:s') : 'N/A' }}" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Usuario</label>
                                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->name }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Modificar</button>
                                        <a href="{{ route('tipo-contenedors.index') }}" class="btn btn-secondary">Cancelar</a>
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