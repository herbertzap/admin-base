<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="registrar-salida"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Registrar Salida"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6>Registrar Salida - TATC {{ $tatc->numero_tatc }}</h6>
                                <a href="{{ route('salidas.create') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Información del TATC -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Información del TATC</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th width="200">Número TATC</th>
                                                    <td>{{ $tatc->numero_tatc }}</td>
                                                    <th width="200">Número Contenedor</th>
                                                    <td>{{ $tatc->numero_contenedor }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Operador</th>
                                                    <td>{{ $tatc->user->operador->nombre_operador ?? 'N/A' }}</td>
                                                    <th>Aduana de Ingreso</th>
                                                    <td>{{ $tatc->aduana_ingreso }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Fecha de Ingreso</th>
                                                    <td>{{ \Carbon\Carbon::parse($tatc->fecha_ingreso)->format('d/m/Y') }}</td>
                                                    <th>Ubicación Física</th>
                                                    <td>{{ $tatc->ubicacion_fisica }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tipo de Contenedor</th>
                                                    <td>{{ $tatc->tipo_contenedor }}</td>
                                                    <th>Estado</th>
                                                    <td><span class="badge bg-success">Vigente</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Formulario de Salida -->
                            <form action="{{ route('salidas.store') }}" method="POST" id="formSalida">
                                @csrf
                                <input type="hidden" name="tatc_id" value="{{ $tatc->id }}">
                                
                                <!-- Tipo de Salida -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">Tipo de Salida</h6>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipo_salida" id="internacion" value="internacion" required>
                                            <label class="form-check-label" for="internacion">
                                                Por Declaración de Internación
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipo_salida" id="cancelacion" value="cancelacion">
                                            <label class="form-check-label" for="cancelacion">
                                                Por Cancelación
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tipo_salida" id="traspaso" value="traspaso">
                                            <label class="form-check-label" for="traspaso">
                                                Por Traspaso
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Campos específicos por tipo de salida -->
                                
                                <!-- Campos para Internación -->
                                <div id="camposInternacion" class="campos-especificos" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="operador_origen_internacion">Operador de origen</label>
                                                <input type="text" class="form-control" id="operador_origen_internacion" value="{{ $tatc->user->operador->nombre_operador ?? 'N/A' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="declaracion_internacion">Declaración de Internación</label>
                                                <input type="text" class="form-control" id="declaracion_internacion" name="declaracion_internacion" placeholder="Ingrese Declaración de Internación">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fecha_internacion">Fecha Internación</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="fecha_internacion" name="fecha_internacion" placeholder="dd/mm/yyyy">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="comentario_internacion">Comentario</label>
                                                <input type="text" class="form-control" id="comentario_internacion" name="comentario_internacion" placeholder="Ingrese comentario">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Campos para Cancelación -->
                                <div id="camposCancelacion" class="campos-especificos" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="operador_origen_cancelacion">Operador de origen</label>
                                                <input type="text" class="form-control" id="operador_origen_cancelacion" value="{{ $tatc->user->operador->nombre_operador ?? 'N/A' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fecha_cancelacion">Fecha Cancelación</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="fecha_cancelacion" name="fecha_cancelacion" placeholder="dd/mm/yyyy">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="aduana_ingreso_cancelacion">Aduana de Ingreso</label>
                                                <input type="text" class="form-control" id="aduana_ingreso_cancelacion" name="aduana_ingreso_cancelacion" placeholder="Ingrese Aduana de Ingreso">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="documento_cancelacion">Documento de Cancelación</label>
                                                <input type="text" class="form-control" id="documento_cancelacion" name="documento_cancelacion" placeholder="Ingrese Documento de Cancelación">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Campos para Traspaso -->
                                <div id="camposTraspaso" class="campos-especificos" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="operador_origen_traspaso">Operador de origen</label>
                                                <input type="text" class="form-control" id="operador_origen_traspaso" value="{{ $tatc->user->operador->nombre_operador ?? 'N/A' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tatc_destino">TATC Destino</label>
                                                <input type="text" class="form-control" id="tatc_destino" name="tatc_destino" placeholder="Ingrese TATC Destino">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fecha_traspaso">Fecha Traspaso</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="fecha_traspaso" name="fecha_traspaso" placeholder="dd/mm/yyyy">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="operador_destino">Operador Destino</label>
                                                <input type="text" class="form-control" id="operador_destino" name="operador_destino" placeholder="Ingrese Operador Destino">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lugar_deposito_origen">Lugar de Depósito Origen</label>
                                                <input type="text" class="form-control" id="lugar_deposito_origen" name="lugar_deposito_origen" placeholder="Ingrese Lugar de Depósito Origen">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lugar_deposito_destino">Lugar de Depósito Destino</label>
                                                <input type="text" class="form-control" id="lugar_deposito_destino" name="lugar_deposito_destino" placeholder="Ingrese Lugar de Depósito Destino">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="valor_contenedor_traspaso">Valor del Contenedor</label>
                                                <input type="number" class="form-control" id="valor_contenedor_traspaso" name="valor_contenedor_traspaso" step="0.01" placeholder="Ingrese Valor del Contenedor">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tipo_bulto_traspaso">Tipo de Bulto</label>
                                                <input type="text" class="form-control" id="tipo_bulto_traspaso" name="tipo_bulto_traspaso" placeholder="Ingrese Tipo de Bulto">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones -->
                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Registrar Salida
                                        </button>
                                        <a href="{{ route('salidas.create') }}" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Cancelar
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
    <x-footers.auth></x-footers.auth>

    <script>
        // Función para mostrar/ocultar campos usando JavaScript puro
        function mostrarCampos(tipoSalida) {
            console.log('Mostrando campos para:', tipoSalida);
            
            // Ocultar todos los campos específicos
            var camposEspecificos = document.querySelectorAll('.campos-especificos');
            camposEspecificos.forEach(function(campo) {
                campo.style.display = 'none';
            });
            
            // Mostrar campos según tipo seleccionado
            if (tipoSalida === 'internacion') {
                var camposInternacion = document.getElementById('camposInternacion');
                if (camposInternacion) camposInternacion.style.display = 'block';
            } else if (tipoSalida === 'cancelacion') {
                var camposCancelacion = document.getElementById('camposCancelacion');
                if (camposCancelacion) camposCancelacion.style.display = 'block';
            } else if (tipoSalida === 'traspaso') {
                var camposTraspaso = document.getElementById('camposTraspaso');
                if (camposTraspaso) camposTraspaso.style.display = 'block';
            }
        }
        
        // Función para manejar el cambio de radio buttons
        function handleTipoSalidaChange() {
            var radioButtons = document.querySelectorAll('input[name="tipo_salida"]');
            radioButtons.forEach(function(radio) {
                radio.addEventListener('change', function() {
                    var tipoSalida = this.value;
                    console.log('Tipo de salida seleccionado:', tipoSalida);
                    mostrarCampos(tipoSalida);
                });
            });
        }
        
        // Función para inicializar el formulario
        function initForm() {
            console.log('Inicializando formulario...');
            
            // Establecer por defecto el primer tipo de salida
            var primerRadio = document.getElementById('internacion');
            if (primerRadio) {
                primerRadio.checked = true;
                mostrarCampos('internacion');
                console.log('Tipo de salida por defecto establecido');
            }
            
            // Agregar event listeners
            handleTipoSalidaChange();
            
            // Validación del formulario
            var form = document.getElementById('formSalida');
            if (form) {
                form.addEventListener('submit', function(e) {
                    var tipoSalida = document.querySelector('input[name="tipo_salida"]:checked');
                    
                    if (!tipoSalida) {
                        e.preventDefault();
                        alert('Debe seleccionar un tipo de salida');
                        return false;
                    }
                    
                    var tipoSalidaValue = tipoSalida.value;
                    
                    // Validar campos requeridos según tipo
                    if (tipoSalidaValue === 'internacion') {
                        var declaracion = document.getElementById('declaracion_internacion').value;
                        var fecha = document.getElementById('fecha_internacion').value;
                        if (!declaracion || !fecha) {
                            e.preventDefault();
                            alert('Debe completar la Declaración de Internación y la Fecha de Internación');
                            return false;
                        }
                    } else if (tipoSalidaValue === 'cancelacion') {
                        var fechaCancelacion = document.getElementById('fecha_cancelacion').value;
                        var aduana = document.getElementById('aduana_ingreso_cancelacion').value;
                        var documento = document.getElementById('documento_cancelacion').value;
                        if (!fechaCancelacion || !aduana || !documento) {
                            e.preventDefault();
                            alert('Debe completar la Fecha de Cancelación, Aduana de Ingreso y Documento de Cancelación');
                            return false;
                        }
                    } else if (tipoSalidaValue === 'traspaso') {
                        var tatcDestino = document.getElementById('tatc_destino').value;
                        var fechaTraspaso = document.getElementById('fecha_traspaso').value;
                        var operadorDestino = document.getElementById('operador_destino').value;
                        if (!tatcDestino || !fechaTraspaso || !operadorDestino) {
                            e.preventDefault();
                            alert('Debe completar el TATC Destino, Fecha de Traspaso y Operador Destino');
                            return false;
                        }
                    }
                });
            }
            
            // Debug: verificar que los elementos existen
            console.log('Elementos encontrados:');
            console.log('Radio buttons:', document.querySelectorAll('input[name="tipo_salida"]').length);
            console.log('Campos internación:', document.getElementById('camposInternacion') ? 1 : 0);
            console.log('Campos cancelación:', document.getElementById('camposCancelacion') ? 1 : 0);
            console.log('Campos traspaso:', document.getElementById('camposTraspaso') ? 1 : 0);
        }
        
        // Inicializar cuando el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initForm);
        } else {
            initForm();
        }
    </script>
</x-layout>
