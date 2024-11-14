<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin sinh viên</title>
    <link rel="stylesheet" type="text/css" href="css/detail.css">
</head>
<body>

<?php include('includes/header.html'); ?>
<?php include('includes/sidebar.html'); ?>
<?php include('includes/headerbar.html'); ?>

<?php
include('db_connect.php');

// Lấy MSSV từ URL
$mssv = $_GET['mssv'];

// Truy vấn để lấy thông tin sinh viên theo MSSV
$sql = "SELECT * FROM SinhVien WHERE MSSV='$mssv'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Truy vấn không thành công: " . mysqli_error($conn);
    exit();
}

$student = mysqli_fetch_assoc($result);

if (!$student) {
    echo "Không tìm thấy sinh viên!";
    exit();
}
?>

<div class="main-content">
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="mssv" value="<?php echo $student['MSSV']; ?>">
        
        <div class="preview-container">
            <img id="preview" src="images/<?php echo $student['Anh']?>" alt="Ảnh sinh viên" width="150px" height="150px">
        </div>

        <table style="display: flex; justify-content:center">
            <tr class="info-row">
                <td>Họ và tên: </td>
                <td><?php echo $student['HoSV'] . ' ' . $student['TenSV']; ?></td>
            </tr>
            <tr class="info-row">
                <td>Giới tính: </td>
                <td><?php echo $student['GioiTinh']; ?></td>
            </tr>
            <tr class="info-row">
                <td>Lớp: </td>
                <td><?php echo $student['Lop']; ?></td>
            </tr>
            <tr class="info-row">
                <td>Ngày sinh: </td>
                <td><?php echo $student['NgaySinh']; ?></td>
            </tr>
            <tr class="info-row">
                <td>Nơi sinh: </td>
                <td><?php echo $student['NoiSinh']; ?></td>
            </tr>
            <tr class="info-row">
                <td>Email: </td>
                <td><?php echo $student['Email']; ?></td>
            </tr>
            <tr class="info-row">
                <td>Số điện thoại: </td>
                <td><?php echo $student['SoDienThoai']; ?></td>
            </tr>
            <tr class="info-row">
                <td>Số CCCD: </td>
                <td><?php echo $student['SoCCCD']; ?></td>
            </tr>
            <tr class="info-row">
                <td>Địa chỉ: </td>
                <td><?php echo $student['DiaChi']; ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="button" onclick="history.back()" class="back-btn">Quay lại</button>
                </td>
            </tr>
        </table>

    </form>
</div>

<?php
// Đóng kết nối cơ sở dữ liệu sau khi sử dụng
mysqli_close($conn);
include('includes/footer.html');
?>

</body>
</html>
