#!/bin/bash
echo "Exportando datos reales de SQLite..."
mkdir -p database/exports
sqlite3 database/database.sqlite ".dump" > database/exports/real-data.sql
echo "Datos exportados a database/exports/real-data.sql"
