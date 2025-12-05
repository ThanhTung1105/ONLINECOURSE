<?php
require_once 'models/User.php';
require_once 'models/Category.php';
require_once 'models/Course.php';
require_once 'models/Enrollment.php';
class AdminController {
    public function dashboard() {
        // Kiểm tra xem user có là admin không (role = 2)
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        
        // Lấy tab hiện tại
        $currentTab = isset($_GET['tab']) ? $_GET['tab'] : 'overview';
        $database = new Database();
        $db = $database->connect();
        if ($currentTab == 'overview') {
            // Khởi tạo Models
            $userModel = new User($db);
            $courseModel = new Course($db);
            $enrollmentModel = new Enrollment($db); // Dùng cho thống kê doanh thu

            // Tính toán và lưu vào mảng $stats
            $stats['totalUsers'] = $userModel->countTotalUsers();
            $stats['totalCourses'] = $courseModel->countCoursesByStatus('approved');
            $stats['pendingCourses'] = $courseModel->countCoursesByStatus('pending');
            $stats['totalRevenue'] = $enrollmentModel->calculateTotalRevenue();
            $stats['totalEnrollments'] = $enrollmentModel->countTotalEnrollments();
        }
        // Nếu là tab users, lấy dữ liệu user
        if ($currentTab == 'users') {
            $database = new Database();
            $db = $database->connect();
            $userModel = new User($db);
            $allUsers = $userModel->getAll();
        }
        elseif ($currentTab == 'categories') { // <--- Logic mới cho Category
            $categoryModel = new Category($db);
            $allCategories = $categoryModel->getAll();
        }
        elseif ($currentTab == 'courses') {
            $courseModel = new Course($db); // Đảm bảo đã require 'models/Course.php' ở đầu file
            $pendingCourses = $courseModel->getPendingCourses();
        }
        include 'views/admin/dashboard.php';
    }

