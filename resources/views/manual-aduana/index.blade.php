<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='manual-aduana'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Manual de Usuario - Aduana"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <!-- Header -->
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="mb-0">Manual de Usuario para Aduana</h4>
                                    <p class="text-sm mb-0">CONTENEDORES PRICER</p>
                                    <p class="text-xs text-muted">Versión 2.0 | {{ now()->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-6 text-end">
                                    <button onclick="window.print()" class="btn btn-primary btn-sm">
                                        🖨️ Imprimir
                                    </button>
                                    <a href="{{ route('manual-aduana.pdf') }}" class="btn btn-success btn-sm">
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
                            <p>Este manual está dirigido específicamente a los funcionarios de Aduana que utilizan el sistema <strong>CONTENEDORES PRICER</strong> para realizar consultas y fiscalización de operaciones con contenedores.</p>
                            
                            <p>Para información general del sistema, consulte el <strong>Manual del Sistema</strong> disponible en el menú principal.</p>

                            <div class="alert alert-info">
                                <strong>⚠️ Importante:</strong> Este manual describe únicamente las funcionalidades de consulta disponibles para el perfil de Aduana. Las operaciones de creación y modificación están restringidas según los permisos asignados.
                            </div>
                        </div>
                    </div>

                    <!-- 3. Módulo de Control de Fiscalización -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">3. Módulo de Control de Fiscalización</h5>
                        </div>
                        <div class="card-body">
                            <p>Este módulo es el principal para realizar consultas y fiscalización de operaciones. Permite generar reportes detallados con múltiples filtros.</p>

                            <h6>3.1 Informe de Movimientos</h6>
                            <p>Acceso: <strong>Control de Fiscalización → Informe de Movimientos</strong></p>
                            
                            <p>Este módulo permite consultar todos los movimientos de contenedores con filtros avanzados:</p>

                            <h6>Filtros Disponibles:</h6>
                            <ul>
                                <li><strong>Tipos de Títulos:</strong> TATC, TSTC o Todos</li>
                                <li><strong>Tipos de Movimiento:</strong>
                                    <ul>
                                        <li>Ingresados: Contenedores que ingresaron al país</li>
                                        <li>Salida por DI: Salidas por Declaración de Internación</li>
                                        <li>Salida por Cancelación: TATCs cancelados</li>
                                        <li>Salida por Traspaso: Transferencias entre operadores</li>
                                    </ul>
                                </li>
                                <li><strong>Vigencia de Títulos:</strong>
                                    <ul>
                                        <li>Vigentes: Títulos que aún no han vencido</li>
                                        <li>Vencidos: Títulos que han superado su fecha de vencimiento</li>
                                        <li>Por Vencer (30 días): Títulos que vencen en los próximos 30 días</li>
                                        <li>Con Prórroga: Títulos que tienen prórrogas activas</li>
                                    </ul>
                                </li>
                                <li><strong>Fecha de Vencimiento:</strong> Rango desde/hasta para filtrar por fecha de vencimiento</li>
                                <li><strong>Con Prórroga:</strong> Filtrar títulos con o sin prórrogas</li>
                                <li><strong>Filtro por Fechas:</strong> Rango de fechas de ingreso o salida (con selector predefinido)</li>
                                <li><strong>Aduana de Ingreso:</strong> Filtrar por aduana de ingreso</li>
                                <li><strong>Aduana de Salida:</strong> Filtrar por aduana de salida</li>
                                <li><strong>Lugar de Depósito:</strong> Filtrar por lugar de depósito</li>
                                <li><strong>Número de Contenedor:</strong> Búsqueda por número completo o parcial</li>
                                <li><strong>Número TATC/TSTC:</strong> Búsqueda específica por número de título</li>
                                <li><strong>Tipo de Contenedor:</strong> 20, 40 o 45 pies</li>
                                <li><strong>Estado del Contenedor:</strong> OP (Operativo) o DM (Dañado)</li>
                            </ul>

                            <h6>Proceso de Consulta:</h6>
                            <ol>
                                <li>Seleccionar los filtros deseados</li>
                                <li>Hacer clic en "FILTRAR" para aplicar los filtros</li>
                                <li>Revisar los resultados en la tabla</li>
                                <li>Ordenar por columnas haciendo clic en los encabezados</li>
                                <li>Hacer clic en "Ver" para acceder a detalles específicos</li>
                            </ol>

                            <h6>Exportación de Datos:</h6>
                            <ol>
                                <li>Aplicar los filtros deseados</li>
                                <li>Hacer clic en "EXPORTAR" para generar archivo Excel</li>
                                <li>O hacer clic en "IMPRIMIR" para generar PDF</li>
                                <li>Descargar y guardar el archivo generado</li>
                            </ol>

                            <h6>3.2 Búsqueda y Extracción</h6>
                            <p>Acceso: <strong>Control de Fiscalización → Búsqueda y Extracción</strong></p>
                            
                            <p>Herramienta especializada para localizar contenedores específicos:</p>
                            <ul>
                                <li>Búsqueda por número de contenedor</li>
                                <li>Búsqueda por número TATC/TSTC</li>
                                <li>Filtros por tipo y estado de contenedor</li>
                                <li>Filtros por aduanas y fechas</li>
                                <li>Acceso directo a información de vigencia, salidas y prórrogas</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 4. Módulo de Control de Plazos -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">4. Módulo de Control de Plazos</h5>
                        </div>
                        <div class="card-body">
                            <p>Este módulo permite consultar información sobre vigencias, cancelaciones, prórrogas y traspasos.</p>

                            <h6>4.1 Plazos de Vigencia</h6>
                            <p>Acceso: <strong>Control de Plazos → Plazos de Vigencia</strong></p>
                            
                            <p>Muestra los TATCs y TSTCs vigentes con sus fechas de vencimiento.</p>

                            <h6>Filtros Disponibles:</h6>
                            <ul>
                                <li><strong>Búsqueda:</strong> Por número TATC/TSTC, contenedor u operador</li>
                                <li><strong>Fecha de Vigencia:</strong> Rango desde/hasta para filtrar por fecha de vencimiento</li>
                                <li><strong>Aduana:</strong> Filtrar por aduana de ingreso</li>
                                <li><strong>Registros por página:</strong> 10, 25, 50 o 100 registros</li>
                            </ul>

                            <h6>Información Mostrada:</h6>
                            <ul>
                                <li>Número TATC/TSTC</li>
                                <li>Número de contenedor</li>
                                <li>Operador</li>
                                <li>Fecha de vencimiento (Vigencia)</li>
                                <li>Estado del título</li>
                            </ul>

                            <h6>4.2 Registro de Cancelaciones</h6>
                            <p>Acceso: <strong>Control de Plazos → Registro de Cancelaciones</strong></p>
                            
                            <p>Lista todos los TATCs cancelados con información detallada.</p>

                            <h6>Filtros Disponibles:</h6>
                            <ul>
                                <li><strong>Búsqueda:</strong> Por número TATC, contenedor u operador</li>
                                <li><strong>Fecha de Cancelación:</strong> Rango desde/hasta</li>
                                <li><strong>Aduana:</strong> Filtrar por aduana de ingreso</li>
                                <li><strong>Registros por página:</strong> Configurable</li>
                            </ul>

                            <h6>4.3 Registro de Prórrogas</h6>
                            <p>Acceso: <strong>Control de Plazos → Registro de Prórrogas</strong></p>
                            
                            <p>Gestiona y consulta las prórrogas solicitadas.</p>

                            <h6>Filtros Disponibles:</h6>
                            <ul>
                                <li><strong>Búsqueda:</strong> Por número de prórroga, TATC, contenedor u operador</li>
                                <li><strong>Fecha de Solicitud:</strong> Rango desde/hasta</li>
                                <li><strong>Aduana:</strong> Filtrar por aduana de ingreso</li>
                                <li><strong>Estado:</strong> Filtrar por estado de la prórroga (Pendiente, Aprobado, Rechazado, etc.)</li>
                                <li><strong>Registros por página:</strong> Configurable</li>
                            </ul>

                            <h6>Estados de Prórroga:</h6>
                            <ul>
                                <li><span class="badge bg-warning">Pendiente:</span> Prórroga solicitada, en espera de aprobación</li>
                                <li><span class="badge bg-success">Aprobado:</span> Prórroga aprobada y activa</li>
                                <li><span class="badge bg-danger">Rechazado:</span> Prórroga rechazada</li>
                            </ul>

                            <h6>4.4 Registro de Traspasos</h6>
                            <p>Acceso: <strong>Control de Plazos → Registro de Traspasos</strong></p>
                            
                            <p>Control de transferencias entre operadores.</p>

                            <h6>Filtros Disponibles:</h6>
                            <ul>
                                <li><strong>Búsqueda:</strong> Por número TATC, contenedor, operador origen o destino</li>
                                <li><strong>Fecha de Traspaso:</strong> Rango desde/hasta</li>
                                <li><strong>Aduana:</strong> Filtrar por aduana de ingreso</li>
                                <li><strong>Estado:</strong> Filtrar por estado del traspaso (Pendiente, Aprobado, Rechazado, Cancelado)</li>
                                <li><strong>Registros por página:</strong> Configurable</li>
                            </ul>

                            <h6>Información Mostrada:</h6>
                            <ul>
                                <li>TATC/TSTC origen</li>
                                <li>Número de contenedor</li>
                                <li>Operador origen (con código)</li>
                                <li>Fecha de traspaso</li>
                                <li>TATC destino</li>
                                <li>Operador destino (con código)</li>
                                <li>Estado del traspaso</li>
                            </ul>

                            <h6>Estados de Traspaso:</h6>
                            <ul>
                                <li><span class="badge bg-warning">Pendiente:</span> Traspaso registrado, en espera de aprobación</li>
                                <li><span class="badge bg-success">Aprobado:</span> Traspaso aprobado y completado</li>
                                <li><span class="badge bg-danger">Rechazado:</span> Traspaso rechazado</li>
                                <li><span class="badge bg-secondary">Cancelado:</span> Traspaso cancelado</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 5. Consulta de Detalles -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">5. Consulta de Detalles</h5>
                        </div>
                        <div class="card-body">
                            <p>Desde cualquier lista de resultados, puede acceder a los detalles completos de un registro haciendo clic en el botón "Ver" o en el número de TATC/TSTC.</p>

                            <h6>Información Disponible en Detalles:</h6>
                            <ul>
                                <li><strong>Datos del Título:</strong> Número, fecha de emisión, estado</li>
                                <li><strong>Datos del Contenedor:</strong> Número, tipo, tamaño, estado</li>
                                <li><strong>Datos del Operador:</strong> Código, nombre, información de contacto</li>
                                <li><strong>Datos de la Aduana:</strong> Aduana de ingreso, aduana de salida</li>
                                <li><strong>Información de Carga:</strong> Descripción, peso, valor</li>
                                <li><strong>Historial de Movimientos:</strong> Todas las operaciones realizadas</li>
                                <li><strong>Salidas Registradas:</strong> Historial de salidas (DI, Cancelación, Traspaso)</li>
                                <li><strong>Prórrogas:</strong> Historial de prórrogas solicitadas y aprobadas</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 6. Exportación de Información -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">6. Exportación de Información</h6>
                        </div>
                        <div class="card-body">
                            <p>El sistema permite exportar la información consultada en diferentes formatos:</p>

                            <h6>6.1 Exportación a Excel</h6>
                            <ol>
                                <li>Aplicar los filtros deseados en cualquier módulo</li>
                                <li>Hacer clic en el botón "EXPORTAR" o "Exportar"</li>
                                <li>Se generará un archivo Excel (.xlsx) con todos los datos filtrados</li>
                                <li>Descargar y guardar el archivo</li>
                            </ol>

                            <h6>6.2 Impresión PDF</h6>
                            <ol>
                                <li>Aplicar los filtros deseados</li>
                                <li>Hacer clic en el botón "IMPRIMIR" o "PDF"</li>
                                <li>Se generará un documento PDF listo para imprimir</li>
                                <li>Descargar o imprimir directamente</li>
                            </ol>

                            <div class="alert alert-info">
                                <strong>💡 Consejo:</strong> Los archivos exportados incluyen todos los filtros aplicados, facilitando el seguimiento y auditoría de las consultas realizadas.
                            </div>
                        </div>
                    </div>

                    <!-- 7. Integración HERMES -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">7. Integración con HERMES</h5>
                        </div>
                        <div class="card-body">
                            <p>El sistema se integra automáticamente con HERMES, el sistema oficial de la Aduana de Chile. Todas las operaciones se comunican en tiempo real.</p>

                            <h6>Tipos de Mensajes HERMES:</h6>
                            <ul>
                                <li><strong>TATC Type 01:</strong> Creación de nuevos TATCs</li>
                                <li><strong>TATC Type 02:</strong> Modificaciones, cancelaciones y traspasos</li>
                                <li><strong>TSTC:</strong> Gestión de TSTCs</li>
                                <li><strong>Salidas:</strong> Registro de salidas de contenedores</li>
                            </ul>

                            <h6>Monitoreo de Comunicaciones:</h6>
                            <p>Desde el módulo HERMES puede consultar:</p>
                            <ul>
                                <li>Historial de mensajes enviados</li>
                                <li>Estado de las comunicaciones</li>
                                <li>Reintentos automáticos en caso de fallo</li>
                                <li>Estadísticas de integración</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 8. Consideraciones Importantes -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">8. Consideraciones Importantes</h5>
                        </div>
                        <div class="card-body">
                            <h6>8.1 Seguridad de la Información</h6>
                            <ul>
                                <li>No compartir credenciales de acceso</li>
                                <li>Cambiar la contraseña periódicamente</li>
                                <li>Cerrar sesión al finalizar el trabajo</li>
                                <li>Reportar cualquier actividad sospechosa</li>
                            </ul>

                            <h6>8.2 Uso Responsable</h6>
                            <ul>
                                <li>Utilizar los filtros para optimizar las consultas</li>
                                <li>Exportar solo la información necesaria</li>
                                <li>Respetar la confidencialidad de los datos</li>
                                <li>Seguir los procedimientos establecidos</li>
                            </ul>

                            <h6>8.3 Soporte Técnico</h6>
                            <p>Para reportar problemas o solicitar ayuda:</p>
                            <ul>
                                <li>Utilizar el sistema de tickets integrado</li>
                                <li>Contactar al administrador del sistema</li>
                                <li>Consultar el manual completo del sistema</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>

