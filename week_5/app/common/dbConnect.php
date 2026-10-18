<?php
// common/dbConnect.php - Ket noi PHP voi MySQL
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'shopping_cart';

// Xu ly truong hop ket noi that bai
try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die('Ket noi database that bai: ' . $conn->connect_error);
    }
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    // PHP 8.1+ nem exception khi ket noi that bai
    die('Ket noi database that bai: ' . $e->getMessage());
}
?>
