<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='busqueda-extraccion'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Búsqueda y Extracción"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="background-color: #0f1b2a; border: 1px solid rgba(231,80,52,0.3);">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="text-white">Búsqueda y Extracción CONTENEDORES DAVI E.I.R.L.</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
                                            <li class="breadcrumb-item"><a href="#">Búsqueda</a></li>
                                            <li class="breadcrumb-item active">Extracción</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Custom Tabs -->
                            <form class="form-horizontal" method="POST" id="formList" name="formList" enctype="multipart/form-data">
                                @csrf
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#form" data-toggle="tab">Parámetros</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane margin active" id="form">
                                            <div class="form-group">
                                                <label class="col-sm-2" for="tipo">Tipos de títulos</label>
                                                <div class="col-sm-4">
                                                    <select name="tipo" id="tipo" class="form-control">
                                                        <option value="*">Todos</option>
                                                        <option value="1">TATC</option>
                                                        <option value="2">TSTC</option>
                                                    </select>
                                                </div>

                                                <label class="col-sm-2" for="estado">Tipos de Movimiento</label>
                                                <div class="col-sm-4">
                                                    <select name="estado" id="estado" class="form-control">
                                                        <option value="*">Todos</option>
                                                        <option value="0">Ingresados</option>
                                                        <option value="1">Salida por DI</option>
                                                        <option value="2">Salida por Cancelación</option>
                                                        <option value="3">Salida por Traspaso</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2" for="filtro">Filtrar Por</label>
                                                <div class="col-sm-4">
                                                    <input type="radio" name="filtro" id="filtro_fechaIngreso" value="0" checked> Fecha de Ingreso &nbsp; &nbsp;
                                                    <input type="radio" name="filtro" id="filtro_fechaSalida" value="1"> Por Fecha de Salida
                                                </div>

                                                <label class="col-sm-2">Selección de Fechas:</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right" id="rango-fechas" name="rango-fechas" autocomplete="off" value="01/01/2025 - 29/08/2025" required="" />
                                                        <input type="hidden" class="form-control" name="fecdes" id="fecdes" value="01/01/2025" required="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                                        <input type="hidden" class="form-control" name="fechas" id="fechas" value="29/08/2025" required="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2" for="aduana_id">Aduana de Ingreso</label>
                                                <div class="col-sm-4">
                                                    <select name="aduana_id" id="aduana_id" class="form-control">
                                                        <option value="*">Todas</option>
                                                        @foreach($aduanas as $aduana)
                                                            <option value="{{ $aduana->codigo }}">{{ $aduana->codigo }} · {{ $aduana->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <label class="col-sm-2" for="salida_cancelacion_aduana_id">Aduana de Salida</label>
                                                <div class="col-sm-4">
                                                    <select name="salida_cancelacion_aduana_id" id="salida_cancelacion_aduana_id" class="form-control">
                                                        <option value="*">Todas</option>
                                                        @foreach($aduanas as $aduana)
                                                            <option value="{{ $aduana->codigo }}">{{ $aduana->codigo }} · {{ $aduana->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2" for="lugardeposito_id">Lugar de Depósito</label>
                                                <div class="col-sm-4">
                                                    <select name="lugardeposito_id" id="lugardeposito_id" class="form-control" data-live-search="true">
                                                        <option value="*">Todos</option>
                                                        @foreach($lugaresDeposito as $lugar)
                                                            <option value="{{ $lugar->id }}">{{ $lugar->nombre_deposito }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-sm-2">
                                                    <button type="submit" class="btn btn-primary btn-block" style="background: linear-gradient(135deg, #e75034 0%, #c73e2a 100%); border: none;">
                                                        <i class="fa fa-search"></i> Buscar
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Filtros adicionales para búsqueda avanzada -->
                                            <div class="form-group">
                                                <label class="col-sm-2" for="numero_contenedor">Número de Contenedor</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="numero_contenedor" id="numero_contenedor" class="form-control" placeholder="Ingrese número de contenedor">
                                                </div>

                                                <label class="col-sm-2" for="numero_tatc">Número TATC/TSTC</label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="numero_tatc" id="numero_tatc" class="form-control" placeholder="Ingrese número TATC o TSTC">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2" for="tipo_contenedor">Tipo de Contenedor</label>
                                                <div class="col-sm-4">
                                                    <select name="tipo_contenedor" id="tipo_contenedor" class="form-control">
                                                        <option value="*">Todos</option>
                                                        <option value="20">20 pies</option>
                                                        <option value="40">40 pies</option>
                                                        <option value="45">45 pies</option>
                                                    </select>
                                                </div>

                                                <label class="col-sm-2" for="estado_contenedor">Estado del Contenedor</label>
                                                <div class="col-sm-4">
                                                    <select name="estado_contenedor" id="estado_contenedor" class="form-control">
                                                        <option value="*">Todos</option>
                                                        <option value="OP">OP - Operativo</option>
                                                        <option value="DM">DM - Dañado</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Resultados -->
                            @if($resultados)
                                <div class="box box-solid">
                                    <div class="box-body no-padding table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nro Contenedor</th>
                                                    <th>Fecha Ingreso</th>
                                                    <th>Aduana Ingreso</th>
                                                    <th>Aduana Salida</th>
                                                    <th>Tipo Salida</th>
                                                    <th>Fecha Salida</th>
                                                    <th>DI / Aduana / Oper.</th>
                                                    <th>Tipo</th>
                                                    <th>TATC / TSTC</th>
                                                    <th>Tipo Contenedor</th>
                                                    <th class="text-center">Tamaño</th>
                                                    <th>Lugar de Depósito</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($resultados as $resultado)
                                                    <tr>
                                                        <td>{{ $resultado['numero_contenedor'] }}</td>
                                                        <td>{{ $resultado['fecha_ingreso'] }}</td>
                                                        <td>{{ $resultado['aduana_ingreso'] }}</td>
                                                        <td>{{ $resultado['aduana_salida'] }}</td>
                                                        <td>{{ $resultado['tipo_salida'] }}</td>
                                                        <td>{{ $resultado['fecha_salida'] }}</td>
                                                        <td>{{ $resultado['di_aduana_oper'] }}</td>
                                                        <td>{{ $resultado['tipo'] }}</td>
                                                        <td>{{ $resultado['numero_tatc'] }}</td>
                                                        <td>{{ $resultado['tipo_contenedor'] }}</td>
                                                        <td class="text-center">{{ $resultado['tamano_contenedor'] }}</td>
                                                        <td>{{ $resultado['lugar_deposito'] }}</td>
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group">
                                                                @if($resultado['modelo'] === 'Tatc')
                                                                    <a href="{{ route('tatc.show', $resultado['id']) }}" class="btn btn-sm btn-info" title="Ver">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('tatc.edit', $resultado['id']) }}" class="btn btn-sm btn-warning" title="Editar">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @elseif($resultado['modelo'] === 'Tstc')
                                                                    <a href="{{ route('tstc.show', $resultado['id']) }}" class="btn btn-sm btn-info" title="Ver">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('tstc.edit', $resultado['id']) }}" class="btn btn-sm btn-warning" title="Editar">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @elseif($resultado['modelo'] === 'Salida')
                                                                    <a href="{{ route('salidas.show', $resultado['id']) }}" class="btn btn-sm btn-info" title="Ver">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('salidas.edit', $resultado['id']) }}" class="btn btn-sm btn-warning" title="Editar">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @endif
                                                                <button type="button" class="btn btn-sm btn-success" title="Exportar" onclick="exportarRegistro('{{ $resultado['modelo'] }}', {{ $resultado['id'] }})">
                                                                    <i class="fas fa-download"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="13" class="text-center">
                                                            <p class="text-sm text-secondary">No hay resultados para la búsqueda realizada.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    @if($resultados->count() > 0)
                                        <div class="box-footer clearfix">
                                            <div class="col-xs-12 col-sm-3 col-md-3">
                                                <p class="help-block">
                                                    Total: {{ $resultados->count() }} registros
                                                </p>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6 text-center help-block">
                                                <button type="button" class="btn btn-success" onclick="exportarResultados()">
                                                    <i class="fas fa-download"></i> Exportar Todos
                                                </button>
                                                <button type="button" class="btn btn-info" onclick="exportarSeleccionados()">
                                                    <i class="fas fa-download"></i> Exportar Seleccionados
                                                </button>
                                            </div>
                                            <div class="col-xs-12 col-sm-3 col-md-3">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout>

