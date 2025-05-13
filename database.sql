-- Buat database
CREATE DATABASE praktikum4;

USE praktikum4;

-- Buat tabel users
CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(100),
    role VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert admin default
INSERT INTO users (username, email, password, role)
VALUES ('admin', 'admin@uns.com', '$2y$10$eImiTXuWVxfM37uY4JANjQWJQ0Q0Q0Q0Q0Q0Q0Q0Q0Q0Q0Q0Q0', 'admin'); -- Replace with hashed password
