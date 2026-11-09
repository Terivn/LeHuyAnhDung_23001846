/**
 * Component <dong-gio-hang>
 * Hiển thị một dòng mục sản phẩm trong giỏ hàng.
 * Đảm bảo luồng dữ liệu một chiều: Không sửa prop trực tiếp, phát $emit lên component cha.
 */
const DongGioHang = {
  name: 'DongGioHang',
  props: {
    item: {
      type: Object,
      required: true
    }
  },

  emits: ['doi-so-luong', 'yeu-cau-xoa'],

  computed: {
    thanhTien() {
      return this.item.donGia * this.item.soLuong;
    }
  },

  methods: {
    dinhDangTien(val) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(val);
    },

    tangSoLuong() {
      if (this.item.soLuong < 99) {
        this.$emit('doi-so-luong', { id: this.item.id, soLuongMoi: this.item.soLuong + 1 });
      }
    },

    giamSoLuong() {
      if (this.item.soLuong > 1) {
        this.$emit('doi-so-luong', { id: this.item.id, soLuongMoi: this.item.soLuong - 1 });
      }
    },

    thayDoiSoLuongInput(event) {
      let val = parseInt(event.target.value, 10);
      if (isNaN(val) || val < 1) val = 1;
      if (val > 99) val = 99;
      
      // Reset input hiển thị nếu có điều chỉnh
      event.target.value = val;
      this.$emit('doi-so-luong', { id: this.item.id, soLuongMoi: val });
    },

    xoaMuc() {
      this.$emit('yeu-cau-xoa', this.item.id);
    }
  },

  template: `
    <tr>
      <td><strong>{{ item.ten }}</strong></td>
      <td>{{ dinhDangTien(item.donGia) }}</td>
      <td>
        <div class="cart-qty-control">
          <button
            class="btn btn--outline btn--sm"
            type="button"
            :disabled="item.soLuong <= 1"
            @click="giamSoLuong"
          >
            -
          </button>
          
          <input
            class="input"
            type="number"
            min="1"
            max="99"
            :value="item.soLuong"
            @change="thayDoiSoLuongInput"
          />

          <button
            class="btn btn--outline btn--sm"
            type="button"
            :disabled="item.soLuong >= 99"
            @click="tangSoLuong"
          >
            +
          </button>
        </div>
      </td>
      <td><strong>{{ dinhDangTien(thanhTien) }}</strong></td>
      <td>
        <button
          class="btn btn--danger btn--sm"
          type="button"
          @click="xoaMuc"
        >
          Xóa
        </button>
      </td>
    </tr>
  `
};
