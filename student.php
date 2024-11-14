<!-- student_management.php -->

<?php include('includes/header.html'); ?>
<?php include('includes/sidebar.html'); ?>
<?php include('includes/headerbar.html'); ?>

<?php
// Kết nối cơ sở dữ liệu
include('db_connect.php');

// // Truy vấn lấy thông tin sinh viên
// $sql = "SELECT * FROM SinhVien"; // Lấy tất cả các sinh viên
// $result = $conn->query($sql);

// Số dòng mỗi trang
$rowsPerPage = 10;
if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}

// Tính vị trí của mẩu tin đầu tiên trên mỗi trang
$offset = ($_GET['page'] - 1) * $rowsPerPage;

$result = mysqli_query($conn, "SELECT * FROM SinhVien LIMIT $offset, $rowsPerPage");

?>

<?php
session_start(); // Bắt đầu phiên làm việc

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['Username'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: login.php");
    exit();
}
?>


<div class="main-content">
    <?php

    if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] == 'success') {
            echo '<div class="notification" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb;">Thêm sinh viên thành công!</div>';
        } elseif ($_SESSION['status'] == 'error') {
            echo '<div class="notification" style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb;">Đã xảy ra lỗi khi thêm sinh viên!</div>';
        }

        // Xóa session status sau khi hiển thị thông báo
        unset($_SESSION['status']);
    }
    ?>
    <div class="filter-section">
        <label for="building">Tòa nhà:</label>
        <select id="building">
            <option value="all">Tất cả</option>
            <!-- Thêm các option khác -->
        </select>

        <label for="room">Phòng:</label>
        <select id="room">
            <option value="all">Tất cả</option>
            <!-- Thêm các option khác -->
        </select>

        <input type="text" placeholder="Họ và tên">
        <input type="text" placeholder="MSSV">
        <button id="addStudentBtn">Thêm sinh viên</button>
    </div>

    <!-- Modal Thêm Sinh Viên -->
    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <h2>Thêm sinh viên</h2>
            <form action="student_create.php" method="POST">
                <label for="hoSV">Họ và tên:</label>
                <input type="text" id="hoSV" name="hoSV" required><br><br>

                <label for="tenSV">Tên:</label>
                <input type="text" id="tenSV" name="tenSV" required><br><br>

                <label for="mssv">MSSV:</label>
                <input type="text" id="mssv" name="mssv" required><br><br>

                <label for="lop">Lớp:</label>
                <input type="text" id="lop" name="lop" required><br><br>

                <label for="gioiTinh">Giới tính:</label>
                <select id="gioiTinh" name="gioiTinh" required>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="soDienThoai">Số điện thoại:</label>
                <input type="text" id="soDienThoai" name="soDienThoai" required><br><br>

                <button type="submit">Lưu</button>
                <button type="button" id="cancelBtn">Hủy</button>
            </form>
        </div>
    </div>

    <table class="student-table">
        <thead>
            <tr>
                <th>Họ và tên</th>
                <th>MSSV</th>
                <th>Giới tính</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Kiểm tra nếu có kết quả
            if ($result->num_rows > 0) {
                // Lặp qua các bản ghi
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["HoSV"] . " " . $row["TenSV"] . "</td>";
                    echo "<td>" . $row["MSSV"] . "</td>";
                    echo "<td>" . $row["GioiTinh"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>" . $row["SoDienThoai"] . "</td>";
                    echo "<td>" . $row["DiaChi"] . "</td>";
                    echo "<td>
                            <a href='change_inf.php?mssv=" . $row['MSSV'] . "' class='edit-btn'>Sửa</a>
                            <a href='delete_student.php?mssv=" . $row['MSSV'] . "' class='delete-btn' onclick='return confirm(\"Bạn có chắc chắn muốn xóa sinh viên này?\")'>Xóa</a>
                            <a href='detail.php?mssv=" . $row['MSSV'] . "' class='detail-btn'>Chi tiết</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Không có sinh viên nào.</td></tr>";
            }

            ?>
        </tbody>
    </table>
    <?php
    // Đếm tổng số sinh viên
    $totalResult = mysqli_query($conn, 'SELECT * FROM SinhVien');
    $numRows = mysqli_num_rows($totalResult);

    // Tính tổng số trang
    $maxPage = floor($numRows / $rowsPerPage) + 1;


    // Hiển thị các liên kết phân trang
    echo "<p align='center'>";

    // Nút quay lại trang đầu tiên và trang trước
    if ($_GET['page'] > 1) {
        echo "<a href='student.php?page=1'><<</a> ";
        echo "<a href='student.php?page=" . ($_GET['page'] - 1) . "'> <</a> ";
    }

    // Hiển thị các số trang
    for ($i = 1; $i <= $maxPage; $i++) {
        if ($i == $_GET['page']) {
            echo '<b>' . $i . '</b> '; // trang hiện tại được bôi đậm
        } else {
            echo "<a href='student.php?page=" . $i . "'>" . $i . "</a> ";
        }
    }

    // Nút chuyển tới trang tiếp theo và trang cuối
    if ($_GET['page'] < $maxPage) {
        echo "<a href='student.php?page=" . ($_GET['page'] + 1) . "'> > </a>";
        echo "<a href='student.php?page=" . $maxPage . "'>>></a>";
    }

    echo "</p>";
    ?>
</div>

<?php
$conn->close();
include('includes/footer.html');
?>