/**
 * Bài 1 — Danh sách sản phẩm có tìm kiếm và thống kê
 * Kiến thức: Directive, methods, computed, watch, mounted
 */
const { createApp } = Vue;

createApp({
  data() {
    return {
      trangThaiTrang: "Đang khởi tạo...",
      tuKhoaTimKiem: "",
      danhMucDuocChon: "Tất cả",
      kieuSapXep: "mac-dinh", // 'mac-dinh', 'gia-tang', 'gia-giam'
      thongBaoTuKhoa: "",
      
      // Danh mục sản phẩm
      danhSachDanhMuc: ["Tất cả", "Điện tử", "Gia dụng", "Thời trang"],
      
      // Mảng dữ liệu gốc
      dsSanPham: [
        { id: 1, ten: "Laptop Dell XPS 13", gia: 25000000, danhMuc: "Điện tử", soLuongTon: 5 },
        { id: 2, ten: "Điện thoại iPhone 15", gia: 22500000, danhMuc: "Điện tử", soLuongTon: 0 },
        { id: 3, ten: "Nồi chiên không dầu Lock&Lock", gia: 1800000, danhMuc: "Gia dụng", soLuongTon: 12 },
        { id: 4, ten: "Máy hút bụi Robot Dreame", gia: 6500000, danhMuc: "Gia dụng", soLuongTon: 3 },
        { id: 5, ten: "Áo sơ mi Nam Premium", gia: 450000, danhMuc: "Thời trang", soLuongTon: 20 },
        { id: 6, ten: "Giày Sneaker Sport Pro", gia: 1200000, danhMuc: "Thời trang", soLuongTon: 0 }
      ],
      
      // Form thêm sản phẩm mới
      spMoi: {
        ten: "",
        gia: null,
        danhMuc: "Điện tử",
        soLuongTon: 0
      },
      
      // Thông báo lỗi form
      loiForm: ""
    };
  },

  computed: {
    /**
     * Mảng sản phẩm sau khi Kết hợp: Tìm kiếm, Lọc theo danh mục và Sắp xếp
     * Không thay đổi mảng gốc dsSanPham
     */
    dsSanPhamDaLoc() {
      let ketQua = [...this.dsSanPham];

      // 1. Tìm kiếm theo tên (không phân biệt hoa/thường)
      const tuKhoa = this.tuKhoaTimKiem.trim().toLowerCase();
      if (tuKhoa) {
        ketQua = ketQua.filter(sp => sp.ten.toLowerCase().includes(tuKhoa));
      }

      // 2. Lọc theo danh mục
      if (this.danhMucDuocChon !== "Tất cả") {
        ketQua = ketQua.filter(sp => sp.danhMuc === this.danhMucDuocChon);
      }

      // 3. Sắp xếp theo giá (Tăng dần / Giảm dần) - Tạo bản sao mảng để không đổi gốc
      if (this.kieuSapXep === "gia-tang") {
        ketQua.sort((a, b) => a.gia - b.gia);
      } else if (this.kieuSapXep === "gia-giam") {
        ketQua.sort((a, b) => b.gia - a.gia);
      }

      return ketQua;
    },

    /**
     * Hiển thị số sản phẩm đang lọc / tổng số sản phẩm
     */
    thongKeSoLuong() {
      return `${this.dsSanPhamDaLoc.length}/${this.dsSanPham.length}`;
    },

    /**
     * Tổng giá trị tồn kho của các sản phẩm đang hiển thị (Giá * Số lượng tồn)
     */
    tongGiaTriTonKho() {
      return this.dsSanPhamDaLoc.reduce((sum, sp) => sum + sp.gia * sp.soLuongTon, 0);
    }
  },

  watch: {
    /**
     * Thông báo khi từ khóa có đúng một ký tự; xóa thông báo khi rỗng hoặc từ 2 ký tự
     */
    tuKhoaTimKiem(val) {
      const kw = val.trim();
      if (kw.length === 1) {
        this.thongBaoTuKhoa = "Từ khóa tìm kiếm quá ngắn, vui lòng nhập ít nhất 2 ký tự để kết quả chính xác hơn.";
      } else {
        this.thongBaoTuKhoa = "";
      }
    }
  },

  mounted() {
    // Đặt trạng thái trang thành "Sẵn sàng"
    this.trangThaiTrang = "Sẵn sàng";
  },

  methods: {
    /** Định dạng tiền tệ VND */
    dinhDangTien(gia) {
      return new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" }).format(gia);
    },

    /** Thêm sản phẩm mới có kiểm tra hợp lệ */
    themSanPham() {
      this.loiForm = "";

      const ten = this.spMoi.ten.trim();
      const gia = Number(this.spMoi.gia);
      const soLuongTon = Number(this.spMoi.soLuongTon);

      // Kiểm tra validation
      if (!ten) {
        this.loiForm = "Vui lòng nhập tên sản phẩm.";
        return;
      }

      if (isNaN(gia) || gia <= 0) {
        this.loiForm = "Giá sản phẩm phải lớn hơn 0.";
        return;
      }

      if (isNaN(soLuongTon) || soLuongTon < 0 || !Number.isInteger(soLuongTon)) {
        this.loiForm = "Số lượng tồn kho phải là số nguyên không âm (>= 0).";
        return;
      }

      // Thêm sản phẩm
      const idMoi = this.dsSanPham.length ? Math.max(...this.dsSanPham.map(p => p.id)) + 1 : 1;
      this.dsSanPham.push({
        id: idMoi,
        ten,
        gia,
        danhMuc: this.spMoi.danhMuc,
        soLuongTon
      });

      // Reset form
      this.spMoi.ten = "";
      this.spMoi.gia = null;
      this.spMoi.danhMuc = "Điện tử";
      this.spMoi.soLuongTon = 0;
    },

    /** Xóa sản phẩm sau khi người dùng xác nhận */
    xoaSanPham(id, ten) {
      const xacNhan = confirm(`Bạn có chắc chắn muốn xóa sản phẩm "${ten}" khỏi danh sách?`);
      if (xacNhan) {
        this.dsSanPham = this.dsSanPham.filter(sp => sp.id !== id);
      }
    }
  }
}).mount("#app");
