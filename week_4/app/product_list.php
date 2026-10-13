<?php
require_once 'model/product.php';
include 'view/header.php';

$products = getAllProducts();
?>
<h2>Danh sach san pham</h2>
<p><a href="product_add.php"><button>Them san pham</button></a></p>
<table>
    <tr>
        <th>ID</th>
        <th>Ten san pham</th>
        <th>Gia</th>
        <th>So luong</th>
        <th>Chuc nang</th>
    </tr>
    <?php if (empty($products)): ?>
        <tr><td colspan="5">Chua co san pham nao.</td></tr>
    <?php else: ?>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><?php echo $p['id']; ?></td>
            <td><?php echo htmlspecialchars($p['name']); ?></td>
            <td><?php echo number_format($p['price'], 2); ?></td>
            <td><?php echo $p['quantity']; ?></td>
            <td>
                <a href="product_edit.php?id=<?php echo $p['id']; ?>">[Sua]</a>
                <a href="product_delete.php?id=<?php echo $p['id']; ?>">[Xoa]</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
<?php include 'view/footer.php'; ?>
