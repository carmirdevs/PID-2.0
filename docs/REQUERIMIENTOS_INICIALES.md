# PID 2.0 — Catálogo inicial de requerimientos (borrador P2)

**Versión:** 0.1 · **Fecha:** 15-11-2026 · **Estado:** propuesta para validación, no especificación aprobada.

## 1. Base de evidencia y alcance

- **Fuente técnica:** [Informe de revisión de PID-Original](https://github.com/carmirdevs/PID-Original/blob/main/docs/INFORME_REVISION_TECNICA.md), evidencias `EV-COD-001` a `EV-COD-008` y observaciones `SEG-01` a `SEG-06`.
- **Fuente contextual (CTX-01):** caracterización histórica confirmada por el equipo: la última versión del PID recibía instrumentaciones XLSX y permitía **sustituir el archivo**, pero no editar estructuradamente actividades o fechas.
- **Fuente de propuesta (PROP-01):** objetivo de PID 2.0, sujeto a validación con actores académicos.
- **Fuente de seguridad (SEG):** riesgos de inspección estática; no son pruebas de explotación.
- **Prioridades:** Alta (imprescindible para la PoC), Media (siguiente incremento), Baja (posterior). La prioridad **no equivale** a aprobación institucional.
- **Estados:** todos los requerimientos están **propuestos**, sin entrevistas, pruebas de aceptación ni autorización institucional de diseño documentadas.
- **Regla de interpretación:** no identificar un módulo en una revisión estática no demuestra su ausencia absoluta.

## 2. Requerimientos funcionales

| ID | Requerimiento propuesto | Fuente | Prioridad | Justificación | Criterio de aceptación verificable |
|---|---|---|---|---|---|
| RF-01 | El sistema permitirá registrar una planeación por periodo, asignatura, grupo y docente autorizado. | EV-COD-007, PROP-01 | Alta | Mantener el contexto académico del PID. | Dado un docente autorizado y datos válidos, se crea una planeación vinculada a un periodo, asignatura y grupo; no se admite una relación inexistente. |
| RF-02 | Cada planeación permitirá registrar unidades temáticas y actividades con identificadores únicos y descripción. | CTX-01, PROP-01 | Alta | Habilitar seguimiento granular. | Una planeación de prueba admite al menos dos unidades y dos actividades por unidad; cada actividad se consulta con su unidad correspondiente. |
| RF-03 | Cada actividad tendrá fecha programada de inicio y fin, con validación de orden cronológico. | CTX-01, PROP-01 | Alta | Establecer programación verificable. | El sistema rechaza una fecha final anterior a la inicial y guarda un intervalo válido. |
| RF-04 | Al aprobar/publicar una planeación inicial se conservará una línea base identificable. | PROP-01 | Alta | Comparar ejecución y cambios. | Tras crear la línea base, su contenido permanece consultable e inalterado ante cambios posteriores. |
| RF-05 | El docente registrará fechas reales y estado de ejecución de cada actividad. | CTX-01, PROP-01 | Alta | Medir avance real. | Un registro de prueba almacena fecha real y estado y se recupera asociado a la actividad y al usuario. |
| RF-06 | El sistema permitirá solicitar cambios de fecha o contenido de actividad, indicando motivo y valores propuestos. | CTX-01, PROP-01 | Alta | Formalizar solicitudes. | Una solicitud contiene actor, fecha, motivo, valores actuales y propuestos; aparece como pendiente sin alterar la línea base. |
| RF-07 | Solo el responsable académico configurado podrá aprobar o rechazar solicitudes de cambio de su ámbito. | PROP-01 | Alta | Respetar autoridad académica. | Una cuenta docente no puede decidir una solicitud; un autorizador competente puede aprobarla o rechazarla con registro de decisión. |
| RF-08 | Una solicitud aprobada producirá una nueva versión de la planeación; una rechazada no cambiará la versión vigente. | PROP-01 | Alta | Evitar cambios no autorizados. | En dos escenarios de prueba, aprobación crea nueva versión y rechazo conserva íntegra la anterior. |
| RF-09 | El sistema conservará historial de versiones con actor, fecha, motivo, decisión y diferencias relevantes. | EV-COD-001, PROP-01 | Alta | Superar el mero contador de sustituciones. | Se pueden consultar versión inicial y posterior sin sobrescritura y reconstruir quién autorizó el cambio. |
| RF-10 | El sistema mostrará avance por actividad, unidad y planeación según una regla de cálculo documentada. | PROP-01 | Media | Facilitar supervisión programática. | Para un conjunto sintético con resultados esperados definidos, el porcentaje mostrado coincide con la fórmula aprobada. **Fórmula pendiente de validación.** |
| RF-11 | El sistema permitirá consultar reportes por periodo, asignatura, grupo y estado de actividades, según permisos. | EV-COD-003, EV-COD-006, PROP-01 | Media | Mantener reportabilidad y ampliarla. | Un usuario autorizado filtra un conjunto sintético y obtiene los registros esperados; otro sin permiso no accede. |
| RF-12 | La gestión documental XLSX original se preservará como capacidad de referencia o integración futura, sin equipararla a edición estructurada. | EV-COD-001, EV-COD-002, CTX-01 | Media | Evitar pérdida de la función documental. | Se documenta y valida una ruta de carga/consulta XLSX con archivo sintético; **no es obligatoria en la PoC mínima**. |

## 3. Requerimientos no funcionales

| ID | Requerimiento propuesto | Fuente | Prioridad | Justificación | Criterio de aceptación verificable |
|---|---|---|---|---|---|
| RNF-01 | Las contraseñas se almacenarán con un algoritmo de hash apropiado y verificación segura. | SEG-01 | Alta | Evitar comparación y almacenamiento inseguro. | En una base de prueba no aparece la contraseña en claro; autenticación correcta e incorrecta produce los resultados esperados. |
| RNF-02 | La autenticación utilizará sesiones de servidor con identificadores no expuestos en URL y cookies configuradas de forma segura. | SEG-02 | Alta | Reducir exposición de sesiones. | Navegación autenticada no contiene identificadores de sesión en parámetros URL; cookies aplican `HttpOnly`, `Secure` bajo HTTPS y `SameSite` definido. |
| RNF-03 | Todas las operaciones de modificación y autorización comprobarán permisos en servidor. | EV-COD-005, PROP-01 | Alta | Evitar escalamiento por interfaz o URL. | Solicitudes HTTP de usuario sin permiso a cada endpoint protegido reciben denegación y no modifican datos. |
| RNF-04 | Los formularios que cambien estado incorporarán protección CSRF. | SEG-05 | Alta | Evitar solicitudes no autorizadas desde otro origen. | Una petición sin token válido se rechaza sin alterar registros. |
| RNF-05 | La bitácora de decisiones será persistente y no modificable por usuarios ordinarios. | PROP-01 | Alta | Trazabilidad y auditabilidad. | Usuarios docente y autorizador no pueden editar ni borrar eventos históricos mediante la aplicación. |
| RNF-06 | Los documentos y evidencias estarán protegidos contra acceso anónimo. | SEG-04 | Media | Confidencialidad académica. | Una URL de archivo sin sesión válida no devuelve el documento; un usuario autorizado sí. |
| RNF-07 | Las cargas de XLSX, cuando se implementen, validarán extensión, tipo, tamaño y contenido. | SEG-03 | Media | Reducir archivos inválidos o peligrosos. | Un XLSX sintético válido se acepta; archivo con extensión falsa y archivo superior al límite configurado se rechazan. |

## 4. Reglas de negocio candidatas

| ID | Regla | Estado |
|---|---|---|
| RN-01 | El docente puede registrar ejecución, pero no aprobar su propia solicitud de cambio salvo autorización institucional expresa. | Pendiente de validación |
| RN-02 | La planeación original no se sobrescribe al aprobar modificaciones. | Propuesta esencial |
| RN-03 | Una solicitud rechazada conserva evidencia de su decisión y no altera la planeación vigente. | Propuesta esencial |
| RN-04 | La autoridad aprobadora se determina por ámbito académico configurable, no por nombre fijo de una persona. | Pendiente de validación |
| RN-05 | La fórmula de avance, las fechas límite y los estados válidos se definirán con responsables académicos antes de aprobar el catálogo. | Pendiente de validación |

## 5. Trazabilidad preliminar problema–objetivo–evidencia–requerimiento

| Problema/necesidad | Objetivo de análisis | Evidencia disponible | Requerimientos relacionados |
|---|---|---|---|
| Sustitución documental sin actualización programática estructurada | OE-P2-01 / OE-P2-03 | EV-COD-001, EV-COD-002, CTX-01 | RF-02, RF-03, RF-05, RF-12 |
| Necesidad de control de cambios académicos | OE-P2-02 / OE-P2-04 | PROP-01; requiere validación con actores | RF-06, RF-07, RF-08, RN-01 a RN-04 |
| Ausencia de evidencia de versionado íntegro | OE-P2-01 / OE-P2-04 | EV-COD-001; inspección estática limitada | RF-04, RF-09, RNF-05 |
| Reportabilidad académica | OE-P2-03 / OE-P2-04 | EV-COD-003, EV-COD-006 | RF-10, RF-11 |
| Riesgos de autenticación, sesión y permisos | OE-P2-04 / OE-P2-05 | EV-COD-005, EV-COD-008, SEG-01, SEG-02 | RNF-01, RNF-02, RNF-03 |
| Riesgos de solicitudes y archivos | OE-P2-04 / OE-P2-05 | SEG-03, SEG-04, SEG-05 | RNF-04, RNF-06, RNF-07 |

**Advertencia metodológica:** `PROP-01` es una **propuesta de diseño**, no evidencia empírica; los requerimientos que dependen de ella requieren corroboración mediante instrumentos de P2. Los códigos `OE-P2` corresponden a objetivos de trabajo preliminares y deben conciliarse con la versión final del artículo IEEE.

## 6. Alcance mínimo de la prueba de concepto (semana 4)

Se evaluará un flujo integrado con **datos sintéticos**:

1. Crear planeación con unidades y actividades.
2. Definir fechas programadas y registrar línea base.
3. Registrar fecha real de ejecución.
4. Solicitar cambio justificado de una actividad.
5. Resolver solicitud con un usuario autorizador.
6. Generar versión nueva únicamente si se aprueba.
7. Consultar historial y demostrar que la versión inicial se conserva.

**No se declara implementado ni probado** ninguno de estos pasos.

## 7. Validaciones pendientes

- Aplicar entrevista semiestructurada y guía de observación, o justificar explícitamente sustitución por fuentes documentales/sintéticas.
- Confirmar actores, reglas de autorización, campos, estados y fórmula de avance.
- Evaluar conflictos, ambigüedad, completitud, factibilidad y criterios de aceptación.
- Completar matriz de trazabilidad con evidencia empírica y pruebas.
- Revisar requerimientos de seguridad con escenarios de prueba.

## 8. Criterio de control de cambios del catálogo

Cada modificación deberá registrar fecha, ID afectado, razón, evidencia nueva, decisión y responsable. La versión 0.1 no implica aprobación del docente ni de una autoridad institucional.
