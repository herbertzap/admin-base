<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='procedimientos-operacion'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Procedimiento de Operación del Sistema"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <!-- Header -->
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="mb-0">Procedimiento de Operación del Sistema</h4>
                                    <p class="text-sm mb-0">CONTENEDORES PRICER</p>
                                    <p class="text-xs text-muted">Versión 2.0 | {{ now()->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-6 text-end">
                                    <button onclick="window.print()" class="btn btn-primary btn-sm">
                                        🖨️ Imprimir
                                    </button>
                                    <a href="{{ route('procedimientos-operacion.pdf') }}" class="btn btn-success btn-sm">
                                        📄 Descargar PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 1. Introducción -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">1. Introducción</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>CONTENEDORES PRICER</strong> es una plataforma computacional desarrollada para la gestión, administración y control de operaciones con contenedores en Aduana, conforme a la Resolución Exenta Nº 3.438/13.09.2024 del Servicio Nacional de Aduanas.</p>
                            
                            <p>Este documento describe los procedimientos de operación del sistema para garantizar el correcto funcionamiento de todas las funcionalidades y el cumplimiento de los requisitos establecidos por la normativa aduanera.</p>
                        </div>
                    </div>

                    <!-- 2. Acceso al Sistema -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">2. Acceso al Sistema</h5>
                        </div>
                        <div class="card-body">
                            <h6>2.1 Inicio de Sesión</h6>
                            <ol>
                                <li>Acceder a la URL del sistema: <code>https://contenedores.pricer.cl</code></li>
                                <li>Ingresar el correo electrónico registrado</li>
                                <li>Ingresar la contraseña asignada</li>
                                <li>Hacer clic en "Iniciar Sesión"</li>
                            </ol>

                            <h6>2.2 Recuperación de Contraseña</h6>
                            <ol>
                                <li>Hacer clic en "¿Olvidaste tu contraseña?"</li>
                                <li>Ingresar el correo electrónico registrado</li>
                                <li>Revisar el correo electrónico para recibir el enlace de recuperación</li>
                                <li>Seguir las instrucciones para restablecer la contraseña</li>
                            </ol>

                            <div class="alert alert-warning">
                                <strong>⚠️ Importante:</strong> Las contraseñas deben tener mínimo 8 caracteres y cumplir con las políticas de seguridad establecidas.
                            </div>
                        </div>
                    </div>

                    <!-- 3. Operaciones Diarias -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">3. Operaciones Diarias del Sistema</h5>
                        </div>
                        <div class="card-body">
                            <h6>3.1 Gestión de TATCs (Títulos de Admisión Temporal de Contenedores)</h6>
                            <ul>
                                <li><strong>Creación:</strong> Ingresar a "TATCs" → "Crear Nuevo" y completar el formulario con todos los datos requeridos</li>
                                <li><strong>Edición:</strong> Seleccionar el TATC deseado y hacer clic en "Editar"</li>
                                <li><strong>Consulta:</strong> Utilizar los filtros de búsqueda para encontrar TATCs específicos</li>
                                <li><strong>Exportación:</strong> Generar reportes en formato Excel desde el módulo de consultas</li>
                            </ul>

                            <h6>3.2 Gestión de TSTCs (Títulos de Salida Temporal de Contenedores)</h6>
                            <ul>
                                <li><strong>Creación:</strong> Ingresar a "TSTCs" → "Crear Nuevo" y completar el formulario</li>
                                <li><strong>Edición:</strong> Modificar TSTCs existentes según sea necesario</li>
                                <li><strong>Consulta:</strong> Buscar y filtrar TSTCs por diferentes criterios</li>
                            </ul>

                            <h6>3.3 Registro de Salidas</h6>
                            <ul>
                                <li><strong>Declaración de Internación:</strong> Registrar salidas por Declaración de Internación</li>
                                <li><strong>Cancelación:</strong> Registrar cancelaciones de TATCs</li>
                                <li><strong>Traspaso:</strong> Registrar traspasos entre operadores, incluyendo código de operador origen y destino</li>
                            </ul>

                            <h6>3.4 Control de Plazos</h6>
                            <ul>
                                <li><strong>Plazos de Vigencia:</strong> Consultar TATCs y TSTCs vigentes</li>
                                <li><strong>Prórrogas:</strong> Solicitar y gestionar prórrogas de vigencia</li>
                                <li><strong>Registro de Cancelación:</strong> Ver registro de contenedores cancelados</li>
                                <li><strong>Registro de Traspaso:</strong> Consultar historial de traspasos</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 4. Módulo de Consultas para Fiscalización -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">4. Módulo de Consultas para Fiscalización</h5>
                        </div>
                        <div class="card-body">
                            <h6>4.1 Informe de Movimientos</h6>
                            <p>El módulo de consultas permite realizar búsquedas avanzadas con múltiples filtros:</p>
                            <ul>
                                <li><strong>Filtro por Vigencia:</strong> Filtrar títulos vigentes, vencidos o por vencer (30 días)</li>
                                <li><strong>Filtro por Fecha de Vencimiento:</strong> Buscar por rango de fechas de vencimiento</li>
                                <li><strong>Filtro por Prórrogas:</strong> Filtrar títulos con o sin prórrogas</li>
                                <li><strong>Filtro por Tipo de Título:</strong> TATC o TSTC</li>
                                <li><strong>Filtro por Aduana:</strong> Filtrar por aduana de ingreso o salida</li>
                                <li><strong>Filtro por Contenedor:</strong> Buscar por número de contenedor</li>
                                <li><strong>Filtro por Fechas:</strong> Filtrar por fecha de ingreso o salida</li>
                            </ul>

                            <h6>4.2 Búsqueda y Extracción</h6>
                            <p>Utilizar los mismos filtros del Informe de Movimientos para realizar búsquedas específicas y exportar resultados.</p>

                            <h6>4.3 Exportación de Datos</h6>
                            <ol>
                                <li>Aplicar los filtros deseados</li>
                                <li>Hacer clic en "EXPORTAR" para generar un archivo Excel</li>
                                <li>Descargar y guardar el archivo generado</li>
                            </ol>
                        </div>
                    </div>

                    <!-- 5. Integración HERMES -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">5. Integración con HERMES</h5>
                        </div>
                        <div class="card-body">
                            <h6>5.1 Funcionamiento Automático</h6>
                            <p>El sistema se integra automáticamente con HERMES, enviando mensajes en tiempo real para todas las operaciones:</p>
                            <ul>
                                <li><strong>TATC Type 01:</strong> Creación de nuevos TATCs</li>
                                <li><strong>TATC Type 02:</strong> Modificaciones, cancelaciones y traspasos</li>
                                <li><strong>TSTC:</strong> Gestión de TSTCs</li>
                                <li><strong>Salidas:</strong> Registro de salidas de contenedores</li>
                            </ul>

                            <h6>5.2 Monitoreo de HERMES</h6>
                            <ol>
                                <li>Acceder a "HERMES" → "Monitor" para ver estadísticas</li>
                                <li>Revisar el historial de mensajes en "HERMES" → "Historial"</li>
                                <li>Verificar el estado de los mensajes enviados</li>
                                <li>Reintentar mensajes fallidos si es necesario</li>
                            </ol>

                            <div class="alert alert-info">
                                <strong>💡 Nota:</strong> Todos los mensajes se envían automáticamente. En caso de fallo, el sistema intentará reenviar automáticamente.
                            </div>
                        </div>
                    </div>

                    <!-- 6. Gestión de Usuarios -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">6. Gestión de Usuarios</h6>
                        </div>
                        <div class="card-body">
                            <h6>6.1 Creación de Usuarios</h6>
                            <ol>
                                <li>Acceder a "Gestión de Usuarios" (requiere permisos de administrador)</li>
                                <li>Hacer clic en "Crear Nuevo Usuario"</li>
                                <li>Completar todos los datos requeridos</li>
                                <li>Asignar roles y permisos</li>
                                <li>Asignar operador (O.C.) si corresponde</li>
                                <li>Guardar el usuario</li>
                            </ol>

                            <h6>6.2 Edición de Usuarios</h6>
                            <ol>
                                <li>Seleccionar el usuario a editar</li>
                                <li>Hacer clic en "Editar"</li>
                                <li>Modificar los datos necesarios</li>
                                <li>Actualizar roles y permisos si es necesario</li>
                                <li>Guardar los cambios</li>
                            </ol>

                            <h6>6.3 Cambio de Contraseñas</h6>
                            <ol>
                                <li>Acceder al perfil del usuario</li>
                                <li>Hacer clic en "Cambiar Contraseña"</li>
                                <li>Ingresar la contraseña actual</li>
                                <li>Ingresar la nueva contraseña (mínimo 8 caracteres)</li>
                                <li>Confirmar la nueva contraseña</li>
                                <li>Guardar los cambios</li>
                            </ol>
                        </div>
                    </div>

                    <!-- 7. Mantenimiento y Soporte -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">7. Mantenimiento y Soporte</h5>
                        </div>
                        <div class="card-body">
                            <h6>7.1 Sistema de Tickets</h6>
                            <p>Para reportar problemas o solicitar soporte:</p>
                            <ol>
                                <li>Acceder a "Sistema de Tickets"</li>
                                <li>Hacer clic en "Nuevo Ticket"</li>
                                <li>Describir el problema o solicitud</li>
                                <li>Adjuntar archivos si es necesario</li>
                                <li>Enviar el ticket</li>
                            </ol>

                            <h6>7.2 Consulta del Manual</h6>
                            <p>El sistema incluye un manual completo disponible en "Manual del Sistema" que contiene información detallada sobre todas las funcionalidades.</p>

                            <h6>7.3 Procedimientos de Respaldo</h6>
                            <p>Los procedimientos de respaldo están documentados en "Procedimientos de Respaldo", incluyendo información sobre respaldos automáticos y manuales.</p>
                        </div>
                    </div>

                    <!-- 8. Consideraciones Importantes -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">8. Consideraciones Importantes</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <h6>⚠️ Aspectos Críticos:</h6>
                                <ul>
                                    <li>Todos los datos deben ser ingresados correctamente antes de guardar</li>
                                    <li>El sistema valida automáticamente los datos antes de enviar a HERMES</li>
                                    <li>Los traspasos deben incluir el código del operador de origen y destino</li>
                                    <li>Las consultas de fiscalización deben utilizar los filtros disponibles para obtener resultados precisos</li>
                                    <li>Las prórrogas solo aplican a TATCs, no a TSTCs</li>
                                </ul>
                            </div>

                            <div class="alert alert-info">
                                <h6>💡 Buenas Prácticas:</h6>
                                <ul>
                                    <li>Revisar los datos antes de guardar cualquier operación</li>
                                    <li>Utilizar los filtros de consulta para obtener información precisa</li>
                                    <li>Exportar reportes regularmente para mantener registros</li>
                                    <li>Mantener las contraseñas seguras y actualizadas</li>
                                    <li>Reportar problemas a través del sistema de tickets</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

