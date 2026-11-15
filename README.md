# PID 2.0 — Plataforma de Instrumentación Didáctica

**Proyecto doctoral en desarrollo · Universidad del Sur · Seminario de Análisis y Diseño de Sistemas**

## Propósito

Investigar, diseñar y evaluar una evolución del PID original hacia un sistema de **seguimiento programático estructurado** de la planeación docente, con solicitudes de cambio, autorización académica y trazabilidad.

## Antecedente verificable

Repositorio histórico privado: [PID-Original](https://github.com/carmirdevs/PID-Original). Su diagnóstico estático se encuentra en `docs/INFORME_REVISION_TECNICA.md` de ese repositorio.

**Distinción fundamental:** la última versión original aceptaba instrumentaciones XLSX y permitía sustituir archivos; no debe confundirse esa operación con actualizar unidades, actividades y fechas de manera estructurada. El diagnóstico técnico tiene límites: no se han completado pruebas funcionales.

## Alcance inicial propuesto (sujeto a validación de requerimientos)

1. Plan académico por periodo, asignatura, grupo, unidad y actividad.
2. Línea base con fechas programadas y registro de ejecución real.
3. Solicitudes justificadas de modificación.
4. Aprobación o rechazo por responsable académico autorizado.
5. Conservación de versiones, identidad del actor, fechas y motivo.
6. Consulta de avances y reportes para roles autorizados.

## Fuera de alcance de la PoC inicial

Inscripciones, calificaciones de alumnos, nómina, finanzas y despliegue institucional en producción.

## Investigación y evidencia

- Sesiones 1 y 2: diagnóstico corregido, levantamiento y especificación de requerimientos.
- Sesión 3: modelos de arquitectura, datos, interfaces y controles.
- Sesión 4: prueba de concepto y evaluación con datos sintéticos.
- **No se reportarán pruebas ni entrevistas como realizadas antes de ejecutarlas.**

## Estado

**Fase: análisis y diseño preliminar.** Este repositorio no contiene aún una aplicación funcional ni está listo para producción.

## Seguridad

No incorporar credenciales, datos personales, respaldos reales ni instrumentaciones institucionales. Usar datos sintéticos en desarrollo y pruebas. Los requisitos de seguridad se fundamentarán en la revisión técnica del sistema anterior.

## Organización prevista

- `docs/`: evidencia, requerimientos, decisiones y trazabilidad.
- `src/`: implementación futura de la PoC.
- `database/`: migraciones y esquema de desarrollo.
- `tests/`: pruebas automatizadas y escenarios verificables.

## Equipo

Carlos Alberto Becerra Grajales y Miriam Crisanto Zetina.
