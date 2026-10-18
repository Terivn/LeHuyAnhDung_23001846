<?php
// model/user.php - Logic truy van bang users (dang ky, dang nhap)
require_once __DIR__ . '/../common/dbConnect.php';

function getUserByUsername($username) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    return $user; // null neu khong ton tai
}

// Them tai khoan moi, mat khau duoc ma hoa bang password_hash()
function addUser($username, $password) {
    global $conn;
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hash);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}
?>
