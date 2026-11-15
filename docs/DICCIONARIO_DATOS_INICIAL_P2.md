# PID 2.0 — Diccionario inicial de datos (Anexo P2)

**Versión:** 0.1 · **Fecha:** 15-11-2026 · **Estado:** borrador técnico sujeto a validación institucional.  
**Fuentes:** esquema SQL depurado de [PID-Original](https://github.com/carmirdevs/PID-Original/blob/main/Basededatos/escolarizado_estructura_sin_datos.sql), [revisión técnica](https://github.com/carmirdevs/PID-Original/blob/main/docs/INFORME_REVISION_TECNICA.md), [catálogo RF/RNF](REQUERIMIENTOS_INICIALES.md), [matriz de trazabilidad](MATRIZ_TRAZABILIDAD_P2.md).

## 1. Convenciones y límites

- **E**: entidad o campo observado en el esquema SQL del PID original; los tipos son los del DDL histórico.
- **P**: entidad, atributo o restricción **propuestos** para PID 2.0, no implementados ni validados.
- **PK/FK** en propuestas: claves y relaciones de diseño previstas, **no** constatación de restricciones en la base original.
- Campos de fechas y estados propuestos requieren reglas de negocio, calendario y roles validados.
- La inspección de estructura no demuestra que las transacciones funcionen ni que existan datos operativos.

## 2. Inventario de las 16 tablas originales (E)

| Tabla SQL | Función inferida por nombre y columnas | Campos representativos observados |
|---|---|---|
| `archivos` | Metadatos de archivos de instrumentación | `id`, `nombre_archivo`, `tipo_archivo`, `instrumentacion_id`, `fecha` |
| `bloques` | Catálogo de bloques | `id`, `nombre`, `status` |
| `carreras` | Catálogo de carreras | `id`, `nombre`, `status` |
| `grupos` | Catálogo de grupos de permisos | `id`, `descripcion_grupo`, `status` |
| `gruposalumnos` | Catálogo de grupos académicos | `id`, `nombre`, `status` |
| `imprimir` | Campos de salida para impresión/reporte | `nomcarrera`, `nommateria`, `fechaplan`, `reporte1`–`reporte4` |
| `instrumentaciones` | Relación académica y fechas de entregas | `id`, `carrera_id`, `materia_id`, `usuario_id`, `periodo_id`, `grupoalumnos_id`, `bloque_id`, `fecha_instrumentacion`, `fecha_modificacion`, `numero_modificaciones` |
| `materias` | Catálogo de materias | `id`, `clave`, `nombre`, `status` |
| `materia_carrera` | Asociación de materias y carreras | `id`, `materia_id`, `carrera_id` |
| `menus` | Catálogo de menús | `id`, `descripcion_menu`, `label_menu` |
| `metodos` | Acciones y métodos de interfaz | `id`, `descripcion_metodo`, `menu_id` |
| `metodo_grupo` | Asociación de métodos y grupos de permisos | `id`, `metodo_id`, `grupo_id` |
| `periodos` | Catálogo de periodos | `id`, `nombre`, `status` |
| `sessiones` | Registro histórico de sesiones | `id`, `session_id`, `usuario_id`, `grupo_id`, `fecha` |
| `usuarios` | Usuarios y credenciales históricas | `id`, `user`, `password`, `nombre`, `apellido_p`, `apellido_m`, `grupo_id` |
| `usuario_carrera` | Asociación usuario-carrera | `id`, `usuario_id`, `carrera_id` |

**Nota:** las tablas incluyen frecuentemente `usuario_alta_id`, `usuario_update_id`, `fecha_alta` y `fecha_update`. Estos metadatos no equivalen a un historial íntegro e inmutable de versiones de la planeación.

## 3. Campos históricos críticos verificados (E)

| Tabla.campo | Tipo original | Interpretación limitada |
|---|---|---|
| `instrumentaciones.id` | `int(11) NOT NULL` | Identificador del registro |
| `instrumentaciones.usuario_id` | `int(11) DEFAULT NULL` | Referencia al docente/usuario |
| `instrumentaciones.materia_id` | `int(11) DEFAULT NULL` | Materia asociada |
| `instrumentaciones.periodo_id` | `int(11) DEFAULT NULL` | Periodo asociado |
| `instrumentaciones.grupoalumnos_id` | `int(11) DEFAULT NULL` | Grupo académico asociado |
| `instrumentaciones.fecha_instrumentacion` | `varchar(255) DEFAULT 'no entregada'` | Fecha o estado textual de entrega; no es tipo temporal |
| `instrumentaciones.fecha_modificacion` | `varchar(255) DEFAULT 'no aplica'` | Fecha o estado textual de sustitución |
| `instrumentaciones.numero_modificaciones` | `int(11) DEFAULT 0` | Contador; no es historial de versiones |
| `archivos.nombre_archivo` | `varchar(255) DEFAULT NULL` | Nombre de archivo |
| `archivos.tipo_archivo` | `varchar(255) DEFAULT NULL` | Tipo registrado |
| `archivos.instrumentacion_id` | `int(11) DEFAULT NULL` | Asociación documental |
| `usuarios.password` | `varchar(50) DEFAULT NULL` | Campo de credencial histórica; **no reutilizar este diseño** |
| `sessiones.session_id` | `varchar(255) DEFAULT NULL` | Identificador histórico de sesión; rediseñar |

## 4. Modelo conceptual propuesto para PID 2.0 (P)

**Entidades mínimas:** `usuarios`, `roles`, `periodos`, `asignaturas`, `grupos_academicos`, `planeaciones`, `unidades`, `actividades`, `ejecuciones`, `solicitudes_cambio`, `decisiones_cambio`, `versiones_planeacion`, `eventos_auditoria`.

**Decisión de diseño pendiente:** determinar si `unidades` y `actividades` son entidades editables vinculadas a una versión o elementos inmutables de una instantánea. Para impedir cambios retroactivos, la propuesta inicial conserva una representación completa por versión; su implementación definitiva debe definirse en sesión 3.

### 4.1 Catálogos y planeación (P)

| Entidad.campo | Tipo sugerido | Regla / descripción | Relación RF |
|---|---|---|---|
| `usuarios.id` | BIGINT PK | Identificador único | RF-01 |
| `usuarios.nombre` | VARCHAR(150) | Nombre de usuario autorizado | RF-01 |
| `usuarios.password_hash` | VARCHAR(255) | Hash seguro; nunca texto plano | RNF-01 |
| `roles.id` | SMALLINT PK | Identificador de rol | RF-07 |
| `roles.clave` | VARCHAR(50) UNIQUE | docente, autorizador, administrador, consulta; catálogo pendiente | RF-07, RNF-03 |
| `periodos.id` | BIGINT PK | Periodo académico | RF-01 |
| `periodos.nombre` | VARCHAR(100) | Denominación del periodo | RF-01 |
| `asignaturas.id` | BIGINT PK | Identificador de asignatura | RF-01 |
| `asignaturas.clave` | VARCHAR(40) | Clave institucional | RF-01 |
| `grupos_academicos.id` | BIGINT PK | Identificador de grupo | RF-01 |
| `grupos_academicos.nombre` | VARCHAR(100) | Nombre del grupo | RF-01 |
| `planeaciones.id` | BIGINT PK | Identificador de planeación | RF-01 |
| `planeaciones.periodo_id` | BIGINT FK | Periodo de referencia | RF-01 |
| `planeaciones.asignatura_id` | BIGINT FK | Asignatura de referencia | RF-01 |
| `planeaciones.grupo_id` | BIGINT FK | Grupo académico | RF-01 |
| `planeaciones.docente_id` | BIGINT FK | Docente responsable | RF-01 |
| `planeaciones.version_vigente_id` | BIGINT FK NULL | Versión aprobada; resolver ciclo de dependencia en diseño | RF-04, RF-08 |
| `unidades.id` | BIGINT PK | Identificador de unidad | RF-02 |
| `unidades.planeacion_id` | BIGINT FK | Planeación asociada; versionado por definir | RF-02 |
| `unidades.numero` | INT | Orden dentro de planeación | RF-02 |
| `unidades.titulo` | VARCHAR(200) | Denominación de unidad | RF-02 |
| `actividades.id` | BIGINT PK | Identificador de actividad | RF-02 |
| `actividades.unidad_id` | BIGINT FK | Unidad asociada | RF-02 |
| `actividades.descripcion` | TEXT | Actividad programada | RF-02 |
| `actividades.fecha_inicio_programada` | DATE | Fecha prevista de inicio | RF-03 |
| `actividades.fecha_fin_programada` | DATE | Fecha prevista de fin; no anterior a inicio | RF-03 |

### 4.2 Ejecución y control de cambios (P)

| Entidad.campo | Tipo sugerido | Regla / descripción | Relación RF |
|---|---|---|---|
| `ejecuciones.id` | BIGINT PK | Registro de ejecución | RF-05 |
| `ejecuciones.actividad_id` | BIGINT FK | Actividad correspondiente | RF-05 |
| `ejecuciones.fecha_inicio_real` | DATE NULL | Inicio efectivo, si aplica | RF-05 |
| `ejecuciones.fecha_fin_real` | DATE NULL | Cierre efectivo, si aplica | RF-05 |
| `ejecuciones.estado` | VARCHAR(30) | Catálogo de estados por validar | RF-05, RF-10 |
| `ejecuciones.registrado_por` | BIGINT FK | Usuario que informa ejecución | RF-05 |
| `solicitudes_cambio.id` | BIGINT PK | Solicitud única | RF-06 |
| `solicitudes_cambio.planeacion_id` | BIGINT FK | Planeación afectada | RF-06 |
| `solicitudes_cambio.actividad_id` | BIGINT FK | Actividad afectada; identidad entre versiones por definir | RF-06 |
| `solicitudes_cambio.solicitante_id` | BIGINT FK | Autor de la solicitud | RF-06 |
| `solicitudes_cambio.justificacion` | TEXT | Motivo obligatorio | RF-06 |
| `solicitudes_cambio.cambios_propuestos` | JSON | Valores antes/después; validar estructura | RF-06 |
| `solicitudes_cambio.estado` | VARCHAR(30) | pendiente/aprobada/rechazada; estados definitivos por validar | RF-06, RF-08 |
| `solicitudes_cambio.creada_en` | DATETIME | Marca temporal de presentación | RF-06 |
| `decisiones_cambio.id` | BIGINT PK | Decisión identificable | RF-07 |
| `decisiones_cambio.solicitud_id` | BIGINT FK | Solicitud resuelta | RF-07 |
| `decisiones_cambio.autorizador_id` | BIGINT FK | Responsable competente | RF-07 |
| `decisiones_cambio.resultado` | VARCHAR(20) | aprobar/rechazar; validar catálogo | RF-07 |
| `decisiones_cambio.motivo` | TEXT | Justificación de decisión | RF-07 |
| `decisiones_cambio.decidida_en` | DATETIME | Fecha y hora de decisión | RF-07 |

### 4.3 Versiones y auditoría (P)

| Entidad.campo | Tipo sugerido | Regla / descripción | Relación RF |
|---|---|---|---|
| `versiones_planeacion.id` | BIGINT PK | Identificador de versión | RF-04, RF-08 |
| `versiones_planeacion.planeacion_id` | BIGINT FK | Planeación versionada | RF-04 |
| `versiones_planeacion.numero_version` | INT | Secuencia positiva por planeación | RF-09 |
| `versiones_planeacion.contenido` | JSON | Instantánea íntegra de unidades/actividades/fechas; diseño sujeto a validación | RF-04, RF-09 |
| `versiones_planeacion.solicitud_origen_id` | BIGINT FK NULL | Solicitud que motivó la versión; nulo en línea base | RF-08 |
| `versiones_planeacion.creada_en` | DATETIME | Fecha de generación | RF-09 |
| `versiones_planeacion.creada_por` | BIGINT FK | Actor que registró la versión | RF-09 |
| `eventos_auditoria.id` | BIGINT PK | Identificador del evento | RNF-05 |
| `eventos_auditoria.actor_id` | BIGINT FK | Usuario que ejecutó la acción | RNF-05 |
| `eventos_auditoria.entidad` | VARCHAR(80) | Tipo de objeto afectado | RNF-05 |
| `eventos_auditoria.entidad_id` | BIGINT | Identificador del objeto | RNF-05 |
| `eventos_auditoria.accion` | VARCHAR(80) | Acción ejecutada | RNF-05 |
| `eventos_auditoria.detalle` | JSON | Metadatos auditables sin secretos | RNF-05 |
| `eventos_auditoria.ocurrido_en` | DATETIME | Marca temporal del evento | RNF-05 |

## 5. Relaciones conceptuales propuestas

- `planeaciones` N:1 `periodos`, `asignaturas`, `grupos_academicos`, `usuarios` (docente).
- `planeaciones` 1:N `unidades` y `versiones_planeacion`.
- `unidades` 1:N `actividades`.
- `actividades` 1:N `ejecuciones` y potencialmente `solicitudes_cambio`.
- `solicitudes_cambio` 1:0..1 `decisiones_cambio` para una resolución única (a confirmar).
- `versiones_planeacion` conserva instantánea histórica y se asocia opcionalmente con solicitud aprobada.
- `eventos_auditoria` registra eventos transversales, con permisos restringidos.

**Problema de diseño abierto:** al guardar actividades editables y versiones JSON, la relación entre `actividad_id` y una actividad histórica necesita un identificador estable o tablas normalizadas de versiones. No resolver implícitamente: llevar a arquitectura de sesión 3.

## 6. Reglas de integridad propuestas

1. `fecha_fin_programada >= fecha_inicio_programada` cuando ambas existan.
2. No alterar la instantánea de la línea base una vez publicada.
3. Una solicitud pendiente no cambia la versión vigente.
4. Una solicitud rechazada no cambia la versión vigente.
5. Una aprobación válida genera nueva versión y evento de auditoría.
6. El autorizador debe tener competencia sobre el ámbito de la planeación.
7. Registrar actor y momento en cada solicitud, decisión y versión.
8. Usar integridad referencial y transacciones para aprobar y versionar de forma atómica.
9. No almacenar contraseñas ni tokens de sesión en texto claro.

## 7. Vacíos y decisiones para validación

| ID | Asunto pendiente | Impacto |
|---|---|---|
| VD-01 | ¿Qué rol y autoridad aprueban cambios, y por qué ámbito? | `roles`, decisiones y permisos |
| VD-02 | ¿Cuál es la fórmula y unidad de medida del avance? | `ejecuciones`, reportes |
| VD-03 | ¿Cómo se identifican actividades entre versiones? | `actividades`, `versiones_planeacion`, solicitudes |
| VD-04 | ¿Se permite editar una planeación antes de fijar línea base? | Estados y versiones |
| VD-05 | ¿Se permiten múltiples decisiones o reconsideraciones? | Cardinalidad de `decisiones_cambio` |
| VD-06 | ¿Se conservarán archivos XLSX en la PoC o en incremento posterior? | Entidad documental |
| VD-07 | ¿Cuáles son los catálogos válidos de estados y plazos? | Restricciones y validaciones |
| VD-08 | ¿Qué datos y reportes pueden ver los distintos roles? | Seguridad y privacidad |

## 8. Correspondencia con la actividad P2

Este documento satisface el **diseño del diccionario inicial de datos** como anexo editable. No sustituye la aplicación de I-01, las pruebas funcionales, la validación institucional ni el diseño físico de base de datos de la sesión 3.

**Estado final:** estructura histórica identificada; modelo conceptual propuesto; aprobación y pruebas pendientes.
