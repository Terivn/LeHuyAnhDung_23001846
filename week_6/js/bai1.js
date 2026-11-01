/**
 * Bài 1 — Thẻ thông tin sinh viên
 * Kiến thức: createApp, data(), {{ }}, v-text, v-bind, v-if, v-show, :class, :style.
 */
const { createApp } = Vue;

createApp({
  data() {
    return {
      sinhVien: {
        maSV: "23001846",
        hoTen: "Lê Huy Anh Dũng",
        lop: "SE2026-T30",
        anhDaiDien: "assets/avatar.svg",
        diemTrungBinh: 8.4,
        dangHoc: true,
      },
      hienGioiThieu: true,
    };
  },

  computed: {
    /** Điểm được chuẩn hóa trong khoảng 0 – 10 để xếp loại luôn chính xác. */
    soDiem() {
      const diem = Number(this.sinhVien.diemTrungBinh);
      if (!Number.isFinite(diem)) return 0;
      return Math.min(10, Math.max(0, diem));
    },

    diemHienThi() {
      return this.soDiem.toFixed(1).replace(".", ",");
    },

    xepLoai() {
      const diem = this.soDiem;
      if (diem >= 8) return "Giỏi";
      if (diem >= 6.5) return "Khá";
      if (diem >= 5) return "Trung bình";
      return "Chưa đạt";
    },

    /** Đổi màu xếp loại bằng :class. */
    xepLoaiClass() {
      const classes = {
        "Giỏi": "rank--gioi",
        "Khá": "rank--kha",
        "Trung bình": "rank--trung-binh",
        "Chưa đạt": "rank--chua-dat",
      };
      return classes[this.xepLoai];
    },

    trangThai() {
      return this.sinhVien.dangHoc ? "Đang học" : "Đã nghỉ";
    },

    duDieuKienHocBong() {
      return this.soDiem >= 8;
    },
  },

  methods: {
    /** Làm tròn 1 chữ số thập phân và giới hạn điểm trong [0, 10]. */
    chuanHoaDiem() {
      let diem = Number(this.sinhVien.diemTrungBinh);
      if (!Number.isFinite(diem)) diem = 0;
      this.sinhVien.diemTrungBinh = Math.min(10, Math.max(0, Math.round(diem * 10) / 10));
    },
  },
}).mount("#app");
