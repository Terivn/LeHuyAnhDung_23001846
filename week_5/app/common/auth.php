<?php
// common/auth.php - Quan ly phien dang nhap va kiem soat truy cap
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiem tra da dang nhap chua
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Ten tai khoan dang nhap hien tai
function currentUsername() {
    return $_SESSION['username'] ?? '';
}

// Bat buoc dang nhap: neu chua dang nhap thi chuyen ve login.php
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}
?>
