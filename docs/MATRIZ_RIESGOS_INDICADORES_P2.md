# Corrección 4 — Valoración, tratamiento de riesgos e indicadores de efectividad de PID 2.0

**Versión:** 0.1 · **Fecha:** 2026-11-15 · **Estado:** propuesta de evaluación para P2 y PoC; sin ejecución ni mediciones empíricas.  
**Base:** [Plan de PoC](PLAN_POC_REALISTA_SEMANA4.md), [contribución MTPD-ID](CONTRIBUCION_CIENTIFICA_MTPD_ID.md), [catálogo RF/RNF](REQUERIMIENTOS_INICIALES.md).

## 1. Método explícito de valoración

Se adopta una matriz ordinal de **probabilidad (P)** e **impacto (I)** de 1 a 5. Se calcula **nivel = P × I** (rango 1–25). Este producto sirve para **priorizar** riesgos, no representa probabilidad estadística, pérdida monetaria esperada ni medida de intervalo validada.

**Probabilidad (estimación experta, no frecuencia observada):** 1 rara; 2 poco probable; 3 posible; 4 probable; 5 muy probable.  
**Impacto:** 1 menor; 2 bajo; 3 moderado; 4 alto; 5 crítico para la integridad, seguridad o entrega.  
**Bandas propuestas:** 1–4 bajo; 5–9 moderado; 10–16 alto; 17–25 crítico.  
**Tratamiento:** evitar, reducir, transferir o aceptar justificadamente. Riesgo **residual** = estimación P e I posterior a controles previstos, **no riesgo efectivamente reducido**.

La valoración será revisada por el equipo en cada hito de la PoC y actualizada ante fallos; la evaluación institucional de probabilidad e impacto está pendiente.

## 2. Registro de riesgos con valoración inicial y residual prevista

| ID | Riesgo / causa | P | I | Nivel inicial | Banda | Tratamiento y evidencia de control | Responsable propuesto | P residual | I residual | Nivel residual previsto |
|---|---|---:|---:|---:|---|---|---|---:|---:|---:|
| R-01 | Sobrecarga del alcance respecto a 28 h-persona estimadas para semanas 3–4 | 4 | 4 | 16 | Alto | Reducir interfaz y funciones secundarias; lista de alcance congelada y bitácora de horas | Carlos y Miriam | 2 | 4 | 8 |
| R-02 | Rol autorizador sin validación institucional | 4 | 4 | 16 | Alto | Etiquetar rol como simulado, solicitar revisión académica; acta de decisión o constancia de limitación | Miriam | 2 | 4 | 8 |
| R-03 | Sobrescritura de línea base o pérdida de versiones | 3 | 5 | 15 | Alto | Instantáneas inmutables, transacción de aprobación y TP-02/TP-05/TP-07 | Carlos | 1 | 5 | 5 |
| R-04 | Autorización indebida o acceso a operaciones privilegiadas | 3 | 5 | 15 | Alto | Permisos en servidor, separación de roles y TP-08; denegación sin mutación | Carlos | 1 | 5 | 5 |
| R-05 | Autenticación, sesiones o CSRF inseguros | 3 | 5 | 15 | Alto | Hash seguro, cookies de sesión y token CSRF; TP-09 con evidencia | Carlos | 1 | 5 | 5 |
| R-06 | No obtener entrevistas u observación funcional autorizada | 4 | 3 | 12 | Alto | Documentar no aplicación, conservar evidencia estática y no atribuir validación a usuarios | Miriam | 3 | 3 | 9 |
| R-07 | Definición ambigua de fechas, estados o cálculo de avance | 4 | 3 | 12 | Alto | Diferir RF-10; registrar reglas candidatas y escenarios de aceptación | Miriam | 2 | 3 | 6 |
| R-08 | Conflictos de versión al aprobar solicitud desactualizada | 3 | 4 | 12 | Alto | Comprobar versión de origen antes de aprobar; caso EC-06 cuando sea viable | Carlos | 2 | 4 | 8 |
| R-09 | Falta de evidencia reproducible de pruebas | 3 | 4 | 12 | Alto | Reservar tiempo, registro TP-01–TP-09 con entradas/salidas, capturas sin datos reales | Carlos y Miriam | 1 | 4 | 4 |
| R-10 | Afirmar novedad científica o mejora institucional sin sustento | 3 | 5 | 15 | Alto | Revisión comparativa, lenguaje provisional y análisis de amenazas a la validez | Carlos y Miriam | 2 | 5 | 10 |

**Interpretación:** todos los valores son juicios preliminares. Por ejemplo, R-10 permanece **alto** aun después del tratamiento propuesto; no se debe considerar cerrado hasta ampliar el estado del arte y obtener resultados de evaluación.

## 3. Registro de tratamiento y seguimiento

En cada revisión registrar: ID, fecha, evidencia nueva, P/I revisados, control ejecutado, responsable, estado (abierto/en tratamiento/mitigado/aceptado), motivo de aceptación y próxima revisión. No asignar «mitigado» hasta verificar el control con evidencia.

**Regla de escalamiento propuesta:** un riesgo crítico (17–25) impide declarar lista la PoC; un riesgo alto (10–16) requiere decisión de tratamiento y responsable; un riesgo residual alto no se oculta ni se etiqueta como resuelto.

## 4. Indicadores de efectividad de la PoC

