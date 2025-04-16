CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "permissions"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "guard_name" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "permissions_name_guard_name_unique" on "permissions"(
  "name",
  "guard_name"
);
CREATE TABLE IF NOT EXISTS "roles"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "guard_name" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "roles_name_guard_name_unique" on "roles"(
  "name",
  "guard_name"
);
CREATE TABLE IF NOT EXISTS "model_has_permissions"(
  "permission_id" integer not null,
  "model_type" varchar not null,
  "model_id" integer not null,
  foreign key("permission_id") references "permissions"("id") on delete cascade,
  primary key("permission_id", "model_id", "model_type")
);
CREATE INDEX "model_has_permissions_model_id_model_type_index" on "model_has_permissions"(
  "model_id",
  "model_type"
);
CREATE TABLE IF NOT EXISTS "model_has_roles"(
  "role_id" integer not null,
  "model_type" varchar not null,
  "model_id" integer not null,
  foreign key("role_id") references "roles"("id") on delete cascade,
  primary key("role_id", "model_id", "model_type")
);
CREATE INDEX "model_has_roles_model_id_model_type_index" on "model_has_roles"(
  "model_id",
  "model_type"
);
CREATE TABLE IF NOT EXISTS "role_has_permissions"(
  "permission_id" integer not null,
  "role_id" integer not null,
  foreign key("permission_id") references "permissions"("id") on delete cascade,
  foreign key("role_id") references "roles"("id") on delete cascade,
  primary key("permission_id", "role_id")
);
CREATE TABLE IF NOT EXISTS "user_details"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "division_id" integer,
  "department_id" integer,
  "supervisor_id" integer,
  "salary_ref_number" integer not null,
  "gender" varchar not null,
  "dob" date not null,
  "phone_number" varchar not null,
  "address" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "organisations"(
  "id" integer primary key autoincrement not null,
  "organisation_name" varchar not null,
  "organisation_logo" varchar,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "divisions"(
  "id" integer primary key autoincrement not null,
  "organisation_id" integer not null,
  "division_name" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "departments"(
  "id" integer primary key autoincrement not null,
  "division_id" integer not null,
  "department_name" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "courses"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "course_name" varchar not null,
  "course_description" varchar not null,
  "course_fee" integer not null,
  "course_image" varchar not null,
  "course_type" varchar check("course_type" in('online', 'face-to-face', 'hybrid')) not null,
  "start_date" date not null,
  "end_date" date not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "course_materials"(
  "id" integer primary key autoincrement not null,
  "course_id" integer not null,
  "material_name" varchar not null,
  "description" text not null,
  "material_content" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("course_id") references "courses"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "course_progress"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "course_id" integer not null,
  "course_material_id" integer not null,
  "status" varchar check("status" in('in_progress', 'completed')) not null default 'in_progress',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("course_id") references "courses"("id") on delete cascade,
  foreign key("course_material_id") references "course_materials"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "enrollments"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "course_id" integer not null,
  "status" varchar not null,
  "score" integer not null default '0',
  "enrolled_at" datetime not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("course_id") references "courses"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "course_feedback"(
  "id" integer primary key autoincrement not null,
  "enrollment_id" integer not null,
  "feedback" text not null,
  "rating" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("enrollment_id") references "enrollments"("id")
);
CREATE TABLE IF NOT EXISTS "quizzes"(
  "id" integer primary key autoincrement not null,
  "course_id" integer not null,
  "title" varchar not null,
  "description" text,
  "max_attempts" integer not null default '1',
  "passing_score" integer not null default '70',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("course_id") references "courses"("id")
);
CREATE TABLE IF NOT EXISTS "questions"(
  "id" integer primary key autoincrement not null,
  "quiz_id" integer not null,
  "question_text" text not null,
  "question_type" varchar check("question_type" in('multiple_choice', 'short_answer', 'multiple_response', 'sequence', 'matching')) not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("quiz_id") references "quizzes"("id")
);
CREATE TABLE IF NOT EXISTS "options"(
  "id" integer primary key autoincrement not null,
  "question_id" integer not null,
  "option_text" text not null,
  "is_correct" tinyint(1),
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("question_id") references "questions"("id")
);
CREATE TABLE IF NOT EXISTS "quiz_responses"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "quiz_id" integer not null,
  "score" integer not null default '0',
  "attempts" integer not null default '0',
  "status" varchar check("status" in('passed', 'failed', 'in_progress')) not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id"),
  foreign key("quiz_id") references "quizzes"("id")
);
CREATE TABLE IF NOT EXISTS "user_answers"(
  "id" integer primary key autoincrement not null,
  "quiz_response_id" integer not null,
  "option_id" integer not null,
  "question_id" integer not null,
  "is_correct" tinyint(1),
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("quiz_response_id") references "quiz_responses"("id"),
  foreign key("option_id") references "options"("id"),
  foreign key("question_id") references "questions"("id")
);
CREATE TABLE IF NOT EXISTS "summaries"(
  "id" integer primary key autoincrement not null,
  "course_id" integer not null,
  "user_id" integer not null,
  "facilitator_cost" numeric,
  "assessment_cost" numeric,
  "certification_cost" numeric,
  "travel_cost" numeric,
  "accommodation_cost" numeric,
  "other_cost" numeric,
  "total_cost" numeric,
  "facilitator_invoice" varchar,
  "assessment_invoice" varchar,
  "certification_invoice" varchar,
  "travel_invoice" varchar,
  "accommodation_invoice" varchar,
  "other_invoice" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("course_id") references "courses"("id"),
  foreign key("user_id") references "users"("id")
);
CREATE TABLE IF NOT EXISTS "assessments"(
  "id" integer primary key autoincrement not null,
  "assessment_title" varchar not null,
  "closing_date" datetime,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "jcps"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "position_title" varchar not null,
  "job_grade" varchar not null,
  "duty_station" varchar not null,
  "job_purpose" varchar not null,
  "is_active" integer not null default '1',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "skill_categories"(
  "id" integer primary key autoincrement not null,
  "category_title" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "skills"(
  "id" integer primary key autoincrement not null,
  "skill_category_id" integer not null,
  "skill_title" varchar not null,
  "skill_description" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("skill_category_id") references "skill_categories"("id")
);
CREATE TABLE IF NOT EXISTS "qualifications"(
  "id" integer primary key autoincrement not null,
  "qualification_title" varchar not null,
  "institution" varchar,
  "qualification_level" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "user_qualification"(
  "id" integer primary key autoincrement not null,
  "qualification_id" integer not null,
  "user_id" integer not null,
  "status" varchar not null default 'pending',
  "from_date" date,
  "end_date" date,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("qualification_id") references "qualifications"("id") on delete cascade,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "jcp_qualification"(
  "id" integer primary key autoincrement not null,
  "jcp_id" integer not null,
  "qualification_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("jcp_id") references "jcps"("id") on delete cascade,
  foreign key("qualification_id") references "qualifications"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "skillharbor_enrollments"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "assessment_id" integer not null,
  "user_status" integer not null default '0',
  "supervisor_status" integer not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade,
  foreign key("assessment_id") references "assessments"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "jcp_skill"(
  "jcp_id" integer not null,
  "skill_id" integer not null,
  "required_level" integer,
  "supervisor_rating" integer not null default '0',
  "user_rating" integer not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("jcp_id") references "jcps"("id") on delete cascade,
  foreign key("skill_id") references "skills"("id") on delete cascade
);

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2025_02_27_070627_create_permission_tables',1);
INSERT INTO migrations VALUES(5,'2025_02_27_074839_create_user_details_table',1);
INSERT INTO migrations VALUES(6,'2025_02_27_081855_create_organisations_table',1);
INSERT INTO migrations VALUES(7,'2025_02_27_081901_create_divisions_table',1);
INSERT INTO migrations VALUES(8,'2025_02_27_081907_create_departments_table',1);
INSERT INTO migrations VALUES(9,'2025_02_27_095442_create_courses_table',1);
INSERT INTO migrations VALUES(10,'2025_02_27_095448_create_course_materials_table',1);
INSERT INTO migrations VALUES(11,'2025_02_27_095457_create_course_progress_table',1);
INSERT INTO migrations VALUES(12,'2025_02_27_095509_create_enrollments_table',1);
INSERT INTO migrations VALUES(13,'2025_02_27_095518_create_course_feedback_table',1);
INSERT INTO migrations VALUES(14,'2025_03_03_083832_create_quizzes_table',1);
INSERT INTO migrations VALUES(15,'2025_03_03_083846_create_questions_table',1);
INSERT INTO migrations VALUES(16,'2025_03_03_083852_create_options_table',1);
INSERT INTO migrations VALUES(17,'2025_03_03_083909_create_quiz_responses_table',1);
INSERT INTO migrations VALUES(18,'2025_03_03_083915_create_user_answers_table',1);
INSERT INTO migrations VALUES(19,'2025_03_03_131141_create_summaries_table',1);
INSERT INTO migrations VALUES(20,'2025_03_03_132047_create_roles_and_permissions',1);
INSERT INTO migrations VALUES(21,'2025_03_03_132731_create_cyber_course',1);
INSERT INTO migrations VALUES(22,'2025_03_06_093417_create_organisation',1);
INSERT INTO migrations VALUES(23,'2025_03_17_074609_create_skillharbor_tables',1);
