# Bài tập thực hành tuần 8 — PHP API + Vue.js

Sinh viên thực hiện: **Lê Huy Anh Dũng**  
MSSV: **23001846**

Ứng dụng quản lý sản phẩm đơn giản: backend PHP (PDO + MySQL) cung cấp REST API, frontend Vue 3 gọi API bằng `fetch()` và cập nhật bảng dữ liệu mà không tải lại trang.

---

## 📁 Cấu trúc thư mục

```
week_8/
├── index.html              # Giao diện quản lý sản phẩm (Vue 3)
├── database.sql            # Tạo database + bảng products + 3 dòng mẫu
├── README.md               # Tài liệu này
├── api/
│   └── products.php        # REST API: GET / POST / PUT / DELETE
├── config/
│   └── db.php              # Kết nối PDO MySQL
├── js/
│   └── app.js              # Logic Vue 3 + Fetch API
├── assets/
│   └── style.css           # Giao diện
└── vendor/
    └── vue.global.prod.js  # Vue 3 runtime
```

---

## ⚙️ Cài đặt & chạy

### 1. Tạo cơ sở dữ liệu

Mở **phpMyAdmin** (hoặc dùng dòng lệnh) và import file `database.sql`:

```bash
mysql -u root -p < database.sql
```

File này sẽ tạo database `week8_db`, bảng `products` và 3 dòng dữ liệu mẫu:

| id | name      | price | stock |
|----|-----------|-------|-------|
| 1  | Bút bi    | 5000  | 20    |
| 2  | Vở ô ly   | 12000 | 15    |
| 3  | Thước kẻ  | 8000  | 0     |

### 2. Kiểm tra thông tin kết nối

Mở `config/db.php` và chỉnh lại nếu cần:

```php
$host   = 'localhost';
$user   = 'root';
$pass   = '';          // XAMPP mặc định để trống
$dbname = 'week8_db';
```

> Nếu database chưa tồn tại, `db.php` sẽ tự tạo database, bảng và dữ liệu mẫu ở lần chạy đầu tiên.

### 3. Chạy ứng dụng

**Cách A — dùng PHP built-in server** (nhanh nhất):

```bash
cd week_8
php -S localhost:8000
```

Mở trình duyệt: <http://localhost:8000>

**Cách B — dùng XAMPP/Apache**: copy thư mục `week_8` vào `C:\xampp\htdocs\`, sau đó mở  
<http://localhost/week_8/>.

> ⚠️ Phải chạy qua web server (Apache hoặc `php -S`). Mở trực tiếp file `index.html` bằng `file://` sẽ không gọi được API PHP.

---

## 🔌 API — `api/products.php`

Mọi phản hồi đều ở dạng JSON và có trường `success`:

```json
{ "success": true,  "data": [ ... ], "message": "..." }
{ "success": false, "message": "..." }
```

| Phương thức | Đường dẫn | Chức năng |
|---|---|---|
| `GET` | `api/products.php` | Lấy danh sách sản phẩm |
| `GET` | `api/products.php?id=1` | Lấy chi tiết một sản phẩm |
| `POST` | `api/products.php` | Thêm sản phẩm mới |
| `PUT` | `api/products.php?id=1` | Cập nhật sản phẩm theo id trên URL |
| `DELETE` | `api/products.php?id=1` | Xóa sản phẩm theo id trên URL |

Body của `POST` / `PUT` là JSON gồm 3 trường:

```json
{ "name": "Bút chì 2B", "price": 3000, "stock": 50 }
```

### Kiểm tra dữ liệu (server-side)

| Trường | Quy tắc | Lỗi trả về |
|---|---|---|
| `name` | Sau khi `trim` phải có **1–100 ký tự** | `400` |
| `price` | Số nguyên **> 0** | `400` |
| `stock` | Số nguyên **≥ 0** | `400` |
| `id` | Sản phẩm phải tồn tại (khi `PUT`/`DELETE`) | `404` |

