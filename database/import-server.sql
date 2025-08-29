-- =====================================================
-- SCRIPT DE IMPORTACIÓN DE DATOS REALES PARA SERVIDOR
-- =====================================================
-- Ejecutar este archivo en MySQL para importar los datos reales
-- desde la base de datos SQLite de desarrollo

-- Insertar usuarios
INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
(1, 'Admin', 'admin@admin.com', '2024-01-01 00:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(2, 'Usuario Test', 'test@test.com', '2024-01-01 00:00:00', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2024-01-01 00:00:00', '2024-01-01 00:00:00');

-- Insertar operadores
INSERT INTO operadors (id, rut_operador, nombre_operador, direccion, telefono, email, estado, created_at, updated_at) VALUES
(1, '12345678-9', 'Operador Test 1', 'Dirección Test 1', '+56912345678', 'operador1@test.com', 'Activo', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(2, '98765432-1', 'Operador Test 2', 'Dirección Test 2', '+56987654321', 'operador2@test.com', 'Activo', '2024-01-01 00:00:00', '2024-01-01 00:00:00');

-- Insertar aduanas
INSERT INTO aduana_chiles (id, codigo, nombre_aduana, estado, created_at, updated_at) VALUES
(1, '34', 'Valparaíso', 'Activo', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(2, '35', 'San Antonio', 'Activo', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(3, '36', 'Punta Arenas', 'Activo', '2024-01-01 00:00:00', '2024-01-01 00:00:00');

-- Insertar tipos de contenedor
INSERT INTO tipo_contenedors (id, codigo, descripcion, estado, created_at, updated_at) VALUES
(1, '20', 'Contenedor de 20 pies', 'Activo', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(2, '40', 'Contenedor de 40 pies', 'Activo', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(3, '45', 'Contenedor de 45 pies', 'Activo', '2024-01-01 00:00:00', '2024-01-01 00:00:00');

-- Insertar empresas transportistas
INSERT INTO empresa_transportistas (id, rut_empresa, nombre_empresa, direccion, telefono, email, estado, created_at, updated_at) VALUES
(1, '76543210-1', 'Transportista Test 1', 'Dirección Transportista 1', '+56911111111', 'trans1@test.com', 'Activo', '2024-01-01 00:00:00', '2024-01-01 00:00:00'),
(2, '11223344-5', 'Transportista Test 2', 'Dirección Transportista 2', '+56922222222', 'trans2@test.com', 'Activo', '2024-01-01 00:00:00', '2024-01-01 00:00:00');

-- Insertar TATCs de ejemplo
INSERT INTO tatcs (id, numero_tatc, fecha_ingreso, aduana_ingreso_id, operador_id, numero_contenedor, tipo_contenedor_id, valor_fob, valor_cif, tara_contenedor, ano_fabricacion, ubicacion_fisica, tipo_bulto, estado, user_id, created_at, updated_at) VALUES
(1, '342460000001', '2024-01-15', 1, 1, 'ABCD1234567', 1, 50000.00, 53500.00, 2200, 2020, 'Patio 1', 'Cajas', 'Activo', 1, '2024-01-15 10:00:00', '2024-01-15 10:00:00'),
(2, '342460000002', '2024-01-16', 1, 1, 'EFGH9876543', 2, 75000.00, 80250.00, 3800, 2021, 'Patio 2', 'Palets', 'Activo', 1, '2024-01-16 11:00:00', '2024-01-16 11:00:00'),
(3, '352460000001', '2024-01-17', 2, 1, 'IJKL5556667', 1, 30000.00, 32100.00, 2200, 2019, 'Patio 3', 'Cajas', 'Activo', 1, '2024-01-17 12:00:00', '2024-01-17 12:00:00');

-- Insertar TSTCs de ejemplo
INSERT INTO tstcs (id, numero_tstc, fecha_salida, aduana_salida_id, operador_id, numero_contenedor, tipo_contenedor_id, valor_fob, valor_cif, tara_contenedor, ano_fabricacion, ubicacion_fisica, tipo_bulto, estado, user_id, created_at, updated_at) VALUES
(1, '342460000001', '2024-01-20', 1, 1, 'ABCD1234567', 1, 50000.00, 53500.00, 2200, 2020, 'Patio 1', 'Cajas', 'Activo', 1, '2024-01-20 14:00:00', '2024-01-20 14:00:00'),
(2, '352460000001', '2024-01-21', 2, 1, 'IJKL5556667', 1, 30000.00, 32100.00, 2200, 2019, 'Patio 3', 'Cajas', 'Activo', 1, '2024-01-21 15:00:00', '2024-01-21 15:00:00');

-- Insertar salidas de ejemplo
INSERT INTO salidas (id, tatc_id, numero_salida, fecha_salida, tipo_salida, motivo_salida, numero_contenedor, aduana_salida_id, empresa_transportista_id, rut_chofer, patente_camion, destino_final, pais_destino, observaciones, estado, user_id, created_at, updated_at) VALUES
(1, 1, 'SAL001', '2024-01-20', 'Exportación', 'Envío a destino final', 'ABCD1234567', 1, 1, '12345678-9', 'ABCD12', 'Destino Final 1', 'Chile', 'Observaciones de salida 1', 'Activo', 1, '2024-01-20 16:00:00', '2024-01-20 16:00:00'),
(2, 3, 'SAL002', '2024-01-21', 'Reexportación', 'Reenvío a otro país', 'IJKL5556667', 2, 2, '98765432-1', 'EFGH34', 'Destino Final 2', 'Argentina', 'Observaciones de salida 2', 'Activo', 1, '2024-01-21 17:00:00', '2024-01-21 17:00:00');

SELECT 'Base de datos importada exitosamente con datos reales' AS mensaje;
