DROP DATABASE IF EXISTS alumnidb;
CREATE DATABASE alumnidb;
USE alumnidb;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role ENUM('alumni', 'photographer', 'admin') NOT NULL
);

CREATE TABLE alumni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    group_number INT,
    potok_number INT,
    major VARCHAR(50),
    graduation_year YEAR,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    photo_path VARCHAR(255),
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    major VARCHAR(50),
    potok_number INT,
    stream VARCHAR(50),
    event VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    session_date DATETIME,
    place VARCHAR(255), 
    type ENUM('group', 'personal'),
    status ENUM('pending', 'approved', 'completed') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_type ENUM('album', 'card', 'calendar', 'mug', 'bridge_card'),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    photo_id INT,
    status ENUM('pending', 'processing', 'shipped') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);
