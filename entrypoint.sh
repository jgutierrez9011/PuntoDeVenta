#!/bin/bash
set -e

# Asegura que solo un MPM esté activo (prefork) para evitar AH00534
# No importa si la configuración viene pre-cargada del sistema.
a2dismod mpm_event mpm_worker || true
rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf 2>/dev/null || true
rm -f /etc/apache2/mods-enabled/mpm_worker.load /etc/apache2/mods-enabled/mpm_worker.conf 2>/dev/null || true

# Rehabilitar prefork y rewrite
a2enmod mpm_prefork rewrite || true

# Debug: lista de módulos activos
echo "[entrypoint] módulos cargados:"
apache2ctl -M | grep mpm || true

# Ejecutar cualquier inicialización adicional aquí si es necesario
# Por ejemplo, migraciones de BD o comandos personalizados

# Iniciar Apache en foreground
apache2-foreground