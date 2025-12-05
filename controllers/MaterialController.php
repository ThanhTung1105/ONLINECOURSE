<?php
require_once 'config/Database.php';
require_once 'models/Material.php';
require_once 'models/Lesson.php';

class MaterialController {
    private $db;
    private $materialModel;
    private $lessonModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->materialModel = new Material($this->db);
        $this->lessonModel = new Lesson($this->db);
    }

    // 1. Quản lý tài liệu của 1 bài học
    public function manage() {
        if (!isset($_GET['lesson_id'])) die("Thiếu ID bài học");
        
        $lesson_id = $_GET['lesson_id'];
        $lesson = $this->lessonModel->getLessonById($lesson_id); // Lấy tên bài học
        $materials = $this->materialModel->getByLessonId($lesson_id);

        include 'views/instructor/materials/manage.php';
    }

    // 2. Upload tài liệu
    public function upload() {
        $lesson_id = $_POST['lesson_id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file_upload'])) {
            $file = $_FILES['file_upload'];
            $filename = $file['name'];
            $file_tmp = $file['tmp_name'];
            
            // Lấy đuôi file
            $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $allowed = array('pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip', 'rar', 'jpg', 'png');

            if (in_array($file_ext, $allowed)) {
                // Đặt tên file mới để tránh trùng (timestamp_tenfile)
                $new_filename = time() . '_' . $filename;
                $upload_dir = "assets/uploads/materials/";
                
                // Tạo thư mục nếu chưa có
                if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);

                $destination = $upload_dir . $new_filename;

                if (move_uploaded_file($file_tmp, $destination)) {
                    // Lưu vào CSDL
                    $data = [
                        'lesson_id' => $lesson_id,
                        'filename' => $filename,      // Tên hiển thị (tên gốc)
                        'file_path' => $new_filename, // Tên file lưu trên server
                        'file_type' => $file_ext
                    ];
                    $this->materialModel->create($data);
                    header("Location: index.php?controller=material&action=manage&lesson_id=$lesson_id");
                } else {
                    echo "Lỗi khi lưu file lên server.";
                }
            } else {
                echo "Định dạng file không hỗ trợ!";
            }
        }
    }

    // 3. Xóa tài liệu
    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $material = $this->materialModel->getById($id);
            
            if ($material) {
                // Xóa file vật lý trong thư mục
                $file_path = "assets/uploads/materials/" . $material['file_path'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                
                // Xóa trong CSDL
                $this->materialModel->delete($id);
                header("Location: index.php?controller=material&action=manage&lesson_id=" . $material['lesson_id']);
            }
        }
    }
}
?>