Todos los indicadores se calculan **solo cuando exista ejecución real** y un denominador mayor que cero. Si no hay casos ejecutados, reportar «no medido», no 0 % ni 100 %. Las metas son umbrales de aceptación propuestos para un conjunto sintético delimitado, **no estándares de desempeño institucional**.

| ID | Indicador | Fórmula | Fuente y momento | Meta propuesta | Interpretación / límite |
|---|---|---|---|---|---|
| IND-01 | Integridad de línea base | (comparaciones V0 sin cambios / comparaciones V0 ejecutadas) × 100 | Instantáneas antes/después; TP-02 | 100 % | Solo casos ejecutados |
| IND-02 | Rechazos sin alteración | (rechazos sin cambio de vigente / rechazos probados) × 100 | Solicitudes, decisiones, versiones; TP-06 | 100 % | No mide política institucional |
| IND-03 | Aprobaciones trazables | (versiones nuevas con solicitud, decisión, actor, fecha y motivo / versiones nuevas evaluadas) × 100 | Versiones y auditoría; TP-05 | 100 % | No acredita inmutabilidad fuera de app |
| IND-04 | Reconstrucción histórica | (consultas históricas correctas / consultas históricas ejecutadas) × 100 | Versiones almacenadas; TP-07 | 100 % | Dataset limitado |
| IND-05 | Denegación de autorización indebida | (intentos no autorizados denegados sin mutación / intentos no autorizados ejecutados) × 100 | Pruebas HTTP, registros; TP-08 | 100 % | No sustituye auditoría de seguridad |
| IND-06 | Cumplimiento de pruebas críticas | (TP-02, TP-05, TP-06 y TP-08 aprobadas / 4) × 100 | Actas de prueba semana 4 | 100 % | Solo cuatro pruebas críticas |
| IND-07 | Cobertura de requerimientos prioritarios | (RF prioritarios con al menos una prueba ejecutada / RF prioritarios incluidos en alcance PoC) × 100 | Matriz de trazabilidad y actas | 100 % | Cobertura no significa aprobación |
| IND-08 | Desviación de esfuerzo | ((horas reales - horas estimadas) / horas estimadas) × 100 | Bitácora de trabajo semanal | ≤ 20 % de exceso | Solo si se registran horas reales; puede ser negativo |
| IND-09 | Completitud de evidencias | (pruebas ejecutadas con entrada, salida, fecha y versión registradas / pruebas ejecutadas) × 100 | Registro de pruebas | 100 % | No evalúa corrección del resultado |

**Nota:** IND-07 debe calcularse contra una lista congelada de RF de la PoC (RF-01 a RF-09), registrando pruebas y criterios; la cobertura no implica que todos los RF hayan pasado. **RF-10 queda fuera de la PoC mínima** hasta aprobar la fórmula de avance.

## 5. Indicadores de seguimiento académico futuros (no medibles aún)

Se plantean únicamente como candidatos para la evolución institucional, condicionados a validar reglas y datos:

- **Avance programático:** actividades completadas / actividades aplicables × 100, si la institución aprueba esa unidad de cálculo y cómo tratar cancelaciones.
- **Desviación temporal:** fecha real de finalización menos fecha programada vigente, en días, con calendario institucional definido.
- **Oportunidad de autorización:** tiempo entre solicitud y decisión, en horas o días hábiles según regla institucional.
- **Proporción de cambios autorizados:** solicitudes aprobadas / solicitudes resueltas × 100; no interpretar una proporción alta o baja como «calidad» sin contexto.

No asignar metas institucionales a estos indicadores antes de entrevistar a responsables académicos.

## 6. Correspondencia con requerimientos e invariantes

| Riesgo / indicador | Requerimientos | Invariantes / pruebas |
|---|---|---|
| R-03, IND-01/04 | RF-04, RF-08, RF-09 | INV-01, INV-04; TP-02, TP-07 |
| R-04, IND-05 | RF-07, RNF-03 | INV-02; TP-08 |
| R-05 | RNF-01, RNF-02, RNF-04 | TP-09 |
| R-07 | RF-03, RF-05, RF-10 | INV-05, INV-07 |
| R-08 | RF-06, RF-08 | INV-08; EC-06 |
| R-09, IND-06/07/09 | RF-01–RF-09 | TP-01–TP-09 |
| R-10 | Objetivo científico MTPD-ID | Estado del arte y evaluación posterior |

## 7. Procedimiento de evaluación y reporte

1. Antes de ejecutar: congelar versión de código, dataset sintético y definición de pruebas.
2. Registrar por prueba: ID, fecha, ejecutor, precondición, datos de entrada, resultado esperado, resultado observado, evidencia y estado (aprobada/fallida/bloqueada).
3. Calcular indicadores solo con denominadores válidos y conservar numeradores.
4. Registrar fallas, riesgos activados, tratamiento y nueva evaluación residual **observada**.
5. Comparar resultados con metas propuestas sin afirmar generalización a producción.
6. Reportar amenazas a la validez: tamaño sintético, ausencia de participantes, entorno aislado, selección de escenarios y falta de comparación empírica con plataformas similares.

## 8. Estado actual y advertencia metodológica

**No se han ejecutado las pruebas TP-01 a TP-09; no hay resultados empíricos ni valores observados de indicadores.** La matriz es un instrumento prospectivo de gestión de riesgos y evaluación, preparado para satisfacer la observación docente sobre valoración y tratamiento. Los valores residuales son **estimaciones esperadas después de controles propuestos**, no reducciones constatadas.
