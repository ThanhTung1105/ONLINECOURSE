<?php
class Course {
    private $conn;
    private $table = 'courses';

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Lấy danh sách khóa học (Cho trang chủ - Public)
    public function getCourses($keyword = '', $category_id = '', $sort = 'newest') {
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                  FROM " . $this->table . " c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  WHERE c.status = 'approved'";
        
        if (!empty($keyword)) {
            $query .= " AND (c.title LIKE :keyword OR c.description LIKE :keyword)";
        }
        if (!empty($category_id)) {
            $query .= " AND c.category_id = :category_id";
        }
        switch ($sort) {
            case 'price_asc':  $query .= " ORDER BY c.price ASC"; break;
            case 'price_desc': $query .= " ORDER BY c.price DESC"; break;
            default:           $query .= " ORDER BY c.created_at DESC"; break;
        }

        $stmt = $this->conn->prepare($query);
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

    // 2. Lấy chi tiết 1 khóa học
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

    // --- CÁC HÀM MỚI CHO GIẢNG VIÊN ---

    // 3. Lấy khóa học của riêng giảng viên đó (để hiện lên Dashboard)
   // Trong models/Course.php
// 3. Lấy khóa học của riêng giảng viên đó (để hiện lên Dashboard)
public function getCoursesByInstructor($instructor_id, $keyword = '', $status = 'all', $sort = 'newest') {
    $query = "SELECT c.*, cat.name as category_name, 
              (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as student_count
              FROM " . $this->table . " c
              LEFT JOIN categories cat ON c.category_id = cat.id
              WHERE c.instructor_id = :instructor_id";
    
    // --- Bổ sung điều kiện tìm kiếm ---
    if (!empty($keyword)) {
        $query .= " AND c.title LIKE :keyword";
    }
    
    // --- Bổ sung điều kiện lọc trạng thái ---
    // Kiểm tra nếu không phải 'all' thì mới lọc
    if ($status !== 'all') {
        $query .= " AND c.status = :status";
    }

    // --- Bổ sung điều kiện sắp xếp ---
    switch ($sort) {
        case 'oldest':  $query .= " ORDER BY c.created_at ASC"; break;
        case 'price_desc': $query .= " ORDER BY c.price DESC"; break;
        case 'price_asc': $query .= " ORDER BY c.price ASC"; break;
        case 'students_desc': $query .= " ORDER BY student_count DESC"; break; // Sắp xếp theo số lượng học viên
        default:           $query .= " ORDER BY c.created_at DESC"; break;
    }

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':instructor_id', $instructor_id);

    // Bind tham số
    if (!empty($keyword)) {
        $keyword = "%{$keyword}%";
        $stmt->bindParam(':keyword', $keyword);
    }
    if ($status !== 'all') {
        $stmt->bindParam(':status', $status);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // 4. Tạo khóa học mới
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (title, description, instructor_id, category_id, price, level, image ,duration_weeks)
                  VALUES (:title, :description, :instructor_id, :category_id, :price, :level, :image, :duration_weeks)";
        $stmt = $this->conn->prepare($query);
        
        // Làm sạch dữ liệu (Security)
        $data['title'] = htmlspecialchars(strip_tags($data['title']));
        
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':instructor_id', $data['instructor_id']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':level', $data['level']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':duration_weeks', $data['duration_weeks']);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // 5. Cập nhật khóa học
    public function update($data) {
        $query = "UPDATE " . $this->table . " 
                  SET title = :title, description = :description, category_id = :category_id, 
                      price = :price, level = :level, duration_weeks = :duration_weeks";
        
        // Nếu có cập nhật ảnh thì mới thêm vào câu SQL
        if (!empty($data['image'])) {
            $query .= ", image = :image";
        }
        
        $query .= " WHERE id = :id AND instructor_id = :instructor_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':level', $data['level']);
        $stmt->bindParam(':duration_weeks', $data['duration_weeks']);
        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':instructor_id', $data['instructor_id']);

        if (!empty($data['image'])) {
            $stmt->bindParam(':image', $data['image']);
        }

        return $stmt->execute();
    }

    // 6. Xóa khóa học
    public function delete($id, $instructor_id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id AND instructor_id = :instructor_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':instructor_id', $instructor_id);
        return $stmt->execute();
    }
    // --- HÀM MỚI CHO ADMIN (PHÊ DUYỆT) ---

    // 1. Lấy danh sách các khóa học đang chờ duyệt
    public function getPendingCourses() {
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                  FROM " . $this->table . " c
                  JOIN users u ON c.instructor_id = u.id
                  JOIN categories cat ON c.category_id = cat.id
                  WHERE c.status = 'pending'
                  ORDER BY c.created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Cập nhật trạng thái khóa học (Duyệt/Từ chối)
    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    // --- HÀM THỐNG KÊ MỚI ---
    // Đếm số lượng khóa học theo trạng thái ('approved', 'pending', 'rejected')
    public function countCoursesByStatus($status) {
        $query = "SELECT COUNT(id) FROM " . $this->table . " WHERE status = :status";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>