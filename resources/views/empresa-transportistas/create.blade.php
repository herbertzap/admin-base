<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='empresas-transportistas'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Nueva Empresa Transportista"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Nueva Empresa Transportista</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('empresa-transportistas.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre de la Empresa *</label>
                                        <input type="text" name="nombre_empresa" class="form-control bg-white text-dark border @error('nombre_empresa') is-invalid @enderror" value="{{ old('nombre_empresa') }}" required>
                                        @error('nombre_empresa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">RUT *</label>
                                        <input type="text" name="rut_empresa" class="form-control bg-white text-dark border @error('rut_empresa') is-invalid @enderror" value="{{ old('rut_empresa') }}" required>
                                        @error('rut_empresa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Dirección</label>
                                        <input type="text" name="direccion" class="form-control bg-white text-dark border" value="{{ old('direccion') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ciudad</label>
                                        <input type="text" name="ciudad" class="form-control bg-white text-dark border" value="{{ old('ciudad') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" name="telefono" class="form-control bg-white text-dark border" value="{{ old('telefono') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control bg-white text-dark border" value="{{ old('email') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Persona de Contacto</label>
                                        <input type="text" name="contacto_persona" class="form-control bg-white text-dark border" value="{{ old('contacto_persona') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Teléfono de Contacto</label>
                                        <input type="text" name="contacto_telefono" class="form-control bg-white text-dark border" value="{{ old('contacto_telefono') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email de Contacto</label>
                                        <input type="email" name="contacto_email" class="form-control bg-white text-dark border" value="{{ old('contacto_email') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Estado *</label>
                                        <select name="estado" class="form-control bg-white text-dark border" required>
                                            <option value="Activo" @if(old('estado') == 'Activo') selected @endif>Activo</option>
                                            <option value="Inactivo" @if(old('estado') == 'Inactivo') selected @endif>Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Observaciones</label>
                                        <textarea name="observaciones" class="form-control bg-white text-dark border" rows="3">{{ old('observaciones') }}</textarea>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Crear Empresa</button>
                                    <a href="{{ route('empresa-transportistas.index') }}" class="btn btn-secondary">Cancelar</a>
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