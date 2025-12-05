<?php
require_once 'config/Database.php';
require_once 'models/Course.php';
require_once 'models/Category.php'; 
require_once 'models/Enrollment.php';// Cần file này để lấy danh mục cho vào thẻ <select>

class InstructorController {
    private $courseModel;
    private $categoryModel;
    private $db;
    private $enrollmentModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->courseModel = new Course($this->db);
        $this->enrollmentModel = new Enrollment($this->db);
        // $this->categoryModel = new Category($this->db); // Bạn cần tạo Model Category tương tự
    }

    // Hiển thị Dashboard
   public function dashboard() {
    // Kiểm tra đăng nhập (Giả sử bạn đã có middleware hoặc check session ở đây)
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) { // Thêm check role
        header("Location: index.php?controller=auth&action=login");
        exit();
    }

    $instructor_id = $_SESSION['user_id'];
    
    // --- 1. Nhận tham số Tìm kiếm/Lọc/Sắp xếp ---
    $keyword = isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '';
    $status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : 'all'; // 'all', 'approved', 'pending', 'rejected'
    $sort = isset($_GET['sort']) ? htmlspecialchars($_GET['sort']) : 'newest';

    // --- 2. Truyền tham số xuống Model ---
    $courses = $this->courseModel->getCoursesByInstructor($instructor_id, $keyword, $status, $sort);
    
    // Truyền lại các tham số đã lọc/tìm kiếm sang View
    include 'views/instructor/dashboard.php';
}
    // Trang tạo khóa học (GET) và Xử lý tạo (POST)
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Xử lý upload ảnh
            $image = "default.jpg";
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "assets/uploads/courses/";
                // Tạo thư mục nếu chưa có
                if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
                
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                $image = $_FILES["image"]["name"];
            }

            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'level' => $_POST['level'],
                'category_id' => $_POST['category_id'],
                'instructor_id' => $_SESSION['user_id'],
                'image' => $image,
                'duration_weeks' => $_POST['duration_weeks']
            ];

            if ($this->courseModel->create($data)) {
                header("Location: index.php?controller=instructor&action=dashboard");
            } else {
                echo "Có lỗi xảy ra!";
            }
        } else {
            // Lấy danh sách danh mục để hiển thị ra dropdown
            // $categories = $this->categoryModel->getAll(); 
            // Tạm thời hardcode nếu bạn chưa có Model Category
             $stmt = $this->db->query("SELECT * FROM categories");
             $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            include 'views/instructor/course/create.php';
        }
    }

    // Chỉnh sửa khóa học
    public function edit() {
        $id = $_GET['id'];
        $course = $this->courseModel->getCourseById($id);

        // Kiểm tra quyền (chỉ chủ sở hữu mới được sửa)
        if ($course['instructor_id'] != $_SESSION['user_id']) {
            die("Bạn không có quyền sửa khóa học này");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image = "";
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "assets/uploads/courses/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                $image = $_FILES["image"]["name"];
            }

            $data = [
                'id' => $id,
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'level' => $_POST['level'],
                'category_id' => $_POST['category_id'],
                'instructor_id' => $_SESSION['user_id'],
                'image' => $image,
                'duration_weeks' => $_POST['duration_weeks']
            ];

            if ($this->courseModel->update($data)) {
                header("Location: index.php?controller=instructor&action=dashboard");
            } else {
                echo "Lỗi update";
            }
        } else {
             $stmt = $this->db->query("SELECT * FROM categories");
             $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            include 'views/instructor/course/edit.php';
        }
    }

    // Xóa khóa học
    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $instructor_id = $_SESSION['user_id'];
            
            if ($this->courseModel->delete($id, $instructor_id)) {
                header("Location: index.php?controller=instructor&action=dashboard");
            } else {
                die("Không thể xóa hoặc bạn không có quyền.");
            }
        }
    }
    // Sửa lại hàm students như sau:
    public function students() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        // 2. Kiểm tra có truyền ID khóa học không
        if (!isset($_GET['course_id'])) {
            die("Không tìm thấy khóa học!");
        }

        $course_id = $_GET['course_id'];

        // 3. Kiểm tra khóa học này có đúng của giảng viên không (Bảo mật)
        $course = $this->courseModel->getCourseById($course_id);
        if (!$course || $course['instructor_id'] != $_SESSION['user_id']) {
            die("Bạn không có quyền xem danh sách này.");
        }

        // 4. Lấy danh sách học viên của khóa đó
        $students = $this->enrollmentModel->getStudentsByCourseId($course_id);
        $course_title = $course['title']; // Lấy tên khóa để hiện ra View

        include 'views/instructor/students/list.php';
    }
}
?>