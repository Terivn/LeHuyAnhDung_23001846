/**
 * Component <the-san-pham>
 * Props: ten, gia, anh, moTa, soLuongTon
 * Đầy đủ validation props, default, required, và state hienMoTa riêng biệt
 */
const TheSanPham = {
  name: 'TheSanPham',
  props: {
    // Prop bắt buộc (required: true)
    ten: {
      type: String,
      required: true
    },
    gia: {
      type: Number,
      required: true
    },
    // Prop có giá trị mặc định (default)
    anh: {
      type: String,
      default: 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=500&auto=format&fit=crop'
    },
    moTa: {
      type: String,
      default: 'Thông tin mô tả chi tiết của sản phẩm chưa được cập nhật.'
    },
    soLuongTon: {
      type: Number,
      default: 0
    }
  },

  data() {
    return {
      // Trạng thái bật/tắt phần mô tả của riêng từng thẻ component
      hienMoTa: false
    };
  },

  methods: {
    dinhDangTien(val) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(val);
    },
    xuLyMua() {
      if (this.soLuongTon > 0) {
        alert(`Cảm ơn bạn! Đã thêm sản phẩm "${this.ten}" vào giỏ hàng.`);
      }
    }
  },

  template: `
    <article class="product-card">
      <div class="product-card__image-wrap">
        <img :src="anh" :alt="ten" class="product-card__image" />
        <span
          class="product-card__badge badge"
          :class="soLuongTon > 0 ? 'badge--success' : 'badge--danger'"
        >
          {{ soLuongTon > 0 ? 'Còn hàng' : 'Hết hàng' }}
        </span>
      </div>
      
      <div class="product-card__body">
        <h3 class="product-card__title">{{ ten }}</h3>
        <div class="product-card__price">{{ dinhDangTien(gia) }}</div>
        <div class="product-card__stock">
          Tồn kho: <strong>{{ soLuongTon }}</strong> sản phẩm
        </div>

        <!-- Phần mô tả (Bật / Tắt độc lập) -->
        <div v-if="hienMoTa" class="product-card__desc">
          <p style="margin: 0;">{{ moTa }}</p>
        </div>

        <div class="product-card__actions">
          <button
            class="btn btn--outline btn--sm"
            type="button"
            @click="hienMoTa = !hienMoTa"
          >
            {{ hienMoTa ? 'Ẩn mô tả' : 'Xem mô tả' }}
          </button>
          
          <!-- Khóa nút Mua nếu hết hàng -->
          <button
            class="btn btn--primary btn--sm"
            type="button"
            :disabled="soLuongTon <= 0"
            @click="xuLyMua"
          >
            {{ soLuongTon > 0 ? 'Mua hàng' : 'Hết hàng' }}
          </button>
        </div>
      </div>
    </article>
  `
};
