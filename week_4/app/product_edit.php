<?php
require_once 'model/product.php';
include 'view/header.php';

$id = $_GET['id'] ?? null;
if ($id === null || !is_numeric($id)) {
    echo '<h2>Sua san pham</h2><p class="error">ID san pham khong hop le.</p>';
    echo '<p><a href="product_list.php">Quay lai</a></p>';
    include 'view/footer.php';
    exit;
}

$product = getProductById(intval($id));
if (!$product) {
    echo '<h2>Sua san pham</h2><p class="error">San pham khong ton tai.</p>';
    echo '<p><a href="product_list.php">Quay lai</a></p>';
    include 'view/footer.php';
    exit;
}

$error = '';
$name = $product['name'];
$price = $product['price'];
$quantity = $product['quantity'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = $_POST['price'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    // Kiem tra du lieu truoc khi cap nhat
    if ($name === '') {
        $error = 'Ten san pham khong duoc rong.';
    } elseif (!is_numeric($price) || floatval($price) <= 0) {
        $error = 'Gia phai > 0.';
    } elseif (filter_var($quantity, FILTER_VALIDATE_INT) === false || intval($quantity) < 0) {
        $error = 'So luong phai la so nguyen >= 0.';
    }

    if ($error === '') {
        if (updateProduct(intval($id), $name, floatval($price), intval($quantity))) {
            header('Location: product_list.php');
            exit;
        } else {
            $error = 'Cap nhat san pham that bai.';
        }
    }
}
?>
<h2>Sua san pham (ID: <?php echo $product['id']; ?>)</h2>
<?php if ($error !== ''): ?>
    <p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<form method="post" action="">
    <p>
        <label>Ten san pham:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
    </p>
    <p>
        <label>Gia:</label>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($price); ?>">
    </p>
    <p>
        <label>So luong:</label>
        <input type="number" step="1" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
    </p>
    <p>
        <button type="submit">Cap nhat</button>
        <a href="product_list.php">Quay lai</a>
    </p>
</form>
<?php include 'view/footer.php'; ?>
