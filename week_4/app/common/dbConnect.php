<?php
// common/dbConnect.php - Ket noi PHP voi MySQL
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'shopping_cart';

$conn = new mysqli($host, $user, $pass, $dbname);

// Xu ly truong hop ket noi that bai
if ($conn->connect_error) {
    die('Ket noi database that bai: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');
?>
