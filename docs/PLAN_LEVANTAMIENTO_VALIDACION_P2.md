# PID 2.0 — Plan de levantamiento y validación de requerimientos (P2)

**Versión:** 0.1 · **Fecha:** 15-11-2026 · **Estado:** diseñado; aplicación y validación pendientes.  
**Equipo:** Carlos Alberto Becerra Grajales y Miriam Crisanto Zetina.  
**Seminario:** Análisis y Diseño de Sistemas, Doctorado en Sistemas Computacionales, Universidad del Sur.

## 1. Propósito y correspondencia con P1

Caracterizar el funcionamiento verificable del PID original, contrastar necesidades académicas y especificar requerimientos funcionales y no funcionales para PID 2.0, con trazabilidad entre problema, objetivos, fuentes, evidencias y decisiones.

**Corrección histórica obligatoria:** la última versión del PID original recibía instrumentaciones en **XLSX**, no PDF; su operación de modificación **sustituía el archivo**, sin editar de manera estructurada actividades ni fechas. El sistema podía generar reportes PDF como salidas.

**Evidencia previa:** [Informe técnico de PID-Original](https://github.com/carmirdevs/PID-Original/blob/main/docs/INFORME_REVISION_TECNICA.md). Inspección estática no equivale a prueba funcional.

## 2. Preguntas de investigación para el levantamiento

- P-L01: ¿Qué procesos, transacciones, actores, entradas, salidas y controles se identifican en el PID original?
- P-L02: ¿Qué necesidades de seguimiento por unidad y actividad no están resueltas de forma estructurada?
- P-L03: ¿Qué autoridades, reglas y evidencias deben intervenir en una modificación de planeación?
- P-L04: ¿Qué información y criterios de aceptación permiten verificar una línea base y su historial de versiones?
- P-L05: ¿Qué restricciones institucionales, técnicas y de seguridad condicionan la PoC?

## 3. Fuentes de información

| ID | Tipo | Fuente | Propósito | Disponibilidad / limitación |
|---|---|---|---|---|
| FI-01 | Interna técnica | Código depurado de PID-Original | Operaciones, validaciones, roles, datos | Disponible; solo inspección estática documentada |
| FI-02 | Interna técnica | Esquema SQL sin datos reales | Entidades y relaciones | Disponible; no acredita uso operativo |
| FI-03 | Interna documental | Manuales, formatos, políticas y calendario institucional | Reglas de negocio y autorizaciones | Solicitar solo documentos autorizados; disponibilidad por confirmar |
| FI-04 | Interna humana | Docentes usuarios del PID | Operación, dificultades, necesidades | Participación por confirmar |
| FI-05 | Interna humana | Jefatura de departamento / autoridad académica | Aprobaciones, restricciones y controles | Participación por confirmar |
| FI-06 | Interna humana | Administrador o responsable técnico | Configuración, seguridad, volumen y operación | Participación por confirmar |
| FE-01 | Externa científica | Literatura de ingeniería de requerimientos, DSR y estudios de caso | Justificación de técnicas y calidad | Disponible; registrar referencias verificadas |
| FE-02 | Externa técnica | ISO/IEC 25010:2023, OWASP ASVS y documentación técnica aplicable | Atributos de calidad y controles | Alcance y versión específica por confirmar |
| FE-03 | Externa comparativa | Artículos y documentación de sistemas similares de planeación académica | Identificar aportación y brechas | Revisión comparativa pendiente; no afirmar novedad demostrada |

## 4. Técnicas, participantes y unidades de análisis

| Técnica | Instrumento | Unidad / participantes | Objetivo | Producto |
|---|---|---|---|---|
| Análisis documental | Ficha de extracción en I-02 | Código, SQL, documentos institucionales | Procesos, reglas y controles | EV-COD / EV-DOC |
| Inspección estática | I-02 | Controladores, modelos, vistas, esquema | Evidencia técnica y riesgos | EV-COD |
| Observación funcional autorizada | I-02 | Flujo de carga, sustitución, consulta, reportes | Contrastar código con ejecución | EV-OBS |
| Entrevista semiestructurada | I-01 | Docentes, jefatura, administración técnica | Necesidades y conflictos | EV-ENT |
| Revisión de escenarios con actores | Matriz de decisiones | Actores disponibles | Validar reglas, prioridad y criterios | DEC / CON |
| Revisión bibliográfica comparativa | Ficha de fuente | Publicaciones y sistemas similares | Fundamentación y brechas | EV-BIB |

**Selección de participantes:** muestreo intencional por rol y conocimiento del proceso; mínimo propuesto: un docente, una persona con atribuciones de autorización y una persona con conocimiento técnico, si están disponibles y autorizados. No es muestra estadística representativa. Registrar cantidad real y sesgo de selección; no inventar participación.

## 5. Procedimiento de aplicación

**Fase A — Preparación**
1. Confirmar autorización de acceso, alcance, confidencialidad y participantes.
2. Congelar identificador de versión/commit de PID-Original; no ejecutar sobre producción.
3. Preparar I-01 e I-02, dataset sintético y formato de evidencia.
4. Definir códigos anónimos P-01, P-02, etc.; no guardar nombres ni grabaciones en GitHub.

**Fase B — Levantamiento**
5. Revisar código, SQL y documentos, registrando archivo, línea o función, fecha y alcance.
6. Aplicar entrevistas solo con consentimiento; registrar respuestas y verificar interpretación con el participante.
7. Observar procesos en entorno autorizado y aislado; registrar entrada, operación, decisión, salida y control.
8. Registrar frecuencia y volumen con datos reales autorizados o marcar explícitamente como estimación/simulación.

**Fase C — Análisis**
9. Codificar necesidades, problemas, reglas, entradas, salidas, frecuencia, volumen, controles y restricciones.
10. Triangular fuentes; registrar contradicciones sin resolverlas unilateralmente.
11. Actualizar catálogo RF/RNF, justificación, prioridad, fuente y aceptación verificable.

**Fase D — Validación**
12. Revisar escenarios con actores competentes cuando sea posible.
13. Evaluar completitud, consistencia, no ambigüedad, factibilidad, verificabilidad y trazabilidad.
14. Registrar decisiones, conflictos pendientes y cambios de versión del catálogo.

## 6. Calendario relativo y esfuerzo (estimaciones, no horas realizadas)

| Momento | Actividad | Evidencia / entrega |
|---|---|---|
| Semana 2, inicio | Fuentes, autorizaciones, diseño de instrumentos | I-01, I-02, plan |
| Semana 2, mitad | Inspección documental y técnica | EV-COD, EV-DOC |
| Semana 2, cierre | Entrevistas/observación si son viables; análisis preliminar | EV-ENT/EV-OBS o justificación de no aplicación |
| Semana 3, inicio | Validación de reglas y catálogo; modelo de datos | RF/RNF v0.2, DEC, diccionario |
| Semana 3, cierre | Arquitectura y escenarios de prueba | Modelos y casos de prueba |
| Semana 4 | PoC y evaluación delimitada | Evidencias y resultados reales de pruebas |

El calendario no implica que las actividades ya se realizaron. Ajustar fechas según disponibilidad y consignas del docente.

## 7. Esquema de evidencia y estados

Campos obligatorios: `ID | fecha | tipo | fuente | autor/rol anonimizado | versión | método | procedimiento | dato/hallazgo | archivo/ruta | limitación | requisito asociado | estado`.

**Prefijos:** EV-COD (código), EV-DOC (documento), EV-ENT (entrevista), EV-OBS (observación), EV-BIB (bibliografía), SIM (dato sintético), CON (conflicto), DEC (decisión).

**Estados:** verificado en código; comprobado en ejecución; declarado por participante; documentado; inferido; simulado; pendiente. Nunca elevar una inferencia o simulación a hecho observado.

## 8. Tratamiento de contradicciones

1. Registrar `CON-###` y las versiones incompatibles de la información.
2. Verificar contexto: rol, versión de PID, periodo, proceso, normativa y fuente.
3. Contrastar documento, código, observación y testimonios según disponibilidad.
4. Separar hecho observado, interpretación, preferencia y regla obligatoria.
5. Someter decisiones normativas al responsable competente; dejar pendientes las no resueltas.
6. Registrar `DEC-###`: conflicto, alternativas, evidencia, responsable, fecha, decisión y requisitos afectados.
7. Actualizar catálogo y matriz de trazabilidad sin borrar historial.

## 9. Criterios de calidad del levantamiento y especificación

- **Validez:** cada afirmación distingue fuente y tipo de evidencia; contraste de fuentes cuando sea viable.
- **Consistencia:** ausencia de reglas contradictorias sin conflicto documentado.
- **Completitud:** actores, entradas, salidas, excepciones, controles y estados de cada proceso prioritario.
- **No ambigüedad:** vocabulario definido; distinguir sustitución XLSX de edición estructurada.
- **Verificabilidad:** cada RF/RNF incluye escenario, precondiciones, resultado observable y criterio de aceptación.
- **Factibilidad:** separar PoC de alcance institucional; registrar recursos y restricciones.
- **Trazabilidad:** RF/RNF prioritarios conectados a problema, objetivo, evidencia o propuesta identificada y prueba prevista.

## 10. Contingencias y ética

Si no se logra autorización específica para entrevistas u observación, usar documentos autorizados, código y datos sintéticos identificados; consignar explícitamente la limitación. No atribuir respuestas ni métricas a personas inexistentes. No subir datos personales, contraseñas, SQL real, grabaciones o capturas sensibles al repositorio.

## 11. Productos y control de cambios

- I-01: `docs/instrumentos/I-01_ENTREVISTA_SEMIESTRUCTURADA.md`
- I-02: `docs/instrumentos/I-02_GUIA_OBSERVACION_TECNICA.md`
- Catálogo v0.1: `docs/REQUERIMIENTOS_INICIALES.md`
- Pendientes: registro de aplicación, matriz de contradicciones y decisiones, dataset anonimizado/sintético, diccionario de datos y trazabilidad consolidada.

**Control:** toda modificación del plan o catálogo registra versión, fecha, motivo y evidencia. Este plan es una propuesta metodológica, no constancia de aplicación.

## 12. Referencias metodológicas iniciales

- B. Nuseibeh and S. Easterbrook, “Requirements engineering: A roadmap,” *Proceedings of the Conference on the Future of Software Engineering*, pp. 35–46, 2000. DOI: 10.1145/336512.336523.
- K. Wiegers and J. Beatty, *Software Requirements*, 3rd ed., Microsoft Press, 2013.
- P. Runeson and M. Höst, “Guidelines for conducting and reporting case study research in software engineering,” *Empirical Software Engineering*, vol. 14, pp. 131–164, 2009. DOI: 10.1007/s10664-008-9102-8.
- A. R. Hevner et al., “Design science in information systems research,” *MIS Quarterly*, vol. 28, no. 1, pp. 75–105, 2004. DOI: 10.2307/25148625.
