<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='customs-declarations'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Ver Declaración"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Declaración: {{ $customsDeclaration->declaration_number }}</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Información General</h6>
                                    <p><strong>Número:</strong> {{ $customsDeclaration->declaration_number }}</p>
                                    <p><strong>Tipo:</strong> {{ $customsDeclaration->document_type }}</p>
                                    <p><strong>Estado:</strong> 
                                        @if($customsDeclaration->status == 'draft')
                                            <span class="badge badge-sm bg-gradient-warning">Borrador</span>
                                        @elseif($customsDeclaration->status == 'submitted')
                                            <span class="badge badge-sm bg-gradient-info">Enviada</span>
                                        @elseif($customsDeclaration->status == 'approved')
                                            <span class="badge badge-sm bg-gradient-success">Aprobada</span>
                                        @else
                                            <span class="badge badge-sm bg-gradient-secondary">{{ $customsDeclaration->status }}</span>
                                        @endif
                                    </p>
                                    <p><strong>Fecha:</strong> {{ $customsDeclaration->declaration_date->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Empresa</h6>
                                    <p><strong>Nombre:</strong> {{ $customsDeclaration->company->name ?? 'N/A' }}</p>
                                    <p><strong>RUT:</strong> {{ $customsDeclaration->company->rut ?? 'N/A' }}</p>
                                    <p><strong>Valor Total:</strong> ${{ number_format($customsDeclaration->total_value, 0, ',', '.') }}</p>
                                    <p><strong>Peso Total:</strong> {{ number_format($customsDeclaration->total_weight, 2, ',', '.') }} kg</p>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h6>Descripción</h6>
                                    <p>{{ $customsDeclaration->description }}</p>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <a href="{{ route('customs-declarations.edit', $customsDeclaration->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="{{ route('customs-declarations.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout> 