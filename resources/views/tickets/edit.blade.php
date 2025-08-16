<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='tickets'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Editar Ticket"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Editar Ticket</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Título</label>
                                    <input type="text" name="titulo" id="titulo" class="form-control" required value="{{ old('titulo', $ticket->titulo) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required>{{ old('descripcion', $ticket->descripcion) }}</textarea>
                                </div>
                                @if(auth()->user() && auth()->user()->is_admin)
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select name="estado" id="estado" class="form-select">
                                        <option value="nuevo" @selected($ticket->estado=='nuevo')>Nuevo</option>
                                        <option value="en_proceso" @selected($ticket->estado=='en_proceso')>En proceso</option>
                                        <option value="cerrado" @selected($ticket->estado=='cerrado')>Cerrado</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="asignado_a" class="form-label">Asignar a</label>
                                    <select name="asignado_a" id="asignado_a" class="form-select">
                                        <option value="">Sin asignar</option>
                                        @foreach($usuarios as $usuario)
                                            <option value="{{ $usuario->id }}" @selected($ticket->asignado_a==$usuario->id)>{{ $usuario->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('tickets.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
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