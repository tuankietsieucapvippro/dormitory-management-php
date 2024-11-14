<?php
// Kết nối cơ sở dữ liệu
include('db_connect.php');
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['Username'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

// Lấy MSSV từ URL
if (isset($_GET['mssv'])) {
    $mssv = $_GET['mssv'];

    // Truy vấn lấy thông tin người dùng tương ứng
    $sql = "SELECT * FROM SinhVien WHERE MSSV = '$mssv'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Lấy UserID từ sinh viên
        $row = mysqli_fetch_assoc($result);
        $userID = $row['TaiKhoanID'];

        // Bắt đầu giao dịch để xóa cả sinh viên và người dùng
        mysqli_begin_transaction($conn);  // Bắt đầu giao dịch

        try {
            // Xóa sinh viên
            $deleteStudentSQL = "DELETE FROM SinhVien WHERE MSSV = '$mssv'";
            mysqli_query($conn, $deleteStudentSQL);

            // Xóa tài khoản người dùng
            $deleteUserSQL = "DELETE FROM user WHERE UserID = '$userID'";
            mysqli_query($conn, $deleteUserSQL);

            // Commit giao dịch
            mysqli_commit($conn);

            // Thiết lập thông báo thành công và chuyển hướng
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Xóa sinh viên thành công!';
            header('Location: student_management.php');
        } catch (Exception $e) {
            // Rollback giao dịch nếu có lỗi
            mysqli_rollback($conn);  // Dùng mysqli_rollback thay vì mysqli_roll_back

            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Đã xảy ra lỗi khi xóa sinh viên!';
            header('Location: student_management.php');
        }
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Không tìm thấy sinh viên này!';
        header('Location: student_management.php');
    }
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'MSSV không hợp lệ!';
    header('Location: student_management.php');
}

mysqli_close($conn);
?>
