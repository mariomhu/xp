CREATE TABLE tags (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(40) NULL,
  PRIMARY KEY(id)
)
TYPE=InnoDB;

CREATE TABLE user_2 (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR(100) NOT NULL,
  name VARCHAR(100) NOT NULL,
  institution VARCHAR(100) NULL,
  creation_date DATETIME NULL,
  ac INTEGER UNSIGNED NOT NULL DEFAULT '0',
  pe INTEGER UNSIGNED NOT NULL DEFAULT '0',
  wa INTEGER UNSIGNED NOT NULL DEFAULT '0',
  ce INTEGER UNSIGNED NOT NULL DEFAULT '0',
  re INTEGER UNSIGNED NOT NULL DEFAULT '0',
  tl INTEGER UNSIGNED NOT NULL DEFAULT '0',
  admin BOOL NULL DEFAULT 'false',
  password_2 VARCHAR(40) NOT NULL,
  login VARCHAR(36) NOT NULL,
  solved INTEGER UNSIGNED NOT NULL DEFAULT '0',
  tried INTEGER UNSIGNED NOT NULL DEFAULT '0',
  page VARCHAR(100) NULL,
  PRIMARY KEY(id)
)
TYPE=InnoDB;

CREATE TABLE problem (
  id INTEGER UNSIGNED NOT NULL,
  user_2_id INTEGER UNSIGNED NOT NULL,
  title VARCHAR(40) NULL,
  creation_date DATETIME NULL,
  ac INTEGER UNSIGNED NOT NULL DEFAULT '0',
  pe INTEGER UNSIGNED NOT NULL DEFAULT '0',
  wa INTEGER UNSIGNED NOT NULL DEFAULT '0',
  ce INTEGER UNSIGNED NOT NULL DEFAULT '0',
  re INTEGER UNSIGNED NOT NULL DEFAULT '0',
  active BOOL NULL,
  tl INTEGER UNSIGNED NOT NULL DEFAULT '0',
  from_2 VARCHAR(100) NULL,
  tried INTEGER UNSIGNED NOT NULL DEFAULT '0',
  solved INTEGER UNSIGNED NOT NULL DEFAULT '0',
  timelimit INTEGER UNSIGNED NULL,
  version INTEGER UNSIGNED NULL,
  PRIMARY KEY(id),
  INDEX t_problem_FKIndex1(user_2_id),
  FOREIGN KEY(user_2_id)
    REFERENCES user_2(id)
      ON DELETE CASCADE
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE contest (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  user_2_id INTEGER UNSIGNED NOT NULL,
  title VARCHAR(40) NULL,
  begin DATETIME NOT NULL,
  end_2 DATETIME NOT NULL,
  penalization INTEGER UNSIGNED NOT NULL,
  blind INTEGER UNSIGNED NOT NULL,
  frozen INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(id),
  INDEX t_contest_FKIndex1(user_2_id),
  FOREIGN KEY(user_2_id)
    REFERENCES user_2(id)
      ON DELETE CASCADE
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE submission (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  problem_id INTEGER UNSIGNED NOT NULL,
  user_2_id INTEGER UNSIGNED NOT NULL,
  time DOUBLE NULL,
  date DATETIME NULL,
  date_judge DATETIME NULL,
  state VARCHAR(2) NULL,
  language INTEGER UNSIGNED NULL,
  PRIMARY KEY(id),
  INDEX t_submission_FKIndex1(user_2_id),
  INDEX t_submission_FKIndex2(problem_id),
  FOREIGN KEY(user_2_id)
    REFERENCES user_2(id)
      ON DELETE CASCADE
      ON UPDATE NO ACTION,
  FOREIGN KEY(problem_id)
    REFERENCES problem(id)
      ON DELETE CASCADE
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE contestusers (
  user_2_id INTEGER UNSIGNED NOT NULL,
  contest_id INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(user_2_id, contest_id),
  INDEX t_user_has_t_contest_FKIndex1(user_2_id),
  INDEX t_user_has_t_contest_FKIndex2(contest_id),
  FOREIGN KEY(user_2_id)
    REFERENCES user_2(id)
      ON DELETE CASCADE
      ON UPDATE NO ACTION,
  FOREIGN KEY(contest_id)
    REFERENCES contest(id)
      ON DELETE CASCADE
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE contestproblems (
  contest_id INTEGER UNSIGNED NOT NULL,
  problem_id INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(contest_id, problem_id),
  INDEX t_problem_has_t_contest_FKIndex1(problem_id),
  INDEX t_problem_has_t_contest_FKIndex2(contest_id),
  FOREIGN KEY(problem_id)
    REFERENCES problem(id)
      ON DELETE CASCADE
      ON UPDATE NO ACTION,
  FOREIGN KEY(contest_id)
    REFERENCES contest(id)
      ON DELETE CASCADE
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE problemtags (
  problem_id INTEGER UNSIGNED NOT NULL,
  tags_id INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(problem_id, tags_id),
  INDEX t_problem_has_t_tags_FKIndex1(problem_id),
  INDEX t_problem_has_t_tags_FKIndex2(tags_id),
  FOREIGN KEY(problem_id)
    REFERENCES problem(id)
      ON DELETE CASCADE
      ON UPDATE NO ACTION,
  FOREIGN KEY(tags_id)
    REFERENCES tags(id)
      ON DELETE CASCADE
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE bestsubmission (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  submission_id INTEGER UNSIGNED NOT NULL,
  problem INTEGER UNSIGNED NULL,
  user_2 INTEGER UNSIGNED NULL,
  time INTEGER UNSIGNED NULL,
  PRIMARY KEY(id),
  INDEX t_bestsubmission_FKIndex1(submission_id),
  FOREIGN KEY(submission_id)
    REFERENCES submission(id)
      ON DELETE CASCADE
      ON UPDATE NO ACTION
)
TYPE=InnoDB;


