<?php

if (PHP_SAPI !== 'cli') {
    header('Content-Type: text/plain; charset=UTF-8');
}

$students = [
    ['name' => 'Nguyen Van An', 'age' => 20, 'score' => 8.5],
    ['name' => 'Tran Thi Binh', 'age' => 21, 'score' => 6.5],
    ['name' => 'Le Van Cuong', 'age' => 19, 'score' => 4.5],
    ['name' => 'Pham Thi Dung', 'age' => 20, 'score' => 7.5]
];

$totalScore = 0;

echo "BÀI 1 - DANH SÁCH SINH VIÊN\n\n";

foreach ($students as $student) {
    echo 'Họ tên: ' . $student['name'] . "\n";
    echo 'Tuổi: ' . $student['age'] . "\n";
    echo 'Điểm: ' . $student['score'] . "\n\n";

    $totalScore += $student['score'];
}

$studentCount = count($students);
$averageScore = $studentCount > 0 ? $totalScore / $studentCount : 0;

echo 'Điểm trung bình của lớp: ' . number_format($averageScore, 2, '.', '') . "\n";
?>
