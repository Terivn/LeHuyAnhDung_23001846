/**
 * Bài 3 — Giỏ hàng với props và $emit
 * Component cha giữ dữ liệu giỏ hàng, nhận sự kiện từ component con <dong-gio-hang>
 */
const { createApp } = Vue;

const app = createApp({
  data() {
    return {
      // Dữ liệu giỏ hàng ban đầu (theo đề bài test case)
      gioHang: [
        { id: 1, ten: "Bút viết kim", donGia: 5000, soLuong: 2 },
        { id: 2, ten: "Quyển vở học sinh 200 trang", donGia: 12000, soLuong: 3 }
      ],

      // Form thêm sản phẩm nhanh
      sanPhamMoi: {
        ten: "",
        donGia: null,
        soLuong: 1
      },

      loiForm: ""
    };
  },

  computed: {
    /** Tổng số lượng sản phẩm trong giỏ */
    tongSoLuong() {
      return this.gioHang.reduce((total, item) => total + item.soLuong, 0);
    },

    /** Tổng tiền của cả giỏ hàng */
    tongTien() {
      return this.gioHang.reduce((total, item) => total + (item.donGia * item.soLuong), 0);
    }
  },

  methods: {
    dinhDangTien(val) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(val);
    },

    /** Xử lý sự kiện doi-so-luong từ component con */
    xuLyDoiSoLuong({ id, soLuongMoi }) {
      const sp = this.gioHang.find(item => item.id === id);
      if (sp) {
        // Kiểm tra hợp lệ từ 1 đến 99
        let count = parseInt(soLuongMoi, 10);
        if (isNaN(count) || count < 1) count = 1;
        if (count > 99) count = 99;
        sp.soLuong = count;
      }
    },

    /** Xử lý sự kiện yeu-cau-xoa từ component con */
    xuLyXoaSanPham(id) {
      const sp = this.gioHang.find(item => item.id === id);
      if (sp && confirm(`Bạn có muốn xóa "${sp.ten}" khỏi giỏ hàng?`)) {
        this.gioHang = this.gioHang.filter(item => item.id !== id);
      }
    },

    /** Thêm mục mới vào giỏ */
    themVaoGio() {
      this.loiForm = "";
      const ten = this.sanPhamMoi.ten.trim();
      const donGia = Number(this.sanPhamMoi.donGia);
      const soLuong = Number(this.sanPhamMoi.soLuong);

      if (!ten) {
        this.loiForm = "Tên sản phẩm không được để trống.";
        return;
      }
      if (isNaN(donGia) || donGia <= 0) {
        this.loiForm = "Đơn giá phải lớn hơn 0.";
        return;
      }
      if (isNaN(soLuong) || soLuong < 1 || soLuong > 99 || !Number.isInteger(soLuong)) {
        this.loiForm = "Số lượng phải là số nguyên từ 1 đến 99.";
        return;
      }

      const idMoi = this.gioHang.length ? Math.max(...this.gioHang.map(i => i.id)) + 1 : 1;
      this.gioHang.push({
        id: idMoi,
        ten,
        donGia,
        soLuong
      });

      // Reset form
      this.sanPhamMoi.ten = "";
      this.sanPhamMoi.donGia = null;
      this.sanPhamMoi.soLuong = 1;
    },

    /** Reset giỏ hàng về đúng Test Case đề bài */
    resetTestCaseStandard() {
      this.gioHang = [
        { id: 1, ten: "Bút viết kim", donGia: 5000, soLuong: 2 },
        { id: 2, ten: "Quyển vở học sinh 200 trang", donGia: 12000, soLuong: 3 }
      ];
    }
  }
});

// Đăng ký component <dong-gio-hang>
app.component('dong-gio-hang', DongGioHang);

app.mount('#app');
