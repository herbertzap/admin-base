<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='procedimientos-cambio-claves'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Procedimiento de Cambio de Claves"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <!-- Header -->
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="mb-0">Procedimiento de Cambio de Claves</h4>
                                    <p class="text-sm mb-0">CONTENEDORES PRICER</p>
                                    <p class="text-xs text-muted">Versión 2.0 | {{ now()->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-6 text-end">
                                    <button onclick="window.print()" class="btn btn-primary btn-sm">
                                        🖨️ Imprimir
                                    </button>
                                    <a href="{{ route('procedimientos-cambio-claves.pdf') }}" class="btn btn-success btn-sm">
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
                            <p>Este documento describe el procedimiento para el cambio de claves (contraseñas) de usuarios en el sistema <strong>CONTENEDORES PRICER</strong>, tanto para funcionarios de la empresa como para los perfiles asignados a Aduana.</p>
                            
                            <div class="alert alert-warning">
                                <strong>⚠️ Importante:</strong> La seguridad de las claves es fundamental para proteger la información del sistema. Todos los usuarios deben seguir estos procedimientos y las políticas de seguridad establecidas.
                            </div>
                        </div>
                    </div>

                    <!-- 2. Políticas de Seguridad de Claves -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">2. Políticas de Seguridad de Claves</h5>
                        </div>
                        <div class="card-body">
                            <h6>2.1 Requisitos de Contraseña</h6>
                            <ul>
                                <li><strong>Longitud mínima:</strong> 8 caracteres</li>
                                <li><strong>Complejidad:</strong> Se recomienda incluir letras mayúsculas, minúsculas, números y caracteres especiales</li>
                                <li><strong>Renovación:</strong> Las contraseñas deben cambiarse periódicamente según la política establecida</li>
                            </ul>

                            <h6>2.2 Buenas Prácticas</h6>
                            <ul>
                                <li>No compartir contraseñas con otros usuarios</li>
                                <li>No escribir contraseñas en lugares visibles</li>
                                <li>No usar información personal fácil de adivinar</li>
                                <li>Cambiar la contraseña inmediatamente si se sospecha compromiso</li>
                                <li>Cerrar sesión al finalizar el trabajo</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 3. Cambio de Clave por el Usuario -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">3. Cambio de Clave por el Usuario</h5>
                        </div>
                        <div class="card-body">
                            <p>Los usuarios pueden cambiar su contraseña en cualquier momento desde su perfil:</p>
                            
                            <h6>3.1 Proceso Paso a Paso</h6>
                            <ol>
                                <li><strong>Acceder al perfil:</strong>
                                    <ul>
                                        <li>Hacer clic en el nombre de usuario en la esquina superior derecha</li>
                                        <li>Seleccionar "Mi Perfil" o "Editar Perfil"</li>
                                    </ul>
                                </li>
                                <li><strong>Sección de contraseña:</strong>
                                    <ul>
                                        <li>Buscar la sección "Seguridad" o "Cambiar Contraseña"</li>
                                        <li>Ingresar la nueva contraseña (mínimo 8 caracteres)</li>
                                        <li>Confirmar la nueva contraseña</li>
                                    </ul>
                                </li>
                                <li><strong>Guardar cambios:</strong>
                                    <ul>
                                        <li>Hacer clic en "Guardar" o "Actualizar"</li>
                                        <li>El sistema validará que la nueva contraseña cumpla con los requisitos</li>
                                        <li>Se mostrará un mensaje de confirmación</li>
                                    </ul>
                                </li>
                            </ol>

                            <div class="alert alert-info">
                                <strong>💡 Nota:</strong> Si deja el campo de contraseña en blanco, se mantendrá la contraseña actual.
                            </div>

                            <h6>3.2 Recuperación de Contraseña Olvidada</h6>
                            <p>Si un usuario olvida su contraseña:</p>
                            
                            <ol>
                                <li><strong>Desde la pantalla de login:</strong>
                                    <ul>
                                        <li>Hacer clic en "¿Olvidaste tu contraseña?"</li>
                                        <li>Ingresar el correo electrónico registrado</li>
                                        <li>Seguir las instrucciones enviadas por correo</li>
                                    </ul>
                                </li>
                                <li><strong>Proceso automático:</strong>
                                    <ul>
                                        <li>El sistema enviará un enlace de recuperación al correo</li>
                                        <li>Hacer clic en el enlace recibido</li>
                                        <li>Ingresar nueva contraseña</li>
                                        <li>Confirmar nueva contraseña</li>
                                    </ul>
                                </li>
                                <li><strong>Si el proceso automático falla:</strong>
                                    <ul>
                                        <li>Contactar al administrador del sistema</li>
                                        <li>El administrador puede restablecer la contraseña manualmente</li>
                                    </ul>
                                </li>
                            </ol>
                        </div>
                    </div>

                    <!-- 4. Cambio de Clave por Administrador -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">4. Cambio de Clave por Administrador</h5>
                        </div>
                        <div class="card-body">
                            <p>El administrador puede cambiar la contraseña de cualquier usuario (funcionarios de la empresa o perfiles de Aduana):</p>
                            
                            <h6>4.1 Proceso Paso a Paso</h6>
                            <ol>
                                <li><strong>Acceder a Gestión de Usuarios:</strong>
                                    <ul>
                                        <li>Ir a "Gestión de Usuarios" → "Lista de Usuarios"</li>
                                        <li>Buscar el usuario correspondiente</li>
                                        <li>Hacer clic en "Editar"</li>
                                    </ul>
                                </li>
                                <li><strong>Modificar contraseña:</strong>
                                    <ul>
                                        <li>Ir a la pestaña "Seguridad" o buscar la sección de contraseña</li>
                                        <li>Ingresar nueva contraseña en el campo "Nueva Contraseña"</li>
                                        <li>Confirmar nueva contraseña en el campo "Confirmar Nueva Contraseña"</li>
                                        <li>La contraseña debe tener mínimo 8 caracteres</li>
                                    </ul>
                                </li>
                                <li><strong>Guardar cambios:</strong>
                                    <ul>
                                        <li>Hacer clic en "Guardar" o "Actualizar"</li>
                                        <li>El sistema actualizará la contraseña del usuario</li>
                                    </ul>
                                </li>
                                <li><strong>Notificar al usuario:</strong>
                                    <ul>
                                        <li>Informar al usuario sobre el cambio de contraseña</li>
                                        <li>Proporcionar la nueva contraseña de forma segura</li>
                                        <li>Recomendar que cambie la contraseña nuevamente por seguridad</li>
                                    </ul>
                                </li>
                            </ol>

                            <h6>4.2 Alta de Nuevos Usuarios</h6>
                            <p>Al crear un nuevo usuario (funcionario o perfil de Aduana):</p>
                            
                            <ol>
                                <li><strong>Crear usuario:</strong>
                                    <ul>
                                        <li>Ir a "Gestión de Usuarios" → "Crear Usuario"</li>
                                        <li>Completar información del usuario (nombre, email, rol, etc.)</li>
                                    </ul>
                                </li>
                                <li><strong>Asignar contraseña inicial:</strong>
                                    <ul>
                                        <li>Ingresar una contraseña temporal segura</li>
                                        <li>Confirmar la contraseña</li>
                                        <li>La contraseña debe cumplir con los requisitos mínimos</li>
                                    </ul>
                                </li>
                                <li><strong>Guardar y notificar:</strong>
                                    <ul>
                                        <li>Guardar el nuevo usuario</li>
                                        <li>Enviar las credenciales de acceso al usuario</li>
                                        <li>Recomendar cambio de contraseña en el primer acceso</li>
                                    </ul>
                                </li>
                            </ol>

                            <h6>4.3 Baja de Usuarios</h6>
                            <p>Para desactivar un usuario (funcionario o perfil de Aduana):</p>
                            
                            <ol>
                                <li><strong>Acceder a Gestión de Usuarios:</strong>
                                    <ul>
                                        <li>Ir a "Gestión de Usuarios" → "Lista de Usuarios"</li>
                                        <li>Buscar el usuario correspondiente</li>
                                        <li>Hacer clic en "Editar"</li>
                                    </ul>
                                </li>
                                <li><strong>Cambiar estado:</strong>
                                    <ul>
                                        <li>Cambiar el estado de "Activo" a "Inactivo"</li>
                                        <li>Guardar los cambios</li>
                                    </ul>
                                </li>
                                <li><strong>Efecto inmediato:</strong>
                                    <ul>
                                        <li>El usuario no podrá iniciar sesión</li>
                                        <li>Si tiene sesión activa, se cerrará automáticamente</li>
                                    </ul>
                                </li>
                                <li><strong>Documentar:</strong>
                                    <ul>
                                        <li>Registrar la fecha de baja</li>
                                        <li>Documentar el motivo</li>
                                        <li>Mantener el registro para auditoría</li>
                                    </ul>
                                </li>
                            </ol>

                            <div class="alert alert-warning">
                                <strong>⚠️ Importante:</strong> Nunca eliminar usuarios inmediatamente. Siempre desactivar primero para mantener el historial y la trazabilidad de las operaciones.
                            </div>
                        </div>
                    </div>

                    <!-- 5. Consideraciones Especiales para Perfiles de Aduana -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">5. Consideraciones Especiales para Perfiles de Aduana</h5>
                        </div>
                        <div class="card-body">
                            <h6>5.1 Alta de Usuarios de Aduana</h6>
                            <ul>
                                <li>Recibir solicitud formal de Aduana para crear usuario</li>
                                <li>Verificar que el correo electrónico sea oficial de Aduana</li>
                                <li>Asignar rol específico de "Aduana" o "Consulta Aduana"</li>
                                <li>No asignar operador (los usuarios de Aduana no tienen operador asociado)</li>
                                <li>Enviar credenciales de forma segura a Aduana</li>
                            </ul>

                            <h6>5.2 Baja de Usuarios de Aduana</h6>
                            <ul>
                                <li>Recibir solicitud formal de Aduana para dar de baja el usuario</li>
                                <li>Desactivar el usuario cambiando su estado a "Inactivo"</li>
                                <li>Notificar a Aduana sobre la baja del usuario</li>
                                <li>Mantener el registro para historial de consultas y auditoría</li>
                            </ul>
                        </div>
                    </div>

                    <!-- 6. Registro y Auditoría -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">6. Registro y Auditoría</h5>
                        </div>
                        <div class="card-body">
                            <p>El sistema mantiene registros de todas las operaciones relacionadas con claves:</p>
                            
                            <h6>Eventos Registrados:</h6>
                            <ul>
                                <li>Cambios de contraseña (por usuario o administrador)</li>
                                <li>Creación de nuevos usuarios</li>
                                <li>Bajas y desactivaciones de usuarios</li>
                                <li>Intentos de inicio de sesión fallidos</li>
                                <li>Recuperaciones de contraseña</li>
                            </ul>

                            <h6>Información de Auditoría:</h6>
                            <ul>
                                <li>Fecha y hora de cada evento</li>
                                <li>Usuario que realizó la acción</li>
                                <li>Dirección IP desde donde se realizó</li>
                                <li>Detalles de la operación</li>
                            </ul>

                            <div class="alert alert-info">
                                <strong>💡 Nota:</strong> Los registros de auditoría se mantienen para cumplir con los requisitos de seguridad y trazabilidad establecidos por Aduana.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>

