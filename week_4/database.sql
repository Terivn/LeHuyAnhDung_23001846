-- Database: shopping_cart
CREATE DATABASE IF NOT EXISTS shopping_cart CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shopping_cart;

CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO products (name, price, quantity) VALUES
('Ao thun nam', 150000.00, 50),
('Quan jeans', 350000.00, 30),
('Giay the thao', 800000.00, 20),
('Mu luoi trai', 120000.00, 100),
('Balo laptop', 500000.00, 15);
