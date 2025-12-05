<?php
class Material {
    private $conn;
    private $table = 'materials';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách tài liệu của 1 bài học
    public function getByLessonId($lesson_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE lesson_id = :lesson_id ORDER BY uploaded_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':lesson_id', $lesson_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin 1 tài liệu (để xóa)
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm tài liệu mới
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (lesson_id, filename, file_path, file_type)
                  VALUES (:lesson_id, :filename, :file_path, :file_type)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':lesson_id', $data['lesson_id']);
        $stmt->bindParam(':filename', $data['filename']);
        $stmt->bindParam(':file_path', $data['file_path']);
        $stmt->bindParam(':file_type', $data['file_type']);

        return $stmt->execute();
    }

    // Xóa tài liệu khỏi Database
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>