Tất cả truy vấn có tham số đều dùng **PDO prepared statement** để chống SQL Injection.

### Ví dụ gọi API bằng curl

```bash
# Lấy danh sách
curl http://localhost:8000/api/products.php

# Thêm sản phẩm
curl -X POST http://localhost:8000/api/products.php \
  -H "Content-Type: application/json" \
  -d '{"name":"Bút chì 2B","price":3000,"stock":50}'

# Cập nhật
curl -X PUT "http://localhost:8000/api/products.php?id=1" \
  -H "Content-Type: application/json" \
  -d '{"name":"Bút bi","price":5500,"stock":20}'

# Xóa
curl -X DELETE "http://localhost:8000/api/products.php?id=3"
```

---

## 🖥️ Giao diện Vue.js (`index.html` + `js/app.js`)

1. **Tải danh sách khi mở trang:** `mounted()` gọi `GET api/products.php`, dùng `v-for` hiển thị bảng gồm tên, đơn giá, số lượng tồn và hai nút **Sửa**, **Xóa**.
2. **Biểu mẫu thêm:** 3 ô *Tên sản phẩm*, *Đơn giá*, *Số lượng tồn* liên kết bằng `v-model`. Ở chế độ thêm, bấm **Thêm sản phẩm** sẽ gửi `POST`.
3. **Chế độ sửa:** bấm **Sửa** đưa dữ liệu dòng được chọn lên biểu mẫu; bấm **Lưu thay đổi** gửi `PUT api/products.php?id=<id>` đúng mã sản phẩm.
4. **Xóa:** bấm **Xóa** sẽ hiện hộp thoại `confirm()`; chỉ gửi `DELETE` khi người dùng đồng ý.
5. **Cập nhật không reload:** sau khi thêm/sửa/xóa thành công, ứng dụng gọi lại `fetchProducts()` để làm mới bảng. Nếu API trả lỗi, thông báo lỗi hiện ngay trên giao diện (đồng thời kiểm tra dữ liệu phía client trước khi gửi).

---

## ✅ Danh sách kiểm tra trước khi nộp (Câu 4)

| Thao tác | Kết quả mong đợi | Trạng thái |
|---|---|---|
| Thêm sản phẩm hợp lệ rồi tải lại trang | Sản phẩm mới vẫn xuất hiện | ✅ |
| Sửa đơn giá của một sản phẩm | Bảng hiển thị đơn giá mới | ✅ |
| Gửi trực tiếp yêu cầu thêm với `stock = -1` | PHP trả lỗi `400`, MySQL không có bản ghi mới | ✅ |
| Xóa một sản phẩm rồi tải lại trang | Sản phẩm đã xóa không còn trong danh sách | ✅ |

Kết quả kiểm thử thực tế (đã chạy với PHP 8.2 + MariaDB 10.4 + Edge headless):

- `GET` → `200`, trả đúng mảng sản phẩm trong `data`.
- `POST` hợp lệ → `201`, thêm bản ghi; `POST` với `stock = -1`, `price = 0`, tên rỗng hoặc tên > 100 ký tự → `400`, không ghi DB.
- `PUT ?id=1` → `200`, cập nhật đúng; `PUT ?id=9999` → `404`; thiếu `id` → `400`.
- `DELETE ?id=3` → `200`; xóa lại `id=3` → `404`; `id=abc` → `400`.
- Giao diện: thêm/sửa/xóa cập nhật bảng ngay, hộp thoại xác nhận hoạt động, không có lỗi console.

---

## 📝 Ghi chú

- Ứng dụng dùng **Vue 3 bản global build** (không cần Node/npm khi chạy).
- CORS đã được bật trong `api/products.php` để tiện gọi API từ công cụ ngoài.
- Mật khẩu MySQL mặc định của XAMPP là rỗng; nếu máy bạn đặt mật khẩu, sửa `$pass` trong `config/db.php`.
