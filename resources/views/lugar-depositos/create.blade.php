<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='lugares-deposito'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Nuevo Lugar de Depósito"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Nuevo Lugar de Depósito</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('lugar-depositos.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Código *</label>
                                        <input type="text" name="codigo" class="form-control @error('codigo') is-invalid @enderror" value="{{ old('codigo') }}" required>
                                        @error('codigo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Nombre del Depósito *</label>
                                        <input type="text" name="nombre_deposito" class="form-control @error('nombre_deposito') is-invalid @enderror" value="{{ old('nombre_deposito') }}" required>
                                        @error('nombre_deposito')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Dirección</label>
                                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Ciudad</label>
                                        <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Región</label>
                                        <input type="text" name="region" class="form-control" value="{{ old('region') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Capacidad</label>
                                        <input type="text" name="capacidad" class="form-control" value="{{ old('capacidad') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Teléfono</label>
                                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Operador</label>
                                        <select name="operador_id" class="form-control">
                                            <option value="">Seleccionar Operador</option>
                                            @foreach($operadores as $operador)
                                                <option value="{{ $operador->id }}" @if(old('operador_id') == $operador->id) selected @endif>
                                                    {{ $operador->nombre_operador }} ({{ $operador->codigo }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Estado *</label>
                                        <select name="estado" class="form-control" required>
                                            <option value="Activo" @if(old('estado') == 'Activo') selected @endif>Activo</option>
                                            <option value="Inactivo" @if(old('estado') == 'Inactivo') selected @endif>Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Observaciones</label>
                                        <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones') }}</textarea>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Crear Lugar</button>
                                    <a href="{{ route('lugar-depositos.index') }}" class="btn btn-secondary">Cancelar</a>
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