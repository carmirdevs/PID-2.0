# Matriz de trazabilidad — PID 2.0

**Versión 0.1 · 15-11-2026 · preliminar, no aprobada.**  
**Cobertura documental:** 19/19 requerimientos del catálogo v0.1 tienen problema/necesidad, objetivo provisional, fuente y prueba prevista. **Cobertura empírica de validación: no acreditada**; ninguna prueba de aceptación ha sido ejecutada.

## Códigos de objetivos provisionales
- **OE-P2-01:** verificar funcionalidades del PID original.
- **OE-P2-02:** identificar necesidades y actores.
- **OE-P2-03:** describir procesos, entradas, salidas y flujos.
- **OE-P2-04:** especificar y validar requerimientos.
- **OE-P2-05:** delimitar la prueba de concepto.

Los objetivos deberán conciliarse con el artículo IEEE y la actividad P2. Las fuentes `PROP-01` y `CTX-01` **no sustituyen** entrevistas ni validación institucional.

## Matriz requisito–problema–objetivo–fuente–prueba

| ID | Problema/necesidad | Objetivo | Fuente/evidencia | Prueba prevista | Estado |
|---|---|---|---|---|---|
| RF-01 | Contexto académico de planeación | OE-P2-03 | EV-COD-007; PROP-01 | Registro de planeación con relaciones válidas | Propuesto; diseño no validado |
| RF-02 | Unidades y actividades estructuradas | OE-P2-01/03 | CTX-01; EV-OBS-001 OBS-07; PROP-01 | Dos unidades y dos actividades por unidad | Propuesto; no comprobado en ejecución |
| RF-03 | Fechas programadas | OE-P2-03/04 | CTX-01; EV-OBS-001 OBS-08; PROP-01 | Rechazar intervalo invertido | Propuesto |
| RF-04 | Línea base inalterable | OE-P2-04/05 | EV-OBS-001 OBS-10; PROP-01 | Conservar línea base tras cambio | Propuesto |
| RF-05 | Fechas reales y ejecución | OE-P2-03/04 | CTX-01; EV-OBS-001 OBS-07/08; PROP-01 | Persistir fecha y estado por actividad | Propuesto |
| RF-06 | Solicitud de cambio justificada | OE-P2-02/04 | CTX-01; EV-COD-001; PROP-01 | Solicitud pendiente sin alterar base | Propuesto; autoridad por validar |
| RF-07 | Aprobación por responsable | OE-P2-02/04 | EV-OBS-001 OBS-09; PROP-01 | Docente denegado; autorizador habilitado | Propuesto; rol por validar |
| RF-08 | Aprobación genera versión | OE-P2-04/05 | EV-OBS-001 OBS-09/10; PROP-01 | Aprobar crea versión; rechazar no altera | Propuesto |
| RF-09 | Historial de versiones | OE-P2-01/04 | EV-COD-001; EV-OBS-001 OBS-10; PROP-01 | Consultar versión inicial y posterior | Propuesto |
| RF-10 | Avance programático | OE-P2-03/04 | PROP-01; EV-OBS-001 OBS-13 | Comparar cálculo con fórmula aprobada | Pendiente fórmula |
| RF-11 | Reportes y filtros | OE-P2-03/04 | EV-COD-003; EV-COD-006; PROP-01 | Filtrado y autorización correctos | Propuesto |
| RF-12 | Carga documental XLSX | OE-P2-01/04 | EV-COD-001; EV-COD-002; CTX-01 | Aceptar XLSX sintético y consultar | Propuesto; fuera PoC mínima |
| RNF-01 | Contraseñas seguras | OE-P2-04/05 | SEG-01; EV-COD-008 | Hash y verificación; no texto plano | Propuesto |
| RNF-02 | Sesiones seguras | OE-P2-04/05 | SEG-02; EV-COD-005/008 | Sin token en URL; cookies seguras | Propuesto |
| RNF-03 | Autorización servidor | OE-P2-04/05 | EV-COD-005; PROP-01 | Denegar endpoints a rol no autorizado | Propuesto |
| RNF-04 | CSRF | OE-P2-04/05 | SEG-05; EV-OBS-001 OBS-12 | Rechazar solicitud sin token | Propuesto; inspección parcial |
| RNF-05 | Bitácora persistente | OE-P2-04/05 | PROP-01; EV-OBS-001 OBS-10 | Usuario ordinario no altera eventos | Propuesto |
| RNF-06 | Acceso protegido a archivos | OE-P2-04/05 | SEG-04; EV-COD-004 | Acceso anónimo denegado | Propuesto |
| RNF-07 | Validación XLSX | OE-P2-04/05 | SEG-03; EV-COD-004 | Aceptar válido; rechazar falso y excesivo | Propuesto; fuera PoC mínima |

## Pruebas de aceptación y estado
Las pruebas de la columna «Prueba prevista» son **diseños de verificación**; no se han ejecutado. Las condiciones completas de aceptación están en [Catálogo v0.1](REQUERIMIENTOS_INICIALES.md). No asignar «cumple» hasta conservar resultado, fecha, versión y datos sintéticos de prueba.

## Vacíos críticos antes de cerrar P2
1. **RF-07 / RN-04:** definir responsable y ámbito de autorización con fuente competente.
2. **RF-10 / RN-05:** validar fórmula de avance y tratamiento de actividades canceladas o reprogramadas.
3. **RF-04, RF-08, RF-09:** acordar qué se versiona y cuándo se establece la línea base.
4. **RNF-01–RNF-07:** validar criterios de seguridad mediante escenarios reproducibles.
5. **RF-02–RF-05:** confirmar granularidad, campos y reglas con docentes y responsables.
6. **Todos:** agregar evidencia de I-01 o justificar limitación; documentar decisiones `DEC-###`.

## Revisión preliminar de calidad
- **Identificación:** 19/19 IDs únicos, sin duplicados.
- **Fuente y prioridad:** presentes en catálogo v0.1; la fuente de varios es solo una propuesta.
- **Aceptación:** criterio preliminar para 19/19; varios requieren parámetros institucionales para ser plenamente medibles.
- **Consistencia:** no se detectan contradicciones formales evidentes entre IDs, pero falta revisión con actores.
- **Factibilidad:** alcance mínimo PoC definido; estimación detallada y evaluación aún pendientes.
- **Trazabilidad:** documental preliminar completa; validación empírica incompleta.

## Relación con entregables P2
- Apartado V: [Aplicación estática de I-02](evidencias/EV-OBS-001_APLICACION_ESTATICA_I02.md).
- Apartado VII: [Catálogo de requerimientos](REQUERIMIENTOS_INICIALES.md).
- Apartado VIII: revisión de calidad preliminar de esta matriz.
- Apartado IX: presente matriz.
- Anexo obligatorio: versión editable de esta matriz y [Registro consolidado](REGISTRO_CONSOLIDADO_EVIDENCIAS.md).
