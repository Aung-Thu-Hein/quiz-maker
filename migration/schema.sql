CREATE DATABASE IF NOT EXISTS quizmaker;
USE quizmaker;

CREATE TABLE quizzes(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    is_used_same_score BOOLEAN NOT NULL,
    question_type TINYINT NOT NULL CHECK(question_type IN (1, 2))
);

CREATE TABLE questions(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT UNSIGNED NOT NULL,
    body MEDIUMTEXT NOT NULL,
    options JSON NOT NULL,
    solution JSON NOT NULL,
    score DECIMAL(4, 2) UNSIGNED NOT NULL
);
