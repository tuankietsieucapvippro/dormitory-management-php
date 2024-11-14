<?php
session_start(); // Bắt đầu phiên làm việc

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['Username'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

// Lấy thông tin từ session
$Username = $_SESSION['Username'];
$UserID = $_SESSION['UserID'];

// Kết nối đến cơ sở dữ liệu
$conn = mysqli_connect('localhost', 'root', '', 'qlktx') 
    OR die('Could not connect to MySQL: ' . mysqli_connect_error());

// Truy vấn thông tin sinh viên từ bảng sinhvien
$sql = "SELECT * FROM sinhvien WHERE TaiKhoanID='$UserID' LIMIT 1";
$result = mysqli_query($conn, $sql);

// Kiểm tra kết quả truy vấn
if ($result && mysqli_num_rows($result) <> 0) {
    $row = mysqli_fetch_assoc($result);
    $ho = $row['HoSV']; // Họ và tên
    $ten = $row['TenSV'];
    $mssv = $row['MSSV']; // Mã sinh viên
    $lop = $row['Lop']; // Lớp
    $gioiTinh = $row['GioiTinh']; // Giới tính
    $ngaySinh = $row['NgaySinh']; // Ngày sinh
    $noiSinh = $row['NoiSinh']; // Nơi sinh
    $diaChi = $row['DiaChi']; // Địa chỉ
    $email = $row['Email']; // Email
    $soDT = $row['SoDienThoai']; // Số điện thoại
    $cccd = $row['SoCCCD']; // Căn cước công dân
} 

// Đóng kết nối
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin sinh viên</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
    <div class="container">
        <img src="ntulogo.jfif" alt="Logo">
    </div>
    <div>
        <form action="logout.php" method="post">
            <div style="display: flex; justify-content: center; align-items: center;">
                <div class="title">
                    <p style="padding-right: 50px;">Xin chào <?php echo $ho.$ten; ?></p>
                    <button type="submit">Đăng xuất</button>
                </div>
            </div>
            <div class="choose">
                <a href="">Thông tin sinh viên</a>
                <a href="">Hóa đơn</a>
                <a href="">Cập nhật hồ sơ</a>
                <a href="">Thay đổi mật khẩu</a>
            </div>
            
            <h1 style="padding-left: 50px;">Thông tin sinh viên</h1>
            <div class="inf">
                <table>
                    <tr>
                        <td>Họ và tên: </td>
                        <td><?php echo $ho.$ten; ?></td>
                    </tr>
                    <tr>
                        <td>MSSV: </td>
                        <td><?php echo $mssv; ?></td>
                    </tr>
                    <tr>
                        <td>Lớp: </td>
                        <td><?php echo $lop; ?></td>
                    </tr>
                    <tr>
                        <td>Giới tính: </td>
                        <td><?php echo $gioiTinh; ?></td>
                    </tr>
                    <tr>
                        <td>Ngày sinh:</td>
                        <td><?php echo $ngaySinh; ?></td>
                    </tr>
                    <tr>
                        <td>Nơi sinh:</td>
                        <td><?php echo $noiSinh; ?></td>
                    </tr>
                    <tr>
                        <td>Địa chỉ: </td>
                        <td><?php echo $diaChi; ?></td>
                    </tr>
                    <tr>
                        <td>Email: </td>
                        <td><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td>Số điện thoại: </td>
                        <td><?php echo $soDT; ?></td>
                    </tr>
                    <tr>
                        <td>Căn cước công dân: </td>
                        <td><?php echo $cccd; ?></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</body>
</html>
