<?php

class Movie
{
    private $id;
    private $title;
    private $price;
    private $totalSeats;
    private $availableSeats;

    public function __construct($id, $title, $price, $totalSeats)
    {
        if ($price <= 0) {
            throw new InvalidArgumentException("Giá vé phải lớn hơn 0.");
        }

        if ($totalSeats <= 0) {
            throw new InvalidArgumentException("Tổng số ghế phải lớn hơn 0.");
        }

        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->totalSeats = $totalSeats;

        // Khi khởi tạo, số ghế còn lại = tổng số ghế
        $this->availableSeats = $totalSeats;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getTotalSeats()
    {
        return $this->totalSeats;
    }

    public function getAvailableSeats()
    {
        return $this->availableSeats;
    }

    public function bookTicket($quantity)
    {
        if ($quantity <= 0) {
            echo "Số vé đặt phải lớn hơn 0.<br>";
            return false;
        }

        if ($quantity > $this->availableSeats) {
            echo "Không đủ ghế để đặt cho phim "
                . $this->title
                . ".<br>";

            return false;
        }

        $this->availableSeats -= $quantity;

        echo "Đặt thành công "
            . $quantity
            . " vé phim "
            . $this->title
            . ".<br>";

        return true;
    }

    public function cancelTicket($quantity)
    {
        if ($quantity <= 0) {
            echo "Số vé hủy phải lớn hơn 0.<br>";
            return false;
        }

        $soldSeats = $this->getSoldSeats();

        if ($quantity > $soldSeats) {
            echo "Không thể hủy "
                . $quantity
                . " vé phim "
                . $this->title
                . " vì chỉ có "
                . $soldSeats
                . " vé đã bán.<br>";

            return false;
        }

        $this->availableSeats += $quantity;

        echo "Hủy thành công "
            . $quantity
            . " vé phim "
            . $this->title
            . ".<br>";

        return true;
    }

    public function getSoldSeats()
    {
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue()
    {
        return $this->getSoldSeats() * $this->price;
    }

    public function displayInfo()
    {
        echo "<h3>" . $this->title . "</h3>";

        echo "Mã phim: " . $this->id . "<br>";

        echo "Tên phim: "
            . $this->title
            . "<br>";

        echo "Giá vé: "
            . number_format($this->price, 0, ',', '.')
            . " VNĐ<br>";

        echo "Tổng số ghế: "
            . $this->totalSeats
            . "<br>";

        echo "Số ghế còn lại: "
            . $this->availableSeats
            . "<br>";

        echo "Số vé đã bán: "
            . $this->getSoldSeats()
            . "<br>";

        echo "Doanh thu: "
            . number_format($this->getRevenue(), 0, ',', '.')
            . " VNĐ<br>";
    }
}


// =======================================
// FUNCTION XỬ LÝ DANH SÁCH PHIM
// =======================================

function findMovieById($movies, $id)
{
    if (empty($movies)) {
        return null;
    }

    foreach ($movies as $movie) {
        if ($movie->getId() == $id) {
            return $movie;
        }
    }

    return null;
}


function getTotalRevenue($movies)
{
    if (empty($movies)) {
        return 0;
    }

    $totalRevenue = 0;

    foreach ($movies as $movie) {
        $totalRevenue += $movie->getRevenue();
    }

    return $totalRevenue;
}


function getBestSellingMovie($movies)
{
    if (empty($movies)) {
        return null;
    }

    $bestMovie = $movies[0];

    foreach ($movies as $movie) {

        if (
            $movie->getSoldSeats()
            > $bestMovie->getSoldSeats()
        ) {
            $bestMovie = $movie;
        }
    }

    return $bestMovie;
}


// =======================================
// CHƯƠNG TRÌNH CHÍNH
// =======================================

try {

    // 1. Tạo danh sách Movie
    $movies = [
        new Movie(1, "Avengers", 100000, 100),
        new Movie(2, "Avatar", 120000, 80),
        new Movie(3, "Batman", 90000, 120)
    ];


    // ===================================
    // 2. Đặt vé Avengers
    // ===================================

    echo "<h2>ĐẶT VÉ</h2>";

    $avengers = findMovieById($movies, 1);

    if ($avengers !== null) {
        $avengers->bookTicket(30);
    }


    // ===================================
    // 3. Đặt vé Avatar
    // ===================================

    $avatar = findMovieById($movies, 2);

    if ($avatar !== null) {
        $avatar->bookTicket(40);
    }


    // ===================================
    // 4. Hủy vé Avengers
    // ===================================

    echo "<h2>HỦY VÉ</h2>";

    if ($avengers !== null) {
        $avengers->cancelTicket(5);
    }


    // ===================================
    // 5. Hiển thị tất cả phim
    // ===================================

    echo "<hr>";

    echo "<h2>DANH SÁCH PHIM</h2>";

    foreach ($movies as $movie) {

        $movie->displayInfo();

        echo "<hr>";
    }


    // ===================================
    // 6. Tổng doanh thu
    // ===================================

    echo "<h2>TỔNG DOANH THU</h2>";

    $totalRevenue = getTotalRevenue($movies);

    echo "Tổng doanh thu tất cả phim: "
        . number_format(
            $totalRevenue,
            0,
            ',',
            '.'
        )
        . " VNĐ<br>";


    // ===================================
    // 7. Phim bán nhiều vé nhất
    // ===================================

    echo "<h2>PHIM BÁN NHIỀU VÉ NHẤT</h2>";

    $bestMovie = getBestSellingMovie($movies);

    if ($bestMovie !== null) {

        echo "Tên phim: "
            . $bestMovie->getTitle()
            . "<br>";

        echo "Số vé đã bán: "
            . $bestMovie->getSoldSeats()
            . "<br>";
    }


    // ===================================
    // TEST CÁC TRƯỜNG HỢP KHÔNG HỢP LỆ
    // ===================================

    echo "<hr>";

    echo "<h2>KIỂM TRA TRƯỜNG HỢP LỖI</h2>";


    // Đặt vé <= 0
    $avengers->bookTicket(0);


    // Đặt vượt quá ghế còn lại
    $avengers->bookTicket(200);


    // Hủy vé <= 0
    $avengers->cancelTicket(0);


    // Hủy nhiều hơn vé đã bán
    $avengers->cancelTicket(100);


    // Tìm phim không tồn tại
    $movieNotFound = findMovieById(
        $movies,
        999
    );

    if ($movieNotFound === null) {
        echo "Không tìm thấy phim có ID 999.<br>";
    }


    // Danh sách rỗng
    $emptyMovies = [];

    echo "<br>";

    echo "Tổng doanh thu danh sách rỗng: "
        . getTotalRevenue($emptyMovies)
        . " VNĐ<br>";


    $bestMovieEmpty =
        getBestSellingMovie($emptyMovies);

    if ($bestMovieEmpty === null) {
        echo "Danh sách phim rỗng, không có phim bán chạy nhất.<br>";
    }

} catch (InvalidArgumentException $e) {

    echo "Lỗi: " . $e->getMessage();
}

?>