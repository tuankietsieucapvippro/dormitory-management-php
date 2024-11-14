<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<style>
    input[type=text]{
        width: 300px;
    }
</style>

<?php include('includes/header.html'); ?>
<?php include('includes/sidebar.html'); ?>
<?php include('includes/headerbar.html'); ?>

<?php
include('db_connect.php');

// Lấy MSSV từ URL
$mssv = $_GET['mssv'];

// Xử lý cập nhật thông tin khi người dùng nhấn nút "Cập nhật"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $hoSV = $_POST['hoSV'];
    $tenSV = $_POST['tenSV'];
    $gioiTinh = $_POST['gioiTinh'];
    $lop = $_POST['lop'];
    $email = $_POST['email'];
    $soDienThoai = $_POST['soDienThoai'];
    $diaChi = $_POST['diaChi'];
    $file_name = $student['anh']; // Đặt giá trị mặc định là ảnh hiện có
    
    // Kiểm tra và xử lý file ảnh nếu người dùng tải lên ảnh mới
    if (isset($_FILES['anh']) && $_FILES['anh']['name'] != "") {
        $errors = array();
        $file_name = $_FILES['anh']['name'];
        $file_tmp = $_FILES['anh']['tmp_name'];
        $file_size = $_FILES['anh']['size'];
        
        // Lấy phần mở rộng của tệp
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Các phần mở rộng được phép
        $allowed_extensions = array("jpeg", "jpg", "png");
    
        // Kiểm tra định dạng tệp
        if (!in_array($file_ext, $allowed_extensions)) {
            $errors[] = "Only JPEG and PNG files are allowed.";
        }
    
        // Kiểm tra kích thước tệp
        if ($file_size > 2097152) {
            $errors[] = "File size must be less than 2MB.";
        }
    
        // Nếu không có lỗi, upload tệp
        if (empty($errors)) {
            // Đảm bảo thư mục tồn tại và có quyền ghi
            if (move_uploaded_file($file_tmp, "images/$file_name")) {
                echo "Upload File successfully!!!";
            } else {
                echo "Failed to upload file.";
            }
        } else {
            print_r($errors);
        }
    }
    

    // Thực hiện cập nhật thông tin vào cơ sở dữ liệu
    $sql = "UPDATE SinhVien SET HoSV='$hoSV', TenSV='$tenSV', GioiTinh='$gioiTinh', Lop='$lop', 
            Email='$email', SoDienThoai='$soDienThoai', DiaChi='$diaChi', anh='$file_name' 
            WHERE MSSV='$mssv'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('Cập nhật thành công!');
            window.location.href = 'student.php';
        </script>";
    } else {
        echo "<script>alert('Cập nhật không thành công. Vui lòng thử lại!');</script>";
    }
}

// Truy vấn để lấy thông tin sinh viên theo MSSV
$sql = "SELECT * FROM SinhVien WHERE MSSV='$mssv'";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);

if (!$student) {
    echo "Không tìm thấy sinh viên!";
    exit();
}
?>

<div class="main-content">
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="mssv" value="<?php echo $student['MSSV']; ?>">
        
        <table>
            <tr>
                <td>
                    <img id="preview" 
                        src="images/<?php echo $student['Anh']; ?>" 
                        alt="Ảnh sinh viên" width="150px" height="150px">
                </td>
                <td><input type="file" name="anh" id="anh" accept="anh/*" style="margin-top: 100px"></td>
            </tr>
            <tr>
                <td>Họ: </td>
                <td><input type="text" name="hoSV" value="<?php echo $student['HoSV']; ?>"></td>
            </tr>
            <tr>
                <td>Tên: </td>
                <td><input type="text" name="tenSV" value="<?php echo $student['TenSV']; ?>"></td>
            </tr>
            <tr>
                <td>Giới tính: </td>
                <td style="display: flex;">
                    <input type="radio" name="gioiTinh" value="Nam" <?php echo ($student['GioiTinh'] == 'Nam') ? 'checked' : ''; ?>> <p style="margin-top: 10px; margin-left: -50px">Nam</p>
                    <input type="radio" name="gioiTinh" value="Nữ" <?php echo ($student['GioiTinh'] == 'Nữ') ? 'checked' : ''; ?>> <p style="margin-top: 10px; margin-left: -50px">Nữ</p>
                </td>
            </tr>
            <tr>
                <td>Lớp: </td>
                <td><input type="text" name="lop" value="<?php echo $student['Lop']; ?>"></td>
            </tr>
            <tr>
                <td>Ngày sinh: </td>
                <td><input type="date" name="ngaySinh" value="<?php echo $student['NgaySinh']; ?>"></td>
            </tr>
            <tr>
                <td>Nơi sinh: </td>
                <td><input type="text" name="noiSinh" value="<?php echo $student['NoiSinh']; ?>"></td>
            </tr>
            
            <tr>
                <td>Email: </td>
                <td><input type="email" name="email" style="width: 300px" value="<?php echo $student['Email']; ?>"></td>
            </tr>
            <tr>
                <td>Số điện thoại: </td>
                <td><input type="text" name="soDienThoai" value="<?php echo $student['SoDienThoai']; ?>"></td>
            </tr>
            <tr>
                <td>Địa chỉ: </td>
                <td><input type="text" name="diaChi" value="<?php echo $student['DiaChi']; ?>"></td>
            </tr>
            <tr>
                <td>Số CCCD: </td>
                <td><input type="text" name="SoCCCD" value="<?php echo $student['SoCCCD']; ?>"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button type="submit">Cập nhật</button>
                </td>
            </tr>
        </table>
    </form>
</div>

<?php
$conn->close();
include('includes/footer.html');
?>

<!-- Hiển thị ảnh -->
<script>
    // Lắng nghe sự kiện thay đổi của input file
    document.getElementById('anh').addEventListener('change', function(event) {
        var preview = document.getElementById('preview');
        var file = event.target.files[0];

        // Kiểm tra nếu file là ảnh
        if (file && file.type.startsWith('anh/')) {
            var reader = new FileReader();

            // Đọc nội dung của file và thiết lập nó làm src cho ảnh
            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(file); // Đọc file ảnh dưới dạng URL dữ liệu
        }
    });
</script>

</body>
</html>