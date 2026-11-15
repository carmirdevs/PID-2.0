# EV-OBS-001 — Aplicación documentada de I-02 mediante inspección estática

**Fecha:** 15-11-2026  
**Instrumento:** [I-02 — Guía de observación e inspección técnica](../instrumentos/I-02_GUIA_OBSERVACION_TECNICA.md)  
**Sistema observado:** [PID-Original](https://github.com/carmirdevs/PID-Original), rama `main`  
**Modalidad:** revisión estática de archivos remotos mediante acceso autorizado a GitHub.  
**Responsable de registro:** equipo de investigación PID 2.0, con asistencia de análisis automatizado.  
**Estado:** APLICADO PARCIALMENTE, exclusivamente a código y esquema SQL. **No** se observaron usuarios ejecutando el sistema, **no** se realizaron entrevistas ni pruebas funcionales.

## 1. Protocolo y trazabilidad

Se consultaron directamente archivos del repositorio remoto. Para reproducir: abrir el archivo indicado, localizar la función o definición señalada y contrastar con el criterio de cada ítem I-02. No se usaron datos personales, credenciales ni base de datos institucional. Los resultados no acreditan comportamiento en producción.

## 2. Registro de ítems efectivamente inspeccionados

| Ítem I-02 | Fuente remota y operación inspeccionada | Resultado observado en código | Estado | Requerimientos |
|---|---|---|---|---|
| OBS-01 | `controladores/controlador_session.php`, `login_bd()`; `clases/seguridad.php`, `valida_permiso()` | El inicio de sesión filtra por usuario, contraseña y estado; genera `session_id` con MD5 sobre cadena y tiempo. La clase de seguridad consulta permisos por grupo y método y lee `session_id` de GET. | Identificado en código; no probado en ejecución | RNF-01, RNF-02, RNF-03 |
| OBS-02 | `controladores/controlador_instrumentaciones.php`, `alta()`, `configuracion()`; esquema `instrumentaciones` | Formularios y relaciones de carrera, materia, docente, periodo, bloque y grupo; tabla con identificadores correspondientes. | Identificado en código; no probado | RF-01 |
| OBS-03 | `controladores/controlador_instrumentaciones.php`, `cargarArchivo()`; `views/instrumentaciones/_formularioSubirArchivo.php` | `subir_archivo(array('xlsx'), ...)` y etiqueta «Formato de Excel .XLSX». | Identificado en código; no se cargó archivo de prueba | RF-12, RNF-07 |
| OBS-04 | `controladores/controlador_instrumentaciones.php`, `modificar_instrumentacion_bd()`, `cargarArchivo()` | Incrementa contador y registra fecha; utiliza carga de archivo con sufijo MOD. No hay evidencia en estas funciones de edición estructurada de actividades. | Identificado en código; ausencia global no demostrada | RF-06, RF-09 |
| OBS-05 | `controladores/controlador_instrumentaciones.php`, `cargarArchivo()`; esquema `instrumentaciones` | Actualiza campo de fecha con `date('Y-m-d H:i:s')` y `numero_modificaciones`. | Identificado en código; reloj real no contrastado | RF-09 |
| OBS-06 | `controladores/controlador_instrumentaciones.php`, `entregarReporte1Bd()` a `entregarReporte4Bd()`, `reporte_carrera_bd()` | Cuatro operaciones de entrega; selección de vista de reporte según `fecha_reporte1` a `fecha_reporte4`. | Identificado en código; PDF no generado durante esta aplicación | RF-11 |
| OBS-07 | Esquema SQL depurado, tabla `instrumentaciones`; controlador de instrumentaciones | La tabla registra relaciones académicas, fechas de entrega y contador, sin campos de unidad/actividad estructurada en dicha tabla. | Alcance restringido a fuentes revisadas; **no acredita ausencia en todo el proyecto** | RF-02, RF-05 |
| OBS-08 | Esquema SQL depurado, tabla `instrumentaciones` | No aparecen campos por actividad para fecha prevista y fecha real en esa tabla. | Inspección parcial; pendiente ampliar búsqueda | RF-03, RF-05 |
| OBS-09 | Controlador de instrumentaciones y esquema SQL depurado | No se observó en las fuentes inspeccionadas un flujo completo de solicitud y aprobación académica. | **No identificado en el alcance**, no prueba de inexistencia | RF-06–RF-08 |
| OBS-10 | `numero_modificaciones` y `fecha_modificacion` en controlador y tabla | Existen contador y fecha; no bastan por sí solos para demostrar versionado íntegro e inmutable. | Identificado en código; versiones anteriores no comprobadas | RF-04, RF-09 |
| OBS-11 | `clases/archivosServidor.php`, `subir_archivo()`, `ver_archivo()` | Comprueba extensión, llama `move_uploaded_file()` y usa URL pública/Office Web Viewer. No se observó verificación MIME ni límite de tamaño en esas funciones. | Identificado en código; no prueba de explotación | RNF-06, RNF-07 |
| OBS-12 | `clases/seguridad.php`; formulario `_formularioSubirArchivo.php` | Token de sesión por GET; en el formulario examinado no aparece campo CSRF. | Inspección parcial; otros controles pendientes | RNF-02–RNF-04 |
| OBS-13 | Sin dataset operativo autorizado | No se midieron frecuencias, volúmenes ni tiempos de operación. | **No evaluado** | RF-10, RF-11 |
| OBS-14 | Sin ejecución del sistema | No se realizaron pruebas de entradas inválidas ni excepciones. | **No evaluado** | RNF-03, RNF-04, RNF-07 |

## 3. Hallazgos clasificados

**HE-01 (confirmado en código):** la interfaz y el controlador de carga de instrumentaciones contemplan XLSX.  
**HE-02 (confirmado en código):** la modificación documental actualiza fecha y contador de modificaciones; el equipo describe la operación histórica como sustitución del archivo.  
**HE-03 (confirmado en código):** el sistema tiene vínculos con carrera, asignatura, docente, periodo, bloque y grupo.  
**HE-04 (confirmado en código):** existen funciones de entrega de cuatro reportes.  
**HE-05 (riesgo de seguridad identificado):** autenticación con comparación directa de contraseña y sesión basada en MD5; pendiente evaluación operativa.  
**HE-06 (limitación de evidencia):** no se demostró ejecución, autorización académica de cambios, versionado íntegro ni seguimiento por actividad. La falta de identificación en esta inspección **no demuestra ausencia absoluta**.

## 4. Transacciones, entradas, salidas y controles

| Proceso | Entrada identificada | Transformación identificada | Salida registrada o prevista | Control observado | Frecuencia/volumen |
|---|---|---|---|---|---|
| Carga de instrumentación | Archivo XLSX e ID de instrumentación | Guardar archivo y actualizar fecha | Archivo registrado, fecha | Validación de extensión | No medido |
| Sustitución documental | XLSX e ID | Incrementar contador, guardar archivo y fecha | Registro de modificación | Identificación de registro | No medido |
| Entrega de reportes | Archivo XLSX e ID | Guardar entrega correspondiente | Fecha de reporte | Flujo por método | No medido |
| Consulta de reportes | Filtros de carrera, periodo, bloque, grupo y tipo | Obtener datos y seleccionar vista | Reporte PDF previsto por código | Permisos generales por método | No medido |

## 5. Contradicciones y asuntos pendientes

- **CON-001 (aclarada en el diagnóstico):** P1 mencionaba recepción PDF; última versión histórica recibe XLSX. La salida PDF para reportes es distinta de la entrada de instrumentaciones.
- **CON-002 (aclarada conceptualmente):** «modificar instrumentación» en PID original significa sustituir archivo; no equivale a editar una actividad estructurada con aprobación.
- **PEND-001:** corroborar en entorno aislado los flujos de carga, sustitución, permisos y reportes.
- **PEND-002:** completar inspección de todos los módulos y del historial Git antes de afirmar inexistencia de capacidades.
- **PEND-003:** medir frecuencia y volumen solo con información autorizada o simulaciones expresamente etiquetadas.
- **PEND-004:** aplicar I-01 a participantes reales, o documentar imposibilidad de aplicación.

## 6. Dictamen metodológico

**I-02 aplicada parcialmente a fuentes técnicas reales.** Los hallazgos son evidencia directa de **implementación estática**; no constituyen observación funcional ni evaluación del desempeño. Pueden incorporarse al apartado V de P2 con estas limitaciones y servir como base provisional para la matriz de trazabilidad. La aplicación del componente operativo de I-02 continúa pendiente.
