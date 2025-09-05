<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='procedimientos-respaldo'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Procedimientos de Respaldo"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <!-- Header -->
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="mb-0">💾 Procedimientos de Respaldo</h4>
                                    <p class="text-sm mb-0">Sistema de Administración de Contenedores.Pricer</p>
                                    <p class="text-xs text-muted">Versión 2.0 | {{ now()->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-6 text-end">
                                    <button onclick="window.print()" class="btn btn-primary btn-sm">
                                        🖨️ Imprimir
                                    </button>
                                    <a href="{{ route('procedimientos-respaldo.pdf') }}" class="btn btn-success btn-sm">
                                        📄 Descargar PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información General -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">1. 📖 Presentación del Sistema</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Contenedores.Pricer</strong> es una plataforma que reúne e integra todos los componentes necesarios para permitir la gestión, administración y comunicación de las operaciones con contenedores en Aduana, además de tener una gran integración con los procesos solicitados por la aduana en la resolución exenta Nº 5660 del 20 de diciembre del 2018.</p>
                            
                            <p>La plataforma es fácil de manejar e intuitiva, funciona bajo el navegador web instalado en el computador, tiene soporte para ser utilizada en Tablet y/o desde dispositivos móviles, no tiene limitación de tiempo ni ubicación, su único requerimiento es tener una conexión a internet.</p>
                            
                            <p><strong>Contenedores.Pricer</strong> es un sistema modular el cual es adaptado según los requerimientos específicos de cada operador.</p>
                        </div>
                    </div>

                    <!-- Procedimientos de Respaldo -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">2. 🔄 Procedimientos de Respaldo</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Contenedores.Pricer</strong> se ejecuta en un ambiente AWS (Amazon Web Services), utilizando servicios de alta disponibilidad y escalabilidad. El sistema implementa múltiples capas de seguridad y respaldo automático para garantizar la integridad y disponibilidad de los datos.</p>
                            
                            <h6>Infraestructura AWS:</h6>
                            <ul>
                                <li><strong>EC2:</strong> Instancias de servidor virtual para la aplicación</li>
                                <li><strong>RDS:</strong> Base de datos MySQL administrada con respaldos automáticos</li>
                                <li><strong>S3:</strong> Almacenamiento de archivos con versionado y replicación</li>
                                <li><strong>CloudWatch:</strong> Monitoreo y alertas del sistema</li>
                                <li><strong>IAM:</strong> Gestión de identidades y accesos</li>
                            </ul>

                            <h6>Sistema de Respaldos Automáticos:</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">📅 Respaldos Diarios</h6>
                                            <p class="card-text">Martes, jueves y sábados</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">📊 Respaldo Semanal</h6>
                                            <p class="card-text">Día lunes (respaldo global)</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="card-title">🗓️ Respaldo Mensual</h6>
                                            <p class="card-text">Primer día del mes (respaldo global)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h6>Ubicaciones de Respaldo:</h6>
                            <ol>
                                <li><strong>RDS Automated Backups:</strong> Respaldos automáticos de base de datos con retención de 30 días</li>
                                <li><strong>S3 Cross-Region Replication:</strong> Replicación automática a múltiples regiones AWS</li>
                                <li><strong>S3 Glacier:</strong> Almacenamiento de respaldos a largo plazo (bajo costo)</li>
                                <li><strong>Local Backups:</strong> Respaldos locales en el servidor de aplicación</li>
                            </ol>

                            <div class="alert alert-success">
                                <strong>✅ Garantía de Seguridad:</strong> Toda la información de archivos y bases de datos está respaldada en múltiples ubicaciones AWS con el fin de no perder ni un kb de información de los clientes.
                            </div>
                        </div>
                    </div>

                    <!-- Herramientas de Respaldo -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">3. 🛠️ Herramientas de Respaldo</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">🗄️ Respaldo de Base de Datos</h6>
                                            <p class="card-text">Crear respaldo manual de la base de datos MySQL</p>
                                            <button class="btn btn-primary" onclick="respaldarBaseDatos()">
                                                <i class="fas fa-database"></i> Crear Respaldo DB
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">📁 Respaldo de Archivos</h6>
                                            <p class="card-text">Crear respaldo manual de archivos del sistema</p>
                                            <button class="btn btn-info" onclick="respaldarArchivos()">
                                                <i class="fas fa-folder"></i> Crear Respaldo Archivos
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Respaldos -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">4. 📋 Respaldos Disponibles</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tablaRespaldos">
                                    <thead>
                                        <tr>
                                            <th>Nombre del Archivo</th>
                                            <th>Tipo</th>
                                            <th>Tamaño</th>
                                            <th>Fecha de Creación</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div class="spinner-border" role="status">
                                                    <span class="visually-hidden">Cargando...</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Procedimientos de Recuperación -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">5. 🔧 Procedimientos para Recuperar la Información</h5>
                        </div>
                        <div class="card-body">
                            <p>Desde el panel de administración AWS, podemos restaurar una copia de los respaldos almacenados. Este proceso toma algunos minutos, una vez terminado el sistema queda en óptimas condiciones de funcionamiento.</p>
                            
                            <h6>Proceso de Recuperación:</h6>
                            <ol>
                                <li><strong>Acceso a AWS Console:</strong> Ingresar al panel de administración AWS</li>
                                <li><strong>Selección de Respaldo:</strong> Elegir el punto de restauración deseado</li>
                                <li><strong>Restauración de Base de Datos:</strong> Restaurar desde RDS Automated Backups</li>
                                <li><strong>Restauración de Archivos:</strong> Restaurar desde S3 o respaldos locales</li>
                                <li><strong>Verificación:</strong> Validar que el sistema funcione correctamente</li>
                            </ol>

                            <h6>Tipos de Recuperación:</h6>
                            <ul>
                                <li><strong>Point-in-Time Recovery:</strong> Restaurar a un momento específico (hasta 30 días atrás)</li>
                                <li><strong>Snapshot Recovery:</strong> Restaurar desde un snapshot específico</li>
                                <li><strong>Cross-Region Recovery:</strong> Restaurar desde otra región AWS</li>
                                <li><strong>Disaster Recovery:</strong> Recuperación completa del sistema</li>
                            </ul>

                            <div class="alert alert-warning">
                                <strong>⚠️ Importante:</strong> En caso de una pérdida del servidor, podemos restaurar la información desde los respaldos automáticos de AWS, respaldos locales o desde el almacenamiento S3 con versionado.
                            </div>
                        </div>
                    </div>

                    <!-- Monitoreo y Alertas -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">6. 📊 Monitoreo y Alertas</h5>
                        </div>
                        <div class="card-body">
                            <p>El sistema implementa monitoreo continuo y alertas automáticas para garantizar la integridad de los respaldos y la disponibilidad del sistema.</p>
                            
                            <h6>Métricas Monitoreadas:</h6>
                            <ul>
                                <li><strong>Estado de Respaldos:</strong> Verificación automática de respaldos exitosos</li>
                                <li><strong>Espacio de Almacenamiento:</strong> Monitoreo del uso de espacio en S3</li>
                                <li><strong>Rendimiento de Base de Datos:</strong> Métricas de RDS y consultas</li>
                                <li><strong>Disponibilidad del Sistema:</strong> Uptime y tiempo de respuesta</li>
                                <li><strong>Logs de Aplicación:</strong> Monitoreo de errores y eventos</li>
                            </ul>

                            <h6>Sistema de Alertas:</h6>
                            <ul>
                                <li><strong>Email:</strong> Notificaciones por correo electrónico</li>
                                <li><strong>SMS:</strong> Alertas críticas por mensaje de texto</li>
                                <li><strong>Slack/Teams:</strong> Integración con herramientas de comunicación</li>
                                <li><strong>Dashboard:</strong> Panel de control en tiempo real</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Contacto y Soporte -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">📞 Contacto y Soporte</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>👨‍💻 Desarrollador</h6>
                                    <p><strong>Herbert Zapata</strong><br>
                                    Email: herbert.zapata19@gmail.com</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>🏢 Empresa</h6>
                                    <p><strong>Contenedores Tomás Dagnino Vicencio E.I.R.L</strong><br>
                                    RUT: 76666087-8<br>
                                    Código HERMES: S46</p>
                                </div>
                            </div>
                            
                            <div class="alert alert-info">
                                <strong>💡 Soporte Técnico:</strong> Para soporte técnico, reportar problemas o solicitar mejoras, utilice el sistema de Tickets integrado en la plataforma. Esto nos permitirá darle seguimiento en tiempo real a sus solicitudes.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>

@push('scripts')
<script>
    // Cargar lista de respaldos al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        cargarRespaldos();
    });

    function cargarRespaldos() {
        fetch('/procedimientos-respaldo/listar')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#tablaRespaldos tbody');
                tbody.innerHTML = '';
                
                if (data.success && data.respaldos.length > 0) {
                    data.respaldos.forEach(respaldo => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${respaldo.nombre}</td>
                            <td><span class="badge ${respaldo.tipo === 'Base de Datos' ? 'bg-primary' : 'bg-info'}">${respaldo.tipo}</span></td>
                            <td>${formatearTamaño(respaldo.tamaño)}</td>
                            <td>${respaldo.fecha}</td>
                            <td>
                                <a href="/procedimientos-respaldo/descargar/${respaldo.nombre}" class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i> Descargar
                                </a>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No hay respaldos disponibles</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const tbody = document.querySelector('#tablaRespaldos tbody');
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error al cargar respaldos</td></tr>';
            });
    }

    function formatearTamaño(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function respaldarBaseDatos() {
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creando...';
        btn.disabled = true;
        
        fetch('/procedimientos-respaldo/respaldar-db', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Respaldo de base de datos creado exitosamente');
                cargarRespaldos();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al crear respaldo de base de datos');
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }

    function respaldarArchivos() {
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creando...';
        btn.disabled = true;
        
        fetch('/procedimientos-respaldo/respaldar-archivos', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Respaldo de archivos creado exitosamente');
                cargarRespaldos();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al crear respaldo de archivos');
        })
        .finally(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
</script>
@endpush
