# 📚 [ONLINECOURSE]: HỆ THỐNG QUẢN LÝ KHÓA HỌC ONLINE



Dự án này là một nền tảng học tập trực tuyến  cơ bản, được xây dựng theo kiến trúc **PHP thuần** kết hợp với **MySQL** theo mô hình **OOP MVC**. Mã nguồn được tổ chức khoa học, tuân thủ các nguyên tắc bảo mật cơ bản (Prepared Statements, Password Hashing) và sẵn sàng cho việc mở rộng.

## 🛠️ CÔNG NGHỆ VÀ KIẾN TRÚC

* **Backend:** PHP 8.x (Sử dụng OOP và PDO).
* **Database:** MySQL  
* **Kiến trúc:** Mô hình MVC (Controller , Model,View ).
* **Frontend:** Bootstrap 5, HTML5, CSS3, JavaScript.

## 🎯 TÍNH NĂNG CHỦ YẾU

### 1. Dành cho Học viên (`role = 0`)
* Xem/Tìm kiếm/Lọc danh sách khóa học có sẵn.
* Đăng ký khóa học
* Xem chi tiết khóa học
* Xem khóa học đã đăng kí
* Xem nội dung bài học/video được nhúng (Embed) trực tiếp.
* Theo dõi tiến độ học tập 

### 2. Dành cho Giảng viên (`role = 1`)
* **Quản lý Khóa học (CRUD):** Tạo, chỉnh sửa, xóa khóa học.
* **Quản lý Bài học:** Thêm/sửa/xóa bài giảng, video URL.
* **Quản lý Tài liệu:** Đăng tải tài liệu học tập (DOCX, PDF, v.v.).
* Theo dõi danh sách học viên đã đăng ký khóa học của mình.

### 3. Dành cho Quản trị viên (`role = 2`)
* Quản lý tài khoản người dùng (Xem, kích hoạt/vô hiệu hóa).
* Quản lý danh mục khóa học (CRUD).
* Thống kê tài khoản
* Phê duyệt khóa học

## 🚀 HƯỚNG DẪN CÀI ĐẶT

1.  **Môi trường:** Cần XAMPP/WAMPP/MAMP (PHP & MySQL).
2.  **Clone Repository:**
    ```bash
    git clone 
    ```
3.  **Cấu hình CSDL:**
    * Tạo CSDL mới có tên `onlinecourse`.
    * Import file SQL gốc (`onlinecourse.sql`) để khôi phục cấu trúc bảng.
4.  **Cấu hình BASE URL:**
    * Mở file `config/config.php` và cập nhật hằng số `BASE_URL` (ví dụ: `/tên_thư_mục_gốc/`).

### 🔑 Tài khoản Test
| Vai trò | Username | Mật khẩu (Ví dụ) |
| :--- | :--- | :--- |
| **Admin** | admin@gmail.com | 123456  |
| **Giảng viên** | gv@gmail.com | 123456 |
| **Học viên** | hv@gmail.com | 123456 |

## 👥 THÀNH VIÊN NHÓM

* Đỗ Thanh Tùng
* Nguyễn Ming Cường

