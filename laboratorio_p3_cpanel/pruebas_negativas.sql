-- Ejecutar UNA sentencia por vez en phpMyAdmin, solo en base descartable.
-- Preparar primero esquema v3 y datos sintéticos corregidos.
-- Verificar SQLSTATE y comprobar que el estado no cambió.
SELECT VERSION() AS version_motor;
SHOW TRIGGERS;
-- 1: fecha invertida (CHECK)
INSERT INTO periodos(clave,inicio,fin) VALUES('P-INVALIDO','2026-09-30','2026-09-01');
-- 2: actualización de instantánea publicada (trigger)
UPDATE version_actividades SET descripcion='ALTERADA' WHERE version_id=1 AND actividad_id=1;
-- 3: borrado de decisión histórica (trigger)
DELETE FROM decisiones_cambio WHERE id=1;
-- 4: inserción tardía de actividad distinta en versión publicada
-- actividad_id=3 debe existir en la misma planeación y NO figurar aún en version_actividades
INSERT INTO version_actividades(version_id,planeacion_id,actividad_id,descripcion,fecha_inicio_programada,fecha_fin_programada)
VALUES (1,1,3,'INSERCION NO AUTORIZADA','2026-03-02','2026-03-04');
-- 5: duplicado de rol y ámbito (UNIQUE)
INSERT INTO usuario_roles(usuario_id,rol_id,ambito_tipo,ambito_id) VALUES(1,1,'grupo',1);
-- Consultas de integridad posteriores (deben mostrar historial original)
SELECT version_id,actividad_id,descripcion FROM version_actividades WHERE version_id=1 ORDER BY actividad_id;
SELECT id,resultado FROM decisiones_cambio WHERE id=1;
SELECT COUNT(*) AS filas_publicaciones FROM publicaciones_version;
