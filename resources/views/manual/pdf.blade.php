<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual del Sistema MITATC</title>
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
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 24px;
            margin: 0 0 10px 0;
            color: #2c3e50;
        }
        
        .header p {
            font-size: 14px;
            margin: 0;
            color: #7f8c8d;
        }
        
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .section h2 {
            font-size: 18px;
            color: #2c3e50;
            border-bottom: 1px solid #bdc3c7;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        
        .section h3 {
            font-size: 14px;
            color: #34495e;
            margin: 15px 0 10px 0;
        }
        
        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .three-columns {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #3498db;
            margin-bottom: 15px;
        }
        
        .info-box h4 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 14px;
        }
        
        .info-box p {
            margin: 5px 0;
        }
        
        .alert {
            background: #e3f2fd;
            border: 1px solid #2196f3;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        
        .alert-warning {
            background: #fff3e0;
            border-color: #ff9800;
        }
        
        .alert-success {
            background: #e8f5e8;
            border-color: #4caf50;
        }
        
        .alert-info {
            background: #e3f2fd;
            border-color: #2196f3;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #7f8c8d;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .contact-info {
            background: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .contact-info h4 {
            margin: 0 0 10px 0;
            color: #2c3e50;
        }
        
        .contact-info p {
            margin: 5px 0;
        }
        
        ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        
        li {
            margin-bottom: 5px;
        }
        
        ol {
            margin: 10px 0;
            padding-left: 20px;
        }
        
        .toc {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        
        .toc h3 {
            margin-top: 0;
            color: #2c3e50;
        }
        
        .toc ol {
            margin: 0;
        }
        
        .toc li {
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📚 Manual del Sistema MITATC</h1>
        <p>Sistema de Administración de Contenedores</p>
        <p>Versión 2.0 | Fecha: {{ now()->format('d/m/Y') }}</p>
    </div>

    <!-- Tabla de Contenidos -->
    <div class="toc">
        <h3>📋 Tabla de Contenidos</h3>
        <ol>
            <li><strong>Presentación del Sistema</strong></li>
            <li><strong>Control de Acceso</strong></li>
            <li><strong>Recuperación de Contraseña</strong></li>
            <li><strong>Pantalla Principal y Navegación</strong></li>
            <li><strong>Gestión de TATCs</strong></li>
            <li><strong>Gestión de TSTCs</strong></li>
            <li><strong>Registro de Salidas</strong></li>
            <li><strong>Control de Plazos</strong></li>
            <li><strong>Sistema de Tickets</strong></li>
            <li><strong>Integración HERMES</strong></li>
            <li><strong>Procedimientos de Respaldo</strong></li>
            <li><strong>Información Técnica</strong></li>
        </ol>
    </div>

    <!-- 1. Presentación del Sistema -->
    <div class="section">
        <h2>1. 📖 Presentación del Sistema</h2>
        
        <p><strong>MITATC</strong> es una plataforma que reúne e integra todos los componentes necesarios para permitir la gestión, administración y comunicación de las operaciones con contenedores en Aduana, además de tener una gran integración con los procesos solicitados por la aduana en la resolución exenta Nº 5660 del 20 de diciembre del 2018.</p>
        
        <h3>Características Principales:</h3>
        <ul>
            <li>✅ <strong>Fácil de manejar e intuitiva</strong> - Funciona bajo el navegador web</li>
            <li>✅ <strong>Multiplataforma</strong> - Soporte para Tablet y dispositivos móviles</li>
            <li>✅ <strong>Sin limitaciones</strong> - No tiene limitación de tiempo ni ubicación</li>
            <li>✅ <strong>Único requerimiento</strong> - Conexión a internet</li>
            <li>✅ <strong>Sistema modular</strong> - Adaptado según requerimientos específicos de cada operador</li>
            <li>✅ <strong>Integración HERMES</strong> - Comunicación automática con el sistema aduanero</li>
        </ul>

        <div class="alert alert-info">
            <strong>💡 Recomendación:</strong> Use el sistema de Ticket incluido en el sistema para reportar problemas o solicitar mejoras. Con esto estaremos en contacto en tiempo real y tendremos un historial de sus solicitudes.
        </div>
    </div>

    <!-- 2. Control de Acceso -->
    <div class="section">
        <h2>2. 🔐 Control de Acceso</h2>
        
        <p>Es la pantalla inicial del sistema, ésta brinda el control y la seguridad que necesita la información de cada operador. Se utiliza para validar el acceso a los usuarios autorizados al sistema.</p>
        
        <h3>Datos Requeridos para el Acceso:</h3>
        <ul>
            <li><strong>Correo Electrónico:</strong> Email registrado en el sistema</li>
            <li><strong>Contraseña:</strong> Contraseña asignada por el administrador</li>
        </ul>

        <div class="alert alert-warning">
            <strong>⚠️ Importante:</strong> Para ingresar al sistema, debe digitar su correo electrónico y la contraseña correspondiente. El sistema también incluye la opción "Recordarme" para mantener la sesión activa.
        </div>
    </div>

    <!-- 3. Recuperación de Contraseña -->
    <div class="section">
        <h2>3. 🔑 Recuperación de Contraseña</h2>
        
        <p>En caso de olvidar su contraseña puede iniciar el proceso de recuperación, con el cual podremos validar su acceso y enviar las indicaciones para obtener una nueva contraseña a su correo electrónico registrado en el sistema.</p>
        
        <h3>Proceso de Recuperación:</h3>
        <ol>
            <li>Pinchar el enlace <strong>"¿Olvidaste tu contraseña?"</strong> en la pantalla de login</li>
            <li>Ingresar su <strong>correo electrónico</strong> registrado en el sistema</li>
            <li>El sistema enviará un email con un enlace de recuperación</li>
            <li>Pinchar el enlace adjunto en el correo</li>
            <li>Ingresar su nueva contraseña (mínimo 8 caracteres)</li>
            <li>Confirmar la nueva contraseña</li>
        </ol>
    </div>

    <!-- 4. Pantalla Principal -->
    <div class="section">
        <h2>4. 🏠 Pantalla Principal y Navegación</h2>
        
        <p>Una vez validado el acceso al sistema, podrá ver la pantalla principal de MITATC, la que se compone de varias opciones:</p>
        
        <div class="three-columns">
            <div>
                <h3>📋 Menú Principal</h3>
                <p>En la parte izquierda de la pantalla el sistema muestra los módulos y menús que tiene acceso con su clave.</p>
            </div>
            <div>
                <h3>👤 Menú Usuario</h3>
                <p>En la parte superior derecha, en el lugar que sale su nombre, podrá encontrar un menú con diferentes opciones, como actualizar sus datos, crear tickets o solicitar ayuda.</p>
            </div>
            <div>
                <h3>📊 Mi Panel</h3>
                <p>El sistema incluye un panel con información útil de cada módulo que compone el sistema. Al pasar el puntero del mouse por cada opción el sistema le mostrará información sobre ese contenido.</p>
            </div>
        </div>
    </div>

    <!-- 5. Gestión de TATCs -->
    <div class="section">
        <h2>5. 📦 Gestión de TATCs</h2>
        
        <p>Los TATCs (Temporales de Admisión para Tránsito de Contenedores) son el núcleo del sistema. Aquí podrá gestionar todos los aspectos relacionados con estos documentos.</p>
        
        <h3>Funcionalidades Disponibles:</h3>
        <ul>
            <li><strong>Crear Nuevo TATC:</strong> Formulario completo con validaciones automáticas</li>
            <li><strong>Editar TATC:</strong> Modificar información de TATCs existentes</li>
            <li><strong>Consultar TATCs:</strong> Búsqueda avanzada con filtros</li>
            <li><strong>Exportar Datos:</strong> Generar reportes en Excel</li>
            <li><strong>Importar Histórico:</strong> Cargar datos desde archivos Excel</li>
            <li><strong>Generar PDF:</strong> Imprimir documentos oficiales</li>
        </ul>

        <h3>Proceso de Creación:</h3>
        <ol>
            <li>Ir a "TATCs" → "Crear Nuevo"</li>
            <li>Completar formulario con datos del contenedor</li>
            <li>Seleccionar operador y aduana</li>
            <li>Validar información ingresada</li>
            <li>Guardar TATC</li>
            <li>El sistema enviará automáticamente a HERMES</li>
        </ol>
    </div>

    <!-- 6. Gestión de TSTCs -->
    <div class="section">
        <h2>6. 📤 Gestión de TSTCs</h2>
        
        <p>Los TSTCs (Temporales de Salida para Tránsito de Contenedores) permiten gestionar las salidas de contenedores del depósito.</p>
        
        <h3>Funcionalidades Disponibles:</h3>
        <ul>
            <li><strong>Crear Nuevo TSTC:</strong> Formulario específico para TSTCs</li>
            <li><strong>Editar TSTC:</strong> Modificar información existente</li>
            <li><strong>Consultar TSTCs:</strong> Búsqueda y filtrado</li>
            <li><strong>Exportar Datos:</strong> Reportes en Excel</li>
            <li><strong>Generar PDF:</strong> Documentos listos para impresión</li>
        </ul>

        <h3>Imprimir TSTC:</h3>
        <p>El sistema incluye la generación automática del documento TSTC. Para esto debe pinchar el botón "Imprimir TSTC" y el sistema entregará en formato PDF el TSTC listo y firmado de forma digital para su impresión o para guardar en su computador.</p>
    </div>

    <!-- 7. Registro de Salidas -->
    <div class="section">
        <h2>7. 🚪 Registro de Salidas</h2>
        
        <p>En este módulo podrá realizar salidas a los TATC registrados. El sistema integra la opción de generar salidas por Declaración de Internación, por Cancelación y Salidas por Traspaso, cada una con la información solicitada por la Aduana.</p>
        
        <h3>Tipos de Salida:</h3>
        <div class="three-columns">
            <div>
                <h4>📋 Declaración de Internación</h4>
                <p>Para contenedores que ingresan al país definitivamente.</p>
            </div>
            <div>
                <h4>❌ Cancelación</h4>
                <p>Para cancelar un TATC existente.</p>
            </div>
            <div>
                <h4>🔄 Traspaso</h4>
                <p>Para transferir contenedores entre operadores.</p>
            </div>
        </div>

        <h3>Opciones de Registro:</h3>
        <ul>
            <li><strong>Salida Individual:</strong> Registrar salida de un TATC específico</li>
            <li><strong>Salida Masiva:</strong> Seleccionar múltiples TATCs y procesarlos en lote</li>
        </ul>

        <h3>Proceso de Registro:</h3>
        <ol>
            <li>Ir a "Salidas" → "Crear Nueva"</li>
            <li>Seleccionar TATC asociado</li>
            <li>Completar tipo de salida y datos requeridos</li>
            <li>Validar información</li>
            <li>Guardar salida</li>
            <li>El sistema enviará automáticamente a HERMES</li>
        </ol>
    </div>

    <!-- 8. Control de Plazos -->
    <div class="section">
        <h2>8. ⏰ Control de Plazos</h2>
        
        <p>En este módulo se registran las fechas de emisión de los respectivos títulos asociando y calculando las fechas de vencimiento según la normativa aduanera.</p>
        
        <h3>Funcionalidades del Control de Plazos:</h3>
        <ul>
            <li><strong>Plazos de Vigencia:</strong> Visualización de TATCs vigentes y próximos a vencer</li>
            <li><strong>Registro de Cancelaciones:</strong> Control de TATCs cancelados</li>
            <li><strong>Registro de Prórrogas:</strong> Seguimiento de extensiones de plazo</li>
            <li><strong>Registro de Traspasos:</strong> Control de transferencias entre operadores</li>
        </ul>

        <h3>Indicadores Visuales:</h3>
        <ul>
            <li><strong>Verde:</strong> TATCs vigentes</li>
            <li><strong>Rojo:</strong> TATCs vencidos</li>
            <li><strong>Amarillo:</strong> TATCs próximos a vencer</li>
        </ul>

        <h3>Funcionalidades Adicionales:</h3>
        <ul>
            <li>Búsqueda de registros por diferentes criterios</li>
            <li>Visualización detallada de cada registro</li>
            <li>Impresión de fichas individuales</li>
            <li>Edición de datos (según permisos)</li>
        </ul>
    </div>

    <!-- 9. Sistema de Tickets -->
    <div class="section">
        <h2>9. 🎫 Sistema de Tickets</h2>
        
        <p>El sistema incluye un completo sistema de tickets de soporte. La idea principal de este módulo es poder entregar soporte técnico sobre el uso de MITATC a los usuarios, además de generar un seguimiento y un historial de lo solicitado.</p>
        
        <h3>Características del Sistema de Tickets:</h3>
        <ul>
            <li>Funcionamiento similar al correo electrónico convencional</li>
            <li>Creación de tickets y respuesta de la mesa de soporte</li>
            <li>Seguimiento completo de solicitudes</li>
            <li>Historial de conversaciones</li>
        </ul>

        <h3>Estados de Tickets:</h3>
        <ul>
            <li><strong>Verde:</strong> Tickets terminados</li>
            <li><strong>Rojo:</strong> Tickets pendientes</li>
            <li><strong>Amarillo:</strong> Requerimientos en progreso</li>
        </ul>

        <h3>Funcionalidades:</h3>
        <ul>
            <li><strong>Abrir Nuevo Ticket:</strong> Crear solicitudes con descripción detallada</li>
            <li><strong>Adjuntar Archivos:</strong> Fotografías, archivos y videos</li>
            <li><strong>Ver Mis Tickets:</strong> Listado completo de solicitudes</li>
            <li><strong>Responder Tickets:</strong> Continuar conversaciones existentes</li>
        </ul>

        <div class="alert alert-info">
            <strong>💡 Modalidades de Soporte:</strong> El uso del sistema de ticket dependerá del contrato que tenga con MITATC, el cual se compone de dos opciones: costo mensual o costo por ticket.
        </div>
    </div>

    <!-- 10. Integración HERMES -->
    <div class="section">
        <h2>10. 🌐 Integración HERMES</h2>
        
        <p>El sistema se integra automáticamente con HERMES, el sistema oficial de la Aduana de Chile, enviando mensajes en tiempo real para todas las operaciones.</p>
        
        <h3>Tipos de Mensajes HERMES:</h3>
        <ul>
            <li><strong>TATC Type 01:</strong> Creación de TATCs</li>
            <li><strong>Eventos TATC Type 02:</strong> Modificaciones, cancelaciones, traspasos</li>
            <li><strong>TSTC:</strong> Gestión de TSTCs</li>
            <li><strong>Salidas:</strong> Registro de salidas de contenedores</li>
        </ul>

        <h3>Características de la Integración:</h3>
        <ul>
            <li>✅ <strong>Envío Automático:</strong> Todos los mensajes se envían automáticamente</li>
            <li>✅ <strong>Monitoreo en Tiempo Real:</strong> Seguimiento de todas las comunicaciones</li>
            <li>✅ <strong>Historial Completo:</strong> Logs detallados de mensajes enviados</li>
            <li>✅ <strong>Reintentos Automáticos:</strong> En caso de fallo en la comunicación</li>
            <li>✅ <strong>Validación de Respuestas:</strong> Verificación de recepción por HERMES</li>
        </ul>

        <h3>Módulo de Monitoreo HERMES:</h3>
        <ul>
            <li>Ir a "HERMES" → "Monitor" para ver estadísticas</li>
            <li>Revisar historial de mensajes en "HERMES" → "Historial"</li>
            <li>Reintentar mensajes fallidos desde el monitor</li>
            <li>Verificar estado de integración en tiempo real</li>
        </ul>
    </div>

    <!-- 11. Procedimientos de Respaldo -->
    <div class="section">
        <h2>11. 💾 Procedimientos de Respaldo</h2>
        
        <p>MITATC se ejecuta en un ambiente CentOS Linux, manejado con WHM/cPanel, lo que brinda una gran capa de seguridad, además de implementar una serie de aplicaciones de seguridad como firewall, protección para ataques de fuerza bruta, protección para ataques DDOS, etc.</p>
        
        <h3>Sistema de Respaldos Automáticos:</h3>
        <ul>
            <li><strong>Respaldos Diarios:</strong> Martes, jueves y sábados</li>
            <li><strong>Respaldo Semanal:</strong> Día lunes (respaldo global)</li>
            <li><strong>Respaldo Mensual:</strong> Primer día del mes (respaldo global)</li>
        </ul>

        <h3>Ubicaciones de Respaldo:</h3>
        <ol>
            <li><strong>Servidor Principal:</strong> Disco duro paralelo al servidor</li>
            <li><strong>Servidor Santiago:</strong> Servidor ubicado en Santiago de Chile</li>
            <li><strong>Discos Externos:</strong> Dos discos duros externos (respaldos los viernes)</li>
        </ol>

        <h3>Información Respalda:</h3>
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

    <!-- 12. Información Técnica -->
    <div class="section">
        <h2>12. ⚙️ Información Técnica</h2>
        
        <div class="two-columns">
            <div>
                <h3>🔧 Tecnologías Backend</h3>
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
            
            <div>
                <h3>🎨 Tecnologías Frontend</h3>
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

        <h3>🔒 Medidas de Seguridad:</h3>
        <ul>
            <li>Firewall configurado</li>
            <li>Protección contra ataques de fuerza bruta</li>
            <li>Protección contra ataques DDOS</li>
            <li>Encriptación de datos sensibles</li>
            <li>Validación de entrada de datos</li>
            <li>Logs de auditoría completos</li>
        </ul>

        <h3>📊 Características del Sistema:</h3>
        <ul>
            <li>Arquitectura modular y escalable</li>
            <li>API RESTful para integraciones</li>
            <li>Procesamiento asíncrono de tareas</li>
            <li>Sistema de colas para HERMES</li>
            <li>Logs detallados de todas las operaciones</li>
            <li>Monitoreo en tiempo real</li>
        </ul>
    </div>

    <!-- Contacto y Soporte -->
    <div class="section">
        <h2>📞 Contacto y Soporte</h2>
        
        <div class="two-columns">
            <div class="contact-info">
                <h4>👨‍💻 Desarrollador</h4>
                <p><strong>Herbert Zapata</strong></p>
                <p>Email: herbert.zapata19@gmail.com</p>
            </div>
            
            <div class="contact-info">
                <h4>🏢 Empresa</h4>
                <p><strong>Contenedores Tomás Dagnino Vicencio E.I.R.L</strong></p>
                <p>RUT: 76666087-8</p>
                <p>Código HERMES: S46</p>
            </div>
        </div>
        
        <div class="alert alert-info">
            <strong>💡 Soporte Técnico:</strong> Para soporte técnico, reportar problemas o solicitar mejoras, utilice el sistema de Tickets integrado en la plataforma. Esto nos permitirá darle seguimiento en tiempo real a sus solicitudes.
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Manual del Sistema MITATC</strong></p>
        <p>Versión: 2.0 | Fecha: {{ now()->format('d/m/Y') }}</p>
        <p>Sistema de Administración de Contenedores con Integración HERMES</p>
        <p><small>Basado en la Resolución Exenta Nº 5660 del 20 de diciembre de 2018</small></p>
    </div>
</body>
</html>