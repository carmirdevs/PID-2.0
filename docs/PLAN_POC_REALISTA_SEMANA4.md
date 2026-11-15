# Corrección 3 — Plan realista de prueba de concepto (PoC) PID 2.0

**Versión:** 0.1 · **Fecha:** 2026-11-15 · **Estado:** planificación prospectiva; no implica horas ejecutadas ni software terminado.  
**Equipo:** Carlos Alberto Becerra Grajales y Miriam Crisanto Zetina.  
**Observación docente atendida:** distinguir modelo funcional, prototipo y PoC; delimitar una demostración de semana 4 y corregir la interpretación de cinco iteraciones/320 horas dentro del seminario.

## 1. Distinción conceptual

- **Modelo funcional (artefacto de investigación):** constructos, relaciones, reglas, estados e invariantes del MTPD-ID. Se describe independientemente del lenguaje de programación.
- **Prototipo:** implementación parcial para explorar una interfaz, arquitectura o flujo. Puede no ejecutar todos los procesos.
- **PoC:** implementación ejecutable y verificable del flujo mínimo que ponga a prueba la viabilidad técnica de una selección explícita de invariantes. No es un sistema institucional completo ni demuestra impacto organizacional.
- **Evolución institucional posterior:** cinco iteraciones y 320 horas del planteamiento original se conservan únicamente como escenario preliminar ampliado, sujeto a nueva estimación. **No forman parte del compromiso de cuatro semanas.**

## 2. Objetivo de la PoC

Comprobar, con datos sintéticos, si es técnicamente viable implementar un flujo de control de modificaciones de instrumentación didáctica que preserve una línea base, impida cambios no autorizados y permita reconstruir la versión vigente y su procedencia.

## 3. Alcance incluido y excluido

**Incluido (mínimo obligatorio):**
1. Crear/consultar una planeación sintética con dos unidades y cuatro actividades (RF-01, RF-02, RF-03).
2. Fijar y consultar línea base V0 sin sobrescritura (RF-04; INV-01).
3. Registrar al menos una fecha real y estado de ejecución (RF-05).
4. Registrar solicitud con actividad, versión de origen, valores actuales/propuestos y motivo (RF-06).
5. Resolver como autorizador de prueba: aprobar o rechazar (RF-07; INV-02).
6. Al aprobar, generar V1 y una traza; al rechazar, no alterar la vigente (RF-08, RF-09; INV-03, INV-04).
7. Consultar línea base, versión vigente y decisiones para reconstrucción básica (INV-07).

**Controles mínimos transversales:** cuentas sintéticas separadas de docente y autorizador; autorización en servidor; hash de contraseñas; sesiones seguras; protección CSRF en operaciones mutantes; registro persistente de decisiones. Estos controles no deben sacrificarse para cumplir el cronograma.

**Fuera de la PoC mínima:** integración con PID-Original en producción; importación XLSX; reportes PDF completos; analítica institucional; tablero multi-carrera; indicadores avanzados de avance (RF-10); notificaciones; migración de datos reales; pruebas de carga; evaluación de usabilidad con muestra real; despliegue productivo. El control de concurrencia completo (INV-08) y una bitácora a prueba de manipulación fuera de la aplicación (INV-09) se consideran extensiones si hay tiempo; la PoC sí debe evitar sobrescritura accidental básica mediante verificación de versión de origen.

## 4. Tecnología de referencia (decisión provisional)

PHP 8.x, MariaDB/MySQL y una interfaz web mínima; entorno aislado local, sin datos institucionales. No se requiere reproducir el sistema original ni utilizar sus mecanismos inseguros de autenticación. La selección se basa en continuidad técnica del proyecto, no en superioridad experimental demostrada.

## 5. Plan de esfuerzo acotado

**Supuesto:** 2 integrantes; esfuerzo conjunto **48 horas-persona**, equivalente a 24 horas por integrante distribuidas en cuatro semanas (6 h/persona/semana). Son horas **estimadas**, no trabajadas. El cronograma admite reasignación y exige registrar horas reales.

| Semana | Actividad y entrega | Carlos (h) | Miriam (h) | Total (h) |
|---|---|---:|---:|---:|
| 1 | Delimitación, inspección de código y escenario de evaluación | 5 | 5 | 10 |
| 2 | Instrumentos, catálogo, trazabilidad y datos sintéticos | 5 | 5 | 10 |
| 3 | Modelo de datos, estados, endpoints mínimos y pruebas unitarias iniciales | 7 | 7 | 14 |
| 4 | Implementación final del flujo, pruebas de aceptación y evidencia reproducible | 7 | 7 | 14 |
| **Total** | | **24** | **24** | **48** |

