<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='profile'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Mi Perfil"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Mi Perfil</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <!-- Tabs -->
                                <ul class="nav nav-tabs" id="profileTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="datos-tab" data-bs-toggle="tab" data-bs-target="#datos" type="button" role="tab" aria-controls="datos" aria-selected="true">Mis Datos</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="seguridad-tab" data-bs-toggle="tab" data-bs-target="#seguridad" type="button" role="tab" aria-controls="seguridad" aria-selected="false">Seguridad</button>
                                    </li>
                                </ul>
                                
                                <div class="tab-content mt-3" id="profileTabContent">
                                    <!-- Tab Mis Datos -->
                                    <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Operador Asociado</label>
                                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->operador ? Auth::user()->operador->codigo . ' | ' . Auth::user()->operador->nombre_operador : 'Sin operador asignado' }}" readonly>
                                                <small class="form-text text-muted">Operador asignado (no editable)</small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nombre Completo *</label>
                                                <input type="text" name="name" class="form-control bg-white text-dark border @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email *</label>
                                                <input type="email" name="email" class="form-control bg-white text-dark border @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">RUT Usuario</label>
                                                <input type="text" name="rut_usuario" class="form-control bg-white text-dark border @error('rut_usuario') is-invalid @enderror" value="{{ old('rut_usuario', Auth::user()->rut_usuario) }}">
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
                                                @if(Auth::user()->fotografia)
                                                    <div class="mt-2">
                                                        <img src="{{ Auth::user()->fotografia_url }}" alt="Fotografía actual" class="img-thumbnail" style="max-height: 100px;">
                                                        <small class="form-text text-muted">Fotografía actual</small>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Estado</label>
                                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->estado }}" readonly>
                                                <small class="form-text text-muted">Estado de la cuenta (no editable)</small>
                                            </div>
                                            
                                            <!-- Información del sistema -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Creado el</label>
                                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->created_at ? Auth::user()->created_at->format('d/m/Y \a \l\a\s H:i:s') : 'N/A' }}" readonly>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Último Movimiento</label>
                                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->ultimo_movimiento ? Auth::user()->ultimo_movimiento->format('d/m/Y \a \l\a\s H:i:s') : 'N/A' }}" readonly>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Renovación de Contraseña</label>
                                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->needsPasswordRenewal() ? 'Quedan ' . Auth::user()->getDaysUntilPasswordRenewal() . ' días para renovar su contraseña, le enviaremos un email informando.' : 'No requiere renovación' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tab Seguridad -->
                                    <div class="tab-pane fade" id="seguridad" role="tabpanel" aria-labelledby="seguridad-tab">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Contraseña Actual</label>
                                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->password ? '••••••••••••••••' : 'Sin contraseña' }}" readonly>
                                                <small class="form-text text-muted">Contraseña cifrada actual (no editable)</small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nueva Contraseña</label>
                                                <input type="password" name="password" class="form-control bg-white text-dark border @error('password') is-invalid @enderror" placeholder="Dejar en blanco para mantener la actual">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Mínimo 8 caracteres</small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Confirmar Nueva Contraseña</label>
                                                <input type="password" name="password_confirmation" class="form-control bg-white text-dark border">
                                                <small class="form-text text-muted">Repetir la nueva contraseña</small>
                                            </div>
                                            
                                            <!-- Información de seguridad -->
                                            <div class="col-md-12 mb-3">
                                                <div class="alert alert-info">
                                                    <h6 class="alert-heading">Información de Seguridad</h6>
                                                    <ul class="mb-0">
                                                        <li>Su contraseña debe tener al menos 8 caracteres</li>
                                                        <li>Se recomienda usar una combinación de letras, números y símbolos</li>
                                                        <li>La contraseña se renueva automáticamente cada 365 días</li>
                                                        <li>Recibirá una notificación por email cuando deba renovar su contraseña</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
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
