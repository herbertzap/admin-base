<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='tatc'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Exportar TATC"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Exportar TATC</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('tatc.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-arrow-left"></i> Volver
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('tatc.procesar-exportacion') }}" id="formExportar">
                                @csrf
                                <div class="row">
                                    <!-- Filtros de fecha -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Rango de Fechas</label>
                                            <div class="input-group">
                                                <input type="text" name="rango_fechas" id="rango_fechas" class="form-control" placeholder="Seleccionar rango de fechas" required>
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input type="hidden" name="fecha_desde" id="fecha_desde">
                                            <input type="hidden" name="fecha_hasta" id="fecha_hasta">
                                        </div>
                                    </div>
                                    
                                    <!-- Filtro de estado -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Estado</label>
                                            <select name="estado" class="form-control">
                                                <option value="">Todos los estados</option>
                                                <option value="Pendiente">Pendiente</option>
                                                <option value="Aprobado">Aprobado</option>
                                                <option value="Rechazado">Rechazado</option>
                                                <option value="Vencido">Vencido</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <!-- Fecha desde individual -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Fecha Desde</label>
                                            <div class="input-group">
                                                <input type="text" name="fecha_desde_individual" id="fecha_desde_individual" class="form-control" placeholder="dd/mm/yyyy">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Fecha hasta individual -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Fecha Hasta</label>
                                            <div class="input-group">
                                                <input type="text" name="fecha_hasta_individual" id="fecha_hasta_individual" class="form-control" placeholder="dd/mm/yyyy">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Filtro de aduana -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Aduana</label>
                                            <select name="aduana" class="form-control">
                                                <option value="">Todas las aduanas</option>
                                                @foreach($aduanas ?? [] as $aduana)
                                                    <option value="{{ $aduana->codigo }}">{{ $aduana->codigo }} - {{ $aduana->nombre_aduana }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Filtro de tipo de ingreso -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Tipo de Ingreso</label>
                                            <select name="tipo_ingreso" class="form-control">
                                                <option value="">Todos los tipos</option>
                                                <option value="traspaso">Traspaso</option>
                                                <option value="desembarque">Desembarque</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <!-- Filtro de operador -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Operador</label>
                                            <select name="operador_id" class="form-control">
                                                <option value="">Todos los operadores</option>
                                                @foreach($operadores ?? [] as $operador)
                                                    <option value="{{ $operador->id }}">{{ $operador->codigo }} - {{ $operador->nombre_operador }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Filtro de número de contenedor -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Número de Contenedor</label>
                                            <input type="text" name="numero_contenedor" class="form-control" placeholder="Buscar por número de contenedor">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <!-- Formato de exportación -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Formato de Exportación</label>
                                            <select name="formato" class="form-control" required>
                                                <option value="excel">Excel (.xlsx)</option>
                                                <option value="csv">CSV (.csv)</option>
                                                <option value="pdf">PDF (.pdf)</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Campos a incluir -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Campos a Incluir</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="campos[]" value="numero_tatc" id="campo_tatc" checked>
                                                <label class="form-check-label" for="campo_tatc">Número TATC</label>
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
                                                <input class="form-check-input" type="checkbox" name="campos[]" value="aduana_ingreso" id="campo_aduana" checked>
                                                <label class="form-check-label" for="campo_aduana">Aduana</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="campos[]" value="estado" id="campo_estado" checked>
                                                <label class="form-check-label" for="campo_estado">Estado</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="campos[]" value="created_at" id="campo_fecha" checked>
                                                <label class="form-check-label" for="campo_fecha">Fecha Creación</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-download"></i> Exportar TATC
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

<!-- JavaScript para Exportar TATC -->
<script>
   // Esperar a que el DOM esté listo
   document.addEventListener('DOMContentLoaded', function() {
       console.log('DOM Content Loaded - Exportar TATC');
       
       // Verificar jQuery después del DOM
       if (typeof $j === 'undefined') {
           console.error('ERROR: $j no está disponible después del DOM');
           return;
       }
       
       // Configurar DateRangePicker para rango de fechas
       if ($j('#rango_fechas').length) {
           console.log('Configurando DateRangePicker para rango de fechas...');
           $j('#rango_fechas').daterangepicker({
               "autoApply": true,
               "locale": { 
                   format: "DD/MM/YYYY",
                   daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi','Sa'],
                   monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                   firstDay: 1,
                   cancelLabel: 'Cancelar',
                   applyLabel: 'Cambiar'
               } 			    
           });
           
           $j('#rango_fechas').on('apply.daterangepicker', function(ev, picker) {
               $j("#fecha_desde").val(picker.startDate.format('YYYY-MM-DD'));
               $j("#fecha_hasta").val(picker.endDate.format('YYYY-MM-DD'));
               console.log('Rango de fechas seleccionado:', picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
           });
       }

       // Configurar DateRangePicker para fecha desde individual
       if ($j('#fecha_desde_individual').length) {
           console.log('Configurando DateRangePicker para fecha desde...');
           $j('#fecha_desde_individual').daterangepicker({
               singleDatePicker: true,
               showDropdowns: true,
               autoApply: true,
               locale: {
                   format: 'DD/MM/YYYY',
                   daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi','Sa'],
                   monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                   firstDay: 1,
                   cancelLabel: 'Cancelar',
                   applyLabel: 'Cambiar'
               }
           });
       }

       // Configurar DateRangePicker para fecha hasta individual
       if ($j('#fecha_hasta_individual').length) {
           console.log('Configurando DateRangePicker para fecha hasta...');
           $j('#fecha_hasta_individual').daterangepicker({
               singleDatePicker: true,
               showDropdowns: true,
               autoApply: true,
               locale: {
                   format: 'DD/MM/YYYY',
                   daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi','Sa'],
                   monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                   firstDay: 1,
                   cancelLabel: 'Cancelar',
                   applyLabel: 'Cambiar'
               }
           });
       }

       // Sincronizar fechas individuales con el rango
       $j('#fecha_desde_individual').on('apply.daterangepicker', function(ev, picker) {
           var fechaDesde = picker.startDate.format('DD/MM/YYYY');
           var fechaHasta = $j('#fecha_hasta_individual').val();
           
           if (fechaHasta) {
               $j('#rango_fechas').val(fechaDesde + ' - ' + fechaHasta);
               $j("#fecha_desde").val(picker.startDate.format('YYYY-MM-DD'));
               console.log('Fecha desde sincronizada:', fechaDesde);
           }
       });

       $j('#fecha_hasta_individual').on('apply.daterangepicker', function(ev, picker) {
           var fechaDesde = $j('#fecha_desde_individual').val();
           var fechaHasta = picker.startDate.format('DD/MM/YYYY');
           
           if (fechaDesde) {
               $j('#rango_fechas').val(fechaDesde + ' - ' + fechaHasta);
               $j("#fecha_hasta").val(picker.startDate.format('YYYY-MM-DD'));
               console.log('Fecha hasta sincronizada:', fechaHasta);
           }
       });

       // Sincronizar rango con fechas individuales
       $j('#rango_fechas').on('apply.daterangepicker', function(ev, picker) {
           $j('#fecha_desde_individual').val(picker.startDate.format('DD/MM/YYYY'));
           $j('#fecha_hasta_individual').val(picker.endDate.format('DD/MM/YYYY'));
           console.log('Rango sincronizado con fechas individuales');
       });
       
       console.log('=== FIN CONFIGURACIÓN EXPORTAR TATC ===');
   });
   
   // También probar con window.onload
   window.onload = function() {
       console.log('Window loaded - Exportar TATC');
       console.log('jQuery en window.onload:', typeof $j !== 'undefined');
   };
   
   // Función para limpiar formulario
   function limpiarFormulario() {
       document.getElementById('formExportar').reset();
       if (typeof $j !== 'undefined') {
           $j('#rango_fechas').val('');
           $j('#fecha_desde').val('');
           $j('#fecha_hasta').val('');
           $j('#fecha_desde_individual').val('');
           $j('#fecha_hasta_individual').val('');
       }
       console.log('Formulario limpiado');
   }

   // Validar que al menos un campo esté seleccionado
   document.getElementById('formExportar').addEventListener('submit', function(e) {
       const camposSeleccionados = document.querySelectorAll('input[name="campos[]"]:checked');
       if (camposSeleccionados.length === 0) {
           e.preventDefault();
           alert('Debe seleccionar al menos un campo para exportar.');
           return false;
       }

       // Validar que se haya seleccionado al menos un tipo de fecha
       let rangoFechas = '';
       let fechaDesdeIndividual = '';
       let fechaHastaIndividual = '';
       
       if (typeof $j !== 'undefined') {
           rangoFechas = $j('#rango_fechas').val();
           fechaDesdeIndividual = $j('#fecha_desde_individual').val();
           fechaHastaIndividual = $j('#fecha_hasta_individual').val();
       }

       if (!rangoFechas && !fechaDesdeIndividual && !fechaHastaIndividual) {
           e.preventDefault();
           alert('Debe seleccionar al menos un rango de fechas para exportar.');
           return false;
       }
       
       console.log('Formulario validado correctamente');
   });
</script>
