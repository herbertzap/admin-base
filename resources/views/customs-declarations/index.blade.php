<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='customs-declarations'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Declaraciones de Aduana"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Declaraciones de Aduana</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Declaración</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Empresa</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipo</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Valor Total</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($declarations as $declaration)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $declaration->declaration_number }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $declaration->created_at->format('d/m/Y') }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $declaration->company->name ?? 'N/A' }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-secondary">{{ $declaration->document_type }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if($declaration->status == 'draft')
                                                    <span class="badge badge-sm bg-gradient-warning">Borrador</span>
                                                @elseif($declaration->status == 'submitted')
                                                    <span class="badge badge-sm bg-gradient-info">Enviada</span>
                                                @elseif($declaration->status == 'approved')
                                                    <span class="badge badge-sm bg-gradient-success">Aprobada</span>
                                                @elseif($declaration->status == 'rejected')
                                                    <span class="badge badge-sm bg-gradient-danger">Rechazada</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-secondary">{{ $declaration->status }}</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">${{ number_format($declaration->total_value, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="{{ route('customs-declarations.show', $declaration->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Ver declaración">
                                                    Ver
                                                </a>
                                                <a href="{{ route('customs-declarations.edit', $declaration->id) }}" class="text-secondary font-weight-bold text-xs ms-2" data-toggle="tooltip" data-original-title="Editar declaración">
                                                    Editar
                                                </a>
                                                <form action="{{ route('customs-declarations.destroy', $declaration->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-danger font-weight-bold text-xs ms-2 border-0 bg-transparent" onclick="return confirm('¿Estás seguro de eliminar esta declaración?')">
                                                        Eliminar
                                                    </button>
                                                </form>
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
            
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('customs-declarations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Declaración
                    </a>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-12">
                    {{ $declarations->links() }}
                </div>
            </div>
        </div>
    </main>
</x-layout> 