<?php

if (PHP_SAPI !== 'cli') {
    header('Content-Type: text/plain; charset=UTF-8');
}

function findBestStudent($students)
{
    $bestStudent = null;

    foreach ($students as $student) {
        if ($bestStudent === null || $student['score'] > $bestStudent['score']) {
            $bestStudent = $student;
        }
    }

    return $bestStudent;
}

function findWorstStudent($students)
{
    $worstStudent = null;

    foreach ($students as $student) {
        if ($worstStudent === null || $student['score'] < $worstStudent['score']) {
            $worstStudent = $student;
        }
    }

    return $worstStudent;
}

function countPassedStudents($students)
{
    $passedCount = 0;

    foreach ($students as $student) {
        if ($student['score'] >= 5) {
            $passedCount++;
        }
    }

    return $passedCount;
}

function findStudentByName($students, $name)
{
    foreach ($students as $student) {
        if ($student['name'] === $name) {
            return $student;
        }
    }

    return null;
}

function displayStudent($student)
{
    if ($student === null) {
        echo "Không tìm thấy sinh viên.\n\n";
        return;
    }

    echo 'Họ tên: ' . $student['name'] . "\n";
    echo 'Tuổi: ' . $student['age'] . "\n";
    echo 'Điểm: ' . $student['score'] . "\n\n";
}

function displayResults($students, $name)
{
    echo "BÀI 3 - XỬ LÝ DANH SÁCH SINH VIÊN\n\n";

    echo "Sinh viên có điểm cao nhất:\n";
    displayStudent(findBestStudent($students));

    echo "Sinh viên có điểm thấp nhất:\n";
    displayStudent(findWorstStudent($students));

    echo 'Số sinh viên đạt: ' . countPassedStudents($students) . "\n\n";

    echo 'Tìm sinh viên theo tên: ' . $name . "\n";
    displayStudent(findStudentByName($students, $name));
}

$students = [
    ['name' => 'Nguyen Van An', 'age' => 20, 'score' => 8.5],
    ['name' => 'Tran Thi Binh', 'age' => 21, 'score' => 6.5],
    ['name' => 'Le Van Cuong', 'age' => 19, 'score' => 4.5],
    ['name' => 'Pham Thi Dung', 'age' => 20, 'score' => 7.5]
];

displayResults($students, 'Tran Thi Binh');