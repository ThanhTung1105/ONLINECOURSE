<?php
require_once 'config/Database.php';
require_once 'models/Lesson.php';
require_once 'models/Enrollment.php';
require_once 'models/Material.php';
require_once 'models/Course.php'; // <--- MỚI THÊM DÒNG NÀY

class LessonController {
    private $db;
    private $lessonModel;
    private $enrollmentModel;
    private $materialModel;
    private $courseModel; // <--- MỚI THÊM

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->lessonModel = new Lesson($this->db);
        $this->enrollmentModel = new Enrollment($this->db);
        $this->materialModel = new Material($this->db);
        $this->courseModel = new Course($this->db); // <--- MỚI THÊM
    }

    // --- CODE CŨ CỦA BẠN (GIỮ NGUYÊN) ---
    // Thay thế hàm public function learn() hiện tại:
public function learn() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?controller=auth&action=login");
        exit;
    }
    
    // --- BỔ SUNG: Kiểm tra quyền truy cập khóa học ---
    // Cần đảm bảo học viên đã đăng ký khóa học này
    $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
    $student_id = $_SESSION['user_id'];
    
    // Nếu học viên chưa đăng ký, chuyển hướng (Bạn cần có hàm isEnrolled trong EnrollmentModel)
    if ($course_id && !$this->enrollmentModel->isEnrolled($student_id, $course_id)) {
        echo "<script>alert('Bạn cần đăng ký khóa học này để xem bài học.'); window.location.href='index.php?controller=course&action=detail&id=$course_id';</script>";
        exit;
    }


    if (!$course_id) header("Location: index.php");

    $lessons = $this->lessonModel->getLessonsByCourse($course_id);
    
    $current_lesson = null;
    if (isset($_GET['lesson_id'])) {
        $current_lesson = $this->lessonModel->getLessonById($_GET['lesson_id']);
    } else if (count($lessons) > 0) {
        $current_lesson = $lessons[0];
    }
    
    $materials = [];
    if ($current_lesson) {
        $materials = $this->materialModel->getByLessonId($current_lesson['id']);
        
        // --- TẠO URL NHÚNG VIDEO ---
        if (!empty($current_lesson['video_url'])) {
            $embed_url = $this->getYoutubeEmbedUrl($current_lesson['video_url']);
        } else {
            $embed_url = null;
        }
    }

    include 'views/lessons/learn.php';
}
    // Trong class LessonController, thêm phương thức sau:
private function getYoutubeEmbedUrl($url) {
    if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
        // Sử dụng regex để tìm ID video
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $videoId = $match[1];
            // Trả về link embed an toàn
            return "https://www.youtube.com/embed/" . $videoId . "?rel=0&showinfo=0";
        }
    }
    // Trả về link gốc nếu không phải YouTube, hy vọng nó là link nhúng trực tiếp
    return $url; 
}

    public function complete() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (isset($_POST['course_id']) && isset($_POST['lesson_id'])) {
            $student_id = $_SESSION['user_id'];
            $course_id = $_POST['course_id'];
            $lesson_id = $_POST['lesson_id'];

            $enrollment_id = $this->enrollmentModel->getEnrollmentId($student_id, $course_id);

            if ($enrollment_id) {
                if ($this->enrollmentModel->markLessonComplete($enrollment_id, $lesson_id)) {
                    $this->enrollmentModel->updateProgress($enrollment_id, $course_id);
                    
                    $sql_check = "SELECT progress FROM enrollments WHERE id = :id";
                    $stmt = $this->db->prepare($sql_check);
                    $stmt->execute(['id' => $enrollment_id]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($row && $row['progress'] >= 100) {
                        $sql_update = "UPDATE enrollments SET status = 'completed' WHERE id = :id";
                        $stmt_update = $this->db->prepare($sql_update);
                        $stmt_update->execute(['id' => $enrollment_id]);
                    }
                }
            }
            header("Location: index.php?controller=lesson&action=learn&course_id=$course_id&lesson_id=$lesson_id");
            exit;
        }
    }

    // --- CODE MỚI THÊM (QUẢN LÝ BÀI HỌC CHO GIẢNG VIÊN) ---

    // 1. Xem danh sách bài học (Dashboard giảng viên bấm vào "Quản lý bài")
    public function manage() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 1) {
             die("Bạn không có quyền truy cập.");
        }

        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
        if (!$course_id) die("Thiếu ID khóa học");

        // Kiểm tra khóa học này có đúng của giảng viên không
        $course = $this->courseModel->getCourseById($course_id);
        if ($course['instructor_id'] != $_SESSION['user_id']) {
            die("Bạn không sở hữu khóa học này.");
        }

        $lessons = $this->lessonModel->getLessonsByCourse($course_id);
        
        // Đường dẫn view: views/instructor/lessons/manage.php
        include 'views/instructor/lessons/manage.php';
    }

    // 2. Thêm bài học
    public function create() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : (isset($_POST['course_id']) ? $_POST['course_id'] : null);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'course_id' => $_POST['course_id'],
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'video_url' => $_POST['video_url'],
                'ordering' => $_POST['ordering']
            ];

            if ($this->lessonModel->create($data)) {
                header("Location: index.php?controller=lesson&action=manage&course_id=" . $data['course_id']);
            } else {
                echo "Lỗi khi thêm bài học";
            }
        } else {
            include 'views/instructor/lessons/create.php';
        }
    }

    // 3. Sửa bài học
    public function edit() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $id = $_GET['id'];
        $lesson = $this->lessonModel->getLessonById($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => $id,
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'video_url' => $_POST['video_url'],
                'ordering' => $_POST['ordering']
            ];

            if ($this->lessonModel->update($data)) {
                header("Location: index.php?controller=lesson&action=manage&course_id=" . $lesson['course_id']);
            } else {
                echo "Lỗi update";
            }
        } else {
            include 'views/instructor/lessons/edit.php';
        }
    }

    // 4. Xóa bài học
    public function delete() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $lesson = $this->lessonModel->getLessonById($id);
            $course_id = $lesson['course_id'];

            // Kiểm tra quyền (tránh xóa bậy)
            $course = $this->courseModel->getCourseById($course_id);
            if ($course['instructor_id'] == $_SESSION['user_id']) {
                $this->lessonModel->delete($id);
            }
            
            header("Location: index.php?controller=lesson&action=manage&course_id=" . $course_id);
        }
    }
}
?>