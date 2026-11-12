<?php
/**
 * api/products.php
 * API CRUD sản phẩm cho bài thực hành tuần 8.
 *
 *   GET    api/products.php          -> danh sách sản phẩm
 *   GET    api/products.php?id=1     -> chi tiết một sản phẩm
 *   POST   api/products.php          -> thêm sản phẩm mới
 *   PUT    api/products.php?id=1     -> cập nhật sản phẩm theo id
 *   DELETE api/products.php?id=1     -> xóa sản phẩm theo id
 *
 * Mọi phản hồi đều là JSON:
 *   { "success": true,  "data": ..., "message": "..." }
 *   { "success": false, "message": "..." }
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Trình duyệt gửi preflight trước PUT/DELETE khi gọi khác origin
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../config/db.php';

/**
 * Trả JSON và kết thúc request.
 */
function respond(bool $success, $data = null, string $message = '', int $status = 200): void
{
    http_response_code($status);

    $payload = ['success' => $success];
    if ($success && $data !== null) {
        $payload['data'] = $data;
    }
    if ($message !== '') {
        $payload['message'] = $message;
    }

    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

/**
 * Đọc JSON từ body request (dùng cho POST và PUT).
 */
function readJsonBody(): array
{
    $raw = file_get_contents('php://input');
    if ($raw === false || trim($raw) === '') {
        return [];
    }

    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

/**
 * Chuyển giá trị đầu vào thành số nguyên hợp lệ.
 * Chỉ chấp nhận số nguyên thật (JSON int) hoặc chuỗi toàn chữ số.
 * Trả về null nếu không hợp lệ (loại bỏ true/false/số thực/mảng...).
 */
function toInt($value): ?int
{
    if (is_int($value)) {
        return $value;
    }
    if (is_string($value) && preg_match('/^-?\d+$/', trim($value)) === 1) {
        return (int) trim($value);
    }
    return null;
}

/**
 * Kiểm tra dữ liệu đầu vào: name (1–100 ký tự), price (> 0), stock (>= 0).
 * Nếu không hợp lệ thì trả lỗi 400 ngay lập tức.
 */
function validateProduct(array $input): array
{
    $errors = [];

    // name: chuỗi sau khi trim phải có từ 1 đến 100 ký tự
    $name = isset($input['name']) && is_string($input['name']) ? trim($input['name']) : '';
    if ($name === '') {
        $errors[] = 'Tên sản phẩm không được để trống.';
    } elseif (mb_strlen($name, 'UTF-8') > 100) {
        $errors[] = 'Tên sản phẩm không được vượt quá 100 ký tự.';
    }

    // price: số nguyên lớn hơn 0
    $price = toInt($input['price'] ?? null);
    if ($price === null || $price <= 0) {
        $errors[] = 'Đơn giá phải là số nguyên lớn hơn 0.';
    }

    // stock: số nguyên không âm
    $stock = toInt($input['stock'] ?? null);
    if ($stock === null || $stock < 0) {
        $errors[] = 'Số lượng tồn phải là số nguyên không âm.';
    }

    if (!empty($errors)) {
        respond(false, null, implode(' ', $errors), 400);
    }

    return [
        'name'  => $name,
        'price' => (int) $price,
        'stock' => (int) $stock,
    ];
}

/**
 * Lấy id từ query string, trả lỗi 400 nếu thiếu hoặc không hợp lệ.
 */
function requireId(): int
{
    $id = toInt($_GET['id'] ?? null);
    if ($id === null || $id <= 0) {
        respond(false, null, 'Thiếu hoặc sai tham số id trên URL.', 400);
    }
    return $id;
}

/**
 * Kiểm tra sản phẩm có tồn tại không, trả lỗi 404 nếu không.
 */
function ensureProductExists(PDO $pdo, int $id): void
{
    $stmt = $pdo->prepare('SELECT id FROM products WHERE id = ?');
    $stmt->execute([$id]);
    if ($stmt->fetch() === false) {
        respond(false, null, "Không tìm thấy sản phẩm có id = {$id}.", 404);
    }
}

$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        // ---------------------------------------------------------------
        // GET: danh sách sản phẩm (hoặc 1 sản phẩm nếu có ?id=)
        // ---------------------------------------------------------------
        case 'GET':
            if (isset($_GET['id'])) {
                $id = requireId();

                $stmt = $pdo->prepare('SELECT id, name, price, stock FROM products WHERE id = ?');
                $stmt->execute([$id]);
                $product = $stmt->fetch();

                if ($product === false) {
                    respond(false, null, "Không tìm thấy sản phẩm có id = {$id}.", 404);
                }

                respond(true, $product, 'Lấy sản phẩm thành công.');
            }

            $stmt = $pdo->query('SELECT id, name, price, stock FROM products ORDER BY id ASC');
            $products = $stmt->fetchAll();

            respond(true, $products, 'Lấy danh sách sản phẩm thành công.');
            break;

        // ---------------------------------------------------------------
        // POST: thêm sản phẩm mới
        // ---------------------------------------------------------------
        case 'POST':
            $data = validateProduct(readJsonBody());

            $stmt = $pdo->prepare('INSERT INTO products (name, price, stock) VALUES (?, ?, ?)');
            $stmt->execute([$data['name'], $data['price'], $data['stock']]);

            $newId = (int) $pdo->lastInsertId();
            $data['id'] = $newId;

            respond(true, $data, 'Thêm sản phẩm thành công.', 201);
            break;

        // ---------------------------------------------------------------
        // PUT: cập nhật sản phẩm theo id trên URL
        // ---------------------------------------------------------------
        case 'PUT':
            $id = requireId();
            ensureProductExists($pdo, $id);

            $data = validateProduct(readJsonBody());

            $stmt = $pdo->prepare('UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?');
            $stmt->execute([$data['name'], $data['price'], $data['stock'], $id]);

            $data['id'] = $id;
            respond(true, $data, 'Cập nhật sản phẩm thành công.');
            break;

        // ---------------------------------------------------------------
        // DELETE: xóa sản phẩm theo id trên URL
        // ---------------------------------------------------------------
        case 'DELETE':
            $id = requireId();
            ensureProductExists($pdo, $id);

            $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
            $stmt->execute([$id]);

            respond(true, null, 'Xóa sản phẩm thành công.');
            break;

        // ---------------------------------------------------------------
        // Phương thức khác: không hỗ trợ
        // ---------------------------------------------------------------
        default:
            respond(false, null, 'Phương thức không được hỗ trợ.', 405);
    }
} catch (PDOException $e) {
    respond(false, null, 'Lỗi cơ sở dữ liệu: ' . $e->getMessage(), 500);
}
