-- Solo lectura. Seleccionar antes la base de datos de la PoC.
SELECT p.id, p.current_version, COUNT(DISTINCT v.id) AS total_versiones,
       MAX(v.version_no) AS ultima_version
FROM plans p JOIN plan_versions v ON v.plan_id=p.id
WHERE p.id=1 GROUP BY p.id,p.current_version;

SELECT v.version_no, v.created_at, a.activity_key, a.title,
       a.planned_date, a.actual_date, v.source_request_id
FROM plan_versions v JOIN activities a ON a.version_id=v.id
WHERE v.plan_id=1 ORDER BY v.version_no,a.activity_key;

SELECT r.id, r.activity_key, r.base_version, r.status,
       solicitante.name AS solicitado_por,
       autorizador.name AS resuelto_por,
       r.created_at, r.decided_at, r.decision_note
FROM change_requests r JOIN users solicitante ON solicitante.id=r.requester_id
LEFT JOIN users autorizador ON autorizador.id=r.decider_id
WHERE r.plan_id=1 ORDER BY r.id;

SELECT a.id, a.created_at, u.name AS responsable, a.action,
       a.plan_id, a.request_id, a.detail
FROM audit_events a JOIN users u ON u.id=a.actor_id
WHERE a.plan_id=1 ORDER BY a.id;