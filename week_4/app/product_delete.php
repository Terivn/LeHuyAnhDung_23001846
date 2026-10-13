<?php
require_once 'model/product.php';
include 'view/header.php';

$id = $_GET['id'] ?? ($_POST['id'] ?? null);
if ($id === null || !is_numeric($id)) {
    echo '<h2>Xoa san pham</h2><p class="error">ID san pham khong hop le.</p>';
    echo '<p><a href="product_list.php">Quay lai</a></p>';
    include 'view/footer.php';
    exit;
}
$id = intval($id);

$product = getProductById($id);
if (!$product) {
    echo '<h2>Xoa san pham</h2><p class="error">San pham khong ton tai.</p>';
    echo '<p><a href="product_list.php">Quay lai</a></p>';
    include 'view/footer.php';
    exit;
}

// Nguoi dung da xac nhan xoa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        if (deleteProduct($id)) {
            header('Location: product_list.php');
            exit;
        } else {
            echo '<h2>Xoa san pham</h2><p class="error">Xoa san pham that bai.</p>';
        }
    } else {
        header('Location: product_list.php');
        exit;
    }
}
?>
<h2>Xoa san pham</h2>
<p>Ban co chac muon xoa san pham sau?</p>
<table>
    <tr><th>ID</th><td><?php echo $product['id']; ?></td></tr>
    <tr><th>Ten san pham</th><td><?php echo htmlspecialchars($product['name']); ?></td></tr>
    <tr><th>Gia</th><td><?php echo number_format($product['price'], 2); ?></td></tr>
    <tr><th>So luong</th><td><?php echo $product['quantity']; ?></td></tr>
</table>
<form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
    <p>
        <button type="submit" name="confirm" value="yes">Xac nhan Xoa</button>
        <button type="submit" name="confirm" value="no">Huy</button>
    </p>
</form>
<p><a href="product_list.php">Quay lai danh sach</a></p>
<?php include 'view/footer.php'; ?>
