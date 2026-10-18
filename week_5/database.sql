-- Database: shopping_cart
CREATE DATABASE IF NOT EXISTS shopping_cart CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shopping_cart;

CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO products (name, price, quantity) VALUES
('Ao thun nam', 150000.00, 50),
('Quan jeans', 350000.00, 30),
('Giay the thao', 800000.00, 20),
('Mu luoi trai', 120000.00, 100),
('Balo laptop', 500000.00, 15);

-- Mat khau mau duoc ma hoa bang password_hash() (khong luu dang van ban thuan):
--   admin / admin123
--   user1 / user123
INSERT INTO users (username, password) VALUES
('admin', '$2y$10$KyZHOT9ho8vrQXTtIUaoX.SxyMFyo9Uu00bzbaR3M5brBEjE2ylda'),
('user1', '$2y$10$yttDQjhJn6kaO0BGPuP6B.IKwm8NR3hw/YPVZfEgJ.Yd/t0tXMcNm');
