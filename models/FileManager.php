<?php
class FileManager {
    
    // Hàm xử lý upload ảnh
    // $file: Biến $_FILES['ten_input']
    // $folder: Thư mục muốn lưu (ví dụ: 'courses', 'avatars')
    public static function uploadImage($file, $folder = 'courses') {
        $target_dir = "assets/uploads/" . $folder . "/";
        
        // Tạo thư mục nếu chưa có
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Lấy đuôi file
        $fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        
        // Kiểm tra định dạng cho phép
        $allowed = array("jpg", "jpeg", "png", "gif");
        if(!in_array($fileType, $allowed)) {
            return ["success" => false, "message" => "Chỉ chấp nhận file ảnh JPG, JPEG, PNG, GIF."];
        }

        // Tạo tên file mới (tránh trùng tên): timestamp_random.jpg
        $new_filename = time() . "_" . rand(1000, 9999) . "." . $fileType;
        $target_file = $target_dir . $new_filename;

        // Tiến hành upload
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return ["success" => true, "filename" => $new_filename];
        } else {
            return ["success" => false, "message" => "Lỗi khi lưu file."];
        }
    }
}
?>