<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='tatc'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Actualizar TATC"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Actualizar TATC #{{ $tatc->numero_tatc }}</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tatc.update', $tatc) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <!-- Tabs -->
                                <ul class="nav nav-tabs" id="tatcTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="nuevo-tab" data-bs-toggle="tab" data-bs-target="#nuevo" type="button" role="tab" aria-controls="nuevo" aria-selected="true">Actualizar TATC</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="transporte-tab" data-bs-toggle="tab" data-bs-target="#transporte" type="button" role="tab" aria-controls="transporte" aria-selected="false">Transporte</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="historial-tab" data-bs-toggle="tab" data-bs-target="#historial" type="button" role="tab" aria-controls="historial" aria-selected="false">Historial</button>
                                    </li>
                                </ul>
                                
                                <div class="tab-content mt-3" id="tatcTabContent">
                                    <!-- Tab Nuevo TATC -->
                                    <div class="tab-pane fade show active" id="nuevo" role="tabpanel" aria-labelledby="nuevo-tab">
                                        <div class="row">
                                            <!-- Columna Izquierda -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Operador</label>
                                                    <input type="text" class="form-control bg-light" value="{{ Auth::user()->operador ? Auth::user()->operador->codigo . ' | ' . Auth::user()->operador->nombre_operador : 'Sin operador asignado' }}" readonly>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Tipo de Ingreso *</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="tipo_ingreso" id="tipo_ingreso_traspaso" value="traspaso" {{ old('tipo_ingreso', $tatc->tipo_ingreso) == 'traspaso' ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="tipo_ingreso_traspaso">
                                                            Traspaso
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="tipo_ingreso" id="tipo_ingreso_desembarque" value="desembarque" {{ old('tipo_ingreso', $tatc->tipo_ingreso) == 'desembarque' ? 'checked' : '' }} required>
                                                        <label class="form-check-label" for="tipo_ingreso_desembarque">
                                                            Desembarque
                                                        </label>
                                                    </div>
                                                    @error('tipo_ingreso')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Ingreso País *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                        <input type="text" name="ingreso_pais" class="form-control bg-white text-dark border @error('ingreso_pais') is-invalid @enderror" value="{{ old('ingreso_pais', $tatc->ingreso_pais ? \Carbon\Carbon::parse($tatc->ingreso_pais)->format('d/m/Y H:i') : '') }}" placeholder="dd/mm/yyyy hh:mm" required>
                                                    </div>
                                                    @error('ingreso_pais')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Nº Contenedor *</label>
                                                    <input type="text" name="numero_contenedor" id="numero_contenedor" class="form-control bg-white text-dark border @error('numero_contenedor') is-invalid @enderror" value="{{ old('numero_contenedor', $tatc->numero_contenedor) }}" required>
                                                    @error('numero_contenedor')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">TATC Origen</label>
                                                    <input type="text" name="tatc_origen" class="form-control bg-white text-dark border @error('tatc_origen') is-invalid @enderror" value="{{ old('tatc_origen', $tatc->tatc_origen) }}">
                                                    @error('tatc_origen')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Tipo de Contenedor *</label>
                                                    <select name="tipo_contenedor" class="form-control bg-white text-dark border @error('tipo_contenedor') is-invalid @enderror" required>
                                                        <option value="">Seleccionar...</option>
                                                        @foreach($tiposContenedor as $tipo)
                                                            <option value="{{ $tipo->codigo }}" {{ old('tipo_contenedor', $tatc->tipo_contenedor) == $tipo->codigo ? 'selected' : '' }}>
                                                                {{ $tipo->codigo }} - {{ $tipo->descripcion }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('tipo_contenedor')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Documento de Ingreso</label>
                                                    <input type="text" name="documento_ingreso" class="form-control bg-white text-dark border @error('documento_ingreso') is-invalid @enderror" value="{{ old('documento_ingreso', $tatc->documento_ingreso) }}">
                                                    @error('documento_ingreso')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Fecha de Traspaso *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                        <input type="text" name="fecha_traspaso" class="form-control bg-white text-dark border @error('fecha_traspaso') is-invalid @enderror" value="{{ old('fecha_traspaso', $tatc->fecha_traspaso ? \Carbon\Carbon::parse($tatc->fecha_traspaso)->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy" required>
                                                    </div>
                                                    @error('fecha_traspaso')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Tara Contenedor</label>
                                                    <input type="text" name="tara_contenedor" class="form-control bg-white text-dark border @error('tara_contenedor') is-invalid @enderror" value="{{ old('tara_contenedor', $tatc->tara_contenedor) }}">
                                                    @error('tara_contenedor')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Tipo de Bulto</label>
                                                    <select name="tipo_bulto" id="tipo_bulto" class="form-control bg-white text-dark border @error('tipo_bulto') is-invalid @enderror" required>
                                                        <option value="">Seleccione tipo de bulto</option>
                                                        <option value="01" {{ old('tipo_bulto', $tatc->tipo_bulto) == '01' ? 'selected' : '' }}>01 · Granel Solido, Particulas Finas (Polvo)</option>
                                                        <option value="02" {{ old('tipo_bulto', $tatc->tipo_bulto) == '02' ? 'selected' : '' }}>02 · Granel Solido, Particulas Granulares (Granos)</option>
                                                        <option value="03" {{ old('tipo_bulto', $tatc->tipo_bulto) == '03' ? 'selected' : '' }}>03 · Granel Solido, Particulas Grandes (Nodulos)</option>
                                                        <option value="04" {{ old('tipo_bulto', $tatc->tipo_bulto) == '04' ? 'selected' : '' }}>04 · Granel Liquido</option>
                                                        <option value="05" {{ old('tipo_bulto', $tatc->tipo_bulto) == '05' ? 'selected' : '' }}>05 · Granel Gaseoso</option>
                                                        <option value="10" {{ old('tipo_bulto', $tatc->tipo_bulto) == '10' ? 'selected' : '' }}>10 · Piezas</option>
                                                        <option value="11" {{ old('tipo_bulto', $tatc->tipo_bulto) == '11' ? 'selected' : '' }}>11 · Tubos</option>
                                                        <option value="12" {{ old('tipo_bulto', $tatc->tipo_bulto) == '12' ? 'selected' : '' }}>12 · Cilindro</option>
                                                        <option value="13" {{ old('tipo_bulto', $tatc->tipo_bulto) == '13' ? 'selected' : '' }}>13 · Rollos</option>
                                                        <option value="16" {{ old('tipo_bulto', $tatc->tipo_bulto) == '16' ? 'selected' : '' }}>16 · Barras</option>
                                                        <option value="17" {{ old('tipo_bulto', $tatc->tipo_bulto) == '17' ? 'selected' : '' }}>17 · Lingotes</option>
                                                        <option value="18" {{ old('tipo_bulto', $tatc->tipo_bulto) == '18' ? 'selected' : '' }}>18 · Troncos</option>
                                                        <option value="19" {{ old('tipo_bulto', $tatc->tipo_bulto) == '19' ? 'selected' : '' }}>19 · Bloque</option>
                                                        <option value="20" {{ old('tipo_bulto', $tatc->tipo_bulto) == '20' ? 'selected' : '' }}>20 · Rollizo</option>
                                                        <option value="21" {{ old('tipo_bulto', $tatc->tipo_bulto) == '21' ? 'selected' : '' }}>21 · Cajon</option>
                                                        <option value="22" {{ old('tipo_bulto', $tatc->tipo_bulto) == '22' ? 'selected' : '' }}>22 · Cajas De Carton</option>
                                                        <option value="23" {{ old('tipo_bulto', $tatc->tipo_bulto) == '23' ? 'selected' : '' }}>23 · Fardo</option>
                                                        <option value="24" {{ old('tipo_bulto', $tatc->tipo_bulto) == '24' ? 'selected' : '' }}>24 · Baul</option>
                                                        <option value="25" {{ old('tipo_bulto', $tatc->tipo_bulto) == '25' ? 'selected' : '' }}>25 · Cofre</option>
                                                        <option value="26" {{ old('tipo_bulto', $tatc->tipo_bulto) == '26' ? 'selected' : '' }}>26 · Armazon</option>
                                                        <option value="27" {{ old('tipo_bulto', $tatc->tipo_bulto) == '27' ? 'selected' : '' }}>27 · Bandeja</option>
                                                        <option value="28" {{ old('tipo_bulto', $tatc->tipo_bulto) == '28' ? 'selected' : '' }}>28 · Caja De Madera</option>
                                                        <option value="29" {{ old('tipo_bulto', $tatc->tipo_bulto) == '29' ? 'selected' : '' }}>29 · Cajas De Lata</option>
                                                        <option value="31" {{ old('tipo_bulto', $tatc->tipo_bulto) == '31' ? 'selected' : '' }}>31 · Botella De Gas</option>
                                                        <option value="32" {{ old('tipo_bulto', $tatc->tipo_bulto) == '32' ? 'selected' : '' }}>32 · Botella</option>
                                                        <option value="33" {{ old('tipo_bulto', $tatc->tipo_bulto) == '33' ? 'selected' : '' }}>33 · Jaulas</option>
                                                        <option value="34" {{ old('tipo_bulto', $tatc->tipo_bulto) == '34' ? 'selected' : '' }}>34 · Bidon</option>
                                                        <option value="35" {{ old('tipo_bulto', $tatc->tipo_bulto) == '35' ? 'selected' : '' }}>35 · Jabas</option>
                                                        <option value="36" {{ old('tipo_bulto', $tatc->tipo_bulto) == '36' ? 'selected' : '' }}>36 · Cestas</option>
                                                        <option value="37" {{ old('tipo_bulto', $tatc->tipo_bulto) == '37' ? 'selected' : '' }}>37 · Barrilete</option>
                                                        <option value="38" {{ old('tipo_bulto', $tatc->tipo_bulto) == '38' ? 'selected' : '' }}>38 · Tonel</option>
                                                        <option value="39" {{ old('tipo_bulto', $tatc->tipo_bulto) == '39' ? 'selected' : '' }}>39 · Pipas</option>
                                                        <option value="40" {{ old('tipo_bulto', $tatc->tipo_bulto) == '40' ? 'selected' : '' }}>40 · Cajas No Especificadas</option>
                                                        <option value="41" {{ old('tipo_bulto', $tatc->tipo_bulto) == '41' ? 'selected' : '' }}>41 · Jarro</option>
                                                        <option value="42" {{ old('tipo_bulto', $tatc->tipo_bulto) == '42' ? 'selected' : '' }}>42 · Frasco</option>
                                                        <option value="43" {{ old('tipo_bulto', $tatc->tipo_bulto) == '43' ? 'selected' : '' }}>43 · Damajuana</option>
                                                        <option value="44" {{ old('tipo_bulto', $tatc->tipo_bulto) == '44' ? 'selected' : '' }}>44 · Barril</option>
                                                        <option value="45" {{ old('tipo_bulto', $tatc->tipo_bulto) == '45' ? 'selected' : '' }}>45 · Tambor</option>
                                                        <option value="46" {{ old('tipo_bulto', $tatc->tipo_bulto) == '46' ? 'selected' : '' }}>46 · Cuñetes</option>
                                                        <option value="47" {{ old('tipo_bulto', $tatc->tipo_bulto) == '47' ? 'selected' : '' }}>47 · Tarros</option>
                                                        <option value="51" {{ old('tipo_bulto', $tatc->tipo_bulto) == '51' ? 'selected' : '' }}>51 · Cubo</option>
                                                        <option value="61" {{ old('tipo_bulto', $tatc->tipo_bulto) == '61' ? 'selected' : '' }}>61 · Paquete</option>
                                                        <option value="62" {{ old('tipo_bulto', $tatc->tipo_bulto) == '62' ? 'selected' : '' }}>62 · Sacos</option>
                                                        <option value="63" {{ old('tipo_bulto', $tatc->tipo_bulto) == '63' ? 'selected' : '' }}>63 · Maleta</option>
                                                        <option value="64" {{ old('tipo_bulto', $tatc->tipo_bulto) == '64' ? 'selected' : '' }}>64 · Bolsa</option>
                                                        <option value="65" {{ old('tipo_bulto', $tatc->tipo_bulto) == '65' ? 'selected' : '' }}>65 · Bala</option>
                                                        <option value="66" {{ old('tipo_bulto', $tatc->tipo_bulto) == '66' ? 'selected' : '' }}>66 · Red</option>
                                                        <option value="67" {{ old('tipo_bulto', $tatc->tipo_bulto) == '67' ? 'selected' : '' }}>67 · Sobres</option>
                                                        <option value="73" {{ old('tipo_bulto', $tatc->tipo_bulto) == '73' ? 'selected' : '' }}>73 · Contenedor De 20 Pies Dry</option>
                                                        <option value="74" {{ old('tipo_bulto', $tatc->tipo_bulto) == '74' ? 'selected' : '' }}>74 · Contenedor De 40 Pies Dry</option>
                                                        <option value="75" {{ old('tipo_bulto', $tatc->tipo_bulto) == '75' ? 'selected' : '' }}>75 · Contenedor Refrigerado 20 Pies</option>
                                                        <option value="76" {{ old('tipo_bulto', $tatc->tipo_bulto) == '76' ? 'selected' : '' }}>76 · Contenedor Refrigerado 40 Pies</option>
                                                        <option value="77" {{ old('tipo_bulto', $tatc->tipo_bulto) == '77' ? 'selected' : '' }}>77 · Estanque (No Utilizar Para Contenedor Tank)</option>
                                                        <option value="78" {{ old('tipo_bulto', $tatc->tipo_bulto) == '78' ? 'selected' : '' }}>78 · Contenedor No Especificado (Open Top, Tank, Flat Rack, Etc.)</option>
                                                        <option value="80" {{ old('tipo_bulto', $tatc->tipo_bulto) == '80' ? 'selected' : '' }}>80 · Pallet</option>
                                                        <option value="81" {{ old('tipo_bulto', $tatc->tipo_bulto) == '81' ? 'selected' : '' }}>81 · Tablero</option>
                                                        <option value="82" {{ old('tipo_bulto', $tatc->tipo_bulto) == '82' ? 'selected' : '' }}>82 · Laminas</option>
                                                        <option value="83" {{ old('tipo_bulto', $tatc->tipo_bulto) == '83' ? 'selected' : '' }}>83 · Carrete</option>
                                                        <option value="85" {{ old('tipo_bulto', $tatc->tipo_bulto) == '85' ? 'selected' : '' }}>85 · Automotor</option>
                                                        <option value="86" {{ old('tipo_bulto', $tatc->tipo_bulto) == '86' ? 'selected' : '' }}>86 · Ataud</option>
                                                        <option value="88" {{ old('tipo_bulto', $tatc->tipo_bulto) == '88' ? 'selected' : '' }}>88 · Maquinaria</option>
                                                        <option value="89" {{ old('tipo_bulto', $tatc->tipo_bulto) == '89' ? 'selected' : '' }}>89 · Planchas</option>
                                                        <option value="90" {{ old('tipo_bulto', $tatc->tipo_bulto) == '90' ? 'selected' : '' }}>90 · Atados</option>
                                                        <option value="91" {{ old('tipo_bulto', $tatc->tipo_bulto) == '91' ? 'selected' : '' }}>91 · Bobina</option>
                                                        <option value="93" {{ old('tipo_bulto', $tatc->tipo_bulto) == '93' ? 'selected' : '' }}>93 · Otros Bultos No Especificados</option>
                                                        <option value="98" {{ old('tipo_bulto', $tatc->tipo_bulto) == '98' ? 'selected' : '' }}>98 · No Existe Bulto</option>
                                                        <option value="99" {{ old('tipo_bulto', $tatc->tipo_bulto) == '99' ? 'selected' : '' }}>99 · Sin Embalar</option>
                                                    </select>
                                                    @error('tipo_bulto')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Valor FOB</label>
                                                    <input type="number" name="valor_fob" id="valor_fob" class="form-control bg-white text-dark border @error('valor_fob') is-invalid @enderror" value="{{ old('valor_fob', $tatc->valor_fob) }}" step="0.01">
                                                    @error('valor_fob')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Comentario</label>
                                                    <textarea name="comentario" class="form-control bg-white text-dark border @error('comentario') is-invalid @enderror" rows="3">{{ old('comentario', $tatc->comentario) }}</textarea>
                                                    @error('comentario')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <!-- Columna Derecha -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Aduana de Ingreso *</label>
                                                    <select name="aduana_ingreso" id="aduana_ingreso" class="form-control bg-white text-dark border @error('aduana_ingreso') is-invalid @enderror" required>
                                                        <option value="">Seleccionar...</option>
                                                        @foreach($aduanas as $aduana)
                                                            <option value="{{ $aduana->codigo }}" {{ old('aduana_ingreso', $tatc->aduana_ingreso) == $aduana->codigo ? 'selected' : '' }}>
                                                                {{ $aduana->codigo }} - {{ $aduana->nombre_aduana }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('aduana_ingreso')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">EIR</label>
                                                    <input type="text" name="eir" class="form-control bg-white text-dark border @error('eir') is-invalid @enderror" value="{{ old('eir', $tatc->eir) }}">
                                                    @error('eir')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">TATC Destino</label>
                                                    <input type="text" name="tatc_destino" class="form-control bg-white text-dark border @error('tatc_destino') is-invalid @enderror" value="{{ old('tatc_destino', $tatc->tatc_destino) }}">
                                                    @error('tatc_destino')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Tamaño Contenedor</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="tamano_contenedor" id="tamano_20" value="20" {{ old('tamano_contenedor', $tatc->tamano_contenedor) == '20' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="tamano_20">20 Pies</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="tamano_contenedor" id="tamano_40" value="40" {{ old('tamano_contenedor', $tatc->tamano_contenedor) == '40' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="tamano_40">40 Pies</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="tamano_contenedor" id="tamano_45" value="45" {{ old('tamano_contenedor', $tatc->tamano_contenedor) == '45' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="tamano_45">45 Pies</label>
                                                    </div>
                                                    @error('tamano_contenedor')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Puerto de Ingreso</label>
                                                    <input type="text" name="puerto_ingreso" class="form-control bg-white text-dark border @error('puerto_ingreso') is-invalid @enderror" value="{{ old('puerto_ingreso', $tatc->puerto_ingreso) }}">
                                                    @error('puerto_ingreso')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Estado Contenedor</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="estado_contenedor" id="estado_op" value="OP" {{ old('estado_contenedor', $tatc->estado_contenedor) == 'OP' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="estado_op">[OP] Operativo</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="estado_contenedor" id="estado_dm" value="DM" {{ old('estado_contenedor', $tatc->estado_contenedor) == 'DM' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="estado_dm">[DM] Dañado</label>
                                                    </div>
                                                    @error('estado_contenedor')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Año Fabricación</label>
                                                    <input type="number" name="anio_fabricacion" class="form-control bg-white text-dark border @error('anio_fabricacion') is-invalid @enderror" value="{{ old('anio_fabricacion', $tatc->anio_fabricacion) }}" min="1900" max="{{ date('Y') + 1 }}">
                                                    @error('anio_fabricacion')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Ubicación Física Contenedor</label>
                                                    <select name="ubicacion_fisica" id="ubicacion_fisica" class="form-control bg-white text-dark border @error('ubicacion_fisica') is-invalid @enderror" required>
                                                        <option value="">Seleccione ubicación</option>
                                                        @foreach($lugaresDeposito as $lugar)
                                                            <option value="{{ $lugar->nombre_deposito }}" {{ old('ubicacion_fisica', $tatc->ubicacion_fisica) == $lugar->nombre_deposito ? 'selected' : '' }}>
                                                                {{ $lugar->nombre_deposito }} ({{ $lugar->direccion }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('ubicacion_fisica')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Valor CIF</label>
                                                    <input type="number" name="valor_cif" id="valor_cif" class="form-control bg-white text-dark border @error('valor_cif') is-invalid @enderror" value="{{ old('valor_cif', $tatc->valor_cif) }}" step="0.01" readonly>
                                                    <small class="form-text text-muted">Se calcula automáticamente (FOB + 7%)</small>
                                                    @error('valor_cif')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Ingreso Depósito *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                        <input type="text" name="ingreso_deposito" class="form-control bg-white text-dark border @error('ingreso_deposito') is-invalid @enderror" value="{{ old('ingreso_deposito', $tatc->ingreso_deposito ? \Carbon\Carbon::parse($tatc->ingreso_deposito)->format('d/m/Y H:i') : '') }}" placeholder="dd/mm/yyyy hh:mm" required>
                                                    </div>
                                                    @error('ingreso_deposito')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tab Transporte -->
                                    <div class="tab-pane fade" id="transporte" role="tabpanel" aria-labelledby="transporte-tab">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Empresa Transportista</label>
                                                <select name="empresa_transportista_id" class="form-control bg-white text-dark border @error('empresa_transportista_id') is-invalid @enderror">
                                                    <option value="">Seleccionar...</option>
                                                    @foreach($empresasTransportistas as $empresa)
                                                        <option value="{{ $empresa->id }}" {{ old('empresa_transportista_id', $tatc->empresa_transportista_id) == $empresa->id ? 'selected' : '' }}>
                                                            {{ $empresa->nombre_empresa }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('empresa_transportista_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">RUT del Chofer</label>
                                                <input type="text" name="rut_chofer" id="rut_chofer" class="form-control bg-white text-dark border @error('rut_chofer') is-invalid @enderror" value="{{ old('rut_chofer', $tatc->rut_chofer) }}">
                                                @error('rut_chofer')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Patente Camión</label>
                                                <input type="text" name="patente_camion" id="patente_camion" class="form-control bg-white text-dark border @error('patente_camion') is-invalid @enderror" value="{{ old('patente_camion', $tatc->patente_camion) }}">
                                                @error('patente_camion')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Documento de Transporte</label>
                                                <input type="text" name="documento_transporte" class="form-control bg-white text-dark border @error('documento_transporte') is-invalid @enderror" value="{{ old('documento_transporte', $tatc->documento_transporte) }}">
                                                @error('documento_transporte')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tab Historial -->
                                    <div class="tab-pane fade" id="historial" role="tabpanel" aria-labelledby="historial-tab">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Usuario</th>
                                                        <th>Acción</th>
                                                        <th>Detalles</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($tatc->historial ?? [] as $registro)
                                                        <tr>
                                                            <td>
                                                                <small class="text-muted">{{ $registro->created_at->format('d/m/Y') }}</small><br>
                                                                <strong>{{ $registro->created_at->format('H:i:s') }}</strong>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-info">{{ $registro->user->name }}</span>
                                                            </td>
                                                            <td>
                                                                @if($registro->accion == 'Creación del Registro')
                                                                    <span class="badge bg-success">{{ $registro->accion }}</span>
                                                                @elseif($registro->accion == 'Modificación del Registro')
                                                                    <span class="badge bg-warning">{{ $registro->accion }}</span>
                                                                @else
                                                                    <span class="badge bg-secondary">{{ $registro->accion }}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <small>{{ $registro->detalles }}</small>
                                                                @if($registro->datos_anteriores && $registro->datos_nuevos)
                                                                    <button class="btn btn-sm btn-outline-info ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#detalles-{{ $registro->id }}" aria-expanded="false">
                                                                        <i class="fas fa-eye"></i> Ver Cambios
                                                                    </button>
                                                                    <div class="collapse mt-2" id="detalles-{{ $registro->id }}">
                                                                        <div class="card card-body">
                                                                            <h6>Cambios Detallados:</h6>
                                                                            <ul class="list-unstyled">
                                                                                @php
                                                                                    $camposImportantes = [
                                                                                        'numero_contenedor' => 'Número de Contenedor',
                                                                                        'tipo_contenedor' => 'Tipo de Contenedor',
                                                                                        'tipo_ingreso' => 'Tipo de Ingreso',
                                                                                        'ingreso_pais' => 'Ingreso al País',
                                                                                        'ingreso_deposito' => 'Ingreso al Depósito',
                                                                                        'tatc_origen' => 'TATC Origen',
                                                                                        'tatc_destino' => 'TATC Destino',
                                                                                        'fecha_traspaso' => 'Fecha de Traspaso',
                                                                                        'tara_contenedor' => 'Tara del Contenedor',
                                                                                        'tipo_bulto' => 'Tipo de Bulto',
                                                                                        'valor_fob' => 'Valor FOB',
                                                                                        'valor_cif' => 'Valor CIF',
                                                                                        'aduana_ingreso' => 'Aduana de Ingreso',
                                                                                        'puerto_ingreso' => 'Puerto de Ingreso',
                                                                                        'estado_contenedor' => 'Estado del Contenedor',
                                                                                        'ubicacion_fisica' => 'Ubicación Física',
                                                                                        'empresa_transportista_id' => 'Empresa Transportista',
                                                                                        'rut_chofer' => 'RUT del Chofer',
                                                                                        'patente_camion' => 'Patente del Camión',
                                                                                        'comentario' => 'Comentario'
                                                                                    ];
                                                                                @endphp
                                                                                @foreach($camposImportantes as $campo => $nombre)
                                                                                    @php
                                                                                        $valorAnterior = $registro->datos_anteriores[$campo] ?? null;
                                                                                        $valorNuevo = $registro->datos_nuevos[$campo] ?? null;
                                                                                    @endphp
                                                                                    @if($valorAnterior !== $valorNuevo)
                                                                                        <li class="mb-2">
                                                                                            <strong>{{ $nombre }}:</strong><br>
                                                                                            <span class="text-danger">Antes: {{ $valorAnterior ?: 'Vacío' }}</span><br>
                                                                                            <span class="text-success">Después: {{ $valorNuevo ?: 'Vacío' }}</span>
                                                                                        </li>
                                                                                    @endif
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($registro->estado_anterior && $registro->estado_nuevo)
                                                                    <span class="badge bg-secondary">{{ $registro->estado_anterior }}</span>
                                                                    <i class="fas fa-arrow-right mx-1"></i>
                                                                    <span class="badge bg-primary">{{ $registro->estado_nuevo }}</span>
                                                                @elseif($registro->estado_nuevo)
                                                                    <span class="badge bg-primary">{{ $registro->estado_nuevo }}</span>
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">
                                                                <i class="fas fa-history fa-2x text-muted mb-2"></i>
                                                                <p class="text-muted">No hay historial disponible</p>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Actualizar TATC
                                        </button>
                                        <a href="{{ route('tatc.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Cancelar
                                        </a>
                                        <button type="button" class="btn btn-info" onclick="imprimirTatc({{ $tatc->id }})">
                                            <i class="fas fa-print"></i> Imprimir TATC
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

    <script>
        // Usar jQuery con noConflict
        var $j = jQuery.noConflict();

        // Configurar Inputmask para el número de contenedor
        $j(document).ready(function() {
            console.log('Configurando validaciones TATC...');
            
            // Inputmask para número de contenedor
            $j("#numero_contenedor").inputmask("AAAA999999-9", {
                placeholder: "AAAA999999-9",
                clearMaskOnLostFocus: false
            });

            // Cálculo automático del valor CIF (FOB + 7%)
            $j('#valor_fob').on('input', function() {
                var valorFob = parseFloat($j(this).val()) || 0;
                var valorCif = valorFob * 1.07; // FOB + 7%
                $j('#valor_cif').val(valorCif.toFixed(2));
                console.log('CIF calculado:', valorCif.toFixed(2));
            });

            // Validación del número de contenedor
            $j('#numero_contenedor').on('blur', function() {
                var numero = $j(this).val();
                if (numero && numero.length !== 11) {
                    console.log('Contenedor inválido - longitud incorrecta');
                    alert('El número de contenedor debe tener 11 caracteres (formato: AAAA999999-9)');
                    $j(this).focus();
                }
            });

            // Validación del RUT del chofer
            $j('#rut_chofer').on('blur', function() {
                var rut = $j(this).val();
                if (rut && !/^\d{1,8}-[0-9kK]$/.test(rut)) {
                    alert('El RUT debe tener el formato: 12345678-9');
                    $j(this).focus();
                }
            });

            // Validación de la patente del camión
            $j('#patente_camion').on('blur', function() {
                var patente = $j(this).val();
                if (patente && !/^[A-Z]{2,4}[A-Z0-9]{2,3}$/.test(patente)) {
                    alert('La patente debe tener el formato: ABCD12 o ABCD123');
                    $j(this).focus();
                }
            });

            // Date pickers para campos de fecha
            $j('input[name="ingreso_pais"], input[name="ingreso_deposito"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                timePicker: true,
                timePicker24Hour: true,
                locale: {
                    format: 'DD/MM/YYYY HH:mm'
                }
            });

            $j('input[name="fecha_traspaso"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            // Confirmación antes de enviar el formulario
            $j('form').on('submit', function(e) {
                if (!confirm('¿Está seguro de que desea actualizar este TATC?')) {
                    e.preventDefault();
                }
            });
        });
    </script>

    <script>
        function imprimirTatc(tatcId) {
            // Abrir ventana de impresión del TATC
            window.open(`/tatc/${tatcId}/pdf`, '_blank');
        }
    </script>
</x-layout>
