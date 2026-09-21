<?php

if (PHP_SAPI !== 'cli') {
    header('Content-Type: text/plain; charset=UTF-8');
}

class Student
{
    public $name;
    public $age;
    public $score;

    public function __construct($name, $age, $score)
    {
        $this->name = $name;
        $this->age = $age;
        $this->score = $score;
    }

    public function getRank()
    {
        if ($this->score >= 8) {
            return 'Giỏi';
        }

        if ($this->score >= 6.5) {
            return 'Khá';
        }

        if ($this->score >= 5) {
            return 'Trung bình';
        }

        return 'Yếu';
    }

    public function isPassed()
    {
        return $this->score >= 5;
    }

    public function display()
    {
        echo 'Họ tên: ' . $this->name . "\n";
        echo 'Tuổi: ' . $this->age . "\n";
        echo 'Điểm: ' . $this->score . "\n";
        echo 'Xếp loại: ' . $this->getRank() . "\n";
        echo 'Kết quả: ' . ($this->isPassed() ? 'Đạt' : 'Chưa đạt') . "\n\n";
    }
}

function findBestStudent($students)
{
    $bestStudent = null;

    foreach ($students as $student) {
        if ($bestStudent === null || $student->score > $bestStudent->score) {
            $bestStudent = $student;
        }
    }

    return $bestStudent;
}

function countPassedStudents($students)
{
    $passedCount = 0;

    foreach ($students as $student) {
        if ($student->isPassed()) {
            $passedCount++;
        }
    }

    return $passedCount;
}

function calculateAverageScore($students)
{
    if (count($students) === 0) {
        return 0;
    }

    $totalScore = 0;

    foreach ($students as $student) {
        $totalScore += $student->score;
    }

    return $totalScore / count($students);
}

function displayClass($students)
{
    echo "BÀI 4 - LẬP TRÌNH HƯỚNG ĐỐI TƯỢNG\n\n";

    foreach ($students as $student) {
        $student->display();
    }

    echo "Sinh viên có điểm cao nhất:\n";
    $bestStudent = findBestStudent($students);

    if ($bestStudent !== null) {
        $bestStudent->display();
    } else {
        echo "Danh sách sinh viên trống.\n\n";
    }

    echo 'Số sinh viên đạt: ' . countPassedStudents($students) . "\n";

    $averageScore = calculateAverageScore($students);
    echo 'Điểm trung bình của lớp: ' . number_format($averageScore, 2, '.', '') . "\n";
}

$student1 = new Student('Nguyen Van An', 20, 8.5);
$student2 = new Student('Tran Thi Binh', 21, 6.5);
$student3 = new Student('Le Van Cuong', 19, 4.5);
$student4 = new Student('Pham Thi Dung', 20, 7.5);

$students = [$student1, $student2, $student3, $student4];

displayClass($students);
