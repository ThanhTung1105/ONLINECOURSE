<?php
require_once 'config/Database.php';
require_once 'models/Course.php';
require_once 'models/Category.php';
require_once 'models/Enrollment.php'; // <--- 1. Thêm dòng này
require_once 'models/User.php';
class StudentController {
    private $db;
    private $courseModel;
    private $categoryModel;
    private $enrollmentModel; // <--- 2. Khai báo thuộc tính mới
    private $userModel; // <--- 2. Khai báo thuộc tính mới
    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->courseModel = new Course($this->db);
        $this->categoryModel = new Category($this->db);
        $this->enrollmentModel = new Enrollment($this->db); // <--- 3. Khởi tạo
        $this->userModel = new User($this->db); // <--- 3. Khởi tạo
    }

    public function dashboard() {
        // Kiểm tra đăng nhập (để lấy ID học viên)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
             // Tốt nhất là chuyển hướng về login
             header("Location: index.php?controller=auth&action=login");
             exit;
        }
        
        // Nếu chưa đăng nhập thì gán ID = 0 hoặc chuyển hướng (ở đây tôi tạm để 0 để không lỗi)
        $student_id = $_SESSION['user_id'];
        $user_data = $this->userModel->getUserById($student_id);
        // --- LẤY DỮ LIỆU ---
        
        // 1. Lấy khóa học CỦA TÔI
        $my_courses = [];
        if ($student_id > 0) {
            $my_courses = $this->enrollmentModel->getMyCourses($student_id);
        }

        // 2. Lấy danh sách khám phá (Code cũ giữ nguyên)
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
        
        $categories = $this->categoryModel->getAll();
        $courses = $this->courseModel->getCourses($keyword, $category_id, $sort);

        // 3. Gửi sang View
        include 'views/student/dashboard.php';
    }
}
?>