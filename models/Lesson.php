<?php
class Lesson {
    private $conn;
    private $table = 'lessons';

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- CODE CŨ (GIỮ NGUYÊN) ---
    public function getLessonsByCourse($course_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE course_id = :course_id ORDER BY ordering ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLessonById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- CODE MỚI THÊM (CHO GIẢNG VIÊN) ---

    // 1. Thêm bài học
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (course_id, title, content, video_url, ordering)
                  VALUES (:course_id, :title, :content, :video_url, :ordering)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':course_id', $data['course_id']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':video_url', $data['video_url']);
        $stmt->bindParam(':ordering', $data['ordering']);

        return $stmt->execute();
    }

    // 2. Cập nhật bài học
    public function update($data) {
        $query = "UPDATE " . $this->table . " 
                  SET title = :title, content = :content, video_url = :video_url, ordering = :ordering
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':video_url', $data['video_url']);
        $stmt->bindParam(':ordering', $data['ordering']);
        $stmt->bindParam(':id', $data['id']);

        return $stmt->execute();
    }

    // 3. Xóa bài học
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>