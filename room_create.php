<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost"; // Tên máy chủ
$username = "root"; // Tên người dùng
$password = ""; // Mật khẩu
$dbname = "qlktx"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu form đã được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $tenPhong = $_POST['tenPhong'];
    $toaNha = $_POST['toaNha'];
    $loaiPhong = $_POST['loaiPhong'];
    $soLuongGiuong = $_POST['soLuongGiuong'];

    // Câu lệnh SQL để thêm phòng vào cơ sở dữ liệu
    $sql = "INSERT INTO phong (TenPhong, ToaNhaID, LoaiPhongID, SoLuongGiuong, TinhTrang) 
            VALUES ('$tenPhong', '$toaNha', '$loaiPhong', '$soLuongGiuong', 'Trống')";

    session_start();
    if ($conn->query($sql) === TRUE) {
        $_SESSION['status'] = 'success';
    } else {
        $_SESSION['status'] = 'error';
    }

    $conn->close();
    header("Location: room.php");
    exit();
}
?>
