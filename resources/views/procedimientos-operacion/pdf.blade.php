<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procedimiento de Operación del Sistema - CONTENEDORES PRICER</title>
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
        
        code {
            background-color: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 11px;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Procedimiento de Operación del Sistema</h1>
        <h2>CONTENEDORES PRICER</h2>
        <p>Versión 2.0 | Fecha: {{ now()->format('d/m/Y') }}</p>
        <p>Sistema de Administración de Contenedores con Integración HERMES</p>
    </div>

    <!-- 1. Introducción -->
    <div class="section">
        <h3>1. Introducción</h3>
        <p><strong>CONTENEDORES PRICER</strong> es una plataforma computacional desarrollada para la gestión, administración y control de operaciones con contenedores en Aduana, conforme a la Resolución Exenta Nº 3.438/13.09.2024 del Servicio Nacional de Aduanas.</p>
        <p>Este documento describe los procedimientos de operación del sistema para garantizar el correcto funcionamiento de todas las funcionalidades y el cumplimiento de los requisitos establecidos por la normativa aduanera.</p>
    </div>

    <!-- 2. Acceso al Sistema -->
    <div class="section">
        <h3>2. Acceso al Sistema</h3>
        
        <h4>2.1 Inicio de Sesión</h4>
        <ol>
            <li>Acceder a la URL del sistema: <code>https://contenedores.pricer.cl</code></li>
            <li>Ingresar el correo electrónico registrado</li>
            <li>Ingresar la contraseña asignada</li>
            <li>Hacer clic en "Iniciar Sesión"</li>
        </ol>

        <h4>2.2 Recuperación de Contraseña</h4>
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

    <!-- 3. Operaciones Diarias -->
    <div class="section">
        <h3>3. Operaciones Diarias del Sistema</h3>
        
        <h4>3.1 Gestión de TATCs (Títulos de Admisión Temporal de Contenedores)</h4>
        <ul>
            <li><strong>Creación:</strong> Ingresar a "TATCs" → "Crear Nuevo" y completar el formulario con todos los datos requeridos</li>
            <li><strong>Edición:</strong> Seleccionar el TATC deseado y hacer clic en "Editar"</li>
            <li><strong>Consulta:</strong> Utilizar los filtros de búsqueda para encontrar TATCs específicos</li>
            <li><strong>Exportación:</strong> Generar reportes en formato Excel desde el módulo de consultas</li>
        </ul>

        <h4>3.2 Gestión de TSTCs (Títulos de Salida Temporal de Contenedores)</h4>
        <ul>
            <li><strong>Creación:</strong> Ingresar a "TSTCs" → "Crear Nuevo" y completar el formulario</li>
            <li><strong>Edición:</strong> Modificar TSTCs existentes según sea necesario</li>
            <li><strong>Consulta:</strong> Buscar y filtrar TSTCs por diferentes criterios</li>
        </ul>

        <h4>3.3 Registro de Salidas</h4>
        <ul>
            <li><strong>Declaración de Internación:</strong> Registrar salidas por Declaración de Internación</li>
            <li><strong>Cancelación:</strong> Registrar cancelaciones de TATCs</li>
            <li><strong>Traspaso:</strong> Registrar traspasos entre operadores, incluyendo código de operador origen y destino (O.C.)</li>
        </ul>

        <h4>3.4 Control de Plazos</h4>
        <ul>
            <li><strong>Plazos de Vigencia:</strong> Consultar TATCs y TSTCs vigentes</li>
            <li><strong>Prórrogas:</strong> Solicitar y gestionar prórrogas de vigencia</li>
            <li><strong>Registro de Cancelación:</strong> Ver registro de contenedores cancelados</li>
            <li><strong>Registro de Traspaso:</strong> Consultar historial de traspasos con códigos de operadores</li>
        </ul>
    </div>

    <!-- 4. Módulo de Consultas para Fiscalización -->
    <div class="section">
        <h3>4. Módulo de Consultas para Fiscalización</h3>
        
        <h4>4.1 Informe de Movimientos</h4>
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

        <h4>4.2 Búsqueda y Extracción</h4>
        <p>Utilizar los mismos filtros del Informe de Movimientos para realizar búsquedas específicas y exportar resultados.</p>

        <h4>4.3 Exportación de Datos</h4>
        <ol>
            <li>Aplicar los filtros deseados</li>
            <li>Hacer clic en "EXPORTAR" para generar un archivo Excel</li>
            <li>Descargar y guardar el archivo generado</li>
        </ol>
    </div>

    <!-- 5. Integración HERMES -->
    <div class="section">
        <h3>5. Integración con HERMES</h3>
        
        <h4>5.1 Funcionamiento Automático</h4>
        <p>El sistema se integra automáticamente con HERMES, enviando mensajes en tiempo real para todas las operaciones:</p>
        <ul>
            <li><strong>TATC Type 01:</strong> Creación de nuevos TATCs</li>
            <li><strong>TATC Type 02:</strong> Modificaciones, cancelaciones y traspasos</li>
            <li><strong>TSTC:</strong> Gestión de TSTCs</li>
            <li><strong>Salidas:</strong> Registro de salidas de contenedores</li>
        </ul>

        <h4>5.2 Monitoreo de HERMES</h4>
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

    <!-- 6. Gestión de Usuarios -->
    <div class="section">
        <h3>6. Gestión de Usuarios</h3>
        
        <h4>6.1 Creación de Usuarios</h4>
        <ol>
            <li>Acceder a "Gestión de Usuarios" (requiere permisos de administrador)</li>
            <li>Hacer clic en "Crear Nuevo Usuario"</li>
            <li>Completar todos los datos requeridos</li>
            <li>Asignar roles y permisos</li>
            <li>Asignar operador (O.C.) si corresponde</li>
            <li>Guardar el usuario</li>
        </ol>

        <h4>6.2 Edición de Usuarios</h4>
        <ol>
            <li>Seleccionar el usuario a editar</li>
            <li>Hacer clic en "Editar"</li>
            <li>Modificar los datos necesarios</li>
            <li>Actualizar roles y permisos si es necesario</li>
            <li>Guardar los cambios</li>
        </ol>

        <h4>6.3 Cambio de Contraseñas</h4>
        <ol>
            <li>Acceder al perfil del usuario</li>
            <li>Hacer clic en "Cambiar Contraseña"</li>
            <li>Ingresar la contraseña actual</li>
            <li>Ingresar la nueva contraseña (mínimo 8 caracteres)</li>
            <li>Confirmar la nueva contraseña</li>
            <li>Guardar los cambios</li>
        </ol>
    </div>

    <!-- 7. Mantenimiento y Soporte -->
    <div class="section">
        <h3>7. Mantenimiento y Soporte</h3>
        
        <h4>7.1 Sistema de Tickets</h4>
        <p>Para reportar problemas o solicitar soporte:</p>
        <ol>
            <li>Acceder a "Sistema de Tickets"</li>
            <li>Hacer clic en "Nuevo Ticket"</li>
            <li>Describir el problema o solicitud</li>
            <li>Adjuntar archivos si es necesario</li>
            <li>Enviar el ticket</li>
        </ol>

        <h4>7.2 Consulta del Manual</h4>
        <p>El sistema incluye un manual completo disponible en "Manual del Sistema" que contiene información detallada sobre todas las funcionalidades.</p>

        <h4>7.3 Procedimientos de Respaldo</h4>
        <p>Los procedimientos de respaldo están documentados en "Procedimientos de Respaldo", incluyendo información sobre respaldos automáticos y manuales.</p>
    </div>

    <!-- 8. Consideraciones Importantes -->
    <div class="section">
        <h3>8. Consideraciones Importantes</h3>
        
        <div class="alert alert-warning">
            <h4>⚠️ Aspectos Críticos:</h4>
            <ul>
                <li>Todos los datos deben ser ingresados correctamente antes de guardar</li>
                <li>El sistema valida automáticamente los datos antes de enviar a HERMES</li>
                <li>Los traspasos deben incluir el código del operador de origen y destino (O.C.)</li>
                <li>Las consultas de fiscalización deben utilizar los filtros disponibles para obtener resultados precisos</li>
                <li>Las prórrogas solo aplican a TATCs, no a TSTCs</li>
            </ul>
        </div>

        <div class="alert alert-info">
            <h4>💡 Buenas Prácticas:</h4>
            <ul>
                <li>Revisar los datos antes de guardar cualquier operación</li>
                <li>Utilizar los filtros de consulta para obtener información precisa</li>
                <li>Exportar reportes regularmente para mantener registros</li>
                <li>Mantener las contraseñas seguras y actualizadas</li>
                <li>Reportar problemas a través del sistema de tickets</li>
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Procedimiento de Operación del Sistema - CONTENEDORES PRICER</strong></p>
        <p>Versión: 2.0 | Fecha: {{ now()->format('d/m/Y') }}</p>
        <p>Sistema de Administración de Contenedores con Integración HERMES</p>
        <p><small>Basado en la Resolución Exenta Nº 3.438/13.09.2024 del Servicio Nacional de Aduanas</small></p>
    </div>
</body>
</html>

