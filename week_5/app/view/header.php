<?php
// view/header.php - Dung chung cho cac trang
require_once __DIR__ . '/../common/auth.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quan ly Gio hang</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <h1>HE THONG QUAN LY GIO HANG</h1>
    <nav>
        <a href="index.php">Trang chu</a> |
        <a href="product_list.php">Danh sach san pham</a> |
        <a href="product_add.php">Them san pham</a>
    </nav>
    <?php if (isLoggedIn()): ?>
        <div class="userbar">
            Xin chao, <b><?php echo htmlspecialchars(currentUsername()); ?></b> |
            <a href="logout.php">Dang xuat</a>
        </div>
    <?php else: ?>
        <div class="userbar">
            <a href="login.php">Dang nhap</a> |
            <a href="register.php">Dang ky</a>
        </div>
    <?php endif; ?>
    <hr>
