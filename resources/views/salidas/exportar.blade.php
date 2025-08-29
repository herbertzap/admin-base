<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="exportar-salidas"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Exportar Salidas"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Exportar Salidas</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('salidas.procesar-exportacion') }}" method="POST" id="exportForm">
                                @csrf
                                
                                <!-- Filtros de Fecha -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Rango de Fechas</label>
                                            <div class="input-group">
                                                <input type="text" id="daterange" name="daterange" class="form-control" readonly>
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Fecha Desde</label>
                                            <input type="date" name="fecha_desde" id="fecha_desde" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Fecha Hasta</label>
                                            <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- Filtros Adicionales -->
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Estado</label>
                                            <select name="estado" class="form-control">
                                                <option value="">Todos los estados</option>
                                                <option value="activo">Activo</option>
                                                <option value="inactivo">Inactivo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Tipo de Salida</label>
                                            <select name="tipo_salida" class="form-control">
                                                <option value="">Todos los tipos</option>
                                                <option value="internacion">Internación</option>
                                                <option value="cancelacion">Cancelación</option>
                                                <option value="traspaso">Traspaso</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Aduana</label>
                                            <select name="aduana_id" class="form-control">
                                                <option value="">Todas las aduanas</option>
                                                @foreach($aduanas as $aduana)
                                                    <option value="{{ $aduana->id }}">{{ $aduana->codigo }} - {{ $aduana->nombre_aduana }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Operador</label>
                                            <select name="operador_id" class="form-control">
                                                <option value="">Todos los operadores</option>
                                                @foreach($operadores as $operador)
                                                    <option value="{{ $operador->id }}">{{ $operador->rut_operador }} - {{ $operador->nombre_operador }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Filtros de Búsqueda -->
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Número de Contenedor</label>
                                            <input type="text" name="numero_contenedor" class="form-control" placeholder="Buscar por contenedor">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Número TATC</label>
                                            <input type="text" name="numero_tatc" class="form-control" placeholder="Buscar por TATC">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Número de Salida</label>
                                            <input type="text" name="numero_salida" class="form-control" placeholder="Buscar por número de salida">
                                        </div>
                                    </div>
                                </div>

                                <!-- Formato de Exportación -->
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Formato de Exportación</label>
                                            <select name="formato" class="form-control" required>
                                                <option value="">Seleccione formato</option>
                                                <option value="excel">Excel (.xlsx)</option>
                                                <option value="csv">CSV (.csv)</option>
                                                <option value="pdf">PDF (.pdf)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Campos a Exportar</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="campos[]" value="numero_salida" id="campo_numero_salida" checked>
                                                        <label class="form-check-label" for="campo_numero_salida">
                                                            Número de Salida
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="campos[]" value="numero_tatc" id="campo_numero_tatc" checked>
                                                        <label class="form-check-label" for="campo_numero_tatc">
                                                            Número TATC
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="campos[]" value="numero_contenedor" id="campo_numero_contenedor" checked>
                                                        <label class="form-check-label" for="campo_numero_contenedor">
                                                            Contenedor
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="campos[]" value="tipo_salida" id="campo_tipo_salida" checked>
                                                        <label class="form-check-label" for="campo_tipo_salida">
                                                            Tipo de Salida
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="campos[]" value="fecha_salida" id="campo_fecha_salida" checked>
                                                        <label class="form-check-label" for="campo_fecha_salida">
                                                            Fecha de Salida
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="campos[]" value="operador" id="campo_operador" checked>
                                                        <label class="form-check-label" for="campo_operador">
                                                            Operador
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="campos[]" value="aduana" id="campo_aduana" checked>
                                                        <label class="form-check-label" for="campo_aduana">
                                                            Aduana
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="campos[]" value="estado" id="campo_estado" checked>
                                                        <label class="form-check-label" for="campo_estado">
                                                            Estado
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-download"></i> Exportar
                                        </button>
                                        <a href="{{ route('salidas.consulta') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Volver
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
    <x-plugins></x-plugins>

    <script>
        // Configurar DateRangePicker
        $(document).ready(function() {
            $('#daterange').daterangepicker({
                opens: 'left',
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
                }
            }, function(start, end, label) {
                $('#fecha_desde').val(start.format('YYYY-MM-DD'));
                $('#fecha_hasta').val(end.format('YYYY-MM-DD'));
            });

            // Sincronizar campos de fecha individuales con el rango
            $('#fecha_desde, #fecha_hasta').on('change', function() {
                var fechaDesde = $('#fecha_desde').val();
                var fechaHasta = $('#fecha_hasta').val();
                
                if (fechaDesde && fechaHasta) {
                    var start = moment(fechaDesde);
                    var end = moment(fechaHasta);
                    $('#daterange').data('daterangepicker').setStartDate(start);
                    $('#daterange').data('daterangepicker').setEndDate(end);
                }
            });

            // Validación del formulario
            $('#exportForm').on('submit', function(e) {
                var formato = $('select[name="formato"]').val();
                var campos = $('input[name="campos[]"]:checked').length;
                var fechaDesde = $('#fecha_desde').val();
                var fechaHasta = $('#fecha_hasta').val();

                if (!formato) {
                    e.preventDefault();
                    alert('Debe seleccionar un formato de exportación');
                    return false;
                }

                if (campos === 0) {
                    e.preventDefault();
                    alert('Debe seleccionar al menos un campo para exportar');
                    return false;
                }

                if (fechaDesde && fechaHasta) {
                    if (moment(fechaDesde).isAfter(moment(fechaHasta))) {
                        e.preventDefault();
                        alert('La fecha desde no puede ser posterior a la fecha hasta');
                        return false;
                    }
                }
            });
        });
    </script>
</x-layout>
