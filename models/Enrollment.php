<?php
class Enrollment {
    private $conn;
    private $table = 'enrollments';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Kiểm tra xem học viên đã đăng ký khóa này chưa
    public function isEnrolled($student_id, $course_id) {
        $query = "SELECT id FROM " . $this->table . " 
                  WHERE student_id = :student_id AND course_id = :course_id LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();

        return $stmt->rowCount() > 0; // Trả về true nếu đã đăng ký
    }

    // Thực hiện đăng ký khóa học
    public function register($student_id, $course_id) {
        $query = "INSERT INTO " . $this->table . " (student_id, course_id, status, progress, enrolled_date) 
                  VALUES (:student_id, :course_id, 'active', 0, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':course_id', $course_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function getMyCourses($student_id) {
        // Kết nối bảng enrollments với courses và users để lấy đủ thông tin
        $query = "SELECT c.*, e.progress, e.status, u.fullname as instructor_name 
                  FROM " . $this->table . " e
                  JOIN courses c ON e.course_id = c.id
                  LEFT JOIN users u ON c.instructor_id = u.id
                  WHERE e.student_id = :student_id
                  ORDER BY e.enrolled_date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // ... code cũ ...

    // 1. Lấy ID đăng ký (enrollment_id) từ student và course
    public function getEnrollmentId($student_id, $course_id) {
        $query = "SELECT id FROM " . $this->table . " WHERE student_id = :s_id AND course_id = :c_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':s_id', $student_id);
        $stmt->bindParam(':c_id', $course_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['id'] : null;
    }

    // 2. Đánh dấu bài học là đã hoàn thành
    public function markLessonComplete($enrollment_id, $lesson_id) {
        // Kiểm tra xem đã hoàn thành trước đó chưa
        $check = "SELECT id FROM lesson_completions WHERE enrollment_id = :e_id AND lesson_id = :l_id";
        $stmt = $this->conn->prepare($check);
        $stmt->bindParam(':e_id', $enrollment_id);
        $stmt->bindParam(':l_id', $lesson_id);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            // Nếu chưa thì thêm vào
            $query = "INSERT INTO lesson_completions (enrollment_id, lesson_id) VALUES (:e_id, :l_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':e_id', $enrollment_id);
            $stmt->bindParam(':l_id', $lesson_id);
            $stmt->execute();
            return true; // Có thay đổi
        }
        return false; // Không thay đổi (đã hoàn thành từ trước)
    }

    // 3. Tính toán và Cập nhật % tiến độ
    public function updateProgress($enrollment_id, $course_id) {
        // Đếm tổng số bài học
        $queryTotal = "SELECT COUNT(*) as total FROM lessons WHERE course_id = :c_id";
        $stmt = $this->conn->prepare($queryTotal);
        $stmt->bindParam(':c_id', $course_id);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        if ($total == 0) return 0; // Tránh chia cho 0

        // Đếm số bài đã học
        $queryDone = "SELECT COUNT(*) as done FROM lesson_completions WHERE enrollment_id = :e_id";
        $stmt = $this->conn->prepare($queryDone);
        $stmt->bindParam(':e_id', $enrollment_id);
        $stmt->execute();
        $done = $stmt->fetch(PDO::FETCH_ASSOC)['done'];

        // Tính phần trăm
        $percent = intval(($done / $total) * 100);

        // Cập nhật vào bảng enrollments
        $update = "UPDATE " . $this->table . " SET progress = :p WHERE id = :id";
        $stmt = $this->conn->prepare($update);
        $stmt->bindParam(':p', $percent);
        $stmt->bindParam(':id', $enrollment_id);
        $stmt->execute();

        return $percent;
    }
}
    

?>