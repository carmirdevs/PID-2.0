# Corrección 2 — Contribución científica propuesta de PID 2.0

**Versión:** 0.1 · **Fecha:** 2026-11-15 · **Estado:** hipótesis de contribución científica, NO novedad demostrada ni modelo validado.  
**Denominación provisional:** Modelo de Trazabilidad Programática y Decisional de la Instrumentación Didáctica (**MTPD-ID**).

## 1. Problema científico y distinción frente a implementación

El PID original registra instrumentaciones XLSX, sustituciones documentales, fechas de entrega y reportes. La inspección estática del repositorio acredita estas operaciones en código, pero no una ejecución funcional validada ni la inexistencia absoluta de otros módulos. El problema de diseño investigable es cómo representar de manera coherente, auditable y verificable **la relación entre una programación académica inicial, su ejecución efectiva y las decisiones autorizadas que la modifican**.

Implementar formularios, tablas, calendarios o botones es una **mejora tecnológica**. La contribución científica potencial sería un **modelo explícito y evaluable**, acompañado de reglas, invariantes, trazabilidad y protocolo de evaluación que puedan estudiarse independientemente de PHP, MySQL o la interfaz concreta.

## 2. Estado del arte y límite de originalidad

La [revisión exploratoria](ESTADO_DEL_ARTE_COMPARATIVO_P2.md) documenta antecedentes de gestión curricular, cambios de materiales, monitoreo educativo y registro de decisiones; además, plataformas institucionales ya ofrecen aprobaciones, historial y versiones. **Ninguna de esas capacidades aisladas puede presentarse como inédita.** La brecha candidata consiste en la articulación y evaluación conjunta de seguimiento programático granular, decisiones académicas y reconstrucción histórica. La brecha aún no se ha demostrado con revisión sistemática ni texto completo de todos los antecedentes.

## 3. Constructos del modelo

| Código | Constructo | Definición operacional propuesta | Correspondencia |
|---|---|---|---|
| C-01 | Planeación | Conjunto de unidades y actividades asociadas a docente, asignatura, grupo y periodo | RF-01, RF-02 |
| C-02 | Línea base | Instantánea inicial aprobada de contenidos y fechas programadas, inalterable tras publicación | RF-04 |
| C-03 | Actividad estable | Identidad lógica que persiste entre versiones y distingue una actividad de sus representaciones históricas | RF-02, RF-09 |
| C-04 | Ejecución | Evidencia de estado y fechas reales de una actividad | RF-05 |
| C-05 | Solicitud | Propuesta justificada de modificar un conjunto explícito de atributos de una versión | RF-06 |
| C-06 | Decisión | Resolución atribuible a un autorizador competente, con fecha, resultado y justificación | RF-07 |
| C-07 | Versión | Instantánea completa y ordenada de una planeación, con referencia a su origen | RF-08, RF-09 |
| C-08 | Traza | Cadena verificable de actor, solicitud, decisión, versión y efecto programático | RF-09, RNF-05 |
| C-09 | Desviación | Diferencia entre programación y ejecución según fórmula y calendario por validar | RF-10 |

**Dos dimensiones:** programática (C-01 a C-04, C-09) y decisional (C-05 a C-08). El vínculo es la identidad estable de actividad y la referencia a la versión afectada.

## 4. Relaciones y procedimiento formal propuesto

Para una planeación P, sea V0 su línea base y Vt su versión vigente. Una solicitud S=(actor, actividad, versión_origen, cambios, motivo, instante) inicia en estado pendiente. Una decisión D=(autorizador, competencia, resultado, instante, motivo) puede rechazarla o aprobarla.

- **Solicitud pendiente:** no modifica Vt.
- **Rechazo:** Vt permanece igual; S y D se conservan.
- **Aprobación válida:** si la versión de origen sigue siendo aplicable y la autoridad es competente, se crea V(t+1) como nueva instantánea, sin alterar V0 ni Vt histórico; se registra la decisión y la traza.
- **Conflicto concurrente:** si la versión de origen ha cambiado, no aplicar silenciosamente el cambio; marcar conflicto para revisión o reevaluación. La política institucional exacta queda pendiente.
- **Reconstrucción:** para un instante de corte se identifica la versión vigente entonces y sus decisiones de origen; la ejecución real se consulta separadamente para no confundir fechas previstas con realizadas.

### Invariantes verificables (propuestos)

- **INV-01 — Inmutabilidad:** ninguna aprobación modifica el contenido de una versión ya publicada.
- **INV-02 — Autorización:** una nueva versión por cambio requiere decisión aprobatoria de un rol competente.
- **INV-03 — Rechazo:** una solicitud rechazada no cambia la versión vigente.
- **INV-04 — Trazabilidad:** toda versión posterior a la línea base identifica solicitud, decisión, actor y momento de origen.
- **INV-05 — Coherencia temporal:** fecha de fin programada no antecede a fecha de inicio.
- **INV-06 — Identidad:** una actividad se identifica establemente a través de versiones o se registra explícitamente su sustitución/división.
- **INV-07 — No ambigüedad:** la línea base, la programación vigente y las fechas reales son campos/consultas distinguibles.
- **INV-08 — Control de concurrencia:** una aprobación no sobrescribe cambios posteriores a la versión sobre la que se solicitó.
- **INV-09 — Auditabilidad:** usuarios ordinarios no pueden editar o eliminar decisiones históricas mediante la aplicación.

Estos invariantes son **hipótesis de diseño**, no propiedades probadas.

## 5. Preguntas e hipótesis evaluables

**PI-C1:** ¿Puede un modelo conjunto programático-decisional preservar la línea base y reconstruir versiones ante solicitudes aprobadas y rechazadas?  
**PI-C2:** ¿Permite identificar el origen y la autoridad de cada cambio sin ambigüedad en escenarios concurrentes?  
**PI-C3:** ¿Qué diferencias observables aparecen frente a una gestión exclusivamente documental en integridad y recuperabilidad de la historia?

**H1 (de diseño):** los escenarios de prueba implementados con MTPD-ID satisfarán INV-01 a INV-09 bajo datos sintéticos, salvo restricciones expresamente excluidas de la PoC.  
**H2 (comparativa, pendiente de diseño):** el modelo permitirá responder consultas de trazabilidad que el flujo documental de sustitución XLSX no representa como datos estructurados, dentro del alcance verificado.

No se afirma mejora cuantitativa, superioridad estadística ni impacto institucional antes de medir.

## 6. Protocolo de evaluación propuesto

| ID | Escenario | Indicador | Criterio de éxito propuesto |
|---|---|---|---|
| EC-01 | Publicar línea base y aprobar un cambio | Integridad de V0 | Igualdad exacta de instantánea antes/después |
| EC-02 | Rechazar cambio | Conservación de versión vigente | Identificador y contenido sin alteración |
| EC-03 | Consultar una versión anterior | Reconstrucción histórica | Datos devueltos coinciden con instantánea almacenada |
| EC-04 | Solicitar autorización desde rol docente | Control de acceso | Operación denegada, sin efectos |
| EC-05 | Aprobar como autorizador competente | Cadena de procedencia | Solicitud, decisión, actor, instante y nueva versión vinculados |
| EC-06 | Aprobar solicitud desactualizada | Control de concurrencia | Rechazo o conflicto explícito; no sobrescritura |
| EC-07 | Ingresar fechas invertidas | Coherencia temporal | Entrada inválida rechazada |
| EC-08 | Consultar línea base vs vigente vs ejecución | Separación conceptual | Tres estados identificables sin mezcla |

**Medidas propuestas:** tasa de invariantes satisfechos = invariantes comprobados / invariantes ejecutados; cobertura de traza = versiones posteriores con procedencia íntegra / versiones posteriores examinadas; tasa de reconstrucción = consultas históricas correctas / consultas ejecutadas. Los umbrales operativos para la PoC son 100 % de integridad y trazabilidad en el conjunto de pruebas definido, **no** una afirmación de fiabilidad en producción.

**Comparador mínimo:** flujo documental del PID original según código inspeccionado, sin afirmar ausencia global de otras capacidades. **Comparador adicional deseable:** una implementación sencilla con sobrescritura de planeación sin versionado, construida expresamente para comparación controlada y etiquetada como tal.

## 7. Alcance de PoC y factibilidad

La semana 4 deberá mostrar un flujo vertical mínimo: crear planeación sintética, fijar V0, registrar ejecución, solicitar cambio, resolverlo, crear V1 solo tras aprobación y consultar historial. Se priorizan INV-01 a INV-05 e INV-07; INV-06, INV-08 e INV-09 deberán probarse si el tiempo permite o declararse fuera de alcance de la PoC. **No** se trasladan las 320 horas ni las cinco iteraciones de evolución institucional al seminario.

## 8. Criterios para sostener la contribución científica

1. Ampliar estado del arte y revisar texto completo de sistemas y modelos cercanos.
2. Explicitar constructos, invariantes, precondiciones y límites de generalización.
3. Demostrar reproducibilidad del protocolo de pruebas y conservar resultados reales.
4. Comparar con línea base o enfoque alternativo sin atribuirle capacidades no verificadas.
5. Analizar resultados negativos, conflictos y amenazas a la validez.
6. Formular contribución como **propuesta y evaluación de un modelo**, no como descubrimiento de funcionalidades inéditas.

## 9. Limitaciones actuales

- No hay entrevistas I-01, validación institucional, ejecución de PoC ni resultados medidos.
- La autoridad competente y la fórmula de avance requieren validación.
- La representación técnica de identidad de actividad y control concurrente requiere diseño en sesión 3.
- El estado del arte sigue siendo exploratorio.
- No se deben formular conclusiones finales antes de las pruebas.
