# I-02 — Guía de observación e inspección técnica del PID original

**Proyecto:** PID 2.0 · **Versión:** 0.1 · **Estado:** guía diseñada; contiene referencias a inspección estática previa, NO a observación operativa realizada.  
**Objetivo:** documentar procesos, transacciones, decisiones, entradas, salidas y controles del PID original, distinguiendo evidencia estática, observación funcional y simulación.

## A. Ficha de sesión
- ID: OBS-____
- Fecha/hora: ____
- Observador: ____
- Entorno: inspección estática / pruebas aisladas / observación autorizada
- Versión/commit del sistema: ____
- Rol de prueba: ____
- Dataset: sintético / anonimizado / no aplica
- Autorización y alcance: ____
- Archivos y rutas revisadas: ____
- Evidencias vinculadas: ____

**Reglas:** no ejecutar pruebas en producción ni acceder a datos personales sin autorización específica; registrar fecha, versión, procedimiento, entradas y salidas; anonimizar capturas; no afirmar que una ruta funciona solo por existir en el código.

## B. Lista de verificación reproducible

Para cada punto: anotar **resultado** (Confirmado en ejecución / Identificado en código / No observado / No evaluado / Contradictorio), **procedimiento**, **evidencia** y **limitación**.

| ID | Objeto de observación | Procedimiento de inspección o prueba | Evidencia inicial disponible | Requerimientos |
|---|---|---|---|---|
| OBS-01 | Autenticación y roles | Revisar inicio de sesión, permisos y accesos según perfil en entorno aislado | EV-COD-005, EV-COD-008 (estática) | RNF-01–RNF-03 |
| OBS-02 | Relación docente–materia–grupo–periodo | Examinar esquema y formulario de asignación; probar asociaciones sintéticas | EV-COD-007 (estática) | RF-01 |
| OBS-03 | Carga de instrumentación XLSX | Revisar validaciones y probar XLSX sintético válido/inválido | EV-COD-001, EV-COD-002 (estática) | RF-12, RNF-07 |
| OBS-04 | Sustitución de archivo | Identificar comportamiento ante segunda carga y datos preservados | EV-COD-001 (estática); contexto CTX-01 | RF-06, RF-09 |
| OBS-05 | Registro de fecha y hora | Comparar timestamps almacenados con eventos de prueba | EV-COD-001, EV-COD-003 (estática) | RF-09 |
| OBS-06 | Entregas y reportes | Inspeccionar periodicidad, filtros y generación de PDF | EV-COD-003, EV-COD-006 (estática) | RF-11 |
| OBS-07 | Actividades por unidad | Buscar entidades y operaciones estructuradas; verificar interfaz si existe | No acreditada en revisión previa | RF-02, RF-05 |
| OBS-08 | Fechas programadas y reales | Buscar campos, operaciones y pantallas por actividad | No acreditada en revisión previa | RF-03, RF-05 |
| OBS-09 | Solicitud y autorización de cambios | Buscar estados, roles, decisiones y reglas; ensayar flujo si existe | No acreditada en revisión previa | RF-06–RF-08 |
| OBS-10 | Línea base e historial | Verificar conservación de versiones completas y consulta retrospectiva | EV-COD-001 solo acredita contador | RF-04, RF-09 |
| OBS-11 | Controles de archivos | Verificar extensión, MIME, tamaño, contenido, rutas y permisos | SEG-03, SEG-04 (estática) | RNF-06, RNF-07 |
| OBS-12 | Controles de formularios y sesiones | Inspeccionar tokens CSRF, cookies y controles por endpoint | SEG-02, SEG-05 (estática) | RNF-02–RNF-04 |
| OBS-13 | Frecuencia y volumen | Registrar conteos y duración con datos autorizados o sintéticos etiquetados | Sin mediciones empíricas | RF-10, RF-11 |
| OBS-14 | Errores y excepciones | Registrar mensajes, estados y cambios ante entradas inválidas | Sin pruebas operativas | RNF-03, RNF-04, RNF-07 |

## C. Formato de observación individual (duplicar por evento)

- **Código de evidencia:** EV-OBS-____
- **Ítem:** OBS-____
- **Objetivo y versión del sistema:** ____
- **Tipo de evidencia:** inspección estática / prueba funcional / documento / simulación
- **Procedimiento exacto:** ____
- **Entrada de prueba y origen:** ____
- **Resultado esperado:** ____
- **Resultado observado:** ____
- **Captura o ruta de código:** ____
- **Estado:** confirmado / no confirmado / contradictorio / pendiente
- **Restricción o posible sesgo:** ____
- **Requerimientos afectados:** ____
- **Responsable de verificación y fecha:** ____

## D. Registro de procesos y transacciones

| ID | Actor | Disparador | Entrada | Proceso/decisión | Salida | Frecuencia/volumen | Control | Evidencia |
|---|---|---|---|---|---|---|---|---|
| PROC-01 | Por identificar | Por verificar | XLSX | Recepción/sustitución | Registro documental | No medido | Por verificar | EV-COD-001 |
| PROC-02 | Por identificar | Por verificar | Datos de periodo | Reporte | PDF | No medido | Por verificar | EV-COD-003, EV-COD-006 |

## E. Criterios de rigor

- Triangular, cuando sea posible, **código + ejecución + documento + entrevista**.
- Registrar evidencia negativa como «no identificado en el alcance revisado», no como inexistencia absoluta.
- Las pruebas sintéticas deben identificarse como tales y no extrapolarse a operación institucional real.
- Mantener diferencias entre formato de entrada XLSX y reportes de salida PDF.
- Los hallazgos se trasladarán a resultados de P2 solo con procedencia, alcance y limitación explícitos.
