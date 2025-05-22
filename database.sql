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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE users ADD profile_picture VARCHAR(255);

-- Insert admin default
INSERT INTO users (username, email, password, role, full_name)
VALUES ('admin', 'admin@uns.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Administrator');
