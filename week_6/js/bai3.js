/**
 * Bài 3 — Quản lý công việc cá nhân
 * Kiến thức: v-for, :key, checkbox, methods, computed, modifier sự kiện.
 */
const { createApp } = Vue;

createApp({
  data() {
    return {
      newTask: "",
      filter: "all",
      loi: "",
      nextId: 5,
      boLocs: [
        { ma: "all", nhan: "Tất cả" },
        { ma: "active", nhan: "Chưa hoàn thành" },
        { ma: "completed", nhan: "Đã hoàn thành" },
      ],
      // Mỗi công việc gồm: id, tên công việc, trạng thái hoàn thành.
      danhSach: [
        { id: 1, ten: "Ôn tập VueJS: directives và computed", hoanThanh: true },
        { id: 2, ten: "Hoàn thiện 3 bài thực hành tuần 6", hoanThanh: false },
        { id: 3, ten: "Đọc 30 phút sách chuyên ngành", hoanThanh: false },
        { id: 4, ten: "Đi chợ mua đồ ăn cho cả tuần", hoanThanh: false },
      ],
    };
  },

  computed: {
    /** Danh sách sau khi áp bộ lọc hiện tại. */
    danhSachLoc() {
      if (this.filter === "active") {
        return this.danhSach.filter((viec) => !viec.hoanThanh);
      }
      if (this.filter === "completed") {
        return this.danhSach.filter((viec) => viec.hoanThanh);
      }
      return this.danhSach;
    },

    tongSoViec() {
      return this.danhSach.length;
    },

    soViecChuaXong() {
      return this.danhSach.filter((viec) => !viec.hoanThanh).length;
    },

    soViecDaXong() {
      return this.tongSoViec - this.soViecChuaXong;
    },

    thongBaoRong() {
      if (this.danhSach.length === 0) {
        return {
          icon: "📝",
          tieuDe: "Danh sách đang trống",
          moTa: "Nhập tên công việc ở trên rồi nhấn “Thêm” hoặc phím Enter.",
        };
      }
      if (this.filter === "active") {
        return {
          icon: "🎉",
          tieuDe: "Không còn việc chưa hoàn thành",
          moTa: "Bạn đã xử lý xong toàn bộ công việc trong danh sách.",
        };
      }
      if (this.filter === "completed") {
        return {
          icon: "🕒",
          tieuDe: "Chưa có việc nào hoàn thành",
          moTa: "Tích vào ô vuông của công việc để đánh dấu đã xong.",
        };
      }
      return {
        icon: "🔎",
        tieuDe: "Không có công việc phù hợp",
        moTa: "Thử chọn bộ lọc khác để xem danh sách.",
      };
    },
  },

  methods: {
    themViec() {
      const ten = this.newTask.trim();
      if (!ten) {
        this.loi = "Tên công việc không được để trống hoặc chỉ chứa khoảng trắng.";
        return;
      }

      this.danhSach.unshift({
        id: this.nextId++,
        ten,
        hoanThanh: false,
      });
      this.newTask = "";
      this.loi = "";

      // Đang lọc "Đã hoàn thành" thì chuyển về "Tất cả" để thấy việc vừa thêm.
      if (this.filter === "completed") {
        this.filter = "all";
      }
    },

    xoaViec(id) {
      this.danhSach = this.danhSach.filter((viec) => viec.id !== id);
    },

    xoaViecDaHoanThanh() {
      this.danhSach = this.danhSach.filter((viec) => !viec.hoanThanh);
    },

    demTheoBoLoc(boLoc) {
      if (boLoc === "active") return this.soViecChuaXong;
      if (boLoc === "completed") return this.soViecDaXong;
      return this.tongSoViec;
    },
  },
}).mount("#app");
