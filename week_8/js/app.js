/**
 * js/app.js — Giao diện quản lý sản phẩm (Vue 3 + Fetch API)
 *
 * Luồng hoạt động:
 *  - mounted(): gọi GET api/products.php để lấy danh sách.
 *  - saveProduct(): chế độ thêm -> POST, chế độ sửa -> PUT ?id=...
 *  - deleteProduct(): xác nhận -> DELETE ?id=...
 *  - Sau mỗi thao tác thành công: gọi lại fetchProducts() để cập nhật bảng.
 */
const { createApp } = Vue;

const API_URL = 'api/products.php';

createApp({
  data() {
    return {
      products: [],
      loading: false,
      submitting: false,

      // form.id = null  -> chế độ thêm
      // form.id = số    -> chế độ sửa
      form: {
        id: null,
        name: '',
        price: null,
        stock: null
      },

      formError: '',
      message: '',
      messageType: 'success',
      messageTimer: null
    };
  },

  computed: {
    isEditing() {
      return this.form.id !== null;
    },

    totalStock() {
      return this.products.reduce((sum, p) => sum + Number(p.stock), 0);
    },

    totalValue() {
      return this.products.reduce((sum, p) => sum + Number(p.price) * Number(p.stock), 0);
    }
  },

  mounted() {
    this.fetchProducts();
  },

  methods: {
    // -----------------------------------------------------------------
    // Gọi API
    // -----------------------------------------------------------------
    async request(url, options = {}) {
      const response = await fetch(url, options);

      let payload;
      try {
        payload = await response.json();
      } catch (error) {
        throw new Error(`Phản hồi không phải JSON (HTTP ${response.status}).`);
      }

      if (!response.ok || payload.success !== true) {
        throw new Error(payload.message || `Yêu cầu thất bại (HTTP ${response.status}).`);
      }

      return payload;
    },

    // -----------------------------------------------------------------
    // GET: tải danh sách sản phẩm
    // -----------------------------------------------------------------
    async fetchProducts() {
      this.loading = true;
      try {
        const payload = await this.request(API_URL);
        this.products = Array.isArray(payload.data) ? payload.data : [];
      } catch (error) {
        this.showMessage(error.message, 'error');
      } finally {
        this.loading = false;
      }
    },

    // -----------------------------------------------------------------
    // POST (thêm) hoặc PUT (sửa)
    // -----------------------------------------------------------------
    async saveProduct() {
      this.formError = '';

      const name = String(this.form.name ?? '').trim();
      const price = Number(this.form.price);
      const stock = Number(this.form.stock);

      // Kiểm tra nhanh phía client; server vẫn kiểm tra lại toàn bộ
      if (name === '') {
        this.formError = 'Vui lòng nhập tên sản phẩm.';
        return;
      }
      if (name.length > 100) {
        this.formError = 'Tên sản phẩm không được vượt quá 100 ký tự.';
        return;
      }
      if (!Number.isInteger(price) || price <= 0) {
        this.formError = 'Đơn giá phải là số nguyên lớn hơn 0.';
        return;
      }
      if (!Number.isInteger(stock) || stock < 0) {
        this.formError = 'Số lượng tồn phải là số nguyên không âm.';
        return;
      }

      const body = JSON.stringify({ name, price, stock });
      const isEdit = this.isEditing;
      const url = isEdit ? `${API_URL}?id=${encodeURIComponent(this.form.id)}` : API_URL;
      const method = isEdit ? 'PUT' : 'POST';

      this.submitting = true;
      try {
        const payload = await this.request(url, {
          method,
          headers: { 'Content-Type': 'application/json' },
          body
        });

        this.showMessage(
          payload.message || (isEdit ? 'Cập nhật sản phẩm thành công.' : 'Thêm sản phẩm thành công.'),
          'success'
        );
        this.resetForm();

        // Tải lại bảng mà không reload trang
        await this.fetchProducts();
      } catch (error) {
        this.showMessage(error.message, 'error');
      } finally {
        this.submitting = false;
      }
    },

    // -----------------------------------------------------------------
    // Chuyển sang chế độ sửa: đưa dữ liệu dòng được chọn lên form
    // -----------------------------------------------------------------
    editProduct(product) {
      this.formError = '';
      this.form = {
        id: product.id,
        name: product.name,
        price: Number(product.price),
        stock: Number(product.stock)
      };
      this.$nextTick(() => {
        const input = document.getElementById('inputName');
        if (input) {
          input.focus();
          input.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      });
    },

    // -----------------------------------------------------------------
    // DELETE: xác nhận trước khi gửi yêu cầu
    // -----------------------------------------------------------------
    async deleteProduct(product) {
      const agreed = window.confirm(`Bạn có chắc chắn muốn xóa sản phẩm "${product.name}" không?`);
      if (!agreed) {
        return;
      }

      try {
        const payload = await this.request(`${API_URL}?id=${encodeURIComponent(product.id)}`, {
          method: 'DELETE'
        });

        this.showMessage(payload.message || 'Xóa sản phẩm thành công.', 'success');

        // Nếu đang sửa đúng sản phẩm vừa xóa thì thoát chế độ sửa
        if (this.form.id === product.id) {
          this.resetForm();
        }

        await this.fetchProducts();
      } catch (error) {
        this.showMessage(error.message, 'error');
      }
    },

    // -----------------------------------------------------------------
    // Tiện ích
    // -----------------------------------------------------------------
    resetForm() {
      this.form = { id: null, name: '', price: null, stock: null };
      this.formError = '';
    },

    showMessage(text, type) {
      this.message = text;
      this.messageType = type === 'error' ? 'error' : 'success';

      if (this.messageTimer) {
        clearTimeout(this.messageTimer);
      }
      this.messageTimer = setTimeout(() => {
        this.message = '';
      }, 5000);
    },

    formatPrice(value) {
      const number = Number(value) || 0;
      return new Intl.NumberFormat('vi-VN').format(number) + ' đ';
    }
  }
}).mount('#app');
