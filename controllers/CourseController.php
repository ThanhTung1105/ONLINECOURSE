<?php
require_once 'config/Database.php';
require_once 'models/Course.php';
require_once 'models/Enrollment.php'; // <--- 1. Thêm dòng này
require_once 'models/Lesson.php';
require_once 'models/Category.php';
class CourseController {
    private $db;
    private $courseModel;
    private $enrollmentModel; 
    // <--- 2. Khai báo thuộc tính mới
    private $lessonModel;
    private $categoryModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->courseModel = new Course($this->db);
        $this->enrollmentModel = new Enrollment($this->db);
        $this->lessonModel = new Lesson($this->db); // <--- 3. Khởi tạo Model
        $this->categoryModel = new Category($this->db);
    }
    public function index() {
        // Lấy tham số tìm kiếm/lọc từ URL
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

        // Lấy dữ liệu
        $categories = $this->categoryModel->getAll();
        $courses = $this->courseModel->getCourses($keyword, $category_id, $sort);

        // Gọi View hiển thị
        include 'views/courses/index.php';
    }

    // Hàm hiển thị chi tiết (Giữ nguyên như cũ)
    public function detail() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $course = $this->courseModel->getCourseById($id);

            if ($course) {
                $lessons = $this->lessonModel->getLessonsByCourse($id);
                include 'views/courses/detail.php';
            } else {
                echo "Lỗi: Không tìm thấy khóa học!";
            }
        } else {
            header("Location: index.php");
        }
    }

    // --- 4. THÊM HÀM MỚI: Xử lý đăng ký ---
    public function register() {
        // Kiểm tra đăng nhập (Bắt buộc phải có session)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            // Nếu chưa đăng nhập, chuyển hướng về trang Login
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
        if (isset($_SESSION['role']) && $_SESSION['role'] != 0) {
        echo "<script>
            alert('Chức năng này chỉ dành cho Học viên!');
            window.location.href = 'index.php';
        </script>";
        exit;
    }

        if (isset($_GET['id'])) {
            $course_id = $_GET['id'];
            $student_id = $_SESSION['user_id'];

            // Kiểm tra xem đã đăng ký chưa
            if ($this->enrollmentModel->isEnrolled($student_id, $course_id)) {
                echo "<script>alert('Bạn đã đăng ký khóa học này rồi!'); window.location.href='index.php?controller=student&action=dashboard';</script>";
            } else {
                // Thực hiện đăng ký
                if ($this->enrollmentModel->register($student_id, $course_id)) {
                    echo "<script>alert('Đăng ký thành công! Chúc bạn học tốt.'); window.location.href='index.php?controller=student&action=dashboard';</script>";
                } else {
                    echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại sau.'); window.history.back();</script>";
                }
            }
        }
    }
}
?>