    // Hiển thị form thêm user mới
    public function addUser() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        include 'views/admin/add_user.php';
    }

    // Xử lý thêm user mới
    public function addUserPost() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
        $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
        $role = isset($_POST['role']) ? (int)$_POST['role'] : 0;

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

        if (!in_array($role, [0, 1, 2])) {
            $errors[] = "Quyền không hợp lệ";
        }

        if (!empty($errors)) {
            include 'views/admin/add_user.php';
            return;
        }

        // Kết nối DB
        $database = new Database();
        $db = $database->connect();
        $userModel = new User($db);

        // Kiểm tra username đã tồn tại
        if ($userModel->usernameExists($username)) {
            $errors[] = "Tên đăng nhập đã tồn tại";
            include 'views/admin/add_user.php';
            return;
        }

        // Kiểm tra email đã tồn tại
        if ($userModel->emailExists($email)) {
            $errors[] = "Email đã tồn tại";
            include 'views/admin/add_user.php';
            return;
        }

        // Tạo user mới
        if ($userModel->createUser($username, $email, $password, $fullname, $role)) {
            $success = "Tạo tài khoản thành công!";
            header("Location: index.php?controller=admin&action=dashboard&tab=users");
            exit;
        } else {
            $error = "Tạo tài khoản thất bại. Vui lòng thử lại.";
            include 'views/admin/add_user.php';
        }
    }

    // Hiển thị form chỉnh sửa user
    public function editUser() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            header('Location: index.php?controller=admin&action=users');
            exit;
        }

        $database = new Database();
        $db = $database->connect();
        $userModel = new User($db);
        $user = $userModel->getById($id);

        if (!$user) {
            header('Location: index.php?controller=admin&action=users');
            exit;
        }

        include 'views/admin/edit_user.php';
    }

    // Xử lý cập nhật user
    public function editUserPost() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
        $role = isset($_POST['role']) ? (int)$_POST['role'] : 0;
        $newPassword = isset($_POST['password']) ? $_POST['password'] : '';

        $errors = [];

        if ($id <= 0) {
            $errors[] = "ID không hợp lệ";
        }

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

        if (empty($fullname)) {
            $errors[] = "Họ tên không được để trống";
        }

        if (!in_array($role, [0, 1, 2])) {
            $errors[] = "Quyền không hợp lệ";
        }

        if (!empty($errors)) {
            $user = ['id' => $id, 'username' => $username, 'email' => $email, 'fullname' => $fullname, 'role' => $role, 'created_at' => date('Y-m-d H:i:s')];
            include 'views/admin/edit_user.php';
            return;
        }

        $database = new Database();
        $db = $database->connect();
        $userModel = new User($db);

        // Cập nhật user
        if ($userModel->updateUser($id, $username, $email, $fullname, $role)) {
            // Nếu có mật khẩu mới, cập nhật
            if (!empty($newPassword)) {
                if (strlen($newPassword) < 6) {
                    $errors[] = "Mật khẩu phải có ít nhất 6 ký tự";
                    $user = (object)['id' => $id, 'username' => $username, 'email' => $email, 'fullname' => $fullname, 'role' => $role];
                    include 'views/admin/edit_user.php';
                    return;
                }
                $userModel->resetPassword($id, $newPassword);
            }

            header("Location: index.php?controller=admin&action=dashboard&tab=users");
            exit;
        } else {
            $error = "Cập nhật tài khoản thất bại. Vui lòng thử lại.";
            $user = ['id' => $id, 'username' => $username, 'email' => $email, 'fullname' => $fullname, 'role' => $role, 'created_at' => date('Y-m-d H:i:s')];
            include 'views/admin/edit_user.php';
        }
    }

    // Xóa user
    public function deleteUser() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($id <= 0) {
            header('Location: index.php?controller=admin&action=users');
            exit;
        }

        // Không cho xóa chính mình
        if ($id == $_SESSION['user_id']) {
            header('Location: index.php?controller=admin&action=users?error=Không thể xóa chính mình');
            exit;
        }

        $database = new Database();
        $db = $database->connect();
        $userModel = new User($db);

        if ($userModel->deleteUser($id)) {
            header("Location: index.php?controller=admin&action=dashboard&tab=users");
            exit;
        } else {
            header('Location: index.php?controller=admin&action=dashboard&tab=users&error=Xóa thất bại');
            exit;
        }
    }

    public function categories() {
        // Redirect to dashboard with categories tab
        header('Location: index.php?controller=admin&action=dashboard&tab=categories');
        exit;
    }

    public function courses() {
        // Redirect to dashboard with courses tab
        header('Location: index.php?controller=admin&action=dashboard&tab=courses');
        exit;
    }
    public function addCategory() {
        // Kiểm tra quyền Admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        // Gọi view hiển thị form
        include 'views/admin/add_category.php';
    }
    public function addCategoryPost() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) exit;

        $name = $_POST['name'];
        $description = $_POST['description'];

        if (empty($name)) {
            $error = "Tên danh mục không được để trống";
            include 'views/admin/add_category.php';
            return;
        }

        $db = (new Database())->connect();
        $categoryModel = new Category($db);

        if ($categoryModel->create($name, $description)) {
            header("Location: index.php?controller=admin&action=dashboard&tab=categories");
        } else {
            $error = "Lỗi khi tạo danh mục";
            include 'views/admin/add_category.php';
        }
    }

    // 3. Hiển thị form sửa danh mục
    public function editCategory() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) exit;
        
        $id = $_GET['id'];
        $db = (new Database())->connect();
        $categoryModel = new Category($db);
        $category = $categoryModel->getById($id);

        include 'views/admin/edit_category.php';
    }

    // 4. Xử lý sửa danh mục
    public function editCategoryPost() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) exit;

        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];

        $db = (new Database())->connect();
        $categoryModel = new Category($db);

        if ($categoryModel->update($id, $name, $description)) {
            header("Location: index.php?controller=admin&action=dashboard&tab=categories");
        } else {
            echo "Lỗi update";
        }
    }

    // 5. Xóa danh mục
    public function deleteCategory() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) exit;

        $id = $_GET['id'];
        $db = (new Database())->connect();
        $categoryModel = new Category($db);
        
        $categoryModel->delete($id);
        header("Location: index.php?controller=admin&action=dashboard&tab=categories");
    }
    // --- PHÊ DUYỆT KHÓA HỌC ---

    // Duyệt khóa học
    public function approveCourse() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) exit;

        $id = $_GET['id'];
        $database = new Database();
        $db = $database->connect();
        $courseModel = new Course($db);

        $courseModel->updateStatus($id, 'approved');
        header("Location: index.php?controller=admin&action=dashboard&tab=courses");
    }

    // Từ chối khóa học
    public function rejectCourse() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) exit;

        $id = $_GET['id'];
        $database = new Database();
        $db = $database->connect();
        $courseModel = new Course($db);

        $courseModel->updateStatus($id, 'rejected'); // Hoặc xóa luôn nếu muốn
        header("Location: index.php?controller=admin&action=dashboard&tab=courses");
    }

    // --- Helper function để giữ code cũ của bạn gọn gàng ---
    
}
?>
