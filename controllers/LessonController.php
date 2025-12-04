<?php
require_once 'config/Database.php';
require_once 'models/Lesson.php';
require_once 'models/Enrollment.php';
require_once 'models/Material.php';
class LessonController {
    private $db;
    private $lessonModel;
    private $enrollmentModel;
    private $materialModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->lessonModel = new Lesson($this->db);
        $this->enrollmentModel = new Enrollment($this->db);
        $this->materialModel = new Material($this->db);
    }

    // Màn hình học bài (Hiện video và danh sách bài)
    public function learn() {
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
        if (!$course_id) header("Location: index.php");

        // Lấy danh sách bài học
        $lessons = $this->lessonModel->getLessonsByCourse($course_id);
        
        // Lấy bài học hiện tại (nếu không chọn thì lấy bài đầu tiên)
        $current_lesson = null;
        if (isset($_GET['lesson_id'])) {
            $current_lesson = $this->lessonModel->getLessonById($_GET['lesson_id']);
        } else if (count($lessons) > 0) {
            $current_lesson = $lessons[0];
        }
        $materials = [];
        if ($current_lesson) {
            $materials = $this->materialModel->getByLessonId($current_lesson['id']);
        }

        include 'views/lessons/learn.php';
    }

    // Xử lý khi bấm nút "Hoàn thành"
    // Xử lý khi bấm nút "Hoàn thành"
    public function complete() {
        // Khởi động session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_POST['course_id']) && isset($_POST['lesson_id'])) {
            $student_id = $_SESSION['user_id'];
            $course_id = $_POST['course_id'];
            $lesson_id = $_POST['lesson_id'];

            // 1. Lấy enrollment id
            $enrollment_id = $this->enrollmentModel->getEnrollmentId($student_id, $course_id);

            if ($enrollment_id) {
                // 2. Đánh dấu hoàn thành bài học
                if ($this->enrollmentModel->markLessonComplete($enrollment_id, $lesson_id)) {
                    
                    // 3. Tính lại tiến độ
                    $this->enrollmentModel->updateProgress($enrollment_id, $course_id);

                    // --- ĐOẠN CODE MỚI (DÙNG PDO) ---
                    // B1: Lấy tiến độ mới nhất (Dùng prepare/execute của PDO)
                    $sql_check = "SELECT progress FROM enrollments WHERE id = :id";
                    $stmt = $this->db->prepare($sql_check);
                    $stmt->execute(['id' => $enrollment_id]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // B2: Nếu >= 100% thì cập nhật trạng thái thành completed
                    if ($row && $row['progress'] >= 100) {
                        $sql_update = "UPDATE enrollments SET status = 'completed' WHERE id = :id";
                        $stmt_update = $this->db->prepare($sql_update);
                        $stmt_update->execute(['id' => $enrollment_id]);
                    }
                    // --- KẾT THÚC ĐOẠN CODE MỚI ---
                }
            }
            
            // Quay lại trang học bài
            header("Location: index.php?controller=lesson&action=learn&course_id=$course_id&lesson_id=$lesson_id");
            exit;
        }
    }
}
?>