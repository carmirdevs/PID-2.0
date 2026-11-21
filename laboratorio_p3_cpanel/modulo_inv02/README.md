# INV-02 — Laboratorio PHP CLI de solo lectura
No es autenticación real ni autorización de escrituras. Evalúa tres casos sintéticos con PDO: docente 1/planeación 1 DENEGADO; autorizador 2/planeación 1 PERMITIDO; autorizador 2/planeación 2 DENEGADO.
1. Guardar la carpeta fuera de public_html.
2. Crear un usuario MariaDB exclusivo con permiso SELECT únicamente sobre planeaciones, roles y usuario_roles de la base de pruebas.
3. Copiar config.example.php a config.local.php y colocar credenciales reales solo en el servidor; nunca subirlas a GitHub.
4. Ejecutar en Terminal cPanel: php -l inv02_cli.php; php inv02_cli.php
5. Conservar el JSON de resultados, revisando que no revele información sensible.
El módulo prohíbe uso HTTP, no recibe IDs desde usuarios, y no ejecuta INSERT, UPDATE ni DELETE. No demuestra control de identidad autenticada ni aprobación transaccional.
