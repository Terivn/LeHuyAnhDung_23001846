-- =========================================================
-- THỰC HÀNH PHP VÀ VUE.JS - BÀI TẬP TUẦN 8
-- Câu 1: Cơ sở dữ liệu cho Quản lý sản phẩm (products)
-- =========================================================

-- Tạo database nếu chưa tồn tại
CREATE DATABASE IF NOT EXISTS `week8_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `week8_db`;

-- Xóa bảng cũ nếu tồn tại
DROP TABLE IF EXISTS `products`;

-- Tạo bảng products theo cấu trúc yêu cầu
CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `price` INT NOT NULL CHECK (`price` > 0),
  `stock` INT NOT NULL CHECK (`stock` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Chèn 3 dòng dữ liệu mẫu theo đề bài
INSERT INTO `products` (`id`, `name`, `price`, `stock`) VALUES
(1, 'Bút bi', 5000, 20),
(2, 'Vở ô ly', 12000, 15),
(3, 'Thước kẻ', 8000, 0);
