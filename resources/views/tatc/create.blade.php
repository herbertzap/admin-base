<x-layout>
   <x-navbars.sidebar activePage="registrar-tatc"></x-navbars.sidebar>
   <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
      <x-navbars.navs.auth titlePage="Ingreso de Contenedores (TATC)"></x-navbars.navs.auth>
      <div class="container-fluid py-4">
         <div class="row">
            <div class="col-12">
               <div class="card mb-4">
                  <div class="card-header pb-0">
                     <div class="row">
                        <div class="col-6">
                           <h6>Ingreso de Contenedores (TATC) - {{ Auth::user()->operador ? Auth::user()->operador->nombre_operador : 'Sin operador asignado' }}</h6>
                        </div>
                        <div class="col-6 text-end">
                           <div class="dropdown">
                              <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                              Opciones
                              </button>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="{{ route('tatc.index') }}">Ver Lista</a></li>
                                 <li><a class="dropdown-item" href="{{ route('tatc.consulta') }}">Consulta</a></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <form method="POST" action="{{ route('tatc.store') }}" id="formulario" enctype="multipart/form-data">
                        @csrf
                        <!-- Tabs -->
                        <ul class="nav nav-tabs" id="tatcTabs" role="tablist">
                           <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="nuevo-tatc-tab" data-bs-toggle="tab" data-bs-target="#nuevo-tatc" type="button" role="tab">
                              Nuevo TATC
                              </button>
                           </li>
                           <li class="nav-item" role="presentation">
                              <button class="nav-link" id="transporte-tab" data-bs-toggle="tab" data-bs-target="#transporte" type="button" role="tab">
                              Transporte
                              </button>
                           </li>
                        </ul>
                        <div class="tab-content" id="tatcTabsContent">
                           <!-- Tab Nuevo TATC -->
                           <div class="tab-pane fade show active" id="nuevo-tatc" role="tabpanel">
                              <div class="row mt-3">
                                 <!-- Columna Izquierda -->
                                 <div class="col-md-6">
                                    <div class="mb-3">
                                       <label class="form-label">Operador</label>
                                       <input type="text" name="operador" id="operador" class="form-control bg-white text-dark border" value="{{ Auth::user()->operador ? Auth::user()->operador->codigo . ' | ' . Auth::user()->operador->rut . ' | ' . Auth::user()->operador->nombre_operador : '' }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Tipo de Ingreso</label>
                                       <div class="form-check">
                                          <input type="radio" name="tipo_ingreso" value="traspaso" class="form-check-input" checked>
                                          <label class="form-check-label">Por Traspaso</label>
                                       </div>
                                       <div class="form-check">
                                          <input type="radio" name="tipo_ingreso" value="desembarque" class="form-check-input">
                                          <label class="form-check-label">Por Desembarque</label>
                                       </div>
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Ingreso al País</label>
                                       <div class="input-group">
                                          <input type="text" name="ingreso_pais" id="ingreso_pais" class="form-control bg-white text-dark border" value="{{ date('d/m/Y H:i') }}" required>
                                          <span class="input-group-text"><i class="material-icons">schedule</i></span>
                                       </div>
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Nº Contenedor</label>
                                       <input type="text" class="form-control bg-white text-dark border" id="numero_contenedor" name="numero_contenedor" 
                                          value="{{ old('numero_contenedor') }}" value="CAIU411412-7" placeholder="Número de Contenedor" maxlength="12" minlength="12" required="">
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">TATC</label>
                                       <input type="text" class="form-control bg-white text-dark border" id="numero_tatc" name="numero_tatc" 
                                          value="Se generará automáticamente" readonly>
                                       <small class="form-text text-muted">Se genera automáticamente al seleccionar la aduana</small>
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">TATC Origen</label>
                                       <input type="text" name="tatc_origen" id="tatc_origen" class="form-control bg-white text-dark border @error('tatc_origen') is-invalid @enderror" value="{{ old('tatc_origen') }}" placeholder="Ingrese el TATC de Origen" maxlength="12">
                                       @error('tatc_origen')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Tipo de Contenedor</label>
                                       <select name="tipo_contenedor" id="tipo_contenedor" class="form-control bg-white text-dark border @error('tipo_contenedor') is-invalid @enderror" required>
                                          <option value="">Seleccione tipo</option>
                                          @foreach($tiposContenedor as $tipo)
                                          <option value="{{ $tipo->codigo }}" {{ old('tipo_contenedor') == $tipo->codigo ? 'selected' : '' }}>
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
                                       <input type="text" name="documento_ingreso" id="documento_ingreso" class="form-control bg-white text-dark border @error('documento_ingreso') is-invalid @enderror" value="{{ old('documento_ingreso') }}" placeholder="Documento de Ingreso" maxlength="50">
                                       @error('documento_ingreso')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Fecha Traspaso</label>
                                       <div class="input-group">
                                          <input type="text" name="fecha_traspaso" id="fecha_traspaso" class="form-control bg-white text-dark border @error('fecha_traspaso') is-invalid @enderror" value="{{ old('fecha_traspaso', date('d/m/Y')) }}" required>
                                          <span class="input-group-text"><i class="material-icons">calendar_today</i></span>
                                       </div>
                                       @error('fecha_traspaso')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Tara del Contenedor (kg)</label>
                                       <input type="number" class="form-control bg-white text-dark border" id="tara_contenedor" name="tara_contenedor" 
                                          value="{{ old('tara_contenedor') }}" min="0" max="50000" step="0.01">
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Tipo de Bulto</label>
                                       <select name="tipo_bulto" id="tipo_bulto" class="form-control bg-white text-dark border @error('tipo_bulto') is-invalid @enderror" required>
                                          <option value="">Seleccione tipo de bulto</option>
                                          <option value="01" {{ old('tipo_bulto') == '01' ? 'selected' : '' }}>01 · Granel Solido, Particulas Finas (Polvo)</option>
                                          <option value="02" {{ old('tipo_bulto') == '02' ? 'selected' : '' }}>02 · Granel Solido, Particulas Granulares (Granos)</option>
                                          <option value="03" {{ old('tipo_bulto') == '03' ? 'selected' : '' }}>03 · Granel Solido, Particulas Grandes (Nodulos)</option>
                                          <option value="04" {{ old('tipo_bulto') == '04' ? 'selected' : '' }}>04 · Granel Liquido</option>
                                          <option value="05" {{ old('tipo_bulto') == '05' ? 'selected' : '' }}>05 · Granel Gaseoso</option>
                                          <option value="10" {{ old('tipo_bulto') == '10' ? 'selected' : '' }}>10 · Piezas</option>
                                          <option value="11" {{ old('tipo_bulto') == '11' ? 'selected' : '' }}>11 · Tubos</option>
                                          <option value="12" {{ old('tipo_bulto') == '12' ? 'selected' : '' }}>12 · Cilindro</option>
                                          <option value="13" {{ old('tipo_bulto') == '13' ? 'selected' : '' }}>13 · Rollos</option>
                                          <option value="16" {{ old('tipo_bulto') == '16' ? 'selected' : '' }}>16 · Barras</option>
                                          <option value="17" {{ old('tipo_bulto') == '17' ? 'selected' : '' }}>17 · Lingotes</option>
                                          <option value="18" {{ old('tipo_bulto') == '18' ? 'selected' : '' }}>18 · Troncos</option>
                                          <option value="19" {{ old('tipo_bulto') == '19' ? 'selected' : '' }}>19 · Bloque</option>
                                          <option value="20" {{ old('tipo_bulto') == '20' ? 'selected' : '' }}>20 · Rollizo</option>
                                          <option value="21" {{ old('tipo_bulto') == '21' ? 'selected' : '' }}>21 · Cajon</option>
                                          <option value="22" {{ old('tipo_bulto') == '22' ? 'selected' : '' }}>22 · Cajas De Carton</option>
                                          <option value="23" {{ old('tipo_bulto') == '23' ? 'selected' : '' }}>23 · Fardo</option>
                                          <option value="24" {{ old('tipo_bulto') == '24' ? 'selected' : '' }}>24 · Baul</option>
                                          <option value="25" {{ old('tipo_bulto') == '25' ? 'selected' : '' }}>25 · Cofre</option>
                                          <option value="26" {{ old('tipo_bulto') == '26' ? 'selected' : '' }}>26 · Armazon</option>
                                          <option value="27" {{ old('tipo_bulto') == '27' ? 'selected' : '' }}>27 · Bandeja</option>
                                          <option value="28" {{ old('tipo_bulto') == '28' ? 'selected' : '' }}>28 · Caja De Madera</option>
                                          <option value="29" {{ old('tipo_bulto') == '29' ? 'selected' : '' }}>29 · Cajas De Lata</option>
                                          <option value="31" {{ old('tipo_bulto') == '31' ? 'selected' : '' }}>31 · Botella De Gas</option>
                                          <option value="32" {{ old('tipo_bulto') == '32' ? 'selected' : '' }}>32 · Botella</option>
                                          <option value="33" {{ old('tipo_bulto') == '33' ? 'selected' : '' }}>33 · Jaulas</option>
                                          <option value="34" {{ old('tipo_bulto') == '34' ? 'selected' : '' }}>34 · Bidon</option>
                                          <option value="35" {{ old('tipo_bulto') == '35' ? 'selected' : '' }}>35 · Jabas</option>
                                          <option value="36" {{ old('tipo_bulto') == '36' ? 'selected' : '' }}>36 · Cestas</option>
                                          <option value="37" {{ old('tipo_bulto') == '37' ? 'selected' : '' }}>37 · Barrilete</option>
                                          <option value="38" {{ old('tipo_bulto') == '38' ? 'selected' : '' }}>38 · Tonel</option>
                                          <option value="39" {{ old('tipo_bulto') == '39' ? 'selected' : '' }}>39 · Pipas</option>
                                          <option value="40" {{ old('tipo_bulto') == '40' ? 'selected' : '' }}>40 · Cajas No Especificadas</option>
                                          <option value="41" {{ old('tipo_bulto') == '41' ? 'selected' : '' }}>41 · Jarro</option>
                                          <option value="42" {{ old('tipo_bulto') == '42' ? 'selected' : '' }}>42 · Frasco</option>
                                          <option value="43" {{ old('tipo_bulto') == '43' ? 'selected' : '' }}>43 · Damajuana</option>
                                          <option value="44" {{ old('tipo_bulto') == '44' ? 'selected' : '' }}>44 · Barril</option>
                                          <option value="45" {{ old('tipo_bulto') == '45' ? 'selected' : '' }}>45 · Tambor</option>
                                          <option value="46" {{ old('tipo_bulto') == '46' ? 'selected' : '' }}>46 · Cuñetes</option>
                                          <option value="47" {{ old('tipo_bulto') == '47' ? 'selected' : '' }}>47 · Tarros</option>
                                          <option value="51" {{ old('tipo_bulto') == '51' ? 'selected' : '' }}>51 · Cubo</option>
                                          <option value="61" {{ old('tipo_bulto') == '61' ? 'selected' : '' }}>61 · Paquete</option>
                                          <option value="62" {{ old('tipo_bulto') == '62' ? 'selected' : '' }}>62 · Sacos</option>
                                          <option value="63" {{ old('tipo_bulto') == '63' ? 'selected' : '' }}>63 · Maleta</option>
                                          <option value="64" {{ old('tipo_bulto') == '64' ? 'selected' : '' }}>64 · Bolsa</option>
                                          <option value="65" {{ old('tipo_bulto') == '65' ? 'selected' : '' }}>65 · Bala</option>
                                          <option value="66" {{ old('tipo_bulto') == '66' ? 'selected' : '' }}>66 · Red</option>
                                          <option value="67" {{ old('tipo_bulto') == '67' ? 'selected' : '' }}>67 · Sobres</option>
                                          <option value="73" {{ old('tipo_bulto') == '73' ? 'selected' : '' }}>73 · Contenedor De 20 Pies Dry</option>
                                          <option value="74" {{ old('tipo_bulto') == '74' ? 'selected' : '' }}>74 · Contenedor De 40 Pies Dry</option>
                                          <option value="75" {{ old('tipo_bulto') == '75' ? 'selected' : '' }}>75 · Contenedor Refrigerado 20 Pies</option>
                                          <option value="76" {{ old('tipo_bulto') == '76' ? 'selected' : '' }}>76 · Contenedor Refrigerado 40 Pies</option>
                                          <option value="77" {{ old('tipo_bulto') == '77' ? 'selected' : '' }}>77 · Estanque (No Utilizar Para Contenedor Tank)</option>
                                          <option value="78" {{ old('tipo_bulto') == '78' ? 'selected' : '' }}>78 · Contenedor No Especificado (Open Top, Tank, Flat Rack, Etc.)</option>
                                          <option value="80" {{ old('tipo_bulto') == '80' ? 'selected' : '' }}>80 · Pallet</option>
                                          <option value="81" {{ old('tipo_bulto') == '81' ? 'selected' : '' }}>81 · Tablero</option>
                                          <option value="82" {{ old('tipo_bulto') == '82' ? 'selected' : '' }}>82 · Laminas</option>
                                          <option value="83" {{ old('tipo_bulto') == '83' ? 'selected' : '' }}>83 · Carrete</option>
                                          <option value="85" {{ old('tipo_bulto') == '85' ? 'selected' : '' }}>85 · Automotor</option>
                                          <option value="86" {{ old('tipo_bulto') == '86' ? 'selected' : '' }}>86 · Ataud</option>
                                          <option value="88" {{ old('tipo_bulto') == '88' ? 'selected' : '' }}>88 · Maquinaria</option>
                                          <option value="89" {{ old('tipo_bulto') == '89' ? 'selected' : '' }}>89 · Planchas</option>
                                          <option value="90" {{ old('tipo_bulto') == '90' ? 'selected' : '' }}>90 · Atados</option>
                                          <option value="91" {{ old('tipo_bulto') == '91' ? 'selected' : '' }}>91 · Bobina</option>
                                          <option value="93" {{ old('tipo_bulto') == '93' ? 'selected' : '' }}>93 · Otros Bultos No Especificados</option>
                                          <option value="98" {{ old('tipo_bulto') == '98' ? 'selected' : '' }}>98 · No Existe Bulto</option>
                                          <option value="99" {{ old('tipo_bulto') == '99' ? 'selected' : '' }}>99 · Sin Embalar</option>
                                       </select>
                                       @error('tipo_bulto')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Valor FOB (USD)</label>
                                       <input type="number" class="form-control bg-white text-dark border" id="valor_fob" name="valor_fob" 
                                          value="{{ old('valor_fob') }}" required min="0" max="10000000" step="0.01">
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Comentario</label>
                                       <textarea name="comentario" id="comentario" rows="3" class="form-control bg-white text-dark border @error('comentario') is-invalid @enderror" placeholder="Ingrese comentarios">{{ old('comentario') }}</textarea>
                                       @error('comentario')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                    </div>
                                 </div>
                                 <!-- Columna Derecha -->
                                 <div class="col-md-6">
                                    <div class="mb-3">
                                       <label class="form-label">Ingreso al Depósito</label>
                                       <div class="input-group">
                                          <input type="text" name="ingreso_deposito" id="ingreso_deposito" class="form-control bg-white text-dark border @error('ingreso_deposito') is-invalid @enderror" value="{{ old('ingreso_deposito', date('d/m/Y H:i')) }}" required>
                                          <span class="input-group-text"><i class="material-icons">schedule</i></span>
                                       </div>
                                       @error('ingreso_deposito')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Aduana de Ingreso</label>
                                       <select name="aduana_ingreso" id="aduana_ingreso" class="form-control bg-white text-dark border @error('aduana_ingreso') is-invalid @enderror" required>
                                          <option value="">Seleccione aduana</option>
                                          @foreach($aduanas as $aduana)
                                          <option value="{{ $aduana->codigo }}" {{ old('aduana_ingreso') == $aduana->codigo ? 'selected' : '' }}>
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
                                       <input type="text" name="eir" id="eir" class="form-control bg-white text-dark border @error('eir') is-invalid @enderror" value="{{ old('eir') }}" placeholder="Recibo de intercambio de equipo" maxlength="50">
                                       @error('eir')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">TATC Destino</label>
                                       <input type="text" name="tatc_destino" id="tatc_destino" class="form-control bg-white text-dark border @error('tatc_destino') is-invalid @enderror" value="{{ old('tatc_destino') }}" placeholder="Ingrese el TATC de Destino" maxlength="12">
                                       @error('tatc_destino')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Tamaño Contenedor</label>
                                       <div class="form-check">
                                          <input type="radio" name="tamano_contenedor" value="20" class="form-check-input" checked>
                                          <label class="form-check-label">20 Pies</label>
                                       </div>
                                       <div class="form-check">
                                          <input type="radio" name="tamano_contenedor" value="40" class="form-check-input">
                                          <label class="form-check-label">40 Pies</label>
                                       </div>
                                       <div class="form-check">
                                          <input type="radio" name="tamano_contenedor" value="45" class="form-check-input">
                                          <label class="form-check-label">45 Pies</label>
                                       </div>
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Puerto de Ingreso</label>
                                       <input type="text" name="puerto_ingreso" id="puerto_ingreso" class="form-control bg-white text-dark border @error('puerto_ingreso') is-invalid @enderror" value="{{ old('puerto_ingreso') }}" placeholder="Puerto de Ingreso" maxlength="100" required>
                                       @error('puerto_ingreso')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Estado Contenedor</label>
                                       <div class="form-check">
                                          <input type="radio" name="estado_contenedor" value="OP" class="form-check-input" checked>
                                          <label class="form-check-label">[OP] Operativo</label>
                                       </div>
                                       <div class="form-check">
                                          <input type="radio" name="estado_contenedor" value="DM" class="form-check-input">
                                          <label class="form-check-label">[DM] Dañado</label>
                                       </div>
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Año de Fabricación</label>
                                       <input type="number" class="form-control bg-white text-dark border" id="anio_fabricacion" name="anio_fabricacion" 
                                          value="{{ old('anio_fabricacion') }}" min="1900" max="{{ date('Y') + 1 }}" maxlength="4">
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Ubicación Física Contenedor</label>
                                       <select name="ubicacion_fisica" id="ubicacion_fisica" class="form-control bg-white text-dark border @error('ubicacion_fisica') is-invalid @enderror" required>
                                          <option value="">Seleccione ubicación</option>
                                          @foreach($lugaresDeposito as $lugar)
                                          <option value="{{ $lugar->nombre_deposito }}" {{ old('ubicacion_fisica') == $lugar->nombre_deposito ? 'selected' : '' }}>
                                          {{ $lugar->nombre_deposito }} ({{ $lugar->direccion }})
                                          </option>
                                          @endforeach
                                       </select>
                                       @error('ubicacion_fisica')
                                       <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                    </div>
                                    <div class="mb-3">
                                       <label class="form-label">Valor CIF (USD)</label>
                                       <input type="number" class="form-control bg-white text-dark border" id="valor_cif" name="valor_cif" 
                                          value="{{ old('valor_cif') }}" readonly step="0.01">
                                       <small class="form-text text-muted">Se calcula automáticamente (FOB + 7%)</small>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- Tab Transporte -->
                           <div class="tab-pane fade" id="transporte" role="tabpanel">
                              <div class="row mt-3">
                                 <div class="col-md-6 mb-3">
                                    <label class="form-label">Empresa Transportista</label>
                                    <select name="empresa_transportista" id="empresa_transportista" class="form-control bg-white text-dark border @error('empresa_transportista') is-invalid @enderror">
                                       <option value="">--</option>
                                       @foreach($empresasTransportistas as $empresa)
                                       <option value="{{ $empresa->id }}" {{ old('empresa_transportista') == $empresa->id ? 'selected' : '' }}>
                                       {{ $empresa->nombre_empresa }}
                                       </option>
                                       @endforeach
                                    </select>
                                    @error('empresa_transportista')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                 </div>
                                 <div class="col-md-6 mb-3">
                                    <label class="form-label">Rut del Chofer</label>
                                    <div class="input-group">
                                       <span class="input-group-text"><i class="material-icons">search</i></span>
                                       <input type="text" name="rut_chofer" id="rut_chofer" class="form-control bg-white text-dark border @error('rut_chofer') is-invalid @enderror" value="{{ old('rut_chofer') }}" placeholder="Rut del Chofer" maxlength="20">
                                    </div>
                                    @error('rut_chofer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                 </div>
                                 <div class="col-md-6 mb-3">
                                    <label class="form-label">Patente Camión</label>
                                    <input type="text" name="patente_camion" id="patente_camion" class="form-control bg-white text-dark border @error('patente_camion') is-invalid @enderror" value="{{ old('patente_camion') }}" placeholder="Ingrese Patente del Camión" maxlength="20">
                                    @error('patente_camion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                 </div>
                                 <div class="col-md-6 mb-3">
                                    <label class="form-label">Documento de Transporte</label>
                                    <input type="text" name="documento_transporte" id="documento_transporte" class="form-control bg-white text-dark border @error('documento_transporte') is-invalid @enderror" value="{{ old('documento_transporte') }}" placeholder="Ingrese Documento de Transporte" maxlength="50">
                                    @error('documento_transporte')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Botones de acción -->
                        <div class="row mt-4">
                           <div class="col-12 text-end">
                              <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                              <i class="material-icons">arrow_back</i> Cancelar
                              </button>
                              <button type="submit" class="btn btn-primary">
                              <i class="material-icons">check</i> Agregar
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
   <!-- Modal de Confirmación -->
   <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header bg-success text-white">
               <h5 class="modal-title" id="successModalLabel">
                  <i class="fas fa-check-circle"></i> TATC Registrado Exitosamente
               </h5>
               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <p>El TATC ha sido registrado correctamente en el sistema.</p>
               <p><strong>Número TATC:</strong> <span id="tatcNumber"></span></p>
               <p>Será redirigido al listado de TATCs en unos segundos...</p>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
               <a href="{{ route('tatc.index') }}" class="btn btn-primary">Ver Listado</a>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal de Error -->
   <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header bg-danger text-white">
               <h5 class="modal-title" id="errorModalLabel">
                  <i class="fas fa-exclamation-triangle"></i> Error al Registrar TATC
               </h5>
               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <p id="errorMessage">Ha ocurrido un error al registrar el TATC. Por favor, intente nuevamente.</p>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
         </div>
      </div>
   </div>
   <script>
      // Mostrar modal de éxito si hay mensaje de éxito
      @if(session('success'))
          document.addEventListener('DOMContentLoaded', function() {
              var successModal = new bootstrap.Modal(document.getElementById('successModal'));
              document.getElementById('tatcNumber').textContent = '{{ session("success") }}';
              successModal.show();
              
              // Redirigir al listado después de 3 segundos
              setTimeout(function() {
                  window.location.href = '{{ route("tatc.index") }}';
              }, 3000);
          });
      @endif
      
      // Mostrar modal de error si hay mensaje de error
      @if(session('error'))
          document.addEventListener('DOMContentLoaded', function() {
              var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
              document.getElementById('errorMessage').textContent = '{{ session("error") }}';
              errorModal.show();
          });
      @endif
   </script>
</x-layout>
<!-- JavaScript para TATC -->
<script>
   // Esperar a que el DOM esté listo
   document.addEventListener('DOMContentLoaded', function() {
       console.log('DOM Content Loaded');
       
       // Verificar jQuery después del DOM
       if (typeof $j === 'undefined') {
           console.error('ERROR: $j no está disponible después del DOM');
           return;
       }
       
       // Función simple para probar
       function testFunction() {
           console.log('Función de prueba ejecutada');
           alert('JavaScript funciona!');
       }
       
       // Probar inputmask
       if ($j("#numero_contenedor").length) {
           console.log('Configurando inputmask para contenedor...');
           try {
               // Aplicar inputmask exactamente como en Mitac
               $j("#numero_contenedor").inputmask("AAAA999999-9");
               console.log('Inputmask aplicado exitosamente');
               
               // Agregar validación al perder el foco (blur) como en Mitac
               $j("#numero_contenedor").blur(function() {
                   var nn = $j(this).val().replace("_","");
                   
                   if (nn.length != 12) {
                       $j(this).css("background-color", "#FD7F83");
                       console.log('Contenedor inválido - longitud incorrecta');
                   } else {
                       $j(this).css("background-color", "#FFFFFF");
                       console.log('Contenedor válido');
                   }
               });
               
           } catch (error) {
               console.error('Error aplicando inputmask:', error);
           }
       }
       
       // Probar cálculo CIF
       if ($j("#valor_fob").length) {
           console.log('Configurando cálculo CIF...');
           $j('#valor_fob').on('input', function() {
               console.log('Valor FOB cambiado:', $j(this).val());
               var valorFob = parseFloat($j(this).val()) || 0;
               var valorCif = valorFob * 1.07;
               $j('#valor_cif').val(valorCif.toFixed(2));
               console.log('CIF calculado:', valorCif);
           });
       }
       
       // Probar generación TATC
       if ($j("#aduana_ingreso").length) {
           console.log('Configurando generación TATC...');
           $j('#aduana_ingreso').on('change', function() {
               console.log('Aduana cambiada:', $j(this).val());
               var aduana = $j(this).val();
               if (aduana) {
                   // Llamar al endpoint AJAX para generar el número TATC
                   $j.ajax({
                       url: '{{ route("tatc.generar-numero") }}',
                       method: 'POST',
                       data: {
                           aduana_ingreso: aduana,
                           _token: '{{ csrf_token() }}'
                       },
                       success: function(response) {
                           if (response.success) {
                               $j("#numero_tatc").val(response.numero_tatc);
                               console.log('TATC generado via AJAX:', response.numero_tatc);
                           } else {
                               console.error('Error generando TATC:', response.error);
                               alert('Error generando número TATC: ' + response.error);
                           }
                       },
                       error: function(xhr, status, error) {
                           console.error('Error en la petición AJAX:', error);
                           alert('Error en la comunicación con el servidor');
                       }
                   });
               }
           });
       }
       
       console.log('=== FIN CONFIGURACIÓN ===');
   });
   
   // También probar con window.onload
   window.onload = function() {
       console.log('Window loaded');
       console.log('jQuery en window.onload:', typeof $j !== 'undefined');
   };
</script>