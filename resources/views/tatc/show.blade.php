<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='actualizar-tatc'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Detalles TATC"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="background-color: #0f1b2a; border: 1px solid rgba(231,80,52,0.3);">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="text-white">Detalles TATC - {{ $tatc->numero_tatc }}</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('tatc.index') }}">TATC</a></li>
                                            <li class="breadcrumb-item active">Detalles</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-white mb-3">Información del Contenedor</h6>
                                    <table class="table table-dark table-striped">
                                        <tbody>
                                            <tr>
                                                <td class="text-white"><strong>Número TATC:</strong></td>
                                                <td class="text-white">{{ $tatc->numero_tatc }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Número Contenedor:</strong></td>
                                                <td class="text-white">{{ $tatc->numero_contenedor }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Tipo Contenedor:</strong></td>
                                                <td class="text-white">{{ $tatc->tipo_contenedor }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Tamaño:</strong></td>
                                                <td class="text-white">{{ $tatc->tamano_contenedor }}'</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Tara Contenedor:</strong></td>
                                                <td class="text-white">{{ $tatc->tara_contenedor }} kg</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Estado Contenedor:</strong></td>
                                                <td class="text-white">{{ $tatc->estado_contenedor }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Año Fabricación:</strong></td>
                                                <td class="text-white">{{ $tatc->anio_fabricacion }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="text-white mb-3">Información de Ingreso</h6>
                                    <table class="table table-dark table-striped">
                                        <tbody>
                                            <tr>
                                                <td class="text-white"><strong>Tipo Ingreso:</strong></td>
                                                <td class="text-white">{{ ucfirst($tatc->tipo_ingreso) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Ingreso País:</strong></td>
                                                <td class="text-white">{{ $tatc->ingreso_pais ? \Carbon\Carbon::parse($tatc->ingreso_pais)->format('d/m/Y') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Ingreso Depósito:</strong></td>
                                                <td class="text-white">{{ $tatc->ingreso_deposito ? \Carbon\Carbon::parse($tatc->ingreso_deposito)->format('d/m/Y') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Aduana Ingreso:</strong></td>
                                                <td class="text-white">{{ $tatc->aduana_ingreso }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Puerto Ingreso:</strong></td>
                                                <td class="text-white">{{ $tatc->puerto_ingreso }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Ubicación Física:</strong></td>
                                                <td class="text-white">{{ $tatc->ubicacion_fisica }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Estado:</strong></td>
                                                <td class="text-white">
                                                    <span class="badge {{ $tatc->estado == 'Pendiente' ? 'bg-warning' : ($tatc->estado == 'Aprobado' ? 'bg-success' : 'bg-danger') }}">
                                                        {{ $tatc->estado }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <h6 class="text-white mb-3">Información Comercial</h6>
                                    <table class="table table-dark table-striped">
                                        <tbody>
                                            <tr>
                                                <td class="text-white"><strong>Valor FOB:</strong></td>
                                                <td class="text-white">USD {{ number_format($tatc->valor_fob, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Valor CIF:</strong></td>
                                                <td class="text-white">USD {{ number_format($tatc->valor_cif, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Tipo Bulto:</strong></td>
                                                <td class="text-white">{{ $tatc->tipo_bulto }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>EIR:</strong></td>
                                                <td class="text-white">{{ $tatc->eir ?? 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="text-white mb-3">Información Adicional</h6>
                                    <table class="table table-dark table-striped">
                                        <tbody>
                                            <tr>
                                                <td class="text-white"><strong>TATC Origen:</strong></td>
                                                <td class="text-white">{{ $tatc->tatc_origen ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>TATC Destino:</strong></td>
                                                <td class="text-white">{{ $tatc->tatc_destino ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Documento Ingreso:</strong></td>
                                                <td class="text-white">{{ $tatc->documento_ingreso ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Fecha Traspaso:</strong></td>
                                                <td class="text-white">{{ $tatc->fecha_traspaso ? \Carbon\Carbon::parse($tatc->fecha_traspaso)->format('d/m/Y') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Comentario:</strong></td>
                                                <td class="text-white">{{ $tatc->comentario ?? 'Sin comentarios' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if($tatc->empresa_transportista_id || $tatc->rut_chofer || $tatc->patente_camion || $tatc->documento_transporte)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="text-white mb-3">Información de Transporte</h6>
                                    <table class="table table-dark table-striped">
                                        <tbody>
                                            <tr>
                                                <td class="text-white"><strong>Empresa Transportista:</strong></td>
                                                <td class="text-white">{{ $tatc->empresa_transportista_id ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>RUT Chofer:</strong></td>
                                                <td class="text-white">{{ $tatc->rut_chofer ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Patente Camión:</strong></td>
                                                <td class="text-white">{{ $tatc->patente_camion ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Documento Transporte:</strong></td>
                                                <td class="text-white">{{ $tatc->documento_transporte ?? 'N/A' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="text-white mb-3">Información del Sistema</h6>
                                    <table class="table table-dark table-striped">
                                        <tbody>
                                            <tr>
                                                <td class="text-white"><strong>Registrado por:</strong></td>
                                                <td class="text-white">{{ $tatc->user->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Fecha Creación:</strong></td>
                                                <td class="text-white">{{ \Carbon\Carbon::parse($tatc->created_at)->format('d/m/Y H:i:s') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-white"><strong>Última Actualización:</strong></td>
                                                <td class="text-white">{{ \Carbon\Carbon::parse($tatc->updated_at)->format('d/m/Y H:i:s') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <a href="{{ route('tatc.index') }}" class="btn btn-secondary me-2">
                                        <i class="fa fa-arrow-left"></i> Volver
                                    </a>
                                    @if($tatc->puedeSerModificado())
                                    <a href="{{ route('tatc.edit', $tatc->id) }}" class="btn btn-primary me-2">
                                        <i class="fa fa-edit"></i> Editar
                                    </a>
                                    @endif
                                    <a href="{{ route('salidas.registrar', $tatc->id) }}" class="btn btn-success">
                                        <i class="fa fa-sign-out"></i> Registrar Salida
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
