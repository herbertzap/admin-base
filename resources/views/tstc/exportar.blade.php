<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='exportar-tstc'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Exportar TSTC"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Exportar TSTC</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('tstc.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('tstc.procesar-exportacion') }}" id="formExportar">
                                @csrf
                                
                                <!-- Filtros -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Rango de Fechas</label>
                                            <div class="input-group">
                                                <input type="text" name="rango_fechas" id="rango_fechas" class="form-control" placeholder="Seleccionar rango de fechas">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Fecha Desde</label>
                                            <div class="input-group">
                                                <input type="text" name="fecha_desde_individual" id="fecha_desde_individual" class="form-control" placeholder="dd/mm/yyyy">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Fecha Hasta</label>
                                            <div class="input-group">
                                                <input type="text" name="fecha_hasta_individual" id="fecha_hasta_individual" class="form-control" placeholder="dd/mm/yyyy">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Estado</label>
                                            <select name="estado" class="form-control">
                                                <option value="">Todos los estados</option>
                                                <option value="activo">Activo</option>
                                                <option value="inactivo">Inactivo</option>
                                                <option value="en_transito">En Tránsito</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Aduana</label>
                                            <select name="aduana" class="form-control">
                                                <option value="">Todas las aduanas</option>
                                                @foreach($aduanas as $aduana)
                                                    <option value="{{ $aduana->codigo }}">{{ $aduana->codigo }} - {{ $aduana->nombre_aduana }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Tipo de Salida</label>
                                            <select name="tipo_salida" class="form-control">
                                                <option value="">Todos los tipos</option>
                                                <option value="traspaso">Traspaso</option>
                                                <option value="desembarque">Desembarque</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Operador</label>
                                            <select name="operador" class="form-control">
                                                <option value="">Todos los operadores</option>
                                                @foreach($operadores as $operador)
                                                    <option value="{{ $operador->id }}">{{ $operador->codigo }} - {{ $operador->nombre_operador }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Número de Contenedor</label>
                                            <input type="text" name="numero_contenedor" class="form-control" placeholder="Buscar por número de contenedor">
                                        </div>
                                    </div>
                                </div>
                                
                                <hr>
                                
                                <!-- Formato de Exportación -->
                                <div class="row">
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
                                </div>
                                
                                <!-- Campos a Incluir -->
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label">Campos a Incluir</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="numero_tstc" id="campo_tstc" checked>
                                                    <label class="form-check-label" for="campo_tstc">Número TSTC</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="numero_contenedor" id="campo_contenedor" checked>
                                                    <label class="form-check-label" for="campo_contenedor">Número Contenedor</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="tipo_contenedor" id="campo_tipo" checked>
                                                    <label class="form-check-label" for="campo_tipo">Tipo Contenedor</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="tipo_salida" id="campo_tipo_salida" checked>
                                                    <label class="form-check-label" for="campo_tipo_salida">Tipo de Salida</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="salida_pais" id="campo_salida_pais" checked>
                                                    <label class="form-check-label" for="campo_salida_pais">Salida del País</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="salida_deposito" id="campo_salida_deposito" checked>
                                                    <label class="form-check-label" for="campo_salida_deposito">Salida del Depósito</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="aduana_salida" id="campo_aduana" checked>
                                                    <label class="form-check-label" for="campo_aduana">Aduana de Salida</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="puerto_salida" id="campo_puerto" checked>
                                                    <label class="form-check-label" for="campo_puerto">Puerto de Salida</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="valor_fob" id="campo_fob" checked>
                                                    <label class="form-check-label" for="campo_fob">Valor FOB</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="valor_cif" id="campo_cif" checked>
                                                    <label class="form-check-label" for="campo_cif">Valor CIF</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="estado" id="campo_estado" checked>
                                                    <label class="form-check-label" for="campo_estado">Estado</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="created_at" id="campo_fecha" checked>
                                                    <label class="form-check-label" for="campo_fecha">Fecha de Creación</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="operador" id="campo_operador" checked>
                                                    <label class="form-check-label" for="campo_operador">Operador</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="empresa_transportista" id="campo_empresa" checked>
                                                    <label class="form-check-label" for="campo_empresa">Empresa Transportista</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="rut_chofer" id="campo_chofer" checked>
                                                    <label class="form-check-label" for="campo_chofer">RUT Chofer</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="campos[]" value="patente_camion" id="campo_patente" checked>
                                                    <label class="form-check-label" for="campo_patente">Patente Camión</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Botones -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-download"></i> Exportar TSTC
                                        </button>
                                        <button type="button" class="btn btn-secondary" onclick="limpiarFormulario()">
                                            <i class="fas fa-times"></i> Limpiar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout>

<script>
    $(document).ready(function() {
        // Configurar rango de fechas
        $('#rango_fechas').daterangepicker({
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
            autoUpdateInput: false
        });

        $('#rango_fechas').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            $('#fecha_desde').val(picker.startDate.format('DD/MM/YYYY'));
            $('#fecha_hasta').val(picker.endDate.format('DD/MM/YYYY'));
        });

        $('#rango_fechas').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('#fecha_desde').val('');
            $('#fecha_hasta').val('');
        });

        // Configurar fecha desde individual
        $('#fecha_desde_individual').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        // Configurar fecha hasta individual
        $('#fecha_hasta_individual').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        // Sincronizar fechas individuales con el rango
        $('#fecha_desde_individual').on('apply.daterangepicker', function(ev, picker) {
            var fechaHasta = $('#fecha_hasta_individual').val();
            if (fechaHasta) {
                $('#rango_fechas').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + fechaHasta);
            }
        });

        $('#fecha_hasta_individual').on('apply.daterangepicker', function(ev, picker) {
            var fechaDesde = $('#fecha_desde_individual').val();
            if (fechaDesde) {
                $('#rango_fechas').val(fechaDesde + ' - ' + picker.startDate.format('DD/MM/YYYY'));
            }
        });

        // Sincronizar rango con fechas individuales
        $('#rango_fechas').on('apply.daterangepicker', function(ev, picker) {
            $('#fecha_desde_individual').val(picker.startDate.format('DD/MM/YYYY'));
            $('#fecha_hasta_individual').val(picker.endDate.format('DD/MM/YYYY'));
        });
    });

    function limpiarFormulario() {
        document.getElementById('formExportar').reset();
        $('#rango_fechas').val('');
        $('#fecha_desde').val('');
        $('#fecha_hasta').val('');
        $('#fecha_desde_individual').val('');
        $('#fecha_hasta_individual').val('');
    }

    document.getElementById('formExportar').addEventListener('submit', function(e) {
        const camposSeleccionados = document.querySelectorAll('input[name="campos[]"]:checked');
        if (camposSeleccionados.length === 0) {
            e.preventDefault();
            alert('Debe seleccionar al menos un campo para exportar.');
            return false;
        }
        
        const rangoFechas = $('#rango_fechas').val();
        const fechaDesdeIndividual = $('#fecha_desde_individual').val();
        const fechaHastaIndividual = $('#fecha_hasta_individual').val();

        if (!rangoFechas && !fechaDesdeIndividual && !fechaHastaIndividual) {
            e.preventDefault();
            alert('Debe seleccionar al menos un rango de fechas para exportar.');
            return false;
        }
    });
</script>
