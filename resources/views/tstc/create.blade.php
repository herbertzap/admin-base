<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='registrar-tstc'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Registrar TSTC"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Ingreso de Contenedores (TSTC) CONTENEDORES DAVI E.I.R.L.</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            OPCIONES <i class="fa fa-cog"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('tstc.create') }}">Crear Nuevo</a></li>
                                            <li><a class="dropdown-item" href="{{ route('tstc.index') }}">Ver Todos</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('tstc.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Custom Tabs -->
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="form-tab" data-bs-toggle="tab" data-bs-target="#form" type="button" role="tab">
                                            <i class="fa fa-plus"></i> Nuevo TSTC
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="transporte-tab" data-bs-toggle="tab" data-bs-target="#transporte" type="button" role="tab">
                                            <i class="fa fa-truck"></i> Transporte
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content mt-3" id="myTabContent">
                                    <!-- Tab Nuevo TSTC -->
                                    <div class="tab-pane fade show active" id="form" role="tabpanel">
                                        <div class="row mt-3">
                                            <!-- Columna Izquierda -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Operador</label>
                                                    <input type="text" class="form-control bg-white text-dark border" name="operador" value="{{ $userOperador->codigo }} | {{ $userOperador->rut_operador }} | {{ $userOperador->nombre_operador }}" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Fecha Emisión TSTC</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                        <input type="text" class="form-control bg-white text-dark border" name="fecha_emision_tstc" id="fecha_emision_tstc" value="{{ old('fecha_emision_tstc', date('d/m/Y')) }}" placeholder="dd/mm/yyyy" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nº Contenedor</label>
                                                    <input type="text" class="form-control bg-white text-dark border" name="numero_contenedor" id="numero_contenedor" value="{{ old('numero_contenedor') }}" placeholder="Número de Contenedor" maxlength="12" minlength="12" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">TSTC</label>
                                                    <input type="text" class="form-control bg-white text-dark border" name="tstc" id="tstc" value="Se generará automáticamente" readonly>
                                                    <small class="form-text text-muted">Se genera automáticamente al seleccionar la aduana</small>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tipo de Contenedor</label>
                                                    <select name="tipo_contenedor" id="tipo_contenedor" class="form-control bg-white text-dark border" required>
                                                        <option value="">Seleccione tipo</option>
                                                        @foreach($tiposContenedor as $tipo)
                                                        <option value="{{ $tipo->codigo }}" {{ old('tipo_contenedor') == $tipo->codigo ? 'selected' : '' }}>
                                                            {{ $tipo->codigo }} - {{ $tipo->descripcion }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Destino Contenedor</label>
                                                    <input type="text" class="form-control bg-white text-dark border" name="destino_contenedor" id="destino_contenedor" value="{{ old('destino_contenedor') }}" placeholder="Ingrese Destino Contenedor" maxlength="255">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Valor FOB (USD)</label>
                                                    <input type="number" class="form-control bg-white text-dark border" name="valor_fob" id="valor_fob" value="{{ old('valor_fob') }}" placeholder="Ingrese Valor FOB en Dolares" min="0" max="10000000" step="0.01">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tara Contenedor</label>
                                                    <input type="number" class="form-control bg-white text-dark border" name="tara_contenedor" id="tara_contenedor" value="{{ old('tara_contenedor') }}" placeholder="Ingrese del Contenedor" min="0" max="50000">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Comentario</label>
                                                    <textarea class="form-control bg-white text-dark border" name="comentario" id="comentario" rows="3" placeholder="Ingrese comentarios" maxlength="255">{{ old('comentario') }}</textarea>
                                                </div>
                                            </div>
                                            
                                            <!-- Columna Derecha -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Ingreso al Deposito</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                        <input type="text" class="form-control bg-white text-dark border" name="ingreso_deposito" id="ingreso_deposito" value="{{ old('ingreso_deposito', date('d/m/Y')) }}" placeholder="dd/mm/yyyy" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Aduana de Salida</label>
                                                    <select name="aduana_salida" id="aduana_salida" class="form-control bg-white text-dark border" required>
                                                        <option value="">Seleccione aduana</option>
                                                        @foreach($aduanas as $aduana)
                                                        <option value="{{ $aduana->codigo }}" {{ old('aduana_salida') == $aduana->codigo ? 'selected' : '' }}>
                                                            {{ $aduana->codigo }} - {{ $aduana->nombre_aduana }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Fecha Salida del País</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-clock-o"></i>
                                                        </div>
                                                        <input type="text" class="form-control bg-white text-dark border" name="fecha_salida_pais" id="fecha_salida_pais" value="{{ old('fecha_salida_pais', date('d/m/Y H:i')) }}" placeholder="dd/mm/yyyy hh:mm" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tamaño Contenedor</label>
                                                    <div class="form-check">
                                                        <input type="radio" name="tamano_contenedor" id="tamano_contenedor_20" value="20 Pies" class="form-check-input" {{ old('tamano_contenedor', '20 Pies') == '20 Pies' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="tamano_contenedor_20">20 Pies</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" name="tamano_contenedor" id="tamano_contenedor_40" value="40 Pies" class="form-check-input" {{ old('tamano_contenedor') == '40 Pies' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="tamano_contenedor_40">40 Pies</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Estado Contenedor</label>
                                                    <div class="form-check">
                                                        <input type="radio" name="estado_contenedor" id="estado_contenedor_op" value="[OP] Operativo" class="form-check-input" {{ old('estado_contenedor', '[OP] Operativo') == '[OP] Operativo' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="estado_contenedor_op">[OP] Operativo</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" name="estado_contenedor" id="estado_contenedor_dm" value="[DM] Dañado" class="form-check-input" {{ old('estado_contenedor') == '[DM] Dañado' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="estado_contenedor_dm">[DM] Dañado</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Código Tipo de Bulto</label>
                                                    <select name="codigo_tipo_bulto" id="codigo_tipo_bulto" class="form-control bg-white text-dark border" required>
                                                        <option value="01">01 · Granel Solido, Particulas Finas (Polvo)</option>
                                                        <option value="02">02 · Granel Solido, Particulas Granulares (Granos)</option>
                                                        <option value="03">03 · Granel Solido, Particulas Grandes (Nodulos)</option>
                                                        <option value="04">04 · Granel Liquido</option>
                                                        <option value="05">05 · Granel Gaseoso</option>
                                                        <option value="10">10 · Piezas</option>
                                                        <option value="11">11 · Tubos</option>
                                                        <option value="12">12 · Cilindro</option>
                                                        <option value="13">13 · Rollos</option>
                                                        <option value="16">16 · Barras</option>
                                                        <option value="17">17 · Lingotes</option>
                                                        <option value="18">18 · Troncos</option>
                                                        <option value="19">19 · Bloque</option>
                                                        <option value="20">20 · Rollizo</option>
                                                        <option value="21">21 · Cajon</option>
                                                        <option value="22">22 · Cajas De Carton</option>
                                                        <option value="23">23 · Fardo</option>
                                                        <option value="24">24 · Baul</option>
                                                        <option value="25">25 · Cofre</option>
                                                        <option value="26">26 · Armazon</option>
                                                        <option value="27">27 · Bandeja</option>
                                                        <option value="28">28 · Caja De Madera</option>
                                                        <option value="29">29 · Cajas De Lata</option>
                                                        <option value="31">31 · Botella De Gas</option>
                                                        <option value="32">32 · Botella</option>
                                                        <option value="33">33 · Jaulas</option>
                                                        <option value="34">34 · Bidon</option>
                                                        <option value="35">35 · Jabas</option>
                                                        <option value="36">36 · Cestas</option>
                                                        <option value="37">37 · Barrilete</option>
                                                        <option value="38">38 · Tonel</option>
                                                        <option value="39">39 · Pipas</option>
                                                        <option value="40">40 · Cajas No Especificadas</option>
                                                        <option value="41">41 · Jarro</option>
                                                        <option value="42">42 · Frasco</option>
                                                        <option value="43">43 · Damajuana</option>
                                                        <option value="44">44 · Barril</option>
                                                        <option value="45">45 · Tambor</option>
                                                        <option value="46">46 · Cuñetes</option>
                                                        <option value="47">47 · Tarros</option>
                                                        <option value="51">51 · Cubo</option>
                                                        <option value="61">61 · Paquete</option>
                                                        <option value="62">62 · Sacos</option>
                                                        <option value="63">63 · Maleta</option>
                                                        <option value="64">64 · Bolsa</option>
                                                        <option value="65">65 · Bala</option>
                                                        <option value="66">66 · Red</option>
                                                        <option value="67">67 · Sobres</option>
                                                        <option value="73">73 · Contenedor De 20 Pies Dry</option>
                                                        <option value="74">74 · Contenedor De 40 Pies Dry</option>
                                                        <option value="75">75 · Contenedor Refrigerado 20 Pies</option>
                                                        <option value="76">76 · Contenedor Refrigerado 40 Pies</option>
                                                        <option value="77">77 · Estanque (No Utilizar Para Contenedor Tank)</option>
                                                        <option value="78">78 · Contenedor No Especificado (Open Top, Tank, Flat Rack, Etc.)</option>
                                                        <option value="80">80 · Pallet</option>
                                                        <option value="81">81 · Tablero</option>
                                                        <option value="82">82 · Laminas</option>
                                                        <option value="83">83 · Carrete</option>
                                                        <option value="85">85 · Automotor</option>
                                                        <option value="86">86 · Ataud</option>
                                                        <option value="88">88 · Maquinaria</option>
                                                        <option value="89">89 · Planchas</option>
                                                        <option value="90">90 · Atados</option>
                                                        <option value="91">91 · Bobina</option>
                                                        <option value="93">93 · Otros Bultos No Especificados</option>
                                                        <option value="98" selected>98 · No Existe Bulto</option>
                                                        <option value="99">99 · Sin Embalar</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Año Fabricación</label>
                                                    <input type="number" class="form-control bg-white text-dark border" name="anio_fabricacion" id="anio_fabricacion" value="{{ old('anio_fabricacion') }}" placeholder="Ingrese año fabricación" min="1900" max="{{ date('Y') + 1 }}" maxlength="4">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab Transporte -->
                                    <div class="tab-pane fade" id="transporte" role="tabpanel">
                                        <div class="row mt-3">
                                            <!-- Columna Izquierda -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Empresa Transportista</label>
                                                    <select name="empresa_transportista_id" id="empresa_transportista_id" class="form-control bg-white text-dark border">
                                                        <option value="">--</option>
                                                        @foreach($empresasTransportistas as $empresa)
                                                        <option value="{{ $empresa->id }}" {{ old('empresa_transportista_id') == $empresa->id ? 'selected' : '' }}>
                                                            {{ $empresa->nombre_empresa }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Rut del Chofer</label>
                                                    <input type="text" class="form-control bg-white text-dark border" name="rut_chofer" id="rut_chofer" value="{{ old('rut_chofer') }}" placeholder="Rut del Chofer" minlength="8" maxlength="10">
                                                </div>
                                            </div>
                                            
                                            <!-- Columna Derecha -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Patente Camión</label>
                                                    <input type="text" class="form-control bg-white text-dark border" name="patente_camion" id="patente_camion" value="{{ old('patente_camion') }}" placeholder="Ingrese Patente del Camión" maxlength="12">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Documento de Transporte</label>
                                                    <input type="text" class="form-control bg-white text-dark border" name="documento_transporte" id="documento_transporte" value="{{ old('documento_transporte') }}" placeholder="Ingrese Documento de Transporte" maxlength="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12 text-end">
                                        <a href="{{ route('tstc.index') }}" class="btn btn-secondary">
                                            <i class="fa fa-times"></i> CANCELAR
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="btnAccion">
                                            <i class="fa fa-check"></i> AGREGAR
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footers.auth></x-footers.auth>
</x-layout>

<script>
$(document).ready(function() {
    // Máscaras de fecha
    $('#fecha_emision_tstc, #ingreso_deposito').inputmask('dd/mm/yyyy');
    $('#fecha_salida_pais').inputmask('dd/mm/yyyy hh:mm');
    
    // Máscara para número de contenedor (como en TATC)
    $('#numero_contenedor').inputmask('AAAA999999-9');
    
    // Validación del número de contenedor (como en TATC)
    $('#numero_contenedor').blur(function() {
        var nn = $(this).val().replace("_","");
        
        if (nn.length != 12) {
            $(this).css("background-color", "#FD7F83");
            $("#btnAccion").attr('disabled','disabled');
        } else {
            $(this).css("background-color", "#FFFFFF");
            $("#btnAccion").removeAttr('disabled');
        }
    });
    
    // Generar TSTC automáticamente cuando cambie la aduana (como en TATC)
    $('#aduana_salida').on('change', function() {
        var aduana = $(this).val();
        if (aduana) {
            // Llamar al endpoint AJAX para generar el número TSTC
            $.ajax({
                url: '{{ route("tstc.generar-numero") }}',
                method: 'POST',
                data: {
                    aduana_salida: aduana,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $("#tstc").val(response.numero_tstc);
                    } else {
                        console.error('Error generando TSTC:', response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la petición AJAX:', error);
                }
            });
        }
    });
    
    // Validación para Valor FOB (solo números y decimales)
    $('#valor_fob').on('input', function() {
        this.value = this.value.replace(/[^0-9\\.]+/g,'');
    });
    
    // Validación para Tara Contenedor (solo números enteros)
    $('#tara_contenedor').on('input', function() {
        this.value = this.value.replace(/[^0-9]+/g,'');
    });
    
    // Validación para Año Fabricación (solo números, máximo 4 dígitos)
    $('#anio_fabricacion').on('input', function() {
        this.value = this.value.replace(/[^0-9]+/g,'');
        if (this.value.length > 4) {
            this.value = this.value.slice(0, 4);
        }
    });
});
</script>
