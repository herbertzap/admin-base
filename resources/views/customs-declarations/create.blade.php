<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='customs-declarations'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Nueva Declaración"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Nueva Declaración de Aduana</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('customs-declarations.store') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Número de Declaración *</label>
                                            <input type="text" class="form-control" name="declaration_number" value="{{ old('declaration_number') }}" required>
                                            @error('declaration_number')
                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Empresa *</label>
                                            <select class="form-control" name="company_id" required>
                                                <option value="">Seleccionar empresa</option>
                                                @foreach($companies as $company)
                                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                        {{ $company->name }} ({{ $company->rut }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('company_id')
                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Tipo de Documento *</label>
                                            <select class="form-control" name="document_type" required>
                                                <option value="">Seleccionar tipo</option>
                                                <option value="DUS" {{ old('document_type') == 'DUS' ? 'selected' : '' }}>DUS</option>
                                                <option value="DUA" {{ old('document_type') == 'DUA' ? 'selected' : '' }}>DUA</option>
                                                <option value="DUS_SIMPLIFICADO" {{ old('document_type') == 'DUS_SIMPLIFICADO' ? 'selected' : '' }}>DUS Simplificado</option>
                                            </select>
                                            @error('document_type')
                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Fecha de Declaración *</label>
                                            <input type="date" class="form-control" name="declaration_date" value="{{ old('declaration_date', date('Y-m-d')) }}" required>
                                            @error('declaration_date')
                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Oficina de Aduana *</label>
                                            <input type="text" class="form-control" name="customs_office" value="{{ old('customs_office') }}" required>
                                            @error('customs_office')
                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Modo de Transporte *</label>
                                            <select class="form-control" name="transport_mode" required>
                                                <option value="">Seleccionar modo</option>
                                                <option value="maritimo" {{ old('transport_mode') == 'maritimo' ? 'selected' : '' }}>Marítimo</option>
                                                <option value="aereo" {{ old('transport_mode') == 'aereo' ? 'selected' : '' }}>Aéreo</option>
                                                <option value="terrestre" {{ old('transport_mode') == 'terrestre' ? 'selected' : '' }}>Terrestre</option>
                                            </select>
                                            @error('transport_mode')
                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Número de Contenedor</label>
                                            <input type="text" class="form-control" name="container_number" value="{{ old('container_number') }}">
                                            @error('container_number')
                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Conocimiento de Embarque</label>
                                            <input type="text" class="form-control" name="bill_of_lading" value="{{ old('bill_of_lading') }}">
                                            @error('bill_of_lading')
                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Valor Total (USD) *</label>
                                            <input type="number" step="0.01" class="form-control" name="total_value" value="{{ old('total_value') }}" required>
                                            @error('total_value')
                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Peso Total (kg) *</label>
                                            <input type="number" step="0.01" class="form-control" name="total_weight" value="{{ old('total_weight') }}" required>
                                            @error('total_weight')
                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Descripción General *</label>
                                            <textarea class="form-control" name="description" rows="3" required>{{ old('description') }}</textarea>
                                            @error('description')
                                                <p class="text-danger text-xs pt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Guardar Declaración
                                        </button>
                                        <a href="{{ route('customs-declarations.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Cancelar
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout> 