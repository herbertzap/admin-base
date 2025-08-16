<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='logistica'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Detalles del Contenedor"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Detalles del Contenedor</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('logistica.edit', $logistica) }}" class="btn btn-primary btn-sm">
                                        <i class="material-icons">edit</i> Editar
                                    </a>
                                    <a href="{{ route('logistica.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="material-icons">arrow_back</i> Volver
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            
                            <!-- Información del Contenedor -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Información del Contenedor</h6>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Número de Contenedor</label>
                                    <p class="form-control bg-light">{{ $logistica->numero_contenedor }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Tipo de Contenedor</label>
                                    <p class="form-control bg-light">{{ $logistica->tipo_contenedor }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Estado del Contenedor</label>
                                    <span class="badge badge-sm bg-gradient-{{ $logistica->estado_contenedor == 'En Tránsito' ? 'warning' : ($logistica->estado_contenedor == 'En Almacén' ? 'info' : 'success') }}">
                                        {{ $logistica->estado_contenedor }}
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Empresa Transportista</label>
                                    <p class="form-control bg-light">{{ $logistica->empresa_transportista }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Ubicación Actual</label>
                                    <p class="form-control bg-light">{{ $logistica->ubicacion_actual }}</p>
                                </div>
                            </div>

                            <!-- Información de Transporte -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Información de Transporte</h6>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Puerto de Origen</label>
                                    <p class="form-control bg-light">{{ $logistica->puerto_origen }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Puerto de Destino</label>
                                    <p class="form-control bg-light">{{ $logistica->puerto_destino }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Fecha de Arribo</label>
                                    <p class="form-control bg-light">{{ $logistica->fecha_arribo->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Naviera</label>
                                    <p class="form-control bg-light">{{ $logistica->naviera }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Buque</label>
                                    <p class="form-control bg-light">{{ $logistica->buque }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Viaje</label>
                                    <p class="form-control bg-light">{{ $logistica->viaje }}</p>
                                </div>
                                @if($logistica->fecha_salida)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Fecha de Salida</label>
                                    <p class="form-control bg-light">{{ $logistica->fecha_salida->format('d/m/Y') }}</p>
                                </div>
                                @endif
                            </div>

                            <!-- Información de Documentación -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Información de Documentación</h6>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Booking</label>
                                    <p class="form-control bg-light">{{ $logistica->booking }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">BL/AWB</label>
                                    <p class="form-control bg-light">{{ $logistica->bl_awb }}</p>
                                </div>
                            </div>

                            <!-- Información de Mercancía -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Información de Mercancía</h6>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Descripción de Mercancía</label>
                                    <p class="form-control bg-light">{{ $logistica->descripcion_mercancia }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Peso Bruto (kg)</label>
                                    <p class="form-control bg-light">{{ number_format($logistica->peso_bruto) }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Volumen (m³)</label>
                                    <p class="form-control bg-light">{{ number_format($logistica->volumen) }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Bultos</label>
                                    <p class="form-control bg-light">{{ number_format($logistica->bultos) }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Tipo de Mercancía</label>
                                    <p class="form-control bg-light">{{ $logistica->tipo_mercancia }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Estado de Mercancía</label>
                                    <p class="form-control bg-light">{{ $logistica->estado_mercancia }}</p>
                                </div>
                                @if($logistica->observaciones)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Observaciones</label>
                                    <p class="form-control bg-light">{{ $logistica->observaciones }}</p>
                                </div>
                                @endif
                            </div>

                            <!-- Información del Sistema -->
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Información del Sistema</h6>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Estado</label>
                                    <span class="badge badge-sm bg-gradient-{{ $logistica->estado == 'Activo' ? 'success' : 'danger' }}">
                                        {{ $logistica->estado }}
                                    </span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Creado</label>
                                    <p class="form-control bg-light">{{ $logistica->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Última Actualización</label>
                                    <p class="form-control bg-light">{{ $logistica->updated_at->format('d/m/Y H:i') }}</p>
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