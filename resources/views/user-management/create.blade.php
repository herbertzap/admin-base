<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='user-management'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Nuevo Usuario"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Nuevo Usuario</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user-management.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- Tabs -->
                                <ul class="nav nav-tabs" id="userTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="datos-tab" data-bs-toggle="tab" data-bs-target="#datos" type="button" role="tab" aria-controls="datos" aria-selected="true">Datos del Usuario</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="privilegios-tab" data-bs-toggle="tab" data-bs-target="#privilegios" type="button" role="tab" aria-controls="privilegios" aria-selected="false">Accesos / Privilegios</button>
                                    </li>
                                </ul>
                                
                                <div class="tab-content mt-3" id="userTabContent">
                                    <!-- Tab Datos del Usuario -->
                                    <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Operador</label>
                                                <select name="operador_id" class="form-control bg-white text-dark border @error('operador_id') is-invalid @enderror" {{ !$currentUser->isAdmin() ? 'disabled' : '' }}>
                                                    <option value="">Sin operador asignado</option>
                                                    @foreach($operadores as $operador)
                                                        <option value="{{ $operador->id }}" {{ old('operador_id') == $operador->id ? 'selected' : '' }}>
                                                            {{ $operador->codigo }} | {{ $operador->nombre_operador }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('operador_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nombre Completo *</label>
                                                <input type="text" name="name" class="form-control bg-white text-dark border @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email *</label>
                                                <input type="email" name="email" class="form-control bg-white text-dark border @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">RUT Usuario</label>
                                                <input type="text" name="rut_usuario" class="form-control bg-white text-dark border @error('rut_usuario') is-invalid @enderror" value="{{ old('rut_usuario') }}">
                                                @error('rut_usuario')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <!-- Fotografía -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Fotografía Usuario</label>
                                                <input type="file" name="fotografia" class="form-control bg-white text-dark border @error('fotografia') is-invalid @enderror" accept="image/*">
                                                @error('fotografia')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Fotografía en formato JPG de 100x100 pixeles</small>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Contraseña *</label>
                                                <input type="password" name="password" class="form-control bg-white text-dark border @error('password') is-invalid @enderror" required>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Confirmar Contraseña *</label>
                                                <input type="password" name="password_confirmation" class="form-control bg-white text-dark border" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
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
                                    
                                    <!-- Tab Accesos / Privilegios -->
                                    <div class="tab-pane fade" id="privilegios" role="tabpanel" aria-labelledby="privilegios-tab">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <h6>Seleccionar roles para el nuevo usuario:</h6>
                                            </div>
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Módulo / Menú</th>
                                                                <th>Estado</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($roles as $role)
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-check">
                                                                            <input type="checkbox" name="roles[]" class="form-check-input" value="{{ $role->name }}" 
                                                                                {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                                                                                {{ !$currentUser->isSuperAdmin() && in_array($role->name, ['admin', 'super-admin']) ? 'disabled' : '' }}>
                                                                            <label class="form-check-label">{{ $role->name }}</label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <span class="badge bg-success">Activo</span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Crear Usuario</button>
                                        <a href="{{ route('user-management.index') }}" class="btn btn-secondary">Cancelar</a>
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
