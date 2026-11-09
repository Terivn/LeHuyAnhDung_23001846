/**
 * Bài 2 — Danh mục sản phẩm bằng component
 * Khởi tạo ứng dụng Vue, đăng ký component <the-san-pham>
 */
const { createApp } = Vue;

const app = createApp({
  data() {
    return {
      // Component cha quản lý danh sách ít nhất 4 sản phẩm
      danhSachSanPham: [
        {
          id: 1,
          ten: "Tai nghe không dây Sony WH-1000XM5",
          gia: 7990000,
          anh: "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop",
          moTa: "Chống ồn chủ động hàng đầu thế giới, pin 30h, hỗ trợ đàm thoại rõ nét và kết nối đa điểm.",
          soLuongTon: 15
        },
        {
          id: 2,
          ten: "Đồng hồ thông minh Apple Watch Series 9",
          gia: 10490000,
          anh: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&auto=format&fit=crop",
          moTa: "Màn hình Retina sáng gấp đôi, chip S9 SiP mạnh mẽ, thao tác chạm hai lần chạm thông minh.",
          soLuongTon: 0 // Thử nghiệm hết hàng (Khóa nút Mua)
        },
        {
          id: 3,
          ten: "Máy ảnh Mirrorless Fujifilm X-T5",
          gia: 43900000,
          // Không truyền anh -> Sử dụng giá trị prop mặc định (default)
          moTa: "Cảm biến X-Trans CMOS 5 HR 40.2 MP, chống rung 7 stop, phong cách hoài cổ cổ điển.",
          soLuongTon: 4
        },
        {
          id: 4,
          ten: "Loa Bluetooth Marshall Stanmore III",
          gia: 9490000,
          anh: "https://images.unsplash.com/photo-1545454675-3531b543be5d?w=500&auto=format&fit=crop",
          // Không truyền moTa -> Sử dụng giá trị prop mặc định (default)
          soLuongTon: 9
        }
      ]
    };
  }
});

// Nạp và đăng ký component <the-san-pham> trước khi mount ứng dụng
app.component("the-san-pham", TheSanPham);

app.mount("#app");
