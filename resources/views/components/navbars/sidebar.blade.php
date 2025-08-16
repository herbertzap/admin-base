@props(['activePage'])

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('dashboard') }} ">
            <img src="{{ asset('assets') }}/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">Sistema Hermes</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Inicio -->
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <!-- Fin Inicio -->

            <!-- Configuración -->
            <li class="nav-item">
                <a class="nav-link text-white {{ in_array($activePage, ['operadores', 'user-profile', 'user-management']) ? ' active bg-gradient-primary' : '' }} " data-bs-toggle="collapse" href="#configuracionMenu" role="button" aria-expanded="{{ in_array($activePage, ['operadores', 'user-profile', 'user-management']) ? 'true' : 'false' }}" aria-controls="configuracionMenu">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">settings</i>
                    </div>
                    <span class="nav-link-text ms-1">Configuración</span>
                </a>
                <div class="collapse {{ in_array($activePage, ['operadores', 'user-profile', 'user-management']) ? 'show' : '' }}" id="configuracionMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'operadores' ? ' active bg-gradient-primary' : '' }} " href="{{ route('operadores.index') }}">
                                <span class="nav-link-text ms-1">Gestión de Operadores</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'user-profile' ? 'active bg-gradient-primary' : '' }} " href="{{ route('user-profile') }}">
                                <span class="nav-link-text ms-1">Mi Perfil</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'user-management' ? ' active bg-gradient-primary' : '' }} " href="{{ route('user-management.index') }}">
                                <span class="nav-link-text ms-1">Gestión de Usuarios</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Fin Configuración -->

            <!-- Mantenedores -->
            <li class="nav-item">
                <a class="nav-link text-white {{ in_array($activePage, ['empresas-transportistas', 'tipos-contenedores', 'aduanas-chile', 'lugares-deposito']) ? ' active bg-gradient-primary' : '' }} " data-bs-toggle="collapse" href="#mantenedoresMenu" role="button" aria-expanded="{{ in_array($activePage, ['empresas-transportistas', 'tipos-contenedores', 'aduanas-chile', 'lugares-deposito']) ? 'true' : 'false' }}" aria-controls="mantenedoresMenu">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">build</i>
                    </div>
                    <span class="nav-link-text ms-1">Mantenedores</span>
                </a>
                <div class="collapse {{ in_array($activePage, ['empresas-transportistas', 'tipos-contenedores', 'aduanas-chile', 'lugares-deposito']) ? 'show' : '' }}" id="mantenedoresMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'empresas-transportistas' ? ' active bg-gradient-primary' : '' }} " href="{{ route('empresa-transportistas.index') }}">
                                <span class="nav-link-text ms-1">Empresas Transportistas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'tipos-contenedores' ? ' active bg-gradient-primary' : '' }} " href="{{ route('tipo-contenedors.index') }}">
                                <span class="nav-link-text ms-1">Tipos de Contenedores</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'aduanas-chile' ? ' active bg-gradient-primary' : '' }} " href="{{ route('aduana-chiles.index') }}">
                                <span class="nav-link-text ms-1">Aduanas de Chile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'lugares-deposito' ? ' active bg-gradient-primary' : '' }} " href="{{ route('lugar-depositos.index') }}">
                                <span class="nav-link-text ms-1">Lugares de Depósito</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Fin Mantenedores -->
             <!-- Logística -->
            <li class="nav-item">
                <a class="nav-link text-white {{ in_array($activePage, ['logistica', 'inventario']) ? ' active bg-gradient-primary' : '' }} " data-bs-toggle="collapse" href="#logisticaMenu" role="button" aria-expanded="{{ in_array($activePage, ['logistica', 'inventario']) ? 'true' : 'false' }}" aria-controls="logisticaMenu">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">local_shipping</i>
                    </div>
                    <span class="nav-link-text ms-1">Logística</span>
                </a>
                <div class="collapse {{ in_array($activePage, ['logistica', 'inventario']) ? 'show' : '' }}" id="logisticaMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'logistica' ? ' active bg-gradient-primary' : '' }} " href="{{ route('logistica.index') }}">
                                <span class="nav-link-text ms-1">Gestión de Contenedores</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'inventario' ? ' active bg-gradient-primary' : '' }} " href="{{ route('inventario') }}">
                                <span class="nav-link-text ms-1">Revisar Inventario</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Fin Logística -->

            <!-- Ingreso TATC -->
            <li class="nav-item">
                <a class="nav-link text-white {{ in_array($activePage, ['registrar-tatc', 'actualizar-tatc', 'consulta-tatc', 'exportar-tatc', 'carga-masiva-tatc']) ? ' active bg-gradient-primary' : '' }} " data-bs-toggle="collapse" href="#tatcMenu" role="button" aria-expanded="{{ in_array($activePage, ['registrar-tatc', 'actualizar-tatc', 'consulta-tatc', 'exportar-tatc', 'carga-masiva-tatc']) ? 'true' : 'false' }}" aria-controls="tatcMenu">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">input</i>
                    </div>
                    <span class="nav-link-text ms-1">TATC</span>
                </a>
                <div class="collapse {{ in_array($activePage, ['registrar-tatc', 'actualizar-tatc', 'consulta-tatc', 'exportar-tatc', 'carga-masiva-tatc']) ? 'show' : '' }}" id="tatcMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'registrar-tatc' ? ' active bg-gradient-primary' : '' }} " href="{{ route('tatc.create') }}">
                                <span class="nav-link-text ms-1">Registrar TATC</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'actualizar-tatc' ? ' active bg-gradient-primary' : '' }} " href="{{ route('tatc.index') }}">
                                <span class="nav-link-text ms-1">Actualizar TATC</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'consulta-tatc' ? ' active bg-gradient-primary' : '' }} " href="{{ route('tatc.consulta') }}">
                                <span class="nav-link-text ms-1">Consulta General TATC</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'exportar-tatc' ? ' active bg-gradient-primary' : '' }} " href="{{ route('tatc.exportar') }}">
                                <span class="nav-link-text ms-1">Exportar TATC</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'carga-masiva-tatc' ? ' active bg-gradient-primary' : '' }} " href="{{ route('tatc.carga-masiva') }}">
                                <span class="nav-link-text ms-1">Carga Masiva TATC</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Fin Ingreso TATC -->

            <!-- Ingreso TSTC -->
            <li class="nav-item">
                <a class="nav-link text-white {{ in_array($activePage, ['registrar-tstc', 'actualizar-tstc', 'consulta-tstc', 'exportar-tstc']) ? ' active bg-gradient-primary' : '' }} " data-bs-toggle="collapse" href="#tstcMenu" role="button" aria-expanded="{{ in_array($activePage, ['registrar-tstc', 'actualizar-tstc', 'consulta-tstc', 'exportar-tstc']) ? 'true' : 'false' }}" aria-controls="tstcMenu">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">input</i>
                    </div>
                    <span class="nav-link-text ms-1">TSTC</span>
                </a>
                <div class="collapse {{ in_array($activePage, ['registrar-tstc', 'actualizar-tstc', 'consulta-tstc', 'exportar-tstc']) ? 'show' : '' }}" id="tstcMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'registrar-tstc' ? ' active bg-gradient-primary' : '' }} " href="{{ route('tstc.create') }}">
                                <span class="nav-link-text ms-1">Registrar TSTC</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'actualizar-tstc' ? ' active bg-gradient-primary' : '' }} " href="{{ route('tstc.index') }}">
                                <span class="nav-link-text ms-1">Actualizar TSTC</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'consulta-tstc' ? ' active bg-gradient-primary' : '' }} " href="{{ route('tstc.consulta') }}">
                                <span class="nav-link-text ms-1">Consulta General TSTC</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'exportar-tstc' ? ' active bg-gradient-primary' : '' }} " href="{{ route('tstc.exportar') }}">
                                <span class="nav-link-text ms-1">Exportar TSTC</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Fin Ingreso TSTC -->

            <!-- Salidas y Cancelaciones -->
            <li class="nav-item">
                <a class="nav-link text-white {{ in_array($activePage, ['registrar-salida', 'actualizar-salidas', 'consulta-salidas', 'exportar-salidas']) ? ' active bg-gradient-primary' : '' }} " data-bs-toggle="collapse" href="#salidasMenu" role="button" aria-expanded="{{ in_array($activePage, ['registrar-salida', 'actualizar-salidas', 'consulta-salidas', 'exportar-salidas']) ? 'true' : 'false' }}" aria-controls="salidasMenu">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">exit_to_app</i>
                    </div>
                    <span class="nav-link-text ms-1">Salidas y Cancelaciones</span>
                </a>
                <div class="collapse {{ in_array($activePage, ['registrar-salida', 'actualizar-salidas', 'consulta-salidas', 'exportar-salidas']) ? 'show' : '' }}" id="salidasMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'registrar-salida' ? ' active bg-gradient-primary' : '' }} " href="{{ route('salidas.create') }}">
                                <span class="nav-link-text ms-1">Registrar Salida</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'actualizar-salidas' ? ' active bg-gradient-primary' : '' }} " href="{{ route('salidas.index') }}">
                                <span class="nav-link-text ms-1">Actualizar Salidas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'consulta-salidas' ? ' active bg-gradient-primary' : '' }} " href="{{ route('salidas.consulta') }}">
                                <span class="nav-link-text ms-1">Consulta General</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ $activePage == 'exportar-salidas' ? ' active bg-gradient-primary' : '' }} " href="{{ route('salidas.exportar') }}">
                                <span class="nav-link-text ms-1">Exportar Salidas</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Fin Salidas y Cancelaciones -->

            <!-- Control de Plazos -->
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'control-plazos' ? ' active bg-gradient-primary' : '' }} " href="#">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">schedule</i>
                    </div>
                    <span class="nav-link-text ms-1">Gestión de Plazos</span>
                </a>
            </li>
            <!-- Fin Control de Plazos -->

            <!-- Control de Inventarios -->
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'inventarios' ? ' active bg-gradient-primary' : '' }} " href="#">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">inventory</i>
                    </div>
                    <span class="nav-link-text ms-1">Gestión de Inventarios</span>
                </a>
            </li>
            <!-- Fin Control de Inventarios -->

            <!-- Control de Fiscalización -->
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'fiscalizacion' ? ' active bg-gradient-primary' : '' }} " href="#">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">security</i>
                    </div>
                    <span class="nav-link-text ms-1">Fiscalización</span>
                </a>
            </li>
            <!-- Fin Control de Fiscalización -->

            <!-- Tickets Soporte -->
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'tickets' ? ' active bg-gradient-primary' : '' }} " data-bs-toggle="collapse" href="#ticketsMenu" role="button" aria-expanded="{{ $activePage == 'tickets' ? 'true' : 'false' }}" aria-controls="ticketsMenu">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">confirmation_number</i>
                    </div>
                    <span class="nav-link-text ms-1">Tickets Soporte</span>
                </a>
                <div class="collapse {{ $activePage == 'tickets' ? 'show' : '' }}" id="ticketsMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('tickets.create') }}">
                                <span class="nav-link-text ms-1">Agregar nuevo</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('tickets.index') }}">
                                <span class="nav-link-text ms-1">Revisar tickets</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Fin Tickets Soporte -->

        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <p class="text-white text-center text-xs opacity-8 mb-0">
                Sistema Hermes v1.0
            </p>
        </div>
    </div>
</aside>
