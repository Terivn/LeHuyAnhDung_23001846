<?php
if (PHP_SAPI !== 'cli') {
    header('Content-Type: text/plain; charset=UTF-8');
}
$prices = [120000, 450000, 890000, 230000, 650000];

function calculateTotal($prices)
{
    $total = 0;
    foreach ($prices as $price) {
        $total += $price;
    }
    return $total;
}
function findMaxPrice($prices)
{
    if (count($prices) === 0) {
        return 0;
    }
    $maxPrice = $prices[0];
    foreach ($prices as $price) {
        if ($price > $maxPrice) {
            $maxPrice = $price;
        }
    }
    return $maxPrice;
}
function formatPrice($price)
{
    return number_format($price, 0, ',', '.') . ' VND';
}
echo "CÂU 2 - XỬ LÝ MẢNG VÀ HÀM TRONG PHP\n\n";
echo "Danh sách giá sản phẩm:\n";
foreach ($prices as $index => $price) {
    echo 'Sản phẩm ' . ($index + 1) . ': ' . formatPrice($price) . "\n";
}
echo "\nTổng giá trị sản phẩm: " . formatPrice(calculateTotal($prices)) . "\n";
echo 'Giá sản phẩm cao nhất: ' . formatPrice(findMaxPrice($prices)) . "\n";
