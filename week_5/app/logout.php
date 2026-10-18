<?php
// logout.php - Xoa phien dang nhap va chuyen ve trang dang nhap
require_once 'common/auth.php';

$_SESSION = [];
session_unset();
session_destroy();

header('Location: login.php');
exit;
?>
