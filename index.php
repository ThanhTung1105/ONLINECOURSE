<?php
// index.php - File điều hướng trung tâm
session_start(); // Khởi tạo session để dùng cho đăng nhập sau này
require_once 'config/Database.php';
require_once 'config/config.php';
// 1. Lấy controller và action từ URL
// Nếu không có, mặc định là 'home' và 'index' (Trang chủ)
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// 2. Chuẩn hóa tên file Controller (ví dụ: home -> HomeController)
$controllerName = ucfirst($controller) . 'Controller'; // Viết hoa chữ cái đầu
$controllerPath = "controllers/$controllerName.php";

// 3. Kiểm tra file Controller có tồn tại không
if (file_exists($controllerPath)) {
    require_once $controllerPath;
    
    // Khởi tạo đối tượng Controller
    $obj = new $controllerName();
    
    // Kiểm tra hàm (action) có tồn tại trong Controller không
    if (method_exists($obj, $action)) {
        // Chạy hàm đó (Hàm này sẽ gọi view hiển thị)
        $obj->$action();
    } else {
        die("Lỗi: Action '$action' không tồn tại trong $controllerName.");
    }
} else {
    die("Lỗi: Controller '$controllerName' không tìm thấy (File $controllerPath chưa tạo).");
}
?>