<?php
require_once 'config/Database.php';

$db = new Database();
$conn = $db->connect();

if($conn) {
    echo "<h1>Kết nối CSDL thành công!</h1>";
} else {
    echo "<h1>Kết nối thất bại.</h1>";
}
?>