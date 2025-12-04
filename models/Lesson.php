<?php
class Lesson {
    private $conn;
    private $table = 'lessons';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách bài học của một khóa
    public function getLessonsByCourse($course_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE course_id = :course_id ORDER BY ordering ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết 1 bài học
    public function getLessonById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>