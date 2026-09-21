<?php

if (PHP_SAPI !== 'cli') {
    header('Content-Type: text/plain; charset=UTF-8');
}

function calculateAverageScore($students)
{
    if (count($students) === 0) {
        return 0;
    }

    $totalScore = 0;

    foreach ($students as $student) {
        $totalScore += $student['score'];
    }

    return $totalScore / count($students);
}

function getRank($score)
{
    if ($score >= 8) {
        return 'Giỏi';
    }

    if ($score >= 6.5) {
        return 'Khá';
    }

    if ($score >= 5) {
        return 'Trung bình';
    }

    return 'Yếu';
}

function displayStudent($student)
{
    echo 'Họ tên: ' . $student['name'] . "\n";
    echo 'Tuổi: ' . $student['age'] . "\n";
    echo 'Điểm: ' . $student['score'] . "\n";
    echo 'Xếp loại: ' . getRank($student['score']) . "\n\n";
}

function displayClass($students)
{
    echo "BÀI 2 - TÁCH HÀM XỬ LÝ SINH VIÊN\n\n";

    foreach ($students as $student) {
        displayStudent($student);
    }

    $averageScore = calculateAverageScore($students);
    echo 'Điểm trung bình của lớp: ' . number_format($averageScore, 2, '.', '') . "\n";
}

$students = [
    ['name' => 'Nguyen Van An', 'age' => 20, 'score' => 8.5],
    ['name' => 'Tran Thi Binh', 'age' => 21, 'score' => 6.5],
    ['name' => 'Le Van Cuong', 'age' => 19, 'score' => 4.5],
    ['name' => 'Pham Thi Dung', 'age' => 20, 'score' => 7.5]
];

displayClass($students);
?>