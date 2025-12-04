<?php
class Course {
    private $conn;
    private $table = 'courses';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách khóa học có Lọc & Tìm kiếm
    public function getCourses($keyword = '', $category_id = '', $sort = 'newest') {
        // Câu truy vấn cơ bản kết nối với bảng users (để lấy tên giảng viên)
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                  FROM " . $this->table . " c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  WHERE 1=1";

        // Thêm điều kiện tìm kiếm từ khóa
        if (!empty($keyword)) {
            $query .= " AND (c.title LIKE :keyword OR c.description LIKE :keyword)";
        }

        // Thêm điều kiện lọc theo danh mục
        if (!empty($category_id)) {
            $query .= " AND c.category_id = :category_id";
        }

        // Sắp xếp
        switch ($sort) {
            case 'price_asc':  $query .= " ORDER BY c.price ASC"; break;
            case 'price_desc': $query .= " ORDER BY c.price DESC"; break;
            default:           $query .= " ORDER BY c.created_at DESC"; break; // Mới nhất
        }

        $stmt = $this->conn->prepare($query);

        // Gán giá trị vào tham số (Binding params)
        if (!empty($keyword)) {
            $keyword = "%{$keyword}%";
            $stmt->bindParam(':keyword', $keyword);
        }
        if (!empty($category_id)) {
            $stmt->bindParam(':category_id', $category_id);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function getCourseById($id) {
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                  FROM " . $this->table . " c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  WHERE c.id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>