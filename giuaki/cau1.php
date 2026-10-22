<?php
if (PHP_SAPI !== 'cli') {
    header('Content-Type: text/plain; charset=UTF-8');
}
$name = 'Lê Huy Anh Dũng';
$score = 6.5;
if ($score >= 8) {
    $rank = 'Giỏi';
} elseif ($score >= 6.5) {
    $rank = 'Khá';
} elseif ($score >= 5) {
    $rank = 'Trung bình';
} else {
    $rank = 'Yếu';
}
echo "CÂU 1 - KIẾN THỨC PHP CƠ BẢN\n\n";
echo 'Tên học sinh: ' . $name . "\n";
echo 'Điểm: ' . number_format($score, 1, '.', '') . "\n";
echo 'Xếp loại: ' . $rank . "\n";
