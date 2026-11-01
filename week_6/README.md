# Week 6 — Bài tập thực hành VueJS

Ba bài thực hành VueJS được đóng gói thành một thư mục chạy độc lập, không cần cài đặt hay build.

## Cấu trúc

```
week_6/
├── index.html              Trang chủ, dẫn tới 3 bài
├── bai1.html               Bài 1 — Thẻ thông tin sinh viên
├── bai2.html               Bài 2 — Đặt vé xem phim
├── bai3.html               Bài 3 — Quản lý công việc cá nhân
├── assets/
│   ├── style.css           Giao diện dùng chung (responsive)
│   └── avatar.svg          Ảnh đại diện minh họa cho Bài 1
├── js/
│   ├── bai1.js             createApp + data + computed + methods
│   ├── bai2.js
│   └── bai3.js
├── vendor/
│   └── vue.global.prod.js  Vue 3 global production build (chạy offline)
└── README.md
```

## Cách chạy

**Cách 1 — mở trực tiếp:** nhấp đúp vào `week_6/index.html` hoặc kéo file vào trình duyệt.

**Cách 2 — dùng local server** (khuyến nghị khi cần kiểm tra trên điện thoại):

```bash
cd week_6
python -m http.server 8000
# Mở http://localhost:8000
```

> Vue 3 đã được đặt trong `vendor/` nên không cần Internet, không cần `npm install`.
> Không sử dụng build tool; template được viết trực tiếp trong HTML (in-DOM template).

## Bài 1 — Thẻ thông tin sinh viên

**Kiến thức:** `createApp`, `data()`, `{{ }}`, `v-text`, `v-bind`, `v-if`, `v-show`, `:class`, `:style`.

**Đã thực hiện:**

1. Dữ liệu sinh viên gồm: mã sinh viên, họ tên, lớp, ảnh đại diện, điểm trung bình, trạng thái đang học.
2. Họ tên hiển thị bằng `{{ sinhVien.hoTen }}`; lớp hiển thị bằng `v-text="sinhVien.lop"`.
3. Ảnh dùng `:src` và `:alt` (alt được ghép từ họ tên).
4. Xếp loại tự động theo điểm:
   - `>= 8` → Giỏi
   - `>= 6.5` → Khá
   - `>= 5` → Trung bình
   - `< 5` → Chưa đạt
5. Màu xếp loại đổi bằng `:class` (`rank--gioi`, `rank--kha`, `rank--trung-binh`, `rank--chua-dat`); thanh điểm dùng `:style` để tô đầy theo giá trị.
6. Nhãn trạng thái hiển thị “Đang học” / “Đã nghỉ”.
7. Nút “Ẩn/Hiện giới thiệu” bật tắt phần giới thiệu bằng `v-show`.
8. Có thêm `v-if` cho thông báo đủ điều kiện học bổng khi điểm từ 8,0 trở lên.
9. Bảng điều khiển bên phải cho phép sửa họ tên, lớp, điểm, trạng thái để thấy giao diện cập nhật ngay.

**Kịch bản kiểm tra:** kéo điểm từ 8,4 xuống 7,2 → xếp loại đổi từ “Giỏi” sang “Khá” và màu đổi theo; tắt trạng thái → nhãn đổi thành “Đã nghỉ”.

## Bài 2 — Đặt vé xem phim

**Kiến thức:** `v-model`, modifier (`.trim`, `.number`), sự kiện, `methods`, `computed`, `@submit.prevent`.

**Đã thực hiện:**

1. Họ tên dùng `v-model.trim`.
2. Chọn suất chiếu bằng `select` với 4 suất: 16:30, 18:45, 20:30, 22:15.
3. Chọn loại vé bằng radio: Vé thường 70.000 ₫, Vé VIP 100.000 ₫.
4. Số lượng dùng `v-model.number`, chỉ nhận số nguyên từ 1 đến 10; có nút tăng/giảm và tự chuẩn hóa khi rời ô nhập.
5. Checkbox combo bắp nước giá 45.000 ₫ cho mỗi đơn.
6. `computed` tính: **Tổng tiền = Giá vé × Số lượng + Tiền combo**.
7. Có nút “Đặt lại form”.
8. Nút “Đặt vé” chỉ bật khi họ tên không rỗng và số lượng hợp lệ.
9. Gửi bằng `@submit.prevent`, hiển thị xác nhận (mã vé, khách hàng, suất chiếu, loại vé, số lượng, combo, tổng tiền) ngay trên trang.

**Kịch bản kiểm tra bắt buộc:** nhập họ tên → chọn **Vé VIP** → số lượng **2** → tick **combo** → tổng tiền hiển thị **245.000 ₫** (100.000 × 2 + 45.000). Bấm “Đặt vé” thấy thông tin xác nhận với cùng tổng tiền.

## Bài 3 — Quản lý công việc cá nhân

**Kiến thức:** `v-for`, `:key`, checkbox, `methods`, `computed`, modifier sự kiện (`.prevent`, `.trim`, `.esc`).

**Đã thực hiện:**

1. Mỗi công việc có `id`, `ten`, `hoanThanh`.
2. Thêm việc bằng nút “Thêm” hoặc nhấn Enter (form `@submit.prevent`).
3. Chặn tên rỗng hoặc chỉ chứa khoảng trắng, hiển thị lỗi rõ ràng.
4. Danh sách dùng `v-for` và `:key="viec.id"`.
5. Checkbox đánh dấu hoàn thành; việc đã xong được gạch ngang và đổi màu.
6. Xóa từng công việc bằng nút `×`.
7. Lọc theo “Tất cả”, “Chưa hoàn thành”, “Đã hoàn thành”; mỗi bộ lọc có số lượng riêng.
8. `computed` tính tổng số việc và số việc chưa hoàn thành.
9. Nút “Xóa các việc đã hoàn thành” (tự khóa khi không còn việc đã xong).
10. Thông báo phù hợp khi danh sách trống hoặc kết quả lọc rỗng.

**Kịch bản kiểm tra:** nhấn Enter để thêm việc; tick checkbox → số “Chưa xong” giảm, “Đã xong” tăng; chuyển bộ lọc → danh sách thay đổi ngay; xóa việc đã hoàn thành → số liệu cập nhật.

## Ghi chú kỹ thuật

- Dùng **Vue 3 global build** (`vue.global.prod.js`) và `createApp({...}).mount("#app")` theo đúng nội dung bài học.
- Không có thao tác DOM thủ công cho dữ liệu: mọi thay đổi đi qua `v-model` / `methods`, giao diện do Vue cập nhật.
- Giao diện dùng CSS thuần, responsive ở 960px và 640px; có hỗ trợ `prefers-reduced-motion`.
- Toàn bộ nội dung tiếng Việt, không phụ thuộc tài nguyên mạng.
