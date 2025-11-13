<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procedimientos de Respaldo - Contenedores.Pricer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #2c3e50;
        }
        
        .header h2 {
            font-size: 18px;
            margin: 5px 0;
            color: #7f8c8d;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 10px;
            color: #95a5a6;
        }
        
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .section h3 {
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 10px;
            border-bottom: 1px solid #bdc3c7;
            padding-bottom: 5px;
        }
        
        .section h4 {
            font-size: 14px;
            color: #34495e;
            margin: 15px 0 8px 0;
        }
        
        .section p {
            margin: 8px 0;
            text-align: justify;
        }
        
        .section ul, .section ol {
            margin: 8px 0;
            padding-left: 20px;
        }
        
        .section li {
            margin: 4px 0;
        }
        
        .highlight {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
        }
        
        .highlight strong {
            color: #2c3e50;
        }
        
        .alert {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin: 10px 0;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeaa7;
            color: #856404;
        }
        
        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }
        
        .grid {
            display: table;
            width: 100%;
            margin: 15px 0;
        }
        
        .grid-item {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        
        .contact-info {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .contact-info h4 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding: 10px;
        }
        
        @page {
            margin: 2cm;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PROCEDIMIENTOS DE RESPALDO</h1>
        <h2>Sistema de Administración de Contenedores.Pricer</h2>
        <p>Versión {{ $version }} | Fecha: {{ $fecha }}</p>
    </div>

    <div class="section">
        <h3>1. PRESENTACIÓN DEL SISTEMA</h3>
        <p><strong>Contenedores.Pricer</strong> es una plataforma que reúne e integra todos los componentes necesarios para permitir la gestión, administración y comunicación de las operaciones con contenedores en Aduana, además de tener una gran integración con los procesos solicitados por la aduana en la resolución exenta Nº 5660 del 20 de diciembre del 2018.</p>
        
        <p>La plataforma es fácil de manejar e intuitiva, funciona bajo el navegador web instalado en el computador, tiene soporte para ser utilizada en Tablet y/o desde dispositivos móviles, no tiene limitación de tiempo ni ubicación, su único requerimiento es tener una conexión a internet.</p>
        
        <p><strong>Contenedores.Pricer</strong> es un sistema modular el cual es adaptado según los requerimientos específicos de cada operador.</p>
    </div>

    <div class="section">
        <h3>2. PROCEDIMIENTOS DE RESPALDO</h3>
        <p><strong>Contenedores.Pricer</strong> se ejecuta en un ambiente AWS (Amazon Web Services), utilizando servicios de alta disponibilidad y escalabilidad. El sistema implementa múltiples capas de seguridad y respaldo automático para garantizar la integridad y disponibilidad de los datos.</p>
        
        <h4>Infraestructura AWS:</h4>
        <ul>
            <li><strong>EC2:</strong> Instancias de servidor virtual para la aplicación</li>
            <li><strong>RDS:</strong> Base de datos MySQL administrada con respaldos automáticos</li>
            <li><strong>S3:</strong> Almacenamiento de archivos con versionado y replicación</li>
            <li><strong>CloudWatch:</strong> Monitoreo y alertas del sistema</li>
            <li><strong>IAM:</strong> Gestión de identidades y accesos</li>
        </ul>

        <h4>Sistema de Respaldos Automáticos:</h4>
        <div class="grid">
            <div class="grid-item">
                <strong>Respaldos Diarios</strong><br>
                Martes, jueves y sábados
            </div>
            <div class="grid-item">
                <strong>Respaldo Semanal</strong><br>
                Día lunes (respaldo global)
            </div>
            <div class="grid-item">
                <strong>Respaldo Mensual</strong><br>
                Primer día del mes (respaldo global)
            </div>
        </div>

        <h4>Ubicaciones de Respaldo:</h4>
        <ol>
            <li><strong>RDS Automated Backups:</strong> Respaldos automáticos de base de datos con retención de 30 días</li>
            <li><strong>S3 Cross-Region Replication:</strong> Replicación automática a múltiples regiones AWS</li>
            <li><strong>S3 Glacier:</strong> Almacenamiento de respaldos a largo plazo (bajo costo)</li>
            <li><strong>Local Backups:</strong> Respaldos locales en el servidor de aplicación</li>
        </ol>

        <div class="alert alert-success">
            <strong>Garantía de Seguridad:</strong> Toda la información de archivos y bases de datos está respaldada en múltiples ubicaciones AWS con el fin de no perder ni un kb de información de los clientes.
        </div>
    </div>

    <div class="section">
        <h3>3. HERRAMIENTAS DE RESPALDO</h3>
        <p>El sistema incluye herramientas integradas para la creación de respaldos manuales:</p>
        
        <h4>Respaldo de Base de Datos:</h4>
        <ul>
            <li>Creación de respaldos SQL completos</li>
            <li>Compresión automática de archivos</li>
            <li>Almacenamiento en directorio seguro</li>
            <li>Verificación de integridad</li>
        </ul>

        <h4>Respaldo de Archivos:</h4>
        <ul>
            <li>Respaldos de archivos de configuración</li>
            <li>Respaldos de logs del sistema</li>
            <li>Respaldos de migraciones de base de datos</li>
            <li>Compresión en formato TAR.GZ</li>
        </ul>
    </div>

    <div class="section">
        <h3>4. PROCEDIMIENTOS PARA RECUPERAR LA INFORMACIÓN</h3>
        <p>Desde el panel de administración AWS, podemos restaurar una copia de los respaldos almacenados. Este proceso toma algunos minutos, una vez terminado el sistema queda en óptimas condiciones de funcionamiento.</p>
        
        <h4>Proceso de Recuperación:</h4>
        <ol>
            <li><strong>Acceso a AWS Console:</strong> Ingresar al panel de administración AWS</li>
            <li><strong>Selección de Respaldo:</strong> Elegir el punto de restauración deseado</li>
            <li><strong>Restauración de Base de Datos:</strong> Restaurar desde RDS Automated Backups</li>
            <li><strong>Restauración de Archivos:</strong> Restaurar desde S3 o respaldos locales</li>
            <li><strong>Verificación:</strong> Validar que el sistema funcione correctamente</li>
        </ol>

        <h4>Tipos de Recuperación:</h4>
        <ul>
            <li><strong>Point-in-Time Recovery:</strong> Restaurar a un momento específico (hasta 30 días atrás)</li>
            <li><strong>Snapshot Recovery:</strong> Restaurar desde un snapshot específico</li>
            <li><strong>Cross-Region Recovery:</strong> Restaurar desde otra región AWS</li>
            <li><strong>Disaster Recovery:</strong> Recuperación completa del sistema</li>
        </ul>

        <div class="alert alert-warning">
            <strong>Importante:</strong> En caso de una pérdida del servidor, podemos restaurar la información desde los respaldos automáticos de AWS, respaldos locales o desde el almacenamiento S3 con versionado.
        </div>
    </div>

    <div class="section">
        <h3>5. MONITOREO Y ALERTAS</h3>
        <p>El sistema implementa monitoreo continuo y alertas automáticas para garantizar la integridad de los respaldos y la disponibilidad del sistema.</p>
        
        <h4>Métricas Monitoreadas:</h4>
        <ul>
            <li><strong>Estado de Respaldos:</strong> Verificación automática de respaldos exitosos</li>
            <li><strong>Espacio de Almacenamiento:</strong> Monitoreo del uso de espacio en S3</li>
            <li><strong>Rendimiento de Base de Datos:</strong> Métricas de RDS y consultas</li>
            <li><strong>Disponibilidad del Sistema:</strong> Uptime y tiempo de respuesta</li>
            <li><strong>Logs de Aplicación:</strong> Monitoreo de errores y eventos</li>
        </ul>

        <h4>Sistema de Alertas:</h4>
        <ul>
            <li><strong>Email:</strong> Notificaciones por correo electrónico</li>
            <li><strong>SMS:</strong> Alertas críticas por mensaje de texto</li>
            <li><strong>Slack/Teams:</strong> Integración con herramientas de comunicación</li>
            <li><strong>Dashboard:</strong> Panel de control en tiempo real</li>
        </ul>
    </div>

    <div class="section">
        <h3>6. MEDIDAS DE SEGURIDAD</h3>
        <ul>
            <li><strong>Encriptación:</strong> Datos encriptados en tránsito y en reposo</li>
            <li><strong>Firewall:</strong> Configuración de seguridad de red</li>
            <li><strong>Protección DDoS:</strong> Protección contra ataques de denegación de servicio</li>
            <li><strong>Autenticación:</strong> Sistema de autenticación robusto</li>
            <li><strong>Logs de Auditoría:</strong> Registro completo de todas las operaciones</li>
            <li><strong>Validación de Datos:</strong> Validación de entrada de datos</li>
        </ul>
    </div>

    <div class="contact-info">
        <h4>CONTACTO Y SOPORTE</h4>
        <p><strong>Desarrollador:</strong> Herbert Zapata<br>
        <strong>Email:</strong> herbert.zapata19@gmail.com</p>
        
        <p><strong>Empresa:</strong> Contenedores Tomás Dagnino Vicencio E.I.R.L<br>
        <strong>RUT:</strong> 76666087-8<br>
        <strong>Código HERMES:</strong> S46</p>
        
        <div class="alert alert-info">
            <strong>Soporte Técnico:</strong> Para soporte técnico, reportar problemas o solicitar mejoras, utilice el sistema de Tickets integrado en la plataforma. Esto nos permitirá darle seguimiento en tiempo real a sus solicitudes.
        </div>
    </div>

    <div class="footer">
        <strong>Procedimientos de Respaldo - Contenedores.Pricer</strong><br>
        Versión: {{ $version }} | Fecha: {{ $fecha }}<br>
        Sistema de Administración de Contenedores con Integración HERMES<br>
        <em>Basado en la Resolución Exenta Nº 5660 del 20 de diciembre de 2018</em>
    </div>
</body>
</html>
