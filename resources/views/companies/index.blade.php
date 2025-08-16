<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='companies'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Empresas"></x-navbars.navs.auth>
        <!-- End Navbar -->
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Empresas</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Empresa</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">RUT</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ciudad</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Contacto</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companies as $company)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $company->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $company->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $company->rut }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-secondary">{{ $company->city }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $company->contact_person }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($company->is_active)
                                            <span class="badge badge-sm bg-gradient-success">Activa</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-secondary">Inactiva</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('companies.show', $company->id) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Ver empresa">
                                            Ver
                                        </a>
                                        <a href="{{ route('companies.edit', $company->id) }}" class="text-secondary font-weight-bold text-xs ms-2" data-toggle="tooltip" data-original-title="Editar empresa">
                                            Editar
                                        </a>
                                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger font-weight-bold text-xs ms-2 border-0 bg-transparent" onclick="return confirm('¿Estás seguro de eliminar esta empresa?')">
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
            <a href="{{ route('companies.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Empresa
            </a>
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col-12">
            {{ $companies->links() }}
        </div>
        </div>
    </main>
</x-layout> 