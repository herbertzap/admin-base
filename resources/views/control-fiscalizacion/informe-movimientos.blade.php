<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='informe-movimientos'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Informe de Movimientos"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card" style="background-color: #0f1b2a; border: 1px solid rgba(231,80,52,0.3);">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="text-white">Informe de Movimientos CONTENEDORES DAVI E.I.R.L.</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
                                            <li class="breadcrumb-item"><a href="#">Informe</a></li>
                                            <li class="breadcrumb-item active">Movimientos</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Filtros Mejorados -->
                            <form method="POST" id="formList" name="formList" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="tipo" class="form-label text-white">Tipos de Títulos</label>
                                            <select name="tipo" id="tipo" class="form-control">
                                                <option value="*">Todos</option>
                                                <option value="1">TATC</option>
                                                <option value="2">TSTC</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="estado" class="form-label text-white">Tipos de Movimiento</label>
                                            <select name="estado" id="estado" class="form-control">
                                                <option value="*">Todos</option>
                                                <option value="0">Ingresados</option>
                                                <option value="1">Salida por DI</option>
                                                <option value="2">Salida por Cancelación</option>
                                                <option value="3">Salida por Traspaso</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label text-white">Filtrar Por</label>
                                            <div class="mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="filtro" id="filtro_fechaIngreso" value="0" checked>
                                                    <label class="form-check-label text-white" for="filtro_fechaIngreso">Fecha de Ingreso</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="filtro" id="filtro_fechaSalida" value="1">
                                                    <label class="form-check-label text-white" for="filtro_fechaSalida">Por Fecha de Salida</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="rango-fechas" class="form-label text-white">Selección de Fechas</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>
                                                <input type="text" class="form-control" id="rango-fechas" name="rango-fechas" autocomplete="off" value="01/01/2025 - 29/08/2025" required />
                                                <input type="hidden" class="form-control" name="fecdes" id="fecdes" value="01/01/2025" required>
                                                <input type="hidden" class="form-control" name="fechas" id="fechas" value="29/08/2025" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="aduana_id" class="form-label text-white">Aduana de Ingreso</label>
                                            <select name="aduana_id" id="aduana_id" class="form-control">
                                                <option value="*">Todas</option>
                                                @foreach($aduanas as $aduana)
                                                    <option value="{{ $aduana->codigo }}">{{ $aduana->codigo }} - {{ $aduana->nombre_aduana }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="salida_cancelacion_aduana_id" class="form-label text-white">Aduana de Salida</label>
                                            <select name="salida_cancelacion_aduana_id" id="salida_cancelacion_aduana_id" class="form-control">
                                                <option value="*">Todas</option>
                                                @foreach($aduanas as $aduana)
                                                    <option value="{{ $aduana->codigo }}">{{ $aduana->codigo }} - {{ $aduana->nombre_aduana }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="lugardeposito_id" class="form-label text-white">Lugar de Depósito</label>
                                            <select name="lugardeposito_id" id="lugardeposito_id" class="form-control">
                                                <option value="*">Todos</option>
                                                @foreach($lugaresDeposito as $lugar)
                                                    <option value="{{ $lugar->id }}">{{ $lugar->nombre_deposito }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-start gap-3">
                                            <button type="submit" class="btn btn-primary btn-lg px-4" style="background: linear-gradient(135deg, #e75034 0%, #c73e2a 100%); border: none;">
                                                <i class="fas fa-search"></i> FILTRAR
                                            </button>
                                            <button type="button" class="btn btn-success btn-lg px-4" onclick="exportarResultados()">
                                                <i class="fas fa-file-excel"></i> EXPORTAR
                                            </button>
                                            <button type="button" class="btn btn-info btn-lg px-4" onclick="imprimirResultados()">
                                                <i class="fas fa-print"></i> IMPRIMIR
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Resultados -->
                            @if($resultados)
                                <div class="box box-solid">
                                    <div class="box-body no-padding table-responsive">
                                        <table class="table table-hover table-striped" id="movimientosTable">
                                            <thead>
                                                <tr>
                                                    <th class="sortable" data-column="numero_contenedor">
                                                        Nro Contenedor <i class="fas fa-sort"></i>
                                                    </th>
                                                    <th class="sortable" data-column="fecha_ingreso">
                                                        Fecha Ingreso <i class="fas fa-sort"></i>
                                                    </th>
                                                    <th class="sortable" data-column="aduana_ingreso">
                                                        Aduana Ingreso <i class="fas fa-sort"></i>
                                                    </th>
                                                    <th class="sortable" data-column="aduana_salida">
                                                        Aduana Salida <i class="fas fa-sort"></i>
                                                    </th>
                                                    <th class="sortable" data-column="tipo_salida">
                                                        Tipo Salida <i class="fas fa-sort"></i>
                                                    </th>
                                                    <th class="sortable" data-column="fecha_salida">
                                                        Fecha Salida <i class="fas fa-sort"></i>
                                                    </th>
                                                    <th class="sortable" data-column="di_aduana_oper">
                                                        DI / Aduana / Oper. <i class="fas fa-sort"></i>
                                                    </th>
                                                    <th class="sortable" data-column="tipo">
                                                        Tipo <i class="fas fa-sort"></i>
                                                    </th>
                                                    <th class="sortable" data-column="tatc_tstc">
                                                        TATC / TSTC <i class="fas fa-sort"></i>
                                                    </th>
                                                    <th class="sortable" data-column="tipo_contenedor">
                                                        Tipo Contenedor <i class="fas fa-sort"></i>
                                                    </th>
                                                    <th class="text-center sortable" data-column="tamano">
                                                        Tamaño <i class="fas fa-sort"></i>
                                                    </th>
                                                    <th class="sortable" data-column="lugar_deposito">
                                                        Lugar de Depósito <i class="fas fa-sort"></i>
                                                    </th>
                                                    <th class="text-center">Ver</th>
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
                                                            @if($resultado['modelo'] === 'Tatc')
                                                                <a href="{{ route('tatc.show', $resultado['id']) }}" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            @elseif($resultado['modelo'] === 'Tstc')
                                                                <a href="{{ route('tstc.show', $resultado['id']) }}" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            @elseif($resultado['modelo'] === 'Salida')
                                                                <a href="{{ route('salidas.show', $resultado['id']) }}" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            @endif
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
                                                <!-- Botón de exportar movido arriba -->
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

@push('css')
<style>
    .sortable {
        cursor: pointer;
        user-select: none;
        position: relative;
    }
    
    .sortable:hover {
        background-color: rgba(231, 80, 52, 0.1);
    }
    
    .sortable i {
        margin-left: 5px;
        opacity: 0.5;
        transition: opacity 0.3s;
    }
    
    .sortable:hover i {
        opacity: 1;
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-control:focus {
        border-color: #e75034;
        box-shadow: 0 0 0 0.2rem rgba(231, 80, 52, 0.25);
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #6c757d;
    }
    
    .table th {
        background-color: #f8f9fa;
        border-top: none;
        font-weight: 600;
        color: #495057;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .btn-lg {
        padding: 0.75rem 2rem;
        font-size: 1.1rem;
        border-radius: 0.5rem;
    }
    
    .gap-3 {
        gap: 1rem;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
    }
    
    .btn-info {
        background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
        border: none;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }
</style>
@endpush

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
        // Obtener los datos del formulario
        var formData = new FormData(document.getElementById('formList'));
        
        // Crear un formulario temporal para enviar los datos
        var tempForm = document.createElement('form');
        tempForm.method = 'POST';
        tempForm.action = '{{ route("control-fiscalizacion.exportar") }}';
        tempForm.style.display = 'none';
        
        // Agregar el token CSRF
        var csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        tempForm.appendChild(csrfToken);
        
        // Agregar todos los campos del formulario
        for (var pair of formData.entries()) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = pair[0];
            input.value = pair[1];
            tempForm.appendChild(input);
        }
        
        document.body.appendChild(tempForm);
        tempForm.submit();
        document.body.removeChild(tempForm);
    }
    
    function imprimirResultados() {
        // Obtener los datos del formulario
        var formData = new FormData(document.getElementById('formList'));
        
        // Crear un formulario temporal para enviar los datos
        var tempForm = document.createElement('form');
        tempForm.method = 'POST';
        tempForm.action = '{{ route("control-fiscalizacion.imprimir") }}';
        tempForm.style.display = 'none';
        
        // Agregar el token CSRF
        var csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        tempForm.appendChild(csrfToken);
        
        // Agregar todos los campos del formulario
        for (var pair of formData.entries()) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = pair[0];
            input.value = pair[1];
            tempForm.appendChild(input);
        }
        
        document.body.appendChild(tempForm);
        tempForm.submit();
        document.body.removeChild(tempForm);
    }

    // Funcionalidad de ordenamiento de tabla
    $(document).ready(function() {
        $('.sortable').click(function() {
            var table = $(this).parents('table').eq(0);
            var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
            this.asc = !this.asc;
            if (!this.asc) {
                rows = rows.reverse();
            }
            for (var i = 0; i < rows.length; i++) {
                table.append(rows[i]);
            }
            
            // Actualizar iconos de ordenamiento
            $('.sortable i').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
            if (this.asc) {
                $(this).find('i').removeClass('fa-sort').addClass('fa-sort-up');
            } else {
                $(this).find('i').removeClass('fa-sort').addClass('fa-sort-down');
            }
        });
    });

    function comparer(index) {
        return function(a, b) {
            var valA = getCellValue(a, index);
            var valB = getCellValue(b, index);
            return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB);
        };
    }

    function getCellValue(row, index) {
        return $(row).children('td').eq(index).text();
    }
</script>
@endpush