**Nota de factibilidad:** las horas de las semanas 1 y 2 son asignaciones retrospectivas de esfuerzo **planificado**, no una afirmación de horas reales ya dedicadas. Dado que los documentos ya existen, se debe registrar el tiempo efectivamente invertido en lugar de reportar 10 h + 10 h como hechos. Las 28 horas-persona de semanas 3 y 4 son una meta exigente; si se detecta insuficiencia, se reducirá interfaz y alcance, no controles críticos.

## 6. Entregables verificables por semana

| Semana | Producto verificable | Criterio de cierre |
|---|---|---|
| 1 | Diagnóstico estático y alcance | Evidencias identificadas y limitaciones expresas |
| 2 | I-01/I-02, catálogo, matriz y dataset SIM-001 | Archivos versionados; I-02 aplicada parcialmente; no simular entrevistas |
| 3 | Esquema de PoC, definición de estados, endpoints y prueba inicial | Código ejecutable local con dataset sintético y pruebas básicas documentadas |
| 4 | Flujo de aprobación/rechazo, versionado, consulta y pruebas | Demostración reproducible y registro de resultados reales; si falla, documentar el fallo |

## 7. Demostración mínima de semana 4

**D-01:** docente sintético crea o consulta planeación, dos unidades y cuatro actividades.  
**D-02:** se publica V0 y se comprueba que su instantánea permanece igual.  
**D-03:** se registra ejecución de actividad.  
**D-04:** se solicita modificar fecha de actividad 3; antes de decidir, V0 y vigente no cambian.  
**D-05:** autorizador aprueba; se crea V1, con motivo y actor vinculados.  
**D-06:** otra solicitud sobre actividad 4 es rechazada; V1 sigue vigente.  
**D-07:** consulta de V0, V1, decisiones y estado de ejecución.  
**D-08:** docente intenta aprobar una solicitud; la operación se deniega.

## 8. Pruebas y métricas propuestas

| Prueba | Requisito/invariante | Resultado esperado | Evidencia exigida |
|---|---|---|---|
| TP-01 | RF-01–RF-03 | Planeación, 2 unidades, 4 actividades y fechas válidas | Captura/consulta de datos sintéticos |
| TP-02 | RF-04, INV-01 | V0 idéntica antes/después de aprobación | Comparación de instantáneas |
| TP-03 | RF-05 | Fecha real y estado recuperables | Consulta de ejecución |
| TP-04 | RF-06, INV-07 | Solicitud pendiente no cambia versión vigente | Consulta antes de decisión |
| TP-05 | RF-07, RF-08, INV-02/04 | Aprobación válida genera V1 con procedencia | Registros de solicitud, decisión, versión |
| TP-06 | RF-08, INV-03 | Rechazo conserva versión vigente | Comparación de estado |
| TP-07 | RF-09 | Reconstrucción de V0 y V1 | Consultas de historial |
| TP-08 | RNF-03 | Docente no puede aprobar | HTTP denegado y estado inalterado |
| TP-09 | RNF-01/02/04 | Credenciales seguras, sesión y CSRF | Pruebas de seguridad mínimas |

**Umbral propuesto:** 100 % de TP-02, TP-05, TP-06 y TP-08 exitosas para declarar demostrada la viabilidad del flujo crítico en el escenario sintético. No extrapolar a confiabilidad de producción. Cualquier falla se registra y analiza, sin ocultarla.

## 9. Riesgos de planificación y contingencias

| Riesgo | Señal temprana | Tratamiento |
|---|---|---|
| Exceso de alcance | Más de 28 h-persona estimadas para semanas 3 y 4 | Reducir vistas y reportes; conservar flujo crítico |
| Ambigüedad de autoridad académica | Sin validación del rol autorizador | Usar rol de prueba explícitamente hipotético, no afirmar regla institucional |
| Problemas de versionado | Se modifica V0 o no se recupera V1 | Priorizar almacenamiento de instantáneas y transacciones |
| Seguridad insuficiente | Contraseña en claro, sesión en URL o endpoints sin control | Bloquear demostración como exitosa hasta corregir controles mínimos |
| Falta de pruebas | No existe evidencia reproducible | Reservar tiempo de semana 4 para registrar entradas, salidas y resultados |

## 10. Límites y próximos ajustes

- El cronograma es **propuesta de esfuerzo**, no parte de horas registradas.
- La viabilidad técnica todavía no ha sido demostrada: depende de implementar y ejecutar la PoC.
- Las reglas académicas y fórmula de avance requieren validación.
- Las cinco iteraciones y 320 h se reubican fuera del seminario; no se declaran ejecutadas ni exigibles en la semana 4.
- La PoC no sustituye evaluación científica completa ni demuestra originalidad del MTPD-ID.
