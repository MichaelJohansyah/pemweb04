-- Buat database
CREATE DATABASE IF NOT EXISTS praktikum4;

USE praktikum4;

-- Buat tabel users
CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255),
    full_name VARCHAR(200),
    profile_picture VARCHAR(255),
    role VARCHAR(50),
    remember_token VARCHAR(64),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert admin default with hashed password (original password: admin123)
INSERT INTO users (username, email, password, role, full_name)
VALUES ('admin', 'admin@uns.com', '$2y$10$4tZW2GvhG1ezItLrJC.q6e8Sd1aZPtuKJe4jxVGbuBdC4Z3WS/guK', 'admin', 'Administrator');
