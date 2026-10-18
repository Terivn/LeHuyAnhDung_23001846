# Week 5 - Quan ly Gio hang (PHP + MySQL) - CRUD + Dang nhap / Dang xuat

## Cau truc
```
week_5/
  database.sql
  app/
    common/dbConnect.php   (ket noi database)
    common/auth.php        (session + kiem soat truy cap)
    model/product.php      (CRUD san pham)
    model/user.php         (dang ky, dang nhap)
    view/header.php
    view/footer.php
    assets/style.css
    index.php
    register.php
    login.php
    logout.php
    product_list.php
    product_add.php
    product_edit.php
    product_delete.php
```

## Cach chay
1. Copy thu muc `app/` vao `htdocs` (XAMPP), vi du: `htdocs/shop/`.
2. Import `week_5/database.sql` vao phpMyAdmin (tao DB `shopping_cart`, bang `products`, bang `users`, 5 san pham mau + 2 tai khoan mau).
3. Neu MySQL khac user/pass root/rong, sua trong `app/common/dbConnect.php`.
4. Mo trinh duyet: `http://localhost/shop/login.php`.

## Tai khoan mau (mat khau luu bang password_hash)
| Username | Password |
|----------|----------|
| admin    | admin123 |
| user1    | user123  |

## Chuc nang
- CRUD san pham: danh sach, them (kiem tra ten/gia > 0/so luong >= 0), sua, xoa co xac nhan.
- Dang ky: kiem tra rong, trung ten dang nhap, ma hoa mat khau bang `password_hash()`.
- Dang nhap: xac thuc bang `password_verify()`, luu `$_SESSION`, chuyen den `product_list.php`.
- Dang xuat: xoa session, quay ve `login.php`.
- Kiem soat truy cap: `product_list.php`, `product_add.php`, `product_edit.php`, `product_delete.php`
  bat buoc dang nhap, neu chua dang nhap tu dong chuyen ve `login.php`.
- Hien thi ten tai khoan va lien ket Dang xuat tren cac trang quan ly san pham.
