# Síntesis de resultados P4 — PID 2.0

## Resultados verificables de la PoC
- POC-01: V0 visualizada con dos unidades y cuatro actividades; no acredita el alta dinámica de nuevas planeaciones.
- POC-02: solicitud 2 aprobada por coordinador A; V1 conserva V0 y modifica A2 del 18 al 22/01/2027.
- POC-03: solicitud 3 rechazada; SQL confirma versión vigente V1, dos versiones y A3 sin cambio (01/02/2027).
- POC-04 y POC-05: reporte JSON de ejecución del 23/11/2026 confirma denegación desde docente y coordinador de otro departamento, sin cambios de solicitud/versiones.
- POC-06: solicitud 1 basada en V0 marcada como conflicto después de V1; SQL confirma que no se creó V2.
- POC-07: solicitudes 5 y 6 creadas sobre V1; HTTP 200 con resultados `aprobada` y `conflicto`. SQL confirma V2 vigente y tres versiones. **No se comprobó solapamiento transaccional**.
- POC-08: SQL devuelve 12 filas de actividades por versión (V0, V1, V2), seis solicitudes (dos aprobadas, dos rechazadas, dos conflictos) y 12 eventos de auditoría.

## Cambios históricos comprobados
| Versión | Solicitud origen | A1 | A2 | A3 | A4 |
|---|---|---|---|---|---|
| V0 | Ninguna | 2027-01-11 | 2027-01-18 | 2027-02-01 | 2027-02-08 |
| V1 | 2 | 2027-01-11 | 2027-01-22 | 2027-02-01 | 2027-02-08 |
| V2 | 5 | 2027-01-14 | 2027-01-22 | 2027-02-01 | 2027-02-08 |

## Evidencia y procedencia
Capturas de cPanel/phpMyAdmin compartidas durante la validación, junto con `PID20_pruebas_controladas.json`. El informe Word/PDF de P4 se conserva por separado; este directorio no incluye capturas que no hayan sido incorporadas explícitamente.

## Pendientes
1. Prueba instrumentada de contención de bloqueo en dos transacciones.
2. Casos negativos específicos de autenticación, sesiones, CSRF y controles OWASP ASVS.
3. Conciliación requisito a requisito con criterios textuales del catálogo P2.
4. Contraste de resultados de encuesta al finalizar la recolección.
5. Registro de versiones de código, entorno PHP/MariaDB y fecha de cada ejecución.