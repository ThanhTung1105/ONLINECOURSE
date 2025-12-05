# 🎓 Online Course - Platform Học Tập Trực Tuyến

Một nền tảng học tập trực tuyến hiện đại, được xây dựng bằng **PHP MVC**, cho phép học viên tìm hiểu kiến thức, giáo viên tạo và quản lý khóa học, và quản trị viên điều phối toàn bộ hệ thống.

## ✨ Tính Năng Chính

### 👨‍🎓 Dành cho Học Viên

- ✅ Đăng ký tài khoản miễn phí
- ✅ Xem danh sách khóa học có sẵn
- ✅ Đăng ký học các khóa học
- ✅ Theo dõi tiến độ học tập
- ✅ Xem bài giảng và tài liệu

### 👨‍🏫 Dành cho Giáo Viên

- ✅ Dashboard quản lý khóa học
- ✅ Tạo và chỉnh sửa khóa học
- ✅ Xem danh sách học viên đã đăng ký
- ✅ Quản lý bài giảng và tài liệu
- ✅ Theo dõi thống kê khóa học

### 🛡️ Dành cho Quản Trị Viên

- ✅ Quản lý tài khoản người dùng
- ✅ Phê duyệt khóa học từ giáo viên
- ✅ Quản lý danh mục khóa học
- ✅ Xem thống kê hệ thống
- ✅ Điều chỉnh quyền người dùng

## 🔒 Hệ Thống Phân Quyền

| Quyền             | Mô Tả                    | Quyền Truy Cập                    |
| ----------------- | ------------------------ | --------------------------------- |
| **Học Viên (0)**  | Người dùng bình thường   | Dashboard học viên, xem khóa học  |
| **Giáo Viên (1)** | Tạo và quản lý khóa học  | Dashboard giáo viên, tạo khóa học |
| **Admin (2)**     | Quản lý toàn bộ hệ thống | Dashboard admin, quản lý tất cả   |

## 🚀 Các Chức Năng Chi Tiết

### Xác Thực & Đăng Ký

- ✅ Đăng ký tài khoản mới (tự động là học viên)
- ✅ Đăng nhập bằng email
- ✅ Xác thực mật khẩu an toàn (BCrypt)
- ✅ Phân quyền tự động dựa trên role
- ✅ Đăng xuất và hủy session

### Dashboard Admin

- ✅ Hiển thị thống kê tổng quan (người dùng, khóa học, doanh thu)
- ✅ Quản lý tài khoản (thêm, sửa, xóa)
- ✅ Phê duyệt khóa học từ giáo viên
- ✅ Quản lý danh mục khóa học
- ✅ Tab điều hướng intuitively

### Quản Lý Tài Khoản

- ✅ Xem danh sách tất cả tài khoản
- ✅ Thêm tài khoản mới (với validation đầy đủ)
- ✅ Chỉnh sửa thông tin và quyền
- ✅ Đặt lại mật khẩu
- ✅ Xóa tài khoản (không cho xóa chính mình)

## 💻 Công Nghệ Sử Dụng

### Backend

- **PHP 7.4+** - Ngôn ngữ lập trình chính
- **PDO (PHP Data Objects)** - Kết nối database an toàn
- **BCrypt** - Mã hóa mật khẩu

### Frontend

- **HTML5** - Cấu trúc
- **CSS3** - Styling
- **Bootstrap 5.3** - Responsive design
- **Font Awesome 6.0** - Icons
- **JavaScript** - Tương tác

### Database

- **MySQL** - Cơ sở dữ liệu quan hệ
- **Tables**: users, courses, categories, lessons, materials, enrollments

## 🔧 Cài Đặt & Chạy

### Yêu Cầu

- PHP 7.4 hoặc cao hơn
- MySQL 5.7 hoặc cao hơn
- XAMPP/WAMP/LAMP (hoặc tương đương)

### Bước Cài Đặt

1. **Clone repository**

```bash
git clone https://github.com/ThanhTung1105/ONLINECOURSE.git
cd onlinecourse
```

2. **Tạo database**

```sql
CREATE DATABASE onlinecourse;
```

3. **Import bảng**

```bash
mysql -u root -p onlinecourse < database.sql
```

4. **Cấu hình kết nối**

```php
// config/Database.php
$host = 'localhost';
$db_name = 'onlinecourse';
$db_user = 'root';
$db_password = '';
```

5. **Chạy ứng dụng**

```
http://localhost/onlinecourse
```

## 🧪 Tài Khoản Test

| Email               | Password | Role      |
| ------------------- | -------- | --------- |
| student@example.com | 123456   | Học Viên  |
| teacher@example.com | 123456   | Giáo Viên |
| admin@example.com   | 123456   | Admin     |

## 📁 Luồng Xử Lý

### Đăng Nhập

```
form → AuthController::loginPost() → User::login()
→ validate password → set session → redirect dashboard
```

### Thêm Tài Khoản (Admin)

```
form → AdminController::addUserPost() → User::createUser()
→ hash password → insert DB → redirect users tab
```

### Phê Duyệt Khóa Học

```
Admin xem danh sách chờ duyệt → click phê duyệt
→ update status khóa học → tạo thông báo cho giáo viên
```

## 🐛 Xử Lý Lỗi

- ✅ Validation đầu vào toàn bộ form
- ✅ Kiểm tra quyền truy cập (role-based)
- ✅ XSS protection (htmlspecialchars)
- ✅ SQL injection prevention (PDO prepared statements)
- ✅ Try-catch error handling

## 📧 Liên Hệ

**Tác Giả**: Thanh Tùng  
**Email**: thanhtung1105@gmail.com  
**GitHub**: [@ThanhTung1105](https://github.com/ThanhTung1105)  
**Repository**: [ONLINECOURSE](https://github.com/ThanhTung1105/ONLINECOURSE)

---

## 🙏 Cảm Ơn

Cảm ơn bạn đã quan tâm đến dự án này! Nếu có bất kỳ câu hỏi hoặc đề nghị, vui lòng liên hệ hoặc tạo issue.

**⭐ Nếu bạn thích dự án này, hãy cho nó một ngôi sao!** ⭐

---

**Cập nhật lần cuối**: 03/12/2025  
**Phiên bản**: 1.0.0
