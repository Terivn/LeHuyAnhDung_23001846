<?php
require_once 'common/auth.php';
include 'view/header.php';
?>
<h2>Trang chu</h2>
<p>Chao mung den voi he thong quan ly gio hang.</p>
<?php if (isLoggedIn()): ?>
<ul>
    <li><a href="product_list.php">Xem danh sach san pham</a></li>
    <li><a href="product_add.php">Them san pham moi</a></li>
</ul>
<?php else: ?>
<p>Vui long <a href="login.php">dang nhap</a> de quan ly san pham.
Neu chua co tai khoan, hay <a href="register.php">dang ky</a>.</p>
<?php endif; ?>
<?php include 'view/footer.php'; ?>
