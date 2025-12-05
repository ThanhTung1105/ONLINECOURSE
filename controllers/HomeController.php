<?php
require_once 'config/Database.php';
require_once 'models/Course.php';

class HomeController {
    private $db;
    private $courseModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->courseModel = new Course($this->db);
    }

    public function index() {
        // Lấy danh sách khóa học mới nhất (Limit 6 khóa để hiển thị trang chủ)
        // Ta dùng hàm getCourses cũ, sau này có thể viết hàm getFeaturedCourses riêng nếu cần
        $courses = $this->courseModel->getCourses('', '', 'newest'); 
        
        // Cắt lấy 6 khóa đầu tiên
        $featured_courses = array_slice($courses, 0, 6);

        include 'views/home/index.php';
    }
}
?>