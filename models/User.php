<?php
class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Hàm kiểm tra đăng nhập
    public function login($email, $password) {
        // 1. Tìm user theo email
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // 2. Nếu tìm thấy user
        if($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // 3. Kiểm tra mật khẩu (đã mã hóa hash)
            if(password_verify($password, $user['password'])) {
                return $user; // Trả về thông tin user nếu đúng
            }
        }
        return false; // Sai email hoặc pass
    }

    // Hàm đăng ký user mới
    public function register($username, $email, $hashedPassword, $fullname) {
        $query = "INSERT INTO " . $this->table . " (username, email, password, fullname, role, created_at) 
                  VALUES (:username, :email, :password, :fullname, 0, NOW())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':fullname', $fullname);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Kiểm tra username đã tồn tại
    public function usernameExists($username) {
        $query = "SELECT id FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    // Kiểm tra email đã tồn tại
    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    // Lấy tất cả user
    public function getAll() {
        $query = "SELECT id, username, email, fullname, role, created_at FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy user theo ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo user mới (từ admin)
    public function createUser($username, $email, $password, $fullname, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO " . $this->table . " (username, email, password, fullname, role, created_at) 
                  VALUES (:username, :email, :password, :fullname, :role, NOW())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':role', $role);
        
        return $stmt->execute();
    }

    // Cập nhật thông tin user
    public function updateUser($id, $username, $email, $fullname, $role) {
        $query = "UPDATE " . $this->table . " 
                  SET username = :username, email = :email, fullname = :fullname, role = :role 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':role', $role);
        
        return $stmt->execute();
    }

    // Xóa user
    public function deleteUser($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Đặt lại mật khẩu
    public function resetPassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE " . $this->table . " SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    // --- HÀM THỐNG KÊ MỚI ---
    // Đếm tổng số người dùng
    public function countTotalUsers() {
        $query = "SELECT COUNT(id) FROM " . $this->table;
        // fetchColumn lấy giá trị đầu tiên của kết quả query
        return $this->conn->query($query)->fetchColumn();
    }
    // Đếm số lượng theo vai trò (0:HV, 1:GV, 2:Admin)
    public function countByRole($role) {
        $query = "SELECT COUNT(id) FROM " . $this->table . " WHERE role = :role";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function getUserById($id) {
        $query = "SELECT id, fullname, email, created_at, role, username FROM " . $this->table . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>