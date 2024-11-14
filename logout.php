<?php
session_start();
// Xóa tất cả dữ liệu của phiên làm việc
session_unset();
session_destroy();

// Chuyển hướng đến trang đăng nhập với thông báo thành công
header("Location: login.php?message=logout_success");
exit();
?>
