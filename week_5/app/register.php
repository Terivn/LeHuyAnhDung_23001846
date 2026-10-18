<?php
require_once 'common/auth.php';
require_once 'model/user.php';

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Kiem tra cac truong khong duoc de trong
    if ($username === '' || $password === '') {
        $error = 'Ten dang nhap va mat khau khong duoc de trong.';
    } elseif (strlen($username) > 50) {
        $error = 'Ten dang nhap toi da 50 ky tu.';
    }
    // Kiem tra ten dang nhap chua ton tai trong database
    elseif (getUserByUsername($username) !== null) {
        $error = 'Ten dang nhap da ton tai. Vui long chon ten khac.';
    } else {
        // Mat khau duoc ma hoa bang password_hash() truoc khi luu
        if (addUser($username, $password)) {
            // Dang ky thanh cong, chuyen den trang dang nhap
            header('Location: login.php?registered=1');
            exit;
        } else {
            $error = 'Dang ky that bai. Vui long thu lai.';
        }
    }
}

include 'view/header.php';
?>
<h2>Dang ky tai khoan</h2>
<?php if ($error !== ''): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
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
        <button type="submit">Dang ky</button>
        <a href="login.php">Da co tai khoan? Dang nhap</a>
    </p>
</form>
<?php include 'view/footer.php'; ?>
