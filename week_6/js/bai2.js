/**
 * Bài 2 — Đặt vé xem phim
 * Kiến thức: v-model + modifier, sự kiện, methods, computed.
 */
const { createApp } = Vue;

const GIA_COMBO = 45000;

createApp({
  data() {
    return {
      hoTen: "",
      suatChieu: "18:45",
      loaiVe: "thuong",
      soLuong: 1,
      coCombo: false,
      daGui: false,
      xacNhan: null,

      giaCombo: GIA_COMBO,
      suatChieus: [
        { ma: "16:30", nhan: "16:30 — 2D · Phòng 1" },
        { ma: "18:45", nhan: "18:45 — 3D · Phòng 2" },
        { ma: "20:30", nhan: "20:30 — IMAX · Phòng 3" },
        { ma: "22:15", nhan: "22:15 — 2D · Phòng 4" },
      ],
      loaiVes: [
        { ma: "thuong", nhan: "Vé thường", gia: 70000 },
        { ma: "vip", nhan: "Vé VIP", gia: 100000 },
      ],
    };
  },

  computed: {
    veDangChon() {
      return this.loaiVes.find((ve) => ve.ma === this.loaiVe) || this.loaiVes[0];
    },

    suatChieuDangChon() {
      return (
        this.suatChieus.find((suat) => suat.ma === this.suatChieu) || this.suatChieus[0]
      );
    },

    /** Thông báo lỗi số lượng; rỗng nghĩa là hợp lệ. */
    loiSoLuong() {
      if (this.soLuong === "" || this.soLuong === null || this.soLuong === undefined) {
        return "Vui lòng nhập số lượng vé.";
      }

      const soLuong = Number(this.soLuong);
      if (!Number.isFinite(soLuong) || !Number.isInteger(soLuong)) {
        return "Số lượng vé phải là số nguyên.";
      }
      if (soLuong < 1 || soLuong > 10) {
        return "Số lượng vé phải từ 1 đến 10.";
      }
      return "";
    },

    soLuongHopLe() {
      return this.loiSoLuong === "";
    },

    giaVe() {
      return this.veDangChon.gia;
    },

    tienVe() {
      return this.soLuongHopLe ? this.giaVe * Number(this.soLuong) : 0;
    },

    tienCombo() {
      return this.coCombo ? this.giaCombo : 0;
    },

    /** Tổng tiền = Giá vé × Số lượng + Tiền combo. */
    tongTien() {
      return this.tienVe + this.tienCombo;
    },

    coTheDatVe() {
      return this.hoTen.trim().length > 0 && this.soLuongHopLe;
    },
  },

  methods: {
    dinhDangTien(giaTri) {
      return Number(giaTri || 0).toLocaleString("vi-VN") + " ₫";
    },

    tangSoLuong() {
      const hienTai = Number.isInteger(this.soLuong) ? this.soLuong : 0;
      this.soLuong = Math.min(10, Math.max(1, hienTai + 1));
    },

    giamSoLuong() {
      const hienTai = Number.isInteger(this.soLuong) ? this.soLuong : 2;
      this.soLuong = Math.max(1, Math.min(10, hienTai - 1));
    },

    /** Rời ô nhập thì đưa số lượng về số nguyên trong khoảng 1 – 10. */
    chuanHoaSoLuong() {
      let soLuong = Number(this.soLuong);
      if (!Number.isFinite(soLuong)) soLuong = 1;
      this.soLuong = Math.min(10, Math.max(1, Math.round(soLuong)));
    },

    datVe() {
      this.daGui = true;
      if (!this.coTheDatVe) return;

      // Lưu lại ảnh chụp đơn vé để phần xác nhận không đổi khi form thay đổi.
      this.xacNhan = {
        maVe: "VE-" + Math.random().toString(36).slice(2, 7).toUpperCase(),
        hoTen: this.hoTen.trim(),
        suatChieu: this.suatChieuDangChon.nhan,
        loaiVe: this.veDangChon.nhan,
        soLuong: Number(this.soLuong),
        coCombo: this.coCombo,
        tongTien: this.tongTien,
      };

      this.$nextTick(() => {
        const phanXacNhan = document.getElementById("xac-nhan");
        if (phanXacNhan) {
          phanXacNhan.scrollIntoView({ behavior: "smooth", block: "nearest" });
        }
      });
    },

    datLai() {
      this.hoTen = "";
      this.suatChieu = "18:45";
      this.loaiVe = "thuong";
      this.soLuong = 1;
      this.coCombo = false;
      this.daGui = false;
      this.xacNhan = null;
    },
  },
}).mount("#app");
