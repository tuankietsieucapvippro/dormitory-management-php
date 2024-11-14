<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <title>Login</title>
</head>

<?php
session_start(); // Bắt đầu phiên làm việc

$conn = mysqli_connect('localhost', 'root', '', 'qlktx') 
    OR die('Could not connect to MySQL: ' . mysqli_connect_error());

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $passworduser = mysqli_real_escape_string($conn, $_POST['passworduser']);
    
    // Lấy vai trò (Role) của người dùng cùng với tên đăng nhập (Username)
    $sql = "SELECT Username, Role, UserID FROM user WHERE Username='$username' AND PasswordUser='$passworduser' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['Username'] = $row['Username']; // Lưu tên người dùng vào phiên
        $_SESSION['Role'] = $row['Role']; // Lưu vai trò người dùng vào phiên
        $_SESSION['UserID'] = $row['UserID']; // Lưu UserID vào phiên

        // Kiểm tra UserID để lấy thông tin từ bảng thích hợp
        if (substr($row['UserID'], 0, 2) == 'sv') {
            // Nếu UserID bắt đầu bằng "sv", lấy dữ liệu từ bảng sinhvien
            $sql_sinhvien = "SELECT * FROM sinhvien WHERE TaiKhoanID='{$row['UserID']}' LIMIT 1";
            $result_sinhvien = mysqli_query($conn, $sql_sinhvien);
            
            if ($result_sinhvien && mysqli_num_rows($result_sinhvien) > 0) {
                $sinhvien_data = mysqli_fetch_assoc($result_sinhvien);
                $_SESSION['SinhVien'] = $sinhvien_data; // Lưu thông tin sinh viên vào phiên
            } else {
                $message = "Sinh viên không tồn tại hoặc lỗi khi lấy thông tin sinh viên.";
            }

            header("Location: index.php"); // Chuyển hướng tới trang index.php nếu là User (Sinh viên)
            exit();
        }   elseif (substr($row['UserID'], 0, 2) == 'nv') {
                // Nếu UserID bắt đầu bằng "nv", lấy dữ liệu từ bảng nhanvien
                $sql_nhanvien = "SELECT * FROM nhanvien WHERE UserID='{$row['UserID']}' LIMIT 1";
                $result_nhanvien = mysqli_query($conn, $sql_nhanvien);

                if ($result_nhanvien && mysqli_num_rows($result_nhanvien) > 0) {
                    $nhanvien_data = mysqli_fetch_assoc($result_nhanvien);
                    $_SESSION['NhanVien'] = $nhanvien_data; // Lưu thông tin nhân viên vào phiên
                } else {
                    $message = "Nhân viên không tồn tại hoặc lỗi khi lấy thông tin nhân viên.";
                }

                header("Location: student.php"); // Chuyển hướng tới trang student.php nếu là Admin (Nhân viên)
                exit();
            } else {
                $message = "Unrecognized role or ID.";
            }
    } else {
        $message = "Invalid username or password";
    }
}

mysqli_close($conn);
?>




<body>
    <div class="limiter">
		<div class="background" style="background-image: url('background1.jpg');">
			<div class="main">
				<form action="" method="post">
					<span>
						<h1 style="padding-bottom: 20px;">Login</h1> 
					</span>

                    <!-- Thông báo lỗi nếu có -->
                    <?php if (!empty($message)) { ?>
                        <div class="error-message" style="color: red; font-size: 14px; margin-bottom: 15px;">
                            <?php echo $message; ?>
                        </div>
                    <?php } ?>

					<div class="input" data-validate="Username is required">
                        <span class="input-label">Username</span>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="far fa-user"></i></span>
                            <input class="input-field" type="text" name="username" placeholder="Type your username">
                        </div>
                    </div>
                    

					<div class="input" data-validate="PasswordUser is required">
						<span class="input-label">PasswordUser</span>
						<div class="input-wrapper">
                            <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                            <input class="input-field" type="password" name="passworduser" placeholder="Type your PasswordUser">
                        </div>
					</div>
					
					<div class="forgot">
						<a href="#">
							Forgot PasswordUser?
						</a>
					</div>
					
					<div class="">
						<div class="">
							<div class=""></div>
							<button type="submit" class="">
								Login
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
</body>
</html>

</html>