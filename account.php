<!-- account.php -->

<?php include('includes/header.html'); ?>
<?php include('includes/sidebar.html'); ?>
<?php include('includes/headerbar.html'); ?>

<?php
// Kết nối cơ sở dữ liệu
include('db_connect.php');

// Số dòng mỗi trang
$rowsPerPage = 10;
if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}

// Tính vị trí của mẩu tin đầu tiên trên mỗi trang
$offset = ($_GET['page'] - 1) * $rowsPerPage;

$result = mysqli_query($conn, "SELECT * FROM user LIMIT $offset, $rowsPerPage");

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
            echo '<div class="notification" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb;">Thêm tài khoản thành công!</div>';
        } elseif ($_SESSION['status'] == 'error') {
            echo '<div class="notification" style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb;">Đã xảy ra lỗi khi thêm tài khoản!</div>';
        }

        // Xóa session status sau khi hiển thị thông báo
        unset($_SESSION['status']);
    }
    ?>

    <div class="filter-section">
        <input type="text" placeholder="Tên đăng nhập">
        <button id="addAccountBtn">Thêm tài khoản</button>
    </div>

    <!-- Modal Thêm Tài Khoản -->
    <div id="addAccountModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <h2>Thêm tài khoản</h2>
            <form action="account_create.php" method="POST">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" required><br><br>

                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required><br><br>

                <label for="role">Vai trò:</label>
                <select id="role" name="role" required>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select><br><br>

                <button type="submit">Lưu</button>
                <button type="button" id="cancelBtn">Hủy</button>
            </form>
        </div>
    </div>

    <table class="account-table">
        <thead>
            <tr>
                <th>Tên đăng nhập</th>
                <th>Mật khẩu</th>
                <th>Vai trò</th>
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
                    echo "<td>" . $row["Username"] . "</td>";
                    echo "<td>" . $row["PasswordUser"] . "</td>"; // Sửa tên cột mật khẩu
                    echo "<td>" . $row["Role"] . "</td>";
                    echo "<td>
                            <a href='change_account.php?username=" . $row['Username'] . "' class='edit-btn'>Sửa</a>
                            <a href='delete_account.php?username=" . $row['Username'] . "' class='delete-btn' onclick='return confirm(\"Bạn có chắc chắn muốn xóa tài khoản này?\")'>Xóa</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Không có tài khoản nào.</td></tr>";
            }

            ?>
        </tbody>
    </table>
    <?php
    // Đếm tổng số tài khoản
    $totalResult = mysqli_query($conn, 'SELECT * FROM user');
    $numRows = mysqli_num_rows($totalResult);

    // Tính tổng số trang
    $maxPage = floor($numRows / $rowsPerPage) + 1;

    // Hiển thị các liên kết phân trang
    echo "<p align='center'>";

    // Nút quay lại trang đầu tiên và trang trước
    if ($_GET['page'] > 1) {
        echo "<a href='account.php?page=1'><<</a> ";
        echo "<a href='account.php?page=" . ($_GET['page'] - 1) . "'> <</a> ";
    }

    // Hiển thị các số trang
    for ($i = 1; $i <= $maxPage; $i++) {
        if ($i == $_GET['page']) {
            echo '<b>' . $i . '</b> '; // trang hiện tại được bôi đậm
        } else {
            echo "<a href='account.php?page=" . $i . "'>" . $i . "</a> ";
        }
    }

    // Nút chuyển tới trang tiếp theo và trang cuối
    if ($_GET['page'] < $maxPage) {
        echo "<a href='account.php?page=" . ($_GET['page'] + 1) . "'> > </a>";
        echo "<a href='account.php?page=" . $maxPage . "'>>></a>";
    }

    echo "</p>";
    ?>
</div>

<?php
$conn->close();
include('includes/footer.html');
?>
