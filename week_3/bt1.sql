
CREATE DATABASE IF NOT EXISTS shopping_cart;

USE shopping_cart;


-- BÀI 1: QUẢN LÝ GIỎ HÀNG

-- 1. Tạo bảng cart_items

CREATE TABLE cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);


-- 2.1. Thêm ít nhất 5 sản phẩm

INSERT INTO cart_items (name, price, quantity)
VALUES
('Laptop ASUS', 15000000, 2),
('Chuột Logitech', 350000, 10),
('Bàn phím cơ', 1200000, 5),
('Tai nghe Bluetooth', 850000, 7),
('USB 64GB', 180000, 12);


-- 2.2. Hiển thị toàn bộ sản phẩm

SELECT * 
FROM cart_items;


-- 2.3. Hiển thị sản phẩm có giá lớn hơn 100000

SELECT *
FROM cart_items
WHERE price > 100000;


-- 2.4. Hiển thị sản phẩm có số lượng lớn hơn 5

SELECT *
FROM cart_items
WHERE quantity > 5;


-- 2.5. Sắp xếp sản phẩm theo giá giảm dần

SELECT *
FROM cart_items
ORDER BY price DESC;


-- 2.6. Cập nhật giá của một sản phẩm

UPDATE cart_items
SET price = 400000
WHERE id = 2;


SELECT *
FROM cart_items
WHERE id = 2;


-- 2.7. Cập nhật số lượng của một sản phẩm

UPDATE cart_items
SET quantity = 8
WHERE id = 3;


-- Kiểm tra

SELECT *
FROM cart_items
WHERE id = 3;


-- 2.8. Xóa một sản phẩm

DELETE FROM cart_items
WHERE id = 5;


-- Kiểm tra lại danh sách

SELECT *
FROM cart_items;


-- 2.9. Hiển thị tên sản phẩm, giá, số lượng và thành tiền

SELECT
    name,
    price,
    quantity,
    price * quantity AS thanh_tien
FROM cart_items;


-- 2.10. Tính tổng tiền của toàn bộ giỏ hàng

SELECT
    SUM(price * quantity) AS tong_tien_gio_hang
FROM cart_items;



-- BÀI 2: QUẢN LÝ VÉ XEM PHIM

-- 1. Tạo bảng movies

CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL
);


-- 2.1. Thêm ít nhất 5 bộ phim

INSERT INTO movies (title, price, total_seats, available_seats)
VALUES
('Avengers Endgame', 120000, 150, 40),
('Spider-Man No Way Home', 100000, 120, 60),
('Avatar 2', 150000, 200, 80),
('Doraemon', 80000, 100, 55),
('Fast X', 110000, 180, 20);


-- 2.2. Hiển thị toàn bộ danh sách phim

SELECT *
FROM movies;


-- 2.3. Hiển thị phim có giá vé lớn hơn 100000

SELECT *
FROM movies
WHERE price > 100000;


-- 2.4. Hiển thị phim còn nhiều hơn 50 ghế

SELECT *
FROM movies
WHERE available_seats > 50;


-- 2.5. Sắp xếp phim theo giá vé giảm dần

SELECT *
FROM movies
ORDER BY price DESC;


-- 2.6. Cập nhật số ghế còn lại của một phim

UPDATE movies
SET available_seats = 45
WHERE id = 2;


-- Kiểm tra

SELECT *
FROM movies
WHERE id = 2;


-- 2.7. Xóa một phim

DELETE FROM movies
WHERE id = 4;


-- Kiểm tra lại

SELECT *
FROM movies;


-- 2.8. Hiển thị số vé đã bán của từng phim

SELECT
    id,
    title,
    total_seats,
    available_seats,
    total_seats - available_seats AS so_ve_da_ban
FROM movies;


-- 2.9. Tính doanh thu của từng phim

SELECT
    id,
    title,
    price,
    total_seats - available_seats AS so_ve_da_ban,
    (total_seats - available_seats) * price AS doanh_thu
FROM movies;


-- 2.10. Tính tổng doanh thu của tất cả các phim

SELECT
    SUM((total_seats - available_seats) * price) AS tong_doanh_thu
FROM movies;


-- 2.11. Tìm phim có số vé bán ra nhiều nhất

SELECT
    id,
    title,
    total_seats,
    available_seats,
    total_seats - available_seats AS so_ve_da_ban
FROM movies
WHERE (total_seats - available_seats) = (
    SELECT MAX(total_seats - available_seats)
    FROM movies
);
