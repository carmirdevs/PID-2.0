-- Ejecutar una sola vez tras respaldar la base. Solo base de encuesta, NO base PID 2.0.
ALTER TABLE survey_invites
 ADD COLUMN consent_version VARCHAR(24) NULL,
 ADD COLUMN consent_sha256 CHAR(64) NULL,
 ADD COLUMN consent_accepted_at DATETIME NULL;
CREATE TABLE IF NOT EXISTS survey_rate_limits (
 rate_key CHAR(64) NOT NULL PRIMARY KEY,
 failures SMALLINT UNSIGNED NOT NULL DEFAULT 0,
 window_started DATETIME NOT NULL,
 blocked_until DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
