<?php
class Material {
    private $conn;
    private $table = 'materials';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách tài liệu của một bài học
    public function getByLessonId($lesson_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE lesson_id = :lesson_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':lesson_id', $lesson_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>