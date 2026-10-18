<?php
require_once 'common/auth.php';
require_once 'model/user.php';

// Neu da dang nhap thi chuyen thang den trang quan ly san pham
if (isLoggedIn()) {
    header('Location: product_list.php');
    exit;
}

$error = '';
$success = isset($_GET['registered']) ? 'Dang ky thanh cong. Hay dang nhap.' : '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Vui long nhap day du ten dang nhap va mat khau.';
    } else {
        $user = getUserByUsername($username);
        // Kiem tra mat khau bang password_verify()
        if ($user && password_verify($password, $user['password'])) {
            // Luu thong tin can thiet vao $_SESSION
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: product_list.php');
            exit;
        } else {
            $error = 'Ten dang nhap hoac mat khau khong chinh xac.';
        }
    }
}

include 'view/header.php';
?>
<h2>Dang nhap</h2>
<?php if ($error !== ''): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<?php if ($success !== ''): ?>
    <p class="success"><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>
<form method="post" action="">
    <p>
        <label>Ten dang nhap:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
    </p>
    <p>
        <label>Mat khau:</label>
        <input type="password" name="password" value="">
    </p>
    <p>
        <button type="submit">Dang nhap</button>
        <a href="register.php">Chua co tai khoan? Dang ky</a>
    </p>
</form>
<?php include 'view/footer.php'; ?>
