<x-layout>
   <x-navbars.sidebar activePage="registrar-tatc"></x-navbars.sidebar>
   <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
      <x-navbars.navs.auth titlePage="Carga Masiva de TATC"></x-navbars.navs.auth>
      <div class="container-fluid py-4">
         <div class="row">
            <div class="col-12">
               <div class="card mb-4">
                  <div class="card-header pb-0">
                     <div class="row">
                        <div class="col-6">
                           <h6>Carga Masiva de Contenedores (TATC) - {{ Auth::user()->operador ? Auth::user()->operador->nombre_operador : 'Sin operador asignado' }}</h6>
                        </div>
                        <div class="col-6 text-end">
                           <div class="dropdown">
                              <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                              Opciones
                              </button>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="{{ route('tatc.create') }}">Nuevo TATC</a></li>
                                 <li><a class="dropdown-item" href="{{ route('tatc.index') }}">Ver Lista</a></li>
                                 <li><a class="dropdown-item" href="{{ route('tatc.consulta') }}">Consulta</a></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                           <strong>Éxito!</strong> {{ session('success') }}
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                     @endif

                     @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                           <strong>Error!</strong> {{ session('error') }}
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                     @endif

                     @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                           <strong>Por favor corrija los siguientes errores:</strong>
                           <ul class="mb-0">
                              @foreach ($errors->all() as $error)
                                 <li>{{ $error }}</li>
                              @endforeach
                           </ul>
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                     @endif

                     <div class="row">
                        <div class="col-lg-8 mx-auto">
                           <div class="card">
                              <div class="card-header">
                                 <h5 class="mb-0">Cargar Archivo Excel</h5>
                              </div>
                              <div class="card-body">
                                 <form method="POST" action="{{ route('tatc.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="tipo_carga" value="masiva">
                                    
                                    <div class="mb-3">
                                       <label for="archivo_excel" class="form-label">Seleccione el archivo Excel</label>
                                       <input type="file" class="form-control" id="archivo_excel" name="archivo_excel" accept=".xlsx,.xls" required>
                                       <small class="text-muted">Formatos permitidos: .xlsx, .xls (Máximo 10MB)</small>
                                    </div>

                                    <div class="alert alert-info" role="alert">
                                       <h6 class="alert-heading">Formato del archivo Excel:</h6>
                                       <p class="mb-0">El archivo debe contener las siguientes columnas:</p>
                                       <ul class="mt-2 mb-0">
                                          <li><strong>Número Contenedor</strong></li>
                                          <li><strong>Tipo Contenedor</strong></li>
                                          <li><strong>Tipo Ingreso</strong> (traspaso/desembarque)</li>
                                          <li><strong>Ingreso País</strong> (formato: dd/mm/yyyy HH:mm)</li>
                                          <li><strong>Ingreso Depósito</strong> (formato: dd/mm/yyyy HH:mm)</li>
                                          <li><strong>Fecha Traspaso</strong> (formato: dd/mm/yyyy)</li>
                                          <li><strong>Aduana Ingreso</strong> (código de aduana)</li>
                                          <li>Otros campos opcionales según el formato estándar</li>
                                       </ul>
                                    </div>

                                    <div class="mb-3">
                                       <a href="#" class="btn btn-sm btn-outline-primary">
                                          <i class="fa fa-download me-1"></i> Descargar Plantilla Excel
                                       </a>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                       <a href="{{ route('tatc.index') }}" class="btn btn-secondary">
                                          <i class="fa fa-arrow-left me-1"></i> Volver
                                       </a>
                                       <button type="submit" class="btn btn-primary">
                                          <i class="fa fa-upload me-1"></i> Cargar Archivo
                                       </button>
                                    </div>
                                 </form>
                              </div>
                           </div>

                           <div class="card mt-4">
                              <div class="card-header">
                                 <h5 class="mb-0">Instrucciones</h5>
                              </div>
                              <div class="card-body">
                                 <ol>
                                    <li>Descargue la plantilla Excel haciendo clic en el botón "Descargar Plantilla Excel"</li>
                                    <li>Complete los datos de los contenedores en el archivo Excel</li>
                                    <li>Asegúrese de que las fechas estén en el formato correcto (dd/mm/yyyy HH:mm para fechas con hora, dd/mm/yyyy para fechas simples)</li>
                                    <li>Verifique que los códigos de aduana sean correctos</li>
                                    <li>Suba el archivo completado usando el formulario anterior</li>
                                    <li>El sistema validará cada registro y le mostrará los resultados</li>
                                 </ol>
                                 <div class="alert alert-warning mt-3" role="alert">
                                    <strong>Importante:</strong> El proceso de carga puede tardar varios minutos dependiendo de la cantidad de registros. Por favor no cierre la ventana mientras se procesa el archivo.
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </main>
</x-layout>



