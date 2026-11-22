CREATE TABLE IF NOT EXISTS survey_admins (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(100) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL,
 role ENUM('admin','reviewer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS survey_invites (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(180) NOT NULL,
 email VARCHAR(254) NOT NULL UNIQUE,
 role ENUM('docente','coordinacion','jefatura') NOT NULL,
 token_hash CHAR(64) NOT NULL UNIQUE,
 expires_at DATETIME NOT NULL,
 used_at DATETIME NULL,
 declined_at DATETIME NULL,
 consent_version VARCHAR(24) NULL,
 consent_sha256 CHAR(64) NULL,
 consent_accepted_at DATETIME NULL,
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS survey_submissions (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 respondent_role ENUM('docente','coordinacion','jefatura') NOT NULL,
 instrument_version VARCHAR(20) NOT NULL,
 submitted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS survey_answers (
 submission_id BIGINT UNSIGNED NOT NULL,
 question_id CHAR(3) NOT NULL,
 choice_index TINYINT UNSIGNED NOT NULL,
 PRIMARY KEY (submission_id, question_id),
 CONSTRAINT fk_survey_submission FOREIGN KEY (submission_id) REFERENCES survey_submissions(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE IF NOT EXISTS survey_rate_limits (
 rate_key CHAR(64) NOT NULL PRIMARY KEY,
 failures SMALLINT UNSIGNED NOT NULL DEFAULT 0,
 window_started DATETIME NOT NULL,
 blocked_until DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
