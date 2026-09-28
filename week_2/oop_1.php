<?php

class CartItem
{
    private string $name;
    private float $price;
    private int $quantity;

    public function __construct($name, $price, $quantity)
    {
        if (empty(trim($name))) {
            throw new InvalidArgumentException("Tên sản phẩm không được để trống.");
        }

        if (!is_numeric($price) || $price <= 0) {
            throw new InvalidArgumentException("Đơn giá phải lớn hơn 0.");
        }

        if (!is_numeric($quantity) || $quantity <= 0 || (int)$quantity != $quantity) {
            throw new InvalidArgumentException("Số lượng phải là số nguyên lớn hơn 0.");
        }

        $this->name = trim($name);
        $this->price = (float)$price;
        $this->quantity = (int)$quantity;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotal(): float
    {
        return $this->price * $this->quantity;
    }
}


class ShoppingCart
{
    private array $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function addItem($item): void
    {
        if (!($item instanceof CartItem)) {
            echo "Không thể thêm: dữ liệu không phải CartItem.<br>";
            return;
        }

        $this->items[] = $item;

        echo "Đã thêm sản phẩm: " . $item->getName() . "<br>";
    }

    public function removeItem($name): void
    {
        foreach ($this->items as $index => $item) {
            if (strcasecmp($item->getName(), $name) == 0) {

                unset($this->items[$index]);

                // Sắp xếp lại chỉ số mảng
                $this->items = array_values($this->items);

                echo "Đã xóa sản phẩm: $name<br>";

                return;
            }
        }

        echo "Không tìm thấy sản phẩm '$name' trong giỏ hàng.<br>";
    }

    public function calculateTotal(): float
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }

    public function displayCart(): void
    {
        echo "<h2>GIỎ HÀNG</h2>";
        if (empty($this->items)) {
            echo "Giỏ hàng hiện đang trống.<br>";
            return;
        }
        echo "
        <table border='1' cellpadding='8' cellspacing='0'>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        ";
        $stt = 1;
        foreach ($this->items as $item) {

            echo "<tr>";

            echo "<td>" . $stt . "</td>";

            echo "<td>" .
                htmlspecialchars($item->getName()) .
                "</td>";

            echo "<td>" .
                number_format($item->getPrice(), 0, ',', '.') .
                " VNĐ</td>";

            echo "<td>" .
                $item->getQuantity() .
                "</td>";

            echo "<td>" .
                number_format($item->getTotal(), 0, ',', '.') .
                " VNĐ</td>";

            echo "</tr>";

            $stt++;
        }

        echo "</table>";
    }
}

try {

    // 1. Tạo ShoppingCart
    $cart = new ShoppingCart();

    // 2. Tạo ít nhất 4 CartItem
    $item1 = new CartItem("Laptop ASUS", 15000000, 1);
    $item2 = new CartItem("Chuột Logitech", 500000, 2);
    $item3 = new CartItem("Bàn phím cơ", 1200000, 1);
    $item4 = new CartItem("Tai nghe", 800000, 2);

    echo "<h3>THÊM SẢN PHẨM</h3>";

    // 3. Thêm sản phẩm
    $cart->addItem($item1);
    $cart->addItem($item2);
    $cart->addItem($item3);
    $cart->addItem($item4);

    echo "<hr>";

    // 4. Hiển thị giỏ hàng
    $cart->displayCart();

    echo "<br><hr>";

    // 5. Tính tổng tiền
    echo "<h3>TỔNG TIỀN GIỎ HÀNG</h3>";

    echo "Tổng tiền: "
        . number_format($cart->calculateTotal(), 0, ',', '.')
        . " VNĐ";

    echo "<br><br><hr>";

    // 6. Xóa sản phẩm
    echo "<h3>XÓA SẢN PHẨM</h3>";

    $cart->removeItem("Bàn phím cơ");

    echo "<br><hr>";

    // 7. Hiển thị lại giỏ hàng
    echo "<h3>GIỎ HÀNG SAU KHI XÓA</h3>";

    $cart->displayCart();

    echo "<br><hr>";

    // Kiểm tra xóa sản phẩm không tồn tại
    echo "<h3>KIỂM TRA XÓA SẢN PHẨM KHÔNG TỒN TẠI</h3>";

    $cart->removeItem("iPhone");

} catch (InvalidArgumentException $e) {

    echo "<strong>Lỗi:</strong> " . $e->getMessage();
}

?>