@push('js')
<script>
    $(function() {
        // Configurar DateRangePicker
        $('#rango-fechas').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
                separator: ' - ',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                fromLabel: 'Desde',
                toLabel: 'Hasta',
                customRangeLabel: 'Personalizado',
                weekLabel: 'S',
                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                firstDay: 1
            },
            startDate: moment('01/01/2025', 'DD/MM/YYYY'),
            endDate: moment('29/08/2025', 'DD/MM/YYYY'),
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                'Este mes': [moment().startOf('month'), moment().endOf('month')],
                'Mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, function(start, end, label) {
            $('#fecdes').val(start.format('DD/MM/YYYY'));
            $('#fechas').val(end.format('DD/MM/YYYY'));
        });

        // Configurar Inputmask para fechas
        $('[data-inputmask]').inputmask();
    });

    function exportarResultados() {
        // Implementar exportación de todos los resultados
        alert('Función de exportación de todos los resultados en desarrollo');
    }

    function exportarSeleccionados() {
        // Implementar exportación de registros seleccionados
        alert('Función de exportación de seleccionados en desarrollo');
    }

    function exportarRegistro(modelo, id) {
        // Implementar exportación de registro individual
        alert('Exportando registro ' + modelo + ' con ID ' + id);
    }
</script>
@endpush
