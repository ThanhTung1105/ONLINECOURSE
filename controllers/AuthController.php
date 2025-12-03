<?php
require_once 'models/User.php';

class AuthController {
    
    // Hiển thị form đăng nhập
    public function login() {
        include 'views/auth/login.php';
    }

    // Xử lý khi nhấn nút "Đăng nhập"
    public function loginPost() {
        // Lấy dữ liệu từ form
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Kết nối DB
        $database = new Database();
        $db = $database->connect();
        $userModel = new User($db);

        // Gọi hàm login bên Model
        $user = $userModel->login($email, $password);

        if ($user) {
            // Lưu session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['fullname'] = $user['fullname'];

            // === LOGIC PHÂN QUYỀN (Role-Based Redirect) ===
            if ($user['role'] == 2) {
                // Admin
                header("Location: index.php?controller=admin&action=dashboard");
            } elseif ($user['role'] == 1) {
                // Giảng viên
                header("Location: index.php?controller=instructor&action=dashboard");
            } else {
                // Học viên (role = 0)
                header("Location: index.php?controller=student&action=dashboard");
            }
        } else {
            // Đăng nhập sai -> Quay lại form và báo lỗi
            $error = "Email hoặc mật khẩu không đúng!";
            include 'views/auth/login.php';
        }
    }

    // Đăng xuất
    public function logout() {
        session_destroy(); // Xóa sạch session
        header("Location: index.php"); // Về trang chủ
    }

    // Hiển thị form đăng ký
    public function register() {
        include 'views/auth/register.php';
    }

    // Xử lý khi nhấn nút "Đăng ký"
    public function registerPost() {
        // Lấy dữ liệu từ form
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';

        // Khởi tạo mảng lỗi
        $errors = [];

        // Validation
        if (empty($username)) {
            $errors[] = "Tên đăng nhập không được để trống";
        } elseif (strlen($username) < 3) {
            $errors[] = "Tên đăng nhập phải có ít nhất 3 ký tự";
        }

        if (empty($email)) {
            $errors[] = "Email không được để trống";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email không hợp lệ";
        }

        if (empty($password)) {
            $errors[] = "Mật khẩu không được để trống";
        } elseif (strlen($password) < 6) {
            $errors[] = "Mật khẩu phải có ít nhất 6 ký tự";
        }

        if ($password !== $confirmPassword) {
            $errors[] = "Mật khẩu không trùng khớp";
        }

        if (empty($fullname)) {
            $errors[] = "Họ tên không được để trống";
        }

        // Nếu có lỗi, hiển thị form lại
        if (!empty($errors)) {
            include 'views/auth/register.php';
            return;
        }

        // Kết nối DB
        $database = new Database();
        $db = $database->connect();
        $userModel = new User($db);

        // Kiểm tra username đã tồn tại chưa
        if ($userModel->usernameExists($username)) {
            $errors[] = "Tên đăng nhập đã tồn tại";
            include 'views/auth/register.php';
            return;
        }

        // Kiểm tra email đã tồn tại chưa
        if ($userModel->emailExists($email)) {
            $errors[] = "Email đã tồn tại";
            include 'views/auth/register.php';
            return;
        }

        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Thêm user mới vào database
        if ($userModel->register($username, $email, $hashedPassword, $fullname)) {
            $success = "Đăng ký thành công! Vui lòng đăng nhập.";
            include 'views/auth/login.php';
        } else {
            $error = "Đăng ký thất bại. Vui lòng thử lại.";
            include 'views/auth/register.php';
        }
    }
}?>