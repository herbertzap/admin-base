<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='aduanas-chile'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Editar Aduana"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Editar Aduana</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('aduana-chiles.update', $aduanaChile) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Código *</label>
                                        <input type="text" name="codigo" class="form-control @error('codigo') is-invalid @enderror" value="{{ old('codigo', $aduanaChile->codigo) }}" required>
                                        @error('codigo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Nombre de la Aduana *</label>
                                        <input type="text" name="nombre_aduana" class="form-control @error('nombre_aduana') is-invalid @enderror" value="{{ old('nombre_aduana', $aduanaChile->nombre_aduana) }}" required>
                                        @error('nombre_aduana')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Ubicación</label>
                                        <input type="text" name="ubicacion" class="form-control" value="{{ old('ubicacion', $aduanaChile->ubicacion) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Región</label>
                                        <input type="text" name="region" class="form-control" value="{{ old('region', $aduanaChile->region) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Dirección</label>
                                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $aduanaChile->direccion) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Teléfono</label>
                                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $aduanaChile->telefono) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email', $aduanaChile->email) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Estado *</label>
                                        <select name="estado" class="form-control" required>
                                            <option value="Activo" @if($aduanaChile->estado == 'Activo') selected @endif>Activo</option>
                                            <option value="Inactivo" @if($aduanaChile->estado == 'Inactivo') selected @endif>Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Observaciones</label>
                                        <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones', $aduanaChile->observaciones) }}</textarea>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Actualizar Aduana</button>
                                    <a href="{{ route('aduana-chiles.index') }}" class="btn btn-secondary">Cancelar</a>
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