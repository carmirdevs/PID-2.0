# Dataset sintético PID 2.0 — SIM-001

**Versión:** 0.1 · **Generado:** 15-11-2026 · **Naturaleza:** datos 100 % ficticios.  
**Estado:** escenario diseñado para la Actividad 2 y la PoC; **no** corresponde a observación institucional ni a ejecución del software.

## Contenido
- `usuarios.csv`: 3 registros
- `periodos.csv`: 1 registros
- `asignaturas.csv`: 1 registros
- `grupos_academicos.csv`: 1 registros
- `planeaciones.csv`: 1 registros
- `unidades.csv`: 2 registros
- `actividades.csv`: 4 registros
- `ejecuciones.csv`: 2 registros
- `solicitudes_cambio.csv`: 2 registros
- `decisiones_cambio.csv`: 2 registros
- `versiones_planeacion.csv`: 2 registros
- `eventos_auditoria.csv`: 5 registros

## Escenario
Una planeación ficticia (ID 1), dos unidades, cuatro actividades y dos solicitudes:
- Solicitud 1: **aprobada**, cambia la programación de actividad 3 (15–19 a 17–21 de febrero de 2027); se genera versión 2.
- Solicitud 2: **rechazada**, intenta extender actividad 4 hasta 5 de marzo; versión vigente permanece en 2.
- Versión 1 conserva fechas originales. La versión 2 conserva las fechas modificadas de actividad 3 y mantiene sin cambios la actividad 4.
- Las tablas `actividades.csv` representan la **línea base**, mientras `versiones_planeacion.csv` contiene instantáneas históricas. **No** se deben interpretar las fechas de `actividades.csv` como la versión vigente después de la aprobación. Este es un compromiso de representación del dataset, no una arquitectura aprobada.
- Los eventos de auditoría están preparados para verificar orden y procedencia, no son registros producidos por un software en funcionamiento.

## Reglas de uso
1. Datos de ejemplo, no de producción; no inferir estadísticas reales.
2. IDs y referencias deben conservar integridad.
3. El JSON embebido en CSV usa comillas escapadas según RFC 4180.
4. Estados, roles y fechas son **supuestos de prueba**, sujetos a validación institucional.
5. No hay contraseñas, datos personales reales ni documentos institucionales.
6. Los eventos y decisiones son **resultados simulados predefinidos**, no resultados de ejecución.
7. Para una importación SQL definitiva se requiere decidir el diseño de versionado, identidad estable de actividades y reglas de autorización.

## Casos de aceptación previstos

| Caso | RF/RNF | Entrada o condición | Resultado esperado | Ejecución |
|---|---|---|---|---|
| CP-01 | RF-01, RF-02 | Planeación 1, 2 unidades, 4 actividades | Relaciones y conteos correctos | No ejecutado |
| CP-02 | RF-03 | Fecha fin anterior a inicio | Validación rechaza la entrada | No ejecutado |
| CP-03 | RF-04, RF-09 | Versiones 1 y 2 | Línea base se conserva y se consulta | No ejecutado |
| CP-04 | RF-05 | Ejecuciones 1 y 2 | Estado y fechas reales asociados a actividad | No ejecutado |
| CP-05 | RF-06–RF-09 | Solicitud 1 aprobada | Versión 2 generada, actividad 3 reprogramada | No ejecutado |
| CP-06 | RF-07–RF-09 | Solicitud 2 rechazada | Versión vigente 2; actividad 4 no cambia | No ejecutado |
| CP-07 | RNF-03 | Docente intenta autorizar | Operación denegada sin cambios | No ejecutado |
| CP-08 | RNF-05 | Intento de editar evento de auditoría | Operación denegada | No ejecutado |
| CP-09 | RF-10 | Avance sobre actividades | No calcular porcentaje definitivo hasta aprobar fórmula | Pendiente definición |

## Comprobaciones estructurales previstas
- Todas las referencias `*_id` apuntan a registros existentes del conjunto, salvo `solicitud_origen_id` vacío de línea base.
- `planeaciones.version_vigente_id=2` refiere a versión 2 de la misma planeación.
- Solicitudes 1 y 2 tienen una decisión cada una.
- Solo la solicitud aprobada origina una versión posterior.
- Las fechas de la actividad 4 son idénticas en las dos versiones.

**Fuentes de diseño:** [Diccionario inicial](../../docs/DICCIONARIO_DATOS_INICIAL_P2.md) y [Catálogo de requerimientos](../../docs/REQUERIMIENTOS_INICIALES.md).
