CREATE DATABASE IF NOT EXISTS idor_lab;
USE idor_lab;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    flag VARCHAR(255)
);

INSERT INTO users (username, email, flag) VALUES
('Alice', 'alice@example.com', NULL),
('Bob', 'bob@example.com', NULL),
('Charlie', 'charlie@example.com', NULL),
('David', 'david@example.com', NULL),
('Eve', 'eve@example.com', NULL),
('Frank', 'frank@example.com', 'flag{D0ck3r_1d0r_rul3z!}');
