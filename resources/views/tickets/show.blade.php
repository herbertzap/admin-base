<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='tickets'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Detalle del Ticket"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Detalle del Ticket</h6>
                            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">Editar</a>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">Título</dt>
                                <dd class="col-sm-8">{{ $ticket->titulo }}</dd>
                                <dt class="col-sm-4">Descripción</dt>
                                <dd class="col-sm-8">{{ $ticket->descripcion }}</dd>
                                <dt class="col-sm-4">Estado</dt>
                                <dd class="col-sm-8">
                                    <span class="badge bg-gradient-{{ $ticket->estado == 'cerrado' ? 'secondary' : ($ticket->estado == 'en_proceso' ? 'warning' : 'success') }}">{{ ucfirst(str_replace('_', ' ', $ticket->estado)) }}</span>
                                </dd>
                                <dt class="col-sm-4">Operario</dt>
                                <dd class="col-sm-8">{{ $ticket->usuario->name ?? '-' }}</dd>
                                <dt class="col-sm-4">Asignado a</dt>
                                <dd class="col-sm-8">{{ $ticket->asignado ? $ticket->asignado->name : '-' }}</dd>
                                <dt class="col-sm-4">Creado</dt>
                                <dd class="col-sm-8">{{ $ticket->created_at->format('d/m/Y H:i') }}</dd>
                                <dt class="col-sm-4">Actualizado</dt>
                                <dd class="col-sm-8">{{ $ticket->updated_at->format('d/m/Y H:i') }}</dd>
                            </dl>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Volver al listado</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout> 