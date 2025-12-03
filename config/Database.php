<?php
class Database {
    private $host = 'localhost'; 
    private $db_name = 'onlinecourse';
    private $username = 'root';
    private $password = '';
    private $port = '3306'; // Sửa thành 3307 nếu XAMPP của bạn khác
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            // Chuỗi kết nối DSN (Data Source Name)
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Lỗi kết nối: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>