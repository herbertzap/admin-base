<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='operadores'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Nuevo Operador"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Nuevo Operador</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('operadores.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Tabs -->
                                <ul class="nav nav-tabs" id="operadorTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="datos-tab" data-bs-toggle="tab" data-bs-target="#datos" type="button" role="tab" aria-controls="datos" aria-selected="true">Datos Generales</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button" role="tab" aria-controls="email" aria-selected="false">Datos de Emails</button>
                                    </li>
                                </ul>
                                
                                <div class="tab-content mt-3" id="operadorTabContent">
                                    <!-- Tab Datos Generales -->
                                    <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Código *</label>
                                                <input type="text" name="codigo" class="form-control bg-white text-dark border @error('codigo') is-invalid @enderror" value="{{ old('codigo') }}" required>
                                                @error('codigo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Rut Operador *</label>
                                                <input type="text" name="rut_operador" class="form-control bg-white text-dark border @error('rut_operador') is-invalid @enderror" value="{{ old('rut_operador') }}" required>
                                                @error('rut_operador')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Nombre Operador *</label>
                                                <input type="text" name="nombre_operador" class="form-control bg-white text-dark border @error('nombre_operador') is-invalid @enderror" value="{{ old('nombre_operador') }}" required>
                                                @error('nombre_operador')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Nombre de Fantasía</label>
                                                <input type="text" name="nombre_fantasia" class="form-control bg-white text-dark border @error('nombre_fantasia') is-invalid @enderror" value="{{ old('nombre_fantasia') }}">
                                                @error('nombre_fantasia')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Dirección del Operador</label>
                                                <input type="text" name="direccion_operador" class="form-control bg-white text-dark border @error('direccion_operador') is-invalid @enderror" value="{{ old('direccion_operador') }}">
                                                @error('direccion_operador')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Resolución Operador</label>
                                                <input type="text" name="resolucion_operador" class="form-control bg-white text-dark border @error('resolucion_operador') is-invalid @enderror" value="{{ old('resolucion_operador') }}">
                                                @error('resolucion_operador')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <!-- Archivos -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Logo del Operador</label>
                                                <input type="file" name="logo_operador" class="form-control bg-white text-dark border @error('logo_operador') is-invalid @enderror" accept="image/*">
                                                @error('logo_operador')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Formatos: JPG, PNG, GIF. Máximo 2MB</small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Firma y timbre del Operador</label>
                                                <input type="file" name="firma_operador" class="form-control bg-white text-dark border @error('firma_operador') is-invalid @enderror" accept="image/*">
                                                @error('firma_operador')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Formatos: JPG, PNG, GIF. Máximo 2MB</small>
                                            </div>
                                            
                                            <!-- Datos del Representante -->
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Rut Representante</label>
                                                <input type="text" name="rut_representante" class="form-control bg-white text-dark border @error('rut_representante') is-invalid @enderror" value="{{ old('rut_representante') }}">
                                                @error('rut_representante')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Nombre Representante</label>
                                                <input type="text" name="nombre_representante" class="form-control bg-white text-dark border @error('nombre_representante') is-invalid @enderror" value="{{ old('nombre_representante') }}">
                                                @error('nombre_representante')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Cargo del Representante</label>
                                                <input type="text" name="cargo_representante" class="form-control bg-white text-dark border @error('cargo_representante') is-invalid @enderror" value="{{ old('cargo_representante') }}">
                                                @error('cargo_representante')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Estado *</label>
                                                <select name="estado" class="form-control bg-white text-dark border @error('estado') is-invalid @enderror" required>
                                                    <option value="">Seleccionar estado</option>
                                                    <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                                                    <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                                </select>
                                                @error('estado')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tab Datos de Email -->
                                    <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nombre Remitente</label>
                                                <input type="text" name="nombre_remitente" class="form-control bg-white text-dark border @error('nombre_remitente') is-invalid @enderror" value="{{ old('nombre_remitente') }}">
                                                @error('nombre_remitente')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email Remitente</label>
                                                <input type="email" name="email_remitente" class="form-control bg-white text-dark border @error('email_remitente') is-invalid @enderror" value="{{ old('email_remitente') }}">
                                                @error('email_remitente')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email Copia</label>
                                                <input type="email" name="email_copia" class="form-control bg-white text-dark border @error('email_copia') is-invalid @enderror" value="{{ old('email_copia') }}">
                                                @error('email_copia')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email Notificaciones</label>
                                                <input type="email" name="email_notificaciones" class="form-control bg-white text-dark border @error('email_notificaciones') is-invalid @enderror" value="{{ old('email_notificaciones') }}">
                                                @error('email_notificaciones')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" name="valida_ingreso_aduana" class="form-check-input" value="1" {{ old('valida_ingreso_aduana') ? 'checked' : '' }}>
                                                    <label class="form-check-label">Validar ingreso aduana</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">CREAR</button>
                                        <a href="{{ route('operadores.index') }}" class="btn btn-secondary">Cancelar</a>
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