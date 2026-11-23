# PID 2.0 — Trazabilidad de requerimientos y validación P4

**Equipo autorizado:** Carlos Alberto Becerra Grajales y Miriam Crisanto Zetina.
**Fecha de corte:** 23 de noviembre de 2026.
**Naturaleza:** PoC con datos sintéticos; no despliegue institucional productivo.

## Archivos
- `Matriz_Trazabilidad_P2_P3_P4.csv`: 12 RF, 7 RNF y 5 reglas RN; componentes, pruebas, evidencias y límites.
- `VALIDACION_P4.md`: síntesis reproducible de los resultados observados.
- `CONSULTAS_VERIFICACION.sql`: consultas SQL de solo lectura para replicar comprobaciones.

## Convenciones de evidencia
**Verificado en escenario** significa que la PoC se comportó según lo esperado en el escenario ejecutado, no que el requisito haya sido aceptado institucionalmente o probado exhaustivamente. **Parcial** indica cobertura incompleta. **Diseñado/no implementado** no es resultado de ejecución. Los códigos TP/TS de P3 eran pruebas previstas y no deben presentarse como ejecutadas.

## Limitaciones principales
- POC-07 comprobó una aprobación y un conflicto con integridad final de datos; no existe evidencia de solapamiento efectivo de transacciones InnoDB.
- Los controles de autenticación, sesiones y CSRF no han sido sometidos a una batería independiente de pruebas negativas.
- La encuesta académica permanece en curso; la aceptación institucional de RF/RNF/RN sigue pendiente.
- La PoC usa un esquema simplificado distinto del modelo lógico completo P3 (15 tablas propuestas).
- Para certificar la correspondencia textual exacta de cada criterio de aceptación se debe cotejar el catálogo P2 completo.

## Seguridad
No subir `app/config.local.php`, bases de datos reales, contraseñas, tokens ni respuestas identificables de encuestas.