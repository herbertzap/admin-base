<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='tickets'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Tickets"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Listado de Tickets</h6>
                            <a href="{{ route('tickets.create') }}" class="btn btn-primary">Agregar nuevo</a>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="px-3 pb-2">
                                <form method="GET" class="row g-2 align-items-center">
                                    <div class="col-auto">
                                        <select name="estado" class="form-select form-select-sm">
                                            <option value="">Todos los estados</option>
                                            <option value="nuevo">Nuevo</option>
                                            <option value="en_proceso">En proceso</option>
                                            <option value="cerrado">Cerrado</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-sm btn-outline-primary" type="submit">Filtrar</button>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Título</th>
                                            <th>Estado</th>
                                            <th>Operario</th>
                                            <th>Asignado a</th>
                                            <th>Creado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tickets as $ticket)
                                        <tr>
                                            <td>{{ $ticket->id }}</td>
                                            <td>{{ $ticket->titulo }}</td>
                                            <td>
                                                <span class="badge bg-gradient-{{ $ticket->estado == 'cerrado' ? 'secondary' : ($ticket->estado == 'en_proceso' ? 'warning' : 'success') }}">{{ ucfirst(str_replace('_', ' ', $ticket->estado)) }}</span>
                                            </td>
                                            <td>{{ $ticket->usuario->name ?? '-' }}</td>
                                            <td>{{ $ticket->asignado ? $ticket->asignado->name : '-' }}</td>
                                            <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-info">Ver</a>
                                                <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-sm btn-warning">Editar</a>
                                                <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar ticket?')">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3 px-3">
                                    {{ $tickets->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout> 