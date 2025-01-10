<?php
$host = 'localhost'; // Tên host
$username = 'root'; // Tên user của MySQL
$password = ''; // Mật khẩu (nếu có, điền vào đây)
$database = 'mnm_pkdt'; // Tên CSDL

$conn = new mysqli($host, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>