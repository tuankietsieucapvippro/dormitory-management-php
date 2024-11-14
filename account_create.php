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
    $username = $_POST['username'];
    $passwordUser = $_POST['password'];
    $role = $_POST['role'];

    // Mã hóa mật khẩu (tùy chọn)
    // $passwordUser = password_hash($passwordUser, PASSWORD_DEFAULT);

    // Câu lệnh SQL để thêm tài khoản vào cơ sở dữ liệu
    $sql = "INSERT INTO user (Username, PasswordUser, Role) 
            VALUES ('$username', '$passwordUser', '$role')";

    session_start();
    if ($conn->query($sql) === TRUE) {
        $_SESSION['status'] = 'success';
    } else {
        $_SESSION['status'] = 'error';
    }

    $conn->close();
    header("Location: account.php");
    exit();
}
?>
