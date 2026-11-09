# Bài tập thực hành Vue 3 — Tuần 7

Sinh viên thực hiện: **Lê Huy Anh Dũng**  
MSSV: **23001846**  

---

## 📁 Cấu trúc thư mục

```
week_7/
├── index.html               # Trang chủ điều hướng các bài tập
├── bai1.html                # Bài 1: Quản lý sản phẩm, tìm kiếm & thống kê
├── bai2.html                # Bài 2: Danh mục sản phẩm bằng Component
├── bai3.html                # Bài 3: Giỏ hàng tương tác với Props & $emit
├── README.md                # Tài liệu hướng dẫn chi tiết
├── vendor/
│   └── vue.global.prod.js   # Vue 3 Standalone Runtime Library
├── assets/
│   └── style.css            # Style CSS dùng chung cho giao diện
├── js/
│   ├── bai1.js              # Logic Vue app Bài 1
│   ├── bai2.js              # Logic Vue app Bài 2
│   └── bai3.js              # Logic Vue app Bài 3
└── components/
    ├── TheSanPham.js        # Component <the-san-pham> (Bài 2)
    └── DongGioHang.js       # Component <dong-gio-hang> (Bài 3)
```

---

## 🎯 Chi tiết các bài tập

### **Bài 1: Danh sách sản phẩm có tìm kiếm và thống kê**
* **Kiến thức:** Directives (`v-model`, `v-for`, `v-if`, `v-cloak`), methods, `computed`, `watch`, lifecycle hook `mounted()`.
* **Yêu cầu đã đáp ứng:**
  1. Hiển thị bảng sản phẩm với nhãn badge "Còn hàng" (màu xanh) hoặc "Hết hàng" (màu đỏ).
  2. Tìm kiếm sản phẩm theo tên (không phân biệt chữ hoa / chữ thường).
  3. Lọc sản phẩm theo từng Danh mục ("Tất cả", "Điện tử", "Gia dụng", "Thời trang").
  4. Sắp xếp giá tăng dần / giảm dần mà **không làm thay đổi mảng dữ liệu gốc**.
  5. Kết hợp linh hoạt Tìm kiếm, Lọc danh mục và Sắp xếp cùng lúc.
  6. Form thêm sản phẩm mới có kiểm tra hợp lệ: Tên không rỗng, giá > 0, tồn kho số nguyên >= 0.
  7. Nút xóa sản phẩm kèm hộp thoại xác nhận `confirm`.
  8. Dùng `computed` hiển thị tỉ lệ hiển thị (ví dụ `3/6 sản phẩm`) và tổng giá trị tồn kho (`đơn giá × tồn kho`).
  9. Dùng `watch` theo dõi từ khóa: Hiển thị cảnh báo nếu từ khóa có đúng 1 ký tự, tự động xóa cảnh báo khi rỗng hoặc từ 2 ký tự.
  10. Dùng `mounted()` để khởi tạo trạng thái trang thành `"Sẵn sàng"`.

### **Bài 2: Danh mục sản phẩm bằng component**
* **Kiến thức:** Component registration, Props validation (`type`, `required`, `default`), scoped component data state, external `.js` component files.
* **Yêu cầu đã đáp ứng:**
  1. Component cha quản lý 4 sản phẩm mẫu với đầy đủ trạng thái.
  2. Component con `<the-san-pham>` nhận các prop: `ten`, `gia`, `anh`, `moTa`, `soLuongTon`.
  3. Khai báo kiếu dữ liệu props: `ten` & `gia` bắt buộc (`required: true`), `anh` & `moTa` có giá trị mặc định (`default`).
  4. Truyền dữ liệu cha &rarr; con bằng binding `:prop="val"`.
  5. Mỗi thẻ có nút "Xem mô tả" / "Ẩn mô tả" điều khiển trạng thái `hienMoTa` riêng trong `data()` của component.
  6. Khi mở mô tả sản phẩm này, các thẻ sản phẩm khác hoàn toàn độc lập, không bị ảnh hưởng.
  7. Sản phẩm hết hàng có nhãn "Hết hàng" riêng và tự động vô hiệu hóa (disable) nút "Mua hàng".
  8. Tách component ra file `components/TheSanPham.js`, nạp và đăng ký với Vue trước khi `app.mount()`.

### **Bài 3: Giỏ hàng với props và $emit**
* **Kiến thức:** One-way data flow (luồng dữ liệu 1 chiều), Custom events (`$emit`), event payload passing.
* **Yêu cầu đã đáp ứng:**
  1. Mục giỏ hàng gồm: `id`, `ten`, `donGia`, `soLuong`.
  2. Component `<dong-gio-hang>` nhận `props`, tự động tính thành tiền và hiển thị nút tăng (+), giảm (-), xóa.
  3. Component con phát sự kiện `$emit('doi-so-luong', { id, soLuongMoi })` và `$emit('yeu-cau-xoa', id)`.
  4. Component cha bắt sự kiện, kiểm tra hợp lệ và cập nhật mảng giỏ hàng.
  5. Giới hạn số lượng chỉ nhận số nguyên từ `1` đến `99`.
  6. Component con tuyệt đối không sửa đổi prop trực tiếp (tuân thủ one-way data binding).
  7. Component cha dùng `computed` tính `tongSoLuong` và `tongTien`.
  8. Khi xóa sạch mặt hàng, giao diện hiển thị trạng thái "Giỏ hàng trống" và hỗ trợ khôi phục dữ liệu mẫu.
  9. **Kiểm tra kết quả chuẩn đề bài:** Với 2 bút giá 5.000đ và 3 quyển vở giá 12.000đ &rarr; Giỏ hiển thị Tổng số lượng là **5** và Tổng tiền là **46.000 đ**.
