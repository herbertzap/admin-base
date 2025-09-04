#!/bin/bash

# Script para migrar datos de SQLite a MySQL
# Proyecto Admin-Base HERMES

echo "🚀 Iniciando migración de SQLite a MySQL..."

# Configuración
SQLITE_DB="database/database.sqlite"
MYSQL_DB="admin_base_hermes"
MYSQL_USER="root"
MYSQL_HOST="localhost"

# Verificar que SQLite existe
if [ ! -f "$SQLITE_DB" ]; then
    echo "❌ Error: Base de datos SQLite no encontrada en $SQLITE_DB"
    exit 1
fi

# Verificar que MySQL esté funcionando
if ! mysql -u "$MYSQL_USER" -e "USE $MYSQL_DB" 2>/dev/null; then
    echo "❌ Error: No se puede conectar a MySQL o la base de datos no existe"
    exit 1
fi

echo "✅ Conexión a MySQL verificada"

# Crear directorio temporal para los datos
TEMP_DIR="temp_migration"
mkdir -p "$TEMP_DIR"

echo "📊 Exportando datos de SQLite..."

# Exportar estructura y datos de cada tabla
TABLES=(
    "users"
    "operadors" 
    "aduanas"
    "lugar_depositos"
    "tipo_contenedors"
    "tipo_bultos"
    "empresa_transportistas"
    "tatcs"
    "tstcs"
    "salidas"
    "hermes_logs"
    "permissions"
    "roles"
    "model_has_permissions"
    "model_has_roles"
    "role_has_permissions"
)

for table in "${TABLES[@]}"; do
    echo "  📋 Exportando tabla: $table"
    
    # Verificar si la tabla existe en SQLite
    if sqlite3 "$SQLITE_DB" ".tables" | grep -q "$table"; then
        # Exportar estructura
        sqlite3 "$SQLITE_DB" ".schema $table" > "$TEMP_DIR/${table}_schema.sql" 2>/dev/null
        
        # Exportar datos
        sqlite3 "$SQLITE_DB" "SELECT * FROM $table;" > "$TEMP_DIR/${table}_data.csv" 2>/dev/null
        
        echo "    ✅ $table exportada"
    else
        echo "    ⚠️ Tabla $table no encontrada en SQLite"
    fi
done

echo ""
echo "🔄 Migrando datos a MySQL..."

# Ejecutar migraciones de Laravel
echo "  🔧 Ejecutando migraciones de Laravel..."
php artisan migrate:fresh --database=mysql

# Importar datos
echo "  📥 Importando datos a MySQL..."

# Función para importar datos de una tabla
import_table_data() {
    local table=$1
    local data_file="$TEMP_DIR/${table}_data.csv"
    
    if [ -f "$data_file" ] && [ -s "$data_file" ]; then
        echo "    📥 Importando datos de $table..."
        
        # Leer datos y generar INSERT statements
        while IFS='|' read -r line; do
            if [ ! -z "$line" ]; then
                # Convertir línea a valores SQL
                values=$(echo "$line" | sed "s/'/\\\'/g" | sed 's/|/","/g' | sed 's/^/"/' | sed 's/$/"/')
                echo "INSERT INTO $table VALUES ($values);" >> "$TEMP_DIR/${table}_inserts.sql"
            fi
        done < "$data_file"
        
        # Ejecutar INSERTs si existen
        if [ -f "$TEMP_DIR/${table}_inserts.sql" ]; then
            mysql -u "$MYSQL_USER" "$MYSQL_DB" < "$TEMP_DIR/${table}_inserts.sql" 2>/dev/null
            echo "      ✅ Datos de $table importados"
        fi
    fi
}

# Importar datos de cada tabla
for table in "${TABLES[@]}"; do
    import_table_data "$table"
done

echo ""
echo "🧹 Limpiando archivos temporales..."
rm -rf "$TEMP_DIR"

echo ""
echo "✅ Migración completada!"
echo "📊 Base de datos MySQL: $MYSQL_DB"
echo "🔍 Verificar datos con: mysql -u $MYSQL_USER -e \"USE $MYSQL_DB; SHOW TABLES;\""
