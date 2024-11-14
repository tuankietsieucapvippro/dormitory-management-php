<?php
$servername = "localhost";   // Tên máy chủ (localhost cho XAMPP)
$username = "root";          // Tên người dùng MySQL (mặc định trong XAMPP là root)
$password = "";              // Mật khẩu (mặc định là rỗng trong XAMPP)
$dbname = "qlktx";    // Tên cơ sở dữ liệu

// Kết nối đến MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
