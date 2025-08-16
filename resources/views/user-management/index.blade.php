<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='user-management'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Gestión de Usuarios"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>Gestión de Usuarios</h6>
                                @if(Auth::user()->canCreateUsers())
                                    <a href="{{ route('user-management.create') }}" class="btn btn-primary btn-sm">Nuevo Usuario</a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuario</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Operador</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Roles</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Último Movimiento</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ $user->fotografia_url }}" class="avatar avatar-sm me-3 border-radius-lg" alt="user">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                                        @if($user->rut_usuario)
                                                            <p class="text-xs text-secondary mb-0">RUT: {{ $user->rut_usuario }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    @if($user->operador)
                                                        {{ $user->operador->codigo }} | {{ $user->operador->nombre_operador }}
                                                    @else
                                                        <span class="text-muted">Sin operador</span>
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @foreach($user->roles as $role)
                                                    <span class="badge badge-sm bg-gradient-success">{{ $role->name }}</span>
                                                @endforeach
                                            </td>
                                            <td class="align-middle text-center">
                                                @if($user->estado == 'Activo')
                                                    <span class="badge badge-sm bg-gradient-success">Activo</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-secondary">Inactivo</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">
                                                    @if($user->ultimo_movimiento)
                                                        {{ $user->ultimo_movimiento->format('d/m/Y H:i') }}
                                                    @else
                                                        Nunca
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="btn-group" role="group">
                                                    @if(Auth::user()->canEditUsers() || Auth::user()->id === $user->id)
                                                        <a href="{{ route('user-management.edit', $user) }}" class="btn btn-link text-secondary px-3 mb-0">
                                                            <i class="fas fa-pencil-alt text-xs me-2"></i>Editar
                                                        </a>
                                                    @endif
                                                    @if(Auth::user()->canEditUsers() && Auth::user()->id !== $user->id)
                                                        <form action="{{ route('user-management.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link text-danger px-3 mb-0">
                                                                <i class="fas fa-trash text-xs me-2"></i>Eliminar
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if($users->hasPages())
                                <div class="card-footer">
                                    {{ $users->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout> 