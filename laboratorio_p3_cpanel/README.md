# P3 — Laboratorio SQL v3 en cPanel (solo pruebas)

**Estado:** preparado, no ejecutado. No usar con bases de producción ni datos académicos reales.

## Instalación segura
1. En cPanel crea una **base de datos nueva y vacía**, y un usuario exclusivo para pruebas. No reutilices credenciales del LMS.
2. Descarga el paquete SQL v3 de la conversación y conserva `esquema_v3_propuesto.sql` y `01_datos_sinteticos.sql`. **No importes los datos sintéticos anteriores sin corregir:** contienen publicaciones con relaciones inválidas (versión 3 vinculada a planeación 1 y versión 4 inexistente).
3. Importa el esquema desde phpMyAdmin **después de quitar** `CREATE DATABASE ...` y `USE pid20_p3_v3;`, porque cPanel normalmente restringe la creación de bases con ese nombre. Selecciona primero la base de pruebas creada.
4. Revisa que cPanel permita `CREATE TRIGGER`; algunos proveedores lo restringen. Comprueba que todos los triggers se hayan creado antes de cargar datos.
5. Corrige el lote de datos de prueba: usa únicamente `(1,1,1),(2,2,1)` en `publicaciones_version`. El esquema y los datos deben importarse en ese orden.
6. Ejecuta las pruebas manuales de `pruebas_negativas.sql` **una por una** desde phpMyAdmin. Los errores son el resultado esperado; revisa tanto el mensaje como que no haya mutaciones. **No ejecutes el lote completo sin supervisión**.
7. Exporta un informe con versión de MySQL/MariaDB, sentencias ejecutadas, SQLSTATE, resultados y estado final de tablas; elimina después la base de pruebas.

## Límites
- No se ha ejecutado este diseño en el servidor cPanel.
- La prueba de una sentencia fallida no demuestra por sí sola que se activó el trigger esperado.
- No prueban autorización por ámbito ni concurrencia real con dos conexiones.
- Una cuenta con privilegios de ALTER/DROP TRIGGER puede eludir los controles.
- La validación del SQL debe registrarse como evidencia técnica de P3, no como validación científica de MTPD-ID.

**Seguridad:** No subas archivos con credenciales a GitHub ni pongas un ejecutor SQL accesible desde una URL pública.
