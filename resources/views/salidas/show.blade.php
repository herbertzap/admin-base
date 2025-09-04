<x-layout>
    <x-navbars.sidebar activePage="salidas"></x-navbars.sidebar>
    
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Detalle de Salida"></x-navbars.navs.auth>
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>Información de la Salida</h6>
                                <div>
                                    @if($salida->estado !== 'Aprobado')
                                        <a href="{{ route('salidas.edit', $salida) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                    @endif
                                    <a href="{{ route('salidas.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($salida->estado === 'Aprobado')
                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Información:</strong> Esta salida está aprobada y no puede ser editada para mantener la integridad de los datos del sistema.
                                </div>
                            @endif
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">Información General</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">Número de Salida:</td>
                                            <td>{{ $salida->numero_salida }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Fecha de Salida:</td>
                                            <td>{{ $salida->fecha_salida ? \Carbon\Carbon::parse($salida->fecha_salida)->format('d/m/Y') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Tipo de Salida:</td>
                                            <td>{{ $salida->tipo_salida }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Estado:</td>
                                            <td>
                                                <span class="badge bg-{{ $salida->estado === 'Aprobado' ? 'success' : 'warning' }}">
                                                    {{ $salida->estado }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Motivo de Salida:</td>
                                            <td>{{ $salida->motivo_salida ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">Información del Contenedor</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">Número de Contenedor:</td>
                                            <td>{{ $salida->numero_contenedor }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Tipo de Contenedor:</td>
                                            <td>{{ $salida->tipo_contenedor }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Estado del Contenedor:</td>
                                            <td>{{ $salida->estado_contenedor ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Aduana de Salida:</td>
                                            <td>{{ $salida->aduana_salida }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Documento de Aduana:</td>
                                            <td>{{ $salida->documento_aduana ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">Información del Transporte</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">Empresa Transportista:</td>
                                            <td>{{ $salida->empresaTransportista->nombre_empresa ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">RUT del Chofer:</td>
                                            <td>{{ $salida->rut_chofer ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Patente del Camión:</td>
                                            <td>{{ $salida->patente_camion ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Número de Documento:</td>
                                            <td>{{ $salida->numero_documento ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">Información del Destino</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">Destino Final:</td>
                                            <td>{{ $salida->destino_final ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">País de Destino:</td>
                                            <td>{{ $salida->pais_destino ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Lugar de Depósito Origen:</td>
                                            <td>{{ $salida->lugar_deposito_origen ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Lugar de Depósito Destino:</td>
                                            <td>{{ $salida->lugar_deposito_destino ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Información del TATC</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">Número TATC:</td>
                                            <td>{{ $salida->tatc->numero_tatc ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Usuario Responsable:</td>
                                            <td>{{ $salida->tatc->user->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Operador:</td>
                                            <td>{{ $salida->tatc->user->operador->nombre_operador ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Observaciones:</td>
                                            <td>{{ $salida->observaciones ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Información Adicional</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="fw-bold">Declaración de Internación:</td>
                                            <td>{{ $salida->declaracion_internacion ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Comentario de Internación:</td>
                                            <td>{{ $salida->comentario_internacion ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">TATC Destino:</td>
                                            <td>{{ $salida->tatc_destino ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Operador Destino:</td>
                                            <td>{{ $salida->operador_destino ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Valor del Contenedor en Traspaso:</td>
                                            <td>{{ $salida->valor_contenedor_traspaso ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Tipo de Bulto en Traspaso:</td>
                                            <td>{{ $salida->tipo_bulto_traspaso ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>
