<?php
// config/db.php - Kết nối PDO MySQL cho API PHP
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'week8_db';
$charset = 'utf8mb4';

try {
    // 1. Thử kết nối trực tiếp đến database
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // 2. Nếu chưa có database week8_db, tự động kết nối MySQL server và tạo DB/bảng mẫu
    try {
        $rootDsn = "mysql:host=$host;charset=$charset";
        $rootPdo = new PDO($rootDsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $rootPdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $rootPdo->exec("USE `$dbname`");
        
        $rootPdo->exec("
            CREATE TABLE IF NOT EXISTS `products` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(100) NOT NULL,
                `price` INT NOT NULL,
                `stock` INT NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        
        // Kiểm tra xem bảng có dữ liệu chưa
        $stmt = $rootPdo->query("SELECT COUNT(*) FROM `products`");
        if ($stmt->fetchColumn() == 0) {
            $rootPdo->exec("
                INSERT INTO `products` (`id`, `name`, `price`, `stock`) VALUES
                (1, 'Bút bi', 5000, 20),
                (2, 'Vở ô ly', 12000, 15),
                (3, 'Thước kẻ', 8000, 0);
            ");
        }
        
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $ex) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi kết nối MySQL Database: ' . $ex->getMessage()
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
