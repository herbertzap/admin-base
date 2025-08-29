<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Mi Panel"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <!-- Tarjetas de Resumen (KPIs) -->
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card" style="background-color: #0f1b2a; border: 1px solid rgba(231,80,52,0.3);">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape text-center border-radius-xl mt-n4 position-absolute" 
                                 style="background: linear-gradient(135deg, #e75034 0%, #c73e2a 100%);">
                                <i class="material-icons opacity-10 text-white">assignment</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize text-white">TATC REGISTRADOS</p>
                                <h4 class="mb-0 text-white">{{ $stats['tatc_registrados'] }}/{{ $stats['tatc_registrados'] }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0 text-white"><span class="text-success text-sm font-weight-bolder">{{ $stats['tatc_registrados'] }}</span> registrados</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card" style="background-color: #0f1b2a; border: 1px solid rgba(231,80,52,0.3);">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape text-center border-radius-xl mt-n4 position-absolute"
                                 style="background: linear-gradient(135deg, #e75034 0%, #c73e2a 100%);">
                                <i class="material-icons opacity-10 text-white">inventory</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize text-white">SALIDAS REGISTRADAS</p>
                                <h4 class="mb-0 text-white">{{ $stats['salidas_registradas'] }}/{{ $stats['tatc_registrados'] }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0 text-white"><span class="text-success text-sm font-weight-bolder">{{ $stats['salidas_registradas'] }}</span> registradas</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card" style="background-color: #0f1b2a; border: 1px solid rgba(231,80,52,0.3);">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape text-center border-radius-xl mt-n4 position-absolute"
                                 style="background: linear-gradient(135deg, #e75034 0%, #c73e2a 100%);">
                                <i class="material-icons opacity-10 text-white">folder</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize text-white">TSTC REGISTRADOS</p>
                                <h4 class="mb-0 text-white">{{ $stats['tstc_registrados'] }}/{{ $stats['tstc_registrados'] }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0 text-white"><span class="text-success text-sm font-weight-bolder">{{ $stats['tstc_registrados'] }}</span> registrados</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card" style="background-color: #0f1b2a; border: 1px solid rgba(231,80,52,0.3);">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape text-center border-radius-xl mt-n4 position-absolute"
                                 style="background: linear-gradient(135deg, #e75034 0%, #c73e2a 100%);">
                                <i class="material-icons opacity-10 text-white">confirmation_number</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize text-white">TICKETS</p>
                                <h4 class="mb-0 text-white">{{ $stats['tickets'] }}/{{ $stats['tickets'] }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0 text-white"><span class="text-success text-sm font-weight-bolder">{{ $stats['tickets'] }}</span> total</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Estadísticas -->
            <div class="row mt-4">
                <div class="col-lg-8 col-md-12">
                    <div class="card" style="background-color: #0f1b2a; border: 1px solid rgba(231,80,52,0.3);">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h6 class="text-white">Estadísticas desde el {{ \Carbon\Carbon::now()->subYear()->format('d/m/Y') }} hasta el {{ \Carbon\Carbon::now()->format('d/m/Y') }}</h6>
                                </div>
                                <div class="col-lg-6 col-5 my-auto text-end">
                                    <div class="d-flex justify-content-end">
                                        <div class="me-3">
                                            <span class="badge badge-sm" style="background-color: #9c27b0;">TATC</span>
                                        </div>
                                        <div class="me-3">
                                            <span class="badge badge-sm" style="background-color: #4caf50;">TSTC</span>
                                        </div>
                                        <div>
                                            <span class="badge badge-sm" style="background-color: #2196f3;">Salidas</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card" style="background-color: #0f1b2a; border: 1px solid rgba(231,80,52,0.3);">
                        <div class="card-header pb-0">
                            <h6 class="text-white">Resumen</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-white">Total TATC:</span>
                                <span class="text-white font-weight-bold">{{ $stats['tatc_registrados'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-white">Total TSTC:</span>
                                <span class="text-white font-weight-bold">{{ $stats['tstc_registrados'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-white">Total Salidas:</span>
                                <span class="text-white font-weight-bold">{{ $stats['salidas_registradas'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tablas de Actividad Reciente -->
            <div class="row mb-4">
                <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
                    <div class="card" style="background-color: #0f1b2a; border: 1px solid rgba(231,80,52,0.3);">
                        <div class="card-header pb-0">
                            <h6 class="text-white">Últimos TATCs Creados</h6>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <tbody>
                                        @forelse($ultimosTatcs as $tatc)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <a href="{{ route('tatc.show', $tatc->id) }}" class="text-white text-sm font-weight-bold mb-0">
                                                            {{ $tatc->numero_tatc }} | {{ $tatc->numero_contenedor }}
                                                        </a>
                                                        <p class="text-xs text-secondary mb-0">{{ $tatc->created_at->format('d/m/Y') }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-sm text-secondary">No hay TATCs recientes</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
                    <div class="card" style="background-color: #0f1b2a; border: 1px solid rgba(231,80,52,0.3);">
                        <div class="card-header pb-0">
                            <h6 class="text-white">Últimas Salidas Ingresadas</h6>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <tbody>
                                        @forelse($ultimasSalidas as $salida)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <a href="{{ route('salidas.show', $salida->id) }}" class="text-white text-sm font-weight-bold mb-0">
                                                            TATC {{ $salida->tatc->numero_tatc ?? 'N/A' }} Por {{ ucfirst($salida->tipo_salida) }}
                                                        </a>
                                                        <p class="text-xs text-secondary mb-0">{{ $salida->created_at->format('d/m/Y') }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-sm text-secondary">No hay salidas recientes</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card" style="background-color: #0f1b2a; border: 1px solid rgba(231,80,52,0.3);">
                        <div class="card-header pb-0">
                            <h6 class="text-white">Últimos Usuarios Conectados</h6>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <tbody>
                                        @forelse($ultimosUsuarios as $usuario)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <a href="#" class="text-white text-sm font-weight-bold mb-0">
                                                            {{ $usuario->name }}
                                                        </a>
                                                        <p class="text-xs text-secondary mb-0">{{ $usuario->last_login_at ? \Carbon\Carbon::parse($usuario->last_login_at)->format('d/m/Y H:i:s') : 'Nunca' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-center">
                                                <p class="text-sm text-secondary">No hay usuarios recientes</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout>

@push('js')
<script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
<script>
    var ctx = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx.createLinearGradient(0, 230, 0, 50);
    gradientStroke1.addColorStop(1, 'rgba(231, 80, 52, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(231, 80, 52, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(231, 80, 52, 0)');

    var gradientStroke2 = ctx.createLinearGradient(0, 230, 0, 50);
    gradientStroke2.addColorStop(1, 'rgba(76, 175, 80, 0.2)');
    gradientStroke2.addColorStop(0.2, 'rgba(76, 175, 80, 0.0)');
    gradientStroke2.addColorStop(0, 'rgba(76, 175, 80, 0)');

    var gradientStroke3 = ctx.createLinearGradient(0, 230, 0, 50);
    gradientStroke3.addColorStop(1, 'rgba(33, 150, 243, 0.2)');
    gradientStroke3.addColorStop(0.2, 'rgba(33, 150, 243, 0.0)');
    gradientStroke3.addColorStop(0, 'rgba(33, 150, 243, 0)');

    var datosGrafico = {!! json_encode($datosGrafico) !!};
    
    var labels = datosGrafico.map(item => item.mes);
    var tatcData = datosGrafico.map(item => item.tatc);
    var tstcData = datosGrafico.map(item => item.tstc);
    var salidasData = datosGrafico.map(item => item.salidas);

    new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [{
                label: "TATC",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#9c27b0",
                borderWidth: 3,
                backgroundColor: gradientStroke1,
                fill: true,
                data: tatcData,
                maxBarThickness: 6
            }, {
                label: "TSTC",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#4caf50",
                borderWidth: 3,
                backgroundColor: gradientStroke2,
                fill: true,
                data: tstcData,
                maxBarThickness: 6
            }, {
                label: "Salidas",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#2196f3",
                borderWidth: 3,
                backgroundColor: gradientStroke3,
                fill: true,
                data: salidasData,
                maxBarThickness: 6
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: 'white'
                    }
                }
            },
            interaction: {
                intersect: false,
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                        color: 'rgba(255, 255, 255, .2)'
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#f8f9fa',
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#f8f9fa',
                        padding: 10,
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
</script>
@endpush
