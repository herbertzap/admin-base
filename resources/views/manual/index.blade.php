<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='manual'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Manual del Sistema Contenedores.Pricer"></x-navbars.navs.auth>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header del Manual -->
            <div class="card mb-4 print-header">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="mb-0">Manual del Sistema Contenedores.Pricer</h4>
                            <p class="text-sm mb-0">Sistema de Administración de Contenedores</p>
                            <p class="text-xs text-muted">Versión 2.0 | {{ now()->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-6 text-end">
                            <button onclick="window.print()" class="btn btn-primary btn-sm print-hide">
                                🖨️ Imprimir Manual
                            </button>
                            <a href="{{ route('manual.pdf') }}" class="btn btn-success btn-sm print-hide">
                                📄 Descargar PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Contenidos -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">📋 Tabla de Contenidos</h5>
                </div>
                <div class="card-body">
                    <ol class="list-unstyled">
                        <li><strong>1. Presentación del Sistema</strong></li>
                        <li><strong>2. Control de Acceso</strong></li>
                        <li><strong>3. Recuperación de Contraseña</strong></li>
                        <li><strong>4. Pantalla Principal y Navegación</strong></li>
                        <li><strong>5. Gestión de TATCs</strong></li>
                        <li><strong>6. Gestión de TSTCs</strong></li>
                        <li><strong>7. Registro de Salidas</strong></li>
                        <li><strong>8. Control de Plazos</strong></li>
                        <li><strong>9. Control de Fiscalización</strong></li>
                        <li><strong>10. Sistema de Tickets</strong></li>
                        <li><strong>11. Integración HERMES</strong></li>
                        <li><strong>12. Procedimientos de Respaldo</strong></li>
                        <li><strong>13. Información Técnica</strong></li>
                    </ol>
                </div>
            </div>

            <!-- 1. Presentación del Sistema -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">1. Presentación del Sistema</h5>
                </div>
                <div class="card-body">
                    <p><strong>Contenedores.Pricer</strong> es una plataforma que reúne e integra todos los componentes necesarios para permitir la gestión, administración y comunicación de las operaciones con contenedores en Aduana, además de tener una gran integración con los procesos solicitados por la aduana en la resolución exenta Nº 5660 del 20 de diciembre del 2018.</p>
                    
                    <h6>Características Principales:</h6>
                    <ul>
                        <li><strong>Fácil de manejar e intuitiva</strong> - Funciona bajo el navegador web</li>
                        <li><strong>Multiplataforma</strong> - Soporte para Tablet y dispositivos móviles</li>
                        <li><strong>Sin limitaciones</strong> - No tiene limitación de tiempo ni ubicación</li>
                        <li><strong>Único requerimiento</strong> - Conexión a internet</li>
                        <li><strong>Sistema modular</strong> - Adaptado según requerimientos específicos de cada operador</li>
                        <li><strong>Integración HERMES</strong> - Comunicación automática con el sistema aduanero</li>
                    </ul>

                    <div class="alert alert-info">
                        <strong>Recomendación:</strong> Use el sistema de Ticket incluido en el sistema para reportar problemas o solicitar mejoras. Con esto estaremos en contacto en tiempo real y tendremos un historial de sus solicitudes.
                    </div>
                </div>
            </div>

            <!-- 2. Control de Acceso -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">2. Control de Acceso</h5>
                </div>
                <div class="card-body">
                    <p>Es la pantalla inicial del sistema, ésta brinda el control y la seguridad que necesita la información de cada operador. Se utiliza para validar el acceso a los usuarios autorizados al sistema.</p>
                    
                    <h6>Datos Requeridos para el Acceso:</h6>
                    <ul>
                        <li><strong>Correo Electrónico:</strong> Email registrado en el sistema</li>
                        <li><strong>Contraseña:</strong> Contraseña asignada por el administrador</li>
                    </ul>

                    <div class="alert alert-warning">
                        <strong>Importante:</strong> Para ingresar al sistema, debe digitar su correo electrónico y la contraseña correspondiente. El sistema también incluye la opción "Recordarme" para mantener la sesión activa.
                    </div>

                    <h6>Usuarios de Ejemplo:</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Correo Electrónico</th>
                                    <th>Contraseña</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Usuario 1</td>
                                    <td>operador1@contenedores.pricer.cl</td>
                                    <td>Pricer2025#Secure</td>
                                </tr>
                                <tr>
                                    <td>Usuario 2</td>
                                    <td>operador2@contenedores.pricer.cl</td>
                                    <td>Pricer2025#Secure</td>
                                </tr>
                                <tr>
                                    <td>Usuario 3</td>
                                    <td>operador3@contenedores.pricer.cl</td>
                                    <td>Pricer2025#Secure</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 3. Recuperación de Contraseña -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">3. Recuperación de Contraseña</h5>
                </div>
                <div class="card-body">
                    <p>En caso de olvidar su contraseña puede iniciar el proceso de recuperación, con el cual podremos validar su acceso y enviar las indicaciones para obtener una nueva contraseña a su correo electrónico registrado en el sistema.</p>
                    
                    <h6>Proceso de Recuperación:</h6>
                    <ol>
                        <li>Pinchar el enlace <strong>"¿Olvidaste tu contraseña?"</strong> en la pantalla de login</li>
                        <li>Ingresar su <strong>correo electrónico</strong> registrado en el sistema</li>
                        <li>El sistema enviará un email con un enlace de recuperación</li>
                        <li>Pinchar el enlace adjunto en el correo</li>
                        <li>Ingresar su nueva contraseña (mínimo 8 caracteres)</li>
                        <li>Confirmar la nueva contraseña</li>
                    </ol>
                </div>
            </div>

            <!-- 4. Pantalla Principal -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">4. Pantalla Principal y Navegación</h5>
                </div>
                <div class="card-body">
                    <p>Una vez validado el acceso al sistema, podrá ver la pantalla principal de Contenedores.Pricer, la que se compone de varias opciones:</p>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <h6>Menú Principal</h6>
                            <p>En la parte izquierda de la pantalla el sistema muestra los módulos y menús que tiene acceso con su clave.</p>
                        </div>
                        <div class="col-md-4">
                            <h6>Menú Usuario</h6>
                            <p>En la parte superior derecha, en el lugar que sale su nombre, podrá encontrar un menú con diferentes opciones, como actualizar sus datos, crear tickets o solicitar ayuda.</p>
                        </div>
                        <div class="col-md-4">
                            <h6>Mi Panel</h6>
                            <p>El sistema incluye un panel con información útil de cada módulo que compone el sistema. Al pasar el puntero del mouse por cada opción el sistema le mostrará información sobre ese contenido.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Gestión de TATCs -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">5. Gestión de TATCs</h5>
                </div>
                <div class="card-body">
                    <p>Los TATCs (Títulos de Admisión Temporal de Contenedores) son el núcleo del sistema. Aquí podrá gestionar todos los aspectos relacionados con estos documentos aduaneros.</p>
                    
                    <h6>Funcionalidades Disponibles:</h6>
                    <ul>
                        <li><strong>Crear Nuevo TATC:</strong> Formulario completo con validaciones automáticas</li>
                        <li><strong>Editar TATC:</strong> Modificar información de TATCs existentes (según permisos)</li>
                        <li><strong>Consultar TATCs:</strong> Búsqueda avanzada con filtros múltiples</li>
                        <li><strong>Exportar Datos:</strong> Generar reportes en Excel</li>
                        <li><strong>Importar Histórico:</strong> Cargar datos desde archivos Excel</li>
                        <li><strong>Generar PDF:</strong> Imprimir documentos oficiales</li>
                        <li><strong>Control de Estados:</strong> Pendiente, Aprobado, Finalizado</li>
                    </ul>

                    <h6>Datos Principales del TATC:</h6>
                    <ul>
                        <li>Número de contenedor y tipo</li>
                        <li>Datos del operador y aduana</li>
                        <li>Información del buque y viaje</li>
                        <li>Puertos de origen, destino y arribo</li>
                        <li>Descripción de la carga y peso</li>
                        <li>Datos del consignatario</li>
                        <li>Información del transportista</li>
                    </ul>

                    <h6>Proceso de Creación:</h6>
                    <ol>
                        <li>Ir a "TATCs" → "Crear Nuevo"</li>
                        <li>Completar formulario con datos del contenedor</li>
                        <li>Seleccionar operador y aduana de ingreso</li>
                        <li>Ingresar datos de la carga y transportista</li>
                        <li>Validar información ingresada</li>
                        <li>Guardar TATC</li>
                        <li>El sistema enviará automáticamente a HERMES</li>
                    </ol>
                </div>
            </div>

            <!-- 6. Gestión de TSTCs -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">6.  Gestión de TSTCs</h5>
                </div>
                <div class="card-body">
                    <p>Los TSTCs (Títulos de Salida Temporal de Contenedores) permiten gestionar las salidas de contenedores del depósito hacia el exterior del país.</p>
                    
                    <h6>Funcionalidades Disponibles:</h6>
                    <ul>
                        <li><strong>Crear Nuevo TSTC:</strong> Formulario específico para TSTCs</li>
                        <li><strong>Editar TSTC:</strong> Modificar información existente</li>
                        <li><strong>Consultar TSTCs:</strong> Búsqueda y filtrado avanzado</li>
                        <li><strong>Exportar Datos:</strong> Reportes en Excel</li>
                        <li><strong>Generar PDF:</strong> Documentos listos para impresión</li>
                        <li><strong>Control de Estados:</strong> Gestión de estados del TSTC</li>
                    </ul>

                    <h6>Datos Principales del TSTC:</h6>
                    <ul>
                        <li>Número de contenedor y tipo</li>
                        <li>Datos del operador</li>
                        <li>Fecha de emisión del TSTC</li>
                        <li>Destino del contenedor</li>
                        <li>Información de la carga (valor FOB, peso)</li>
                        <li>Datos del lugar de depósito</li>
                        <li>Información del transportista</li>
                    </ul>

                    <h6>Imprimir TSTC:</h6>
                    <p>El sistema incluye la generación automática del documento TSTC. Para esto debe pinchar el botón "Imprimir TSTC" y el sistema entregará en formato PDF el TSTC listo y firmado de forma digital para su impresión o para guardar en su computador.</p>
                </div>
            </div>

            <!-- 7. Registro de Salidas -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">7.  Registro de Salidas</h5>
                </div>
                <div class="card-body">
                    <p>En este módulo podrá realizar salidas a los TATC registrados. El sistema integra la opción de generar salidas por Declaración de Internación, por Cancelación y Salidas por Traspaso, cada una con la información solicitada por la Aduana.</p>
                    
                    <h6>Tipos de Salida:</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <h6>📋 Declaración de Internación</h6>
                            <p>Para contenedores que ingresan al país definitivamente.</p>
                        </div>
                        <div class="col-md-4">
                            <h6>❌ Cancelación</h6>
                            <p>Para cancelar un TATC existente.</p>
                        </div>
                        <div class="col-md-4">
                            <h6>🔄 Traspaso</h6>
                            <p>Para transferir contenedores entre operadores.</p>
                        </div>
                    </div>

                    <h6>Opciones de Registro:</h6>
                    <ul>
                        <li><strong>Salida Individual:</strong> Registrar salida de un TATC específico</li>
                        <li><strong>Salida Masiva:</strong> Seleccionar múltiples TATCs y procesarlos en lote</li>
                    </ul>

                    <h6>Proceso de Registro:</h6>
                    <ol>
                        <li>Ir a "Salidas" → "Crear Nueva"</li>
                        <li>Seleccionar TATC asociado</li>
                        <li>Completar tipo de salida y datos requeridos</li>
                        <li>Validar información</li>
                        <li>Guardar salida</li>
                        <li>El sistema enviará automáticamente a HERMES</li>
                    </ol>
                </div>
            </div>

            <!-- 8. Control de Plazos -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">8.  Control de Plazos</h5>
                </div>
                <div class="card-body">
                    <p>En este módulo se registran las fechas de emisión de los respectivos títulos asociando y calculando las fechas de vencimiento según la normativa aduanera.</p>
                    
                    <h6>Funcionalidades del Control de Plazos:</h6>
                    <ul>
                        <li><strong>Plazos de Vigencia:</strong> Visualización de TATCs y TSTCs vigentes con filtros avanzados</li>
                        <li><strong>Registro de Cancelaciones:</strong> Control de TATCs cancelados con filtros por fecha y aduana</li>
                        <li><strong>Registro de Prórrogas:</strong> Seguimiento de extensiones de plazo con filtros por estado</li>
                        <li><strong>Registro de Traspasos:</strong> Control de transferencias entre operadores con filtros por fecha, aduana y estado</li>
                    </ul>

                    <h6>8.1 Plazos de Vigencia</h6>
                    <p>Muestra los TATCs y TSTCs vigentes con sus fechas de vencimiento. Incluye filtros avanzados:</p>
                    <ul>
                        <li><strong>Búsqueda:</strong> Por número TATC/TSTC, contenedor u operador</li>
                        <li><strong>Fecha de Vigencia:</strong> Rango desde/hasta para filtrar por fecha de vencimiento</li>
                        <li><strong>Aduana:</strong> Filtrar por aduana de ingreso</li>
                        <li><strong>Registros por página:</strong> 10, 25, 50 o 100 registros</li>
                    </ul>
                    <p>La columna "Fecha de vencimiento (Vigencia)" muestra el estado de cada título.</p>

                    <h6>8.2 Registro de Cancelaciones</h6>
                    <p>Lista todos los TATCs cancelados con filtros:</p>
                    <ul>
                        <li><strong>Búsqueda:</strong> Por número TATC, contenedor u operador</li>
                        <li><strong>Fecha de Cancelación:</strong> Rango desde/hasta</li>
                        <li><strong>Aduana:</strong> Filtrar por aduana de ingreso</li>
                        <li><strong>Registros por página:</strong> Configurable</li>
                    </ul>

                    <h6>8.3 Registro de Prórrogas</h6>
                    <p>Gestiona las prórrogas solicitadas con filtros completos:</p>
                    <ul>
                        <li><strong>Búsqueda:</strong> Por número de prórroga, TATC, contenedor u operador</li>
                        <li><strong>Fecha de Solicitud:</strong> Rango desde/hasta</li>
                        <li><strong>Aduana:</strong> Filtrar por aduana de ingreso</li>
                        <li><strong>Estado:</strong> Filtrar por estado de la prórroga (Pendiente, Aprobado, Rechazado, etc.)</li>
                        <li><strong>Registros por página:</strong> Configurable</li>
                    </ul>

                    <h6>8.4 Registro de Traspasos</h6>
                    <p>Control de transferencias entre operadores con filtros avanzados:</p>
                    <ul>
                        <li><strong>Búsqueda:</strong> Por número TATC, contenedor, operador origen o destino</li>
                        <li><strong>Fecha de Traspaso:</strong> Rango desde/hasta</li>
                        <li><strong>Aduana:</strong> Filtrar por aduana de ingreso</li>
                        <li><strong>Estado:</strong> Filtrar por estado del traspaso (Pendiente, Aprobado, Rechazado, Cancelado)</li>
                        <li><strong>Registros por página:</strong> Configurable</li>
                    </ul>
                    <p>Los estados se muestran con colores: <span class="badge bg-success">Aprobado</span>, <span class="badge bg-warning">Pendiente</span>, <span class="badge bg-danger">Rechazado</span>, <span class="badge bg-secondary">Cancelado</span></p>

                    <h6>Indicadores Visuales:</h6>
                    <ul>
                        <li><span class="badge bg-success">Verde:</span> TATCs vigentes / Traspasos aprobados</li>
                        <li><span class="badge bg-danger">Rojo:</span> TATCs vencidos / Traspasos rechazados</li>
                        <li><span class="badge bg-warning">Amarillo:</span> TATCs próximos a vencer / Traspasos pendientes</li>
                    </ul>

                    <h6>Funcionalidades Adicionales:</h6>
                    <ul>
                        <li>Búsqueda avanzada con múltiples filtros combinables</li>
                        <li>Paginación configurable</li>
                        <li>Exportación de datos a Excel</li>
                        <li>Visualización detallada de cada registro</li>
                        <li>Impresión de fichas individuales</li>
                        <li>Edición de datos (según permisos)</li>
                    </ul>
                </div>
            </div>

            <!-- 9. Control de Fiscalización -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">9.  Control de Fiscalización</h5>
                </div>
                <div class="card-body">
                    <p>El módulo de Control de Fiscalización proporciona herramientas avanzadas para generar reportes y análisis de movimientos de contenedores, facilitando la supervisión y auditoría de las operaciones.</p>
                    
                    <h6>Módulos de Fiscalización:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>📈 Informe de Movimientos</h6>
                            <p>Genera reportes detallados de todos los movimientos de contenedores con filtros avanzados y opciones de exportación.</p>
                        </div>
                        <div class="col-md-6">
                            <h6>🔍 Búsqueda y Extracción</h6>
                            <p>Herramienta de búsqueda avanzada para localizar contenedores específicos y extraer información detallada.</p>
                        </div>
                    </div>

                    <h6>Funcionalidades del Informe de Movimientos:</h6>
                    <ul>
                        <li><strong>Filtros Avanzados:</strong>
                            <ul>
                                <li>Tipos de Títulos (TATC/TSTC/Todos)</li>
                                <li>Tipos de Movimiento (Ingresados/Salidas por DI/Cancelación/Traspaso)</li>
                                <li>Filtro por Fechas (Ingreso o Salida)</li>
                                <li>Selector de Rango de Fechas con opciones predefinidas</li>
                                <li>Aduana de Ingreso y Salida</li>
                                <li>Lugar de Depósito</li>
                                <li>Número de Contenedor (búsqueda parcial)</li>
                                <li>Número TATC/TSTC (búsqueda específica)</li>
                                <li>Tipo de Contenedor (20, 40, 45 pies)</li>
                                <li>Estado del Contenedor (OP - Operativo, DM - Dañado)</li>
                                <li><strong>Vigencia de Títulos:</strong> Filtrar por vigentes, vencidos, por vencer (30 días) o con prórroga</li>
                                <li><strong>Fecha de Vencimiento:</strong> Rango desde/hasta para filtrar por fecha de vencimiento</li>
                                <li><strong>Con Prórroga:</strong> Filtrar títulos con o sin prórrogas activas</li>
                            </ul>
                        </li>
                        <li><strong>Visualización de Datos:</strong>
                            <ul>
                                <li>Tabla ordenable por columnas (clic en encabezados)</li>
                                <li>Indicadores visuales de ordenamiento (ascendente/descendente)</li>
                                <li>Información completa de cada movimiento</li>
                                <li>Enlaces directos a detalles de TATC/TSTC/Salidas</li>
                            </ul>
                        </li>
                        <li><strong>Opciones de Exportación:</strong>
                            <ul>
                                <li><strong>Exportar a Excel:</strong> Descarga archivo CSV con todos los datos filtrados</li>
                                <li><strong>Imprimir PDF:</strong> Genera reporte en formato PDF listo para impresión</li>
                            </ul>
                        </li>
                    </ul>

                    <h6>Funcionalidades de Búsqueda y Extracción:</h6>
                    <ul>
                        <li><strong>Filtros Específicos:</strong>
                            <ul>
                                <li>Búsqueda por número de contenedor</li>
                                <li>Búsqueda por número TATC/TSTC</li>
                                <li>Filtro por tipo y estado de contenedor</li>
                                <li>Filtro por aduanas y fechas</li>
                            </ul>
                        </li>
                        <li><strong>Resultados Inteligentes:</strong>
                            <ul>
                                <li>Botón "Ver" que redirige al detalle apropiado según el estado</li>
                                <li>Acceso directo a información de vigencia, salidas y prórrogas</li>
                                <li>Exportación de resultados filtrados</li>
                            </ul>
                        </li>
                    </ul>

                    <h6>Características Técnicas:</h6>
                    <ul>
                        <li><strong>Persistencia de Filtros:</strong> Los filtros aplicados se mantienen después de cada búsqueda</li>
                        <li><strong>Selector de Fechas Inteligente:</strong> DateRangePicker con opciones predefinidas (Hoy, Ayer, Últimos 7 días, etc.)</li>
                        <li><strong>Ordenamiento Dinámico:</strong> Clic en encabezados para ordenar ascendente/descendente</li>
                        <li><strong>Exportación Completa:</strong> Incluye todos los filtros aplicados en el archivo exportado</li>
                        <li><strong>Interfaz Responsiva:</strong> Optimizada para dispositivos móviles y tablets</li>
                    </ul>

                    <h6>Proceso de Uso:</h6>
                    <ol>
                        <li>Ir a "Control de Fiscalización" → "Informe de Movimientos"</li>
                        <li>Seleccionar filtros deseados (tipo, fechas, aduanas, etc.)</li>
                        <li>Hacer clic en "FILTRAR" para aplicar filtros</li>
                        <li>Revisar resultados en la tabla ordenable</li>
                        <li>Usar "EXPORTAR" para descargar Excel o "IMPRIMIR" para PDF</li>
                        <li>Hacer clic en "Ver" para acceder a detalles específicos</li>
                    </ol>

                    <div class="alert alert-info">
                        <strong> Consejo:</strong> Los filtros se mantienen activos entre búsquedas, permitiendo ajustar criterios sin perder la configuración anterior. Use el selector de fechas para rangos rápidos o ingrese fechas específicas manualmente.
                    </div>
                </div>
            </div>

            <!-- 10. Sistema de Tickets -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">10.  Sistema de Tickets</h5>
                </div>
                <div class="card-body">
                    <p>El sistema incluye un completo sistema de tickets de soporte. La idea principal de este módulo es poder entregar soporte técnico sobre el uso de Contenedores.Pricer a los usuarios, además de generar un seguimiento y un historial de lo solicitado.</p>
                    
                    <h6>Características del Sistema de Tickets:</h6>
                    <ul>
                        <li>Funcionamiento similar al correo electrónico convencional</li>
                        <li>Creación de tickets y respuesta de la mesa de soporte</li>
                        <li>Seguimiento completo de solicitudes</li>
                        <li>Historial de conversaciones</li>
                    </ul>

                    <h6>Estados de Tickets:</h6>
                    <ul>
                        <li><span class="badge bg-success">Verde:</span> Tickets terminados</li>
                        <li><span class="badge bg-danger">Rojo:</span> Tickets pendientes</li>
                        <li><span class="badge bg-warning">Amarillo:</span> Requerimientos en progreso</li>
                    </ul>

                    <h6>Funcionalidades:</h6>
                    <ul>
                        <li><strong>Abrir Nuevo Ticket:</strong> Crear solicitudes con descripción detallada</li>
                        <li><strong>Adjuntar Archivos:</strong> Fotografías, archivos y videos</li>
                        <li><strong>Ver Mis Tickets:</strong> Listado completo de solicitudes</li>
                        <li><strong>Responder Tickets:</strong> Continuar conversaciones existentes</li>
                    </ul>

                    <div class="alert alert-info">
                        <strong> Modalidades de Soporte:</strong> El uso del sistema de ticket dependerá del contrato que tenga con Contenedores.Pricer, el cual se compone de dos opciones: costo mensual o costo por ticket.
                    </div>
                </div>
            </div>

            <!-- 11. Integración HERMES -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">11.  Integración HERMES</h5>
                </div>
                <div class="card-body">
                    <p>El sistema se integra automáticamente con HERMES, el sistema oficial de la Aduana de Chile, enviando mensajes en tiempo real para todas las operaciones.</p>
                    
                    <h6>Tipos de Mensajes HERMES:</h6>
                    <ul>
                        <li><strong>TATC Type 01:</strong> Creación de TATCs</li>
                        <li><strong>Eventos TATC Type 02:</strong> Modificaciones, cancelaciones, traspasos</li>
                        <li><strong>TSTC:</strong> Gestión de TSTCs</li>
                        <li><strong>Salidas:</strong> Registro de salidas de contenedores</li>
                    </ul>

                    <h6>Características de la Integración:</h6>
                    <ul>
                        <li>✅ <strong>Envío Automático:</strong> Todos los mensajes se envían automáticamente</li>
                        <li>✅ <strong>Monitoreo en Tiempo Real:</strong> Seguimiento de todas las comunicaciones</li>
                        <li>✅ <strong>Historial Completo:</strong> Logs detallados de mensajes enviados</li>
                        <li>✅ <strong>Reintentos Automáticos:</strong> En caso de fallo en la comunicación</li>
                        <li>✅ <strong>Validación de Respuestas:</strong> Verificación de recepción por HERMES</li>
                    </ul>

                    <h6>Módulo de Monitoreo HERMES:</h6>
                    <ul>
                        <li>Ir a "HERMES" → "Monitor" para ver estadísticas</li>
                        <li>Revisar historial de mensajes en "HERMES" → "Historial"</li>
                        <li>Reintentar mensajes fallidos desde el monitor</li>
                        <li>Verificar estado de integración en tiempo real</li>
                    </ul>
                </div>
            </div>

            <!-- 12. Procedimientos de Respaldo -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">12.  Procedimientos de Respaldo</h5>
                </div>
                <div class="card-body">
                    <p>Contenedores.Pricer se ejecuta en un ambiente CentOS Linux, manejado con WHM/cPanel, lo que brinda una gran capa de seguridad, además de implementar una serie de aplicaciones de seguridad como firewall, protección para ataques de fuerza bruta, protección para ataques DDOS, etc.</p>
                    
                    <h6>Sistema de Respaldos Automáticos:</h6>
                    <ul>
                        <li><strong>Respaldos Diarios:</strong> Martes, jueves y sábados</li>
                        <li><strong>Respaldo Semanal:</strong> Día lunes (respaldo global)</li>
                        <li><strong>Respaldo Mensual:</strong> Primer día del mes (respaldo global)</li>
                    </ul>

                    <h6>Ubicaciones de Respaldo:</h6>
                    <ol>
                        <li><strong>Servidor Principal:</strong> Disco duro paralelo al servidor</li>
                        <li><strong>Servidor Santiago:</strong> Servidor ubicado en Santiago de Chile</li>
                        <li><strong>Discos Externos:</strong> Dos discos duros externos (respaldos los viernes)</li>
                    </ol>

                    <h6>Información Respalda:</h6>
                    <ul>
                        <li>Archivos del sistema</li>
                        <li>Bases de datos completas</li>
                        <li>Configuraciones del servidor</li>
                        <li>Logs del sistema</li>
                    </ul>

                    <div class="alert alert-success">
                        <strong>✅ Garantía de Seguridad:</strong> Toda la información de archivos y bases de datos está respaldada en 3 ubicaciones distintas con el fin de no perder ni un kb de información de los clientes.
                    </div>
                </div>
            </div>

            <!-- 13. Información Técnica -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">13.  Información Técnica</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>🔧 Tecnologías Backend</h6>
                            <ul>
                                <li><strong>Framework:</strong> Laravel 11</li>
                                <li><strong>Base de Datos:</strong> MySQL</li>
                                <li><strong>Servidor Web:</strong> Apache/Nginx</li>
                                <li><strong>Sistema Operativo:</strong> CentOS Linux</li>
                                <li><strong>Panel de Control:</strong> WHM/cPanel</li>
                                <li><strong>Autenticación:</strong> Sistema de sesiones Laravel</li>
                                <li><strong>Jobs:</strong> Procesamiento asíncrono</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>🎨 Tecnologías Frontend</h6>
                            <ul>
                                <li><strong>Templates:</strong> Blade</li>
                                <li><strong>CSS Framework:</strong> Tailwind CSS</li>
                                <li><strong>JavaScript:</strong> Vanilla JS + Alpine.js</li>
                                <li><strong>UI Framework:</strong> Material Dashboard</li>
                                <li><strong>Iconos:</strong> Material Icons + Font Awesome</li>
                                <li><strong>Responsive:</strong> Bootstrap Grid</li>
                            </ul>
                        </div>
                    </div>

                    <h6>🔒 Medidas de Seguridad:</h6>
                    <ul>
                        <li>Firewall configurado</li>
                        <li>Protección contra ataques de fuerza bruta</li>
                        <li>Protección contra ataques DDOS</li>
                        <li>Encriptación de datos sensibles</li>
                        <li>Validación de entrada de datos</li>
                        <li>Logs de auditoría completos</li>
                    </ul>

                    <h6> Características del Sistema:</h6>
                    <ul>
                        <li>Arquitectura modular y escalable</li>
                        <li>API RESTful para integraciones</li>
                        <li>Procesamiento asíncrono de tareas</li>
                        <li>Sistema de colas para HERMES</li>
                        <li>Logs detallados de todas las operaciones</li>
                        <li>Monitoreo en tiempo real</li>
                    </ul>
                </div>
            </div>

            <!-- Contacto y Soporte -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"> Contacto y Soporte</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>👨‍💻 Desarrollador</h6>
                            <p><strong>Herbert Zapata</strong><br>
                            Email: herbert.zapata19@gmail.com</p>
                        </div>
                        <div class="col-md-6">
                            <h6> Empresa</h6>
                            <p><strong>Contenedores Tomás Dagnino Vicencio E.I.R.L</strong><br>
                            RUT: 76666087-8<br>
                            Código HERMES: S46</p>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <strong> Soporte Técnico:</strong> Para soporte técnico, reportar problemas o solicitar mejoras, utilice el sistema de Tickets integrado en la plataforma. Esto nos permitirá darle seguimiento en tiempo real a sus solicitudes.
                    </div>
                </div>
            </div>

            <!-- Footer del Manual -->
            <div class="card print-footer">
                <div class="card-body text-center">
                    <p class="mb-0">
                        <strong>Manual del Sistema Contenedores.Pricer</strong><br>
                        Versión: 2.0 | Fecha: {{ now()->format('d/m/Y') }}<br>
                        Sistema de Administración de Contenedores con Integración HERMES<br>
                        <small class="text-muted">Basado en la Resolución Exenta Nº 5660 del 20 de diciembre de 2018</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
    </main>
    <x-plugins></x-plugins>
</x-layout>

<!-- Estilos para impresión -->
<style>
@media print {
    .print-hide {
        display: none !important;
    }
    
    .print-header {
        page-break-after: avoid;
    }
    
    .print-footer {
        page-break-before: avoid;
        position: fixed;
        bottom: 0;
        width: 100%;
    }
    
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
        page-break-inside: avoid;
    }
    
    .card-header {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid #ddd !important;
    }
    
    body {
        font-size: 12px;
        line-height: 1.4;
    }
    
    h4, h5, h6 {
        color: #000 !important;
    }
    
    .badge {
        border: 1px solid #000 !important;
        color: #000 !important;
        background-color: transparent !important;
    }
    
    .alert {
        border: 1px solid #ddd !important;
        background-color: #f8f9fa !important;
    }
}
</style>