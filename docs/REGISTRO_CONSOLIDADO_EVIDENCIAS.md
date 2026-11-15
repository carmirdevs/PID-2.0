# Registro consolidado de evidencias — PID 2.0

**Versión:** 0.1 · **Fecha:** 2026-11-15 · **Estado:** consolidación documental y estática, no validación funcional.

## Criterios
- **EC**: evidencia comprobada en código o esquema (no en ejecución).
- **CTX**: aclaración histórica del equipo; requiere contraste independiente cuando proceda.
- **PROP**: hipótesis de necesidad o decisión de diseño, no hallazgo empírico.
- **PEND**: no evaluado o pendiente de triangulación.
- Las observaciones negativas significan «no identificado en el alcance inspeccionado», no ausencia absoluta.

## Registro

| ID | Clase | Fuente concreta | Hallazgo y límite | Relación |
|---|---|---|---|---|
| EV-COD-001 | EC | PID-Original: `controladores/controlador_instrumentaciones.php`, `cargarArchivo()`, `modificar_instrumentacion_bd()` | Carga XLSX, fecha y contador de modificaciones; no acredita versiones inmutables. | RF-06, RF-09, RF-12 |
| EV-COD-002 | EC | `views/instrumentaciones/_formularioSubirArchivo.php` | Interfaz indica formato XLSX. | RF-12 |
| EV-COD-003 | EC | `controladores/controlador_instrumentaciones.php`, `entregarReporte1Bd()` a `entregarReporte4Bd()` | Cuatro operaciones de entrega; ejecución no probada. | RF-11 |
| EV-COD-004 | EC | `clases/archivosServidor.php` | Valida extensión, usa `move_uploaded_file()`, ofrece Office Web Viewer mediante URL pública. | RNF-06, RNF-07 |
| EV-COD-005 | EC | `clases/seguridad.php`, `valida_permiso()` | Permisos por grupo y método; lee `session_id` desde GET. | RNF-02, RNF-03 |
| EV-COD-006 | EC | `views/instrumentaciones/reporteInstrumentaciones.php` y `reporteSemanas.php` | Plantillas de salida PDF; no implica admisión de PDF como entrada. | RF-11 |
| EV-COD-007 | EC | `Basededatos/escolarizado_estructura_sin_datos.sql` | Esquema de 16 tablas; instrumentaciones vincula docente, carrera, materia, grupo, bloque y periodo. | RF-01, RF-02, RF-03, RF-05 |
| EV-COD-008 | EC | `controladores/controlador_session.php`, `login_bd()` | Filtra por contraseña directamente y genera sesión con MD5; no prueba explotación. | RNF-01, RNF-02 |
| EV-OBS-001 | EC | `docs/evidencias/EV-OBS-001_APLICACION_ESTATICA_I02.md` | Primera aplicación parcial I-02; 14 ítems registrados, sin ejecución. | RF-01–RF-12, RNF-01–RNF-07 según ítem |
| CTX-01 | CTX | Aclaración del equipo investigador | Última versión recibe XLSX y sustituye archivos, sin edición programática estructurada. | RF-02, RF-03, RF-05, RF-06, RF-12 |
| PROP-01 | PROP | Objetivo de PID 2.0 | Seguimiento por actividad, autorizaciones, línea base, versiones y trazabilidad propuestos. | RF-01–RF-12, RNF-03, RNF-05 |
| SEG-01 | EC | EV-COD-008 | Comparación directa de contraseña. | RNF-01 |
| SEG-02 | EC | EV-COD-005, EV-COD-008 | Token por GET y generación basada en MD5. | RNF-02 |
| SEG-03 | EC | EV-COD-004 | Validación de extensión; otros controles no observados en función revisada. | RNF-07 |
| SEG-04 | EC | EV-COD-004 | Construcción de URL pública para archivos. | RNF-06 |
| SEG-05 | PEND | Formulario inspeccionado en EV-OBS-001 | No se observó token CSRF en ese formulario; revisar demás capas. | RNF-04 |
| SEG-06 | EC | Informe técnico de PID-Original | Variantes de controladores identificadas en revisión inicial. | Diseño y mantenimiento |

## Incidencias y decisiones

| ID | Situación | Resolución / estado | Fundamento |
|---|---|---|---|
| CON-001 | Descripción histórica de entrada PDF frente a XLSX | Aclaración del equipo: última versión usa XLSX; los reportes pueden salir en PDF. **Contraste funcional pendiente.** | CTX-01, EV-COD-001/002/006 |
| CON-002 | «Modificar instrumentación» confundido con edición programática | Diferenciar sustitución documental de edición estructurada autorizada. **Aclaración conceptual, validación de proceso pendiente.** | CTX-01, EV-COD-001 |
| DEC-001 | No afirmar que falta una función en todo el sistema a partir de inspección parcial | Adoptada como regla metodológica del estudio; no como decisión institucional de producto. | EV-OBS-001 |
| DEC-002 | No presentar necesidades propuestas como evidencia empírica | Adoptada como regla metodológica; requerimientos permanecen propuestos. | PROP-01 |

## Limitaciones y acciones
1. No se han realizado entrevistas I-01 ni observación funcional.
2. No se han medido frecuencias, volúmenes, tiempos ni resultados de aceptación.
3. La inspección estática no acredita ausencia global de módulos.
4. Se requiere identificar versión/commit fijo del original para reproducibilidad.
5. Las reglas de autorización y fórmula de avance requieren validación institucional.

**Fuentes de control:** [Informe técnico PID-Original](https://github.com/carmirdevs/PID-Original/blob/main/docs/INFORME_REVISION_TECNICA.md) · [I-02 aplicada parcialmente](evidencias/EV-OBS-001_APLICACION_ESTATICA_I02.md).
