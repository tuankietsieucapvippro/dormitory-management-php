<!-- room.php -->

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

$result = mysqli_query($conn, "
    SELECT 
        phong.PhongID, 
        phong.TenPhong, 
        toanha.TenToaNha, 
        loaiphong.TenLoaiPhong, 
        loaiphong.DonGia, 
        phong.SoLuongGiuong, 
        COUNT(sinhvien.SinhVienID) as SoNguoiDangO 
    FROM 
        phong 
    LEFT JOIN 
        toanha ON phong.ToaNhaID = toanha.ToaNhaID 
    LEFT JOIN 
        loaiphong ON phong.LoaiPhongID = loaiphong.LoaiPhongID 
    LEFT JOIN 
        sinhvien ON phong.PhongID = sinhvien.PhongID 
    GROUP BY 
        phong.PhongID 
    LIMIT $offset, $rowsPerPage
");

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
            echo '<div class="notification" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb;">Thêm phòng thành công!</div>';
        } elseif ($_SESSION['status'] == 'error') {
            echo '<div class="notification" style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb;">Đã xảy ra lỗi khi thêm phòng!</div>';
        }

        // Xóa session status sau khi hiển thị thông báo
        unset($_SESSION['status']);
    }
    ?>

    <div class="filter-section">
        <input type="text" placeholder="Tên phòng">
        <button id="addRoomBtn">Thêm phòng</button>
    </div>

    <!-- Modal Thêm Phòng -->
    <div id="addRoomModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <h2>Thêm phòng</h2>
            <form action="room_create.php" method="POST">
                <label for="tenPhong">Tên phòng:</label>
                <input type="text" id="tenPhong" name="tenPhong" required><br><br>

                <label for="toaNha">Tòa nhà:</label>
                <select id="toaNha" name="toaNha" required>
                    <?php
                    $buildings = mysqli_query($conn, "SELECT * FROM toanha");
                    while ($building = mysqli_fetch_assoc($buildings)) {
                        echo "<option value='{$building['ToaNhaID']}'>{$building['TenToaNha']}</option>";
                    }
                    ?>
                </select><br><br>

                <label for="loaiPhong">Loại phòng:</label>
                <select id="loaiPhong" name="loaiPhong" required>
                    <?php
                    $room_types = mysqli_query($conn, "SELECT * FROM loaiphong");
                    while ($room_type = mysqli_fetch_assoc($room_types)) {
                        echo "<option value='{$room_type['LoaiPhongID']}'>{$room_type['TenLoaiPhong']} ({$room_type['DonGia']})</option>";
                    }
                    ?>
                </select><br><br>

                <label for="soLuongGiuong">Số lượng giường:</label>
                <input type="text" id="soLuongGiuong" name="soLuongGiuong" required><br><br>

                <button type="submit">Lưu</button>
                <button type="button" id="cancelBtn">Hủy</button>
            </form>
        </div>
    </div>

    <table class="room-table">
        <thead>
            <tr>
                <th>Tên phòng</th>
                <th>Tòa nhà</th>
                <th>Loại phòng</th>
                <th>Đơn giá</th>
                <th>Số lượng giường</th>
                <th>Số người đang ở</th>
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
                    echo "<td>" . $row["TenPhong"] . "</td>";
                    echo "<td>" . $row["TenToaNha"] . "</td>";
                    echo "<td>" . $row["TenLoaiPhong"] . "</td>";
                    echo "<td>" . $row["DonGia"] . "</td>";
                    echo "<td>" . $row["SoLuongGiuong"] . "</td>";
                    echo "<td>" . $row["SoNguoiDangO"] . "</td>";
                    echo "<td>
                            <a href='change_room.php?PhongID=" . $row['PhongID'] . "' class='edit-btn'>Sửa</a>
                            <a href='delete_room.php?PhongID=" . $row['PhongID'] . "' class='delete-btn' onclick='return confirm(\"Bạn có chắc chắn muốn xóa phòng này?\")'>Xóa</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Không có phòng nào.</td></tr>";
            }

            ?>
        </tbody>
    </table>
    <?php
    // Đếm tổng số phòng
    $totalResult = mysqli_query($conn, 'SELECT * FROM phong');
    $numRows = mysqli_num_rows($totalResult);

    // Tính tổng số trang
    $maxPage = floor($numRows / $rowsPerPage) + 1;

    // Hiển thị các liên kết phân trang
    echo "<p align='center'>";

    // Nút quay lại trang đầu tiên và trang trước
    if ($_GET['page'] > 1) {
        echo "<a href='room.php?page=1'><<</a> ";
        echo "<a href='room.php?page=" . ($_GET['page'] - 1) . "'> <</a> ";
    }

    // Hiển thị các số trang
    for ($i = 1; $i <= $maxPage; $i++) {
        if ($i == $_GET['page']) {
            echo '<b>' . $i . '</b> '; // trang hiện tại được bôi đậm
        } else {
            echo "<a href='room.php?page=" . $i . "'>" . $i . "</a> ";
        }
    }

    // Nút chuyển tới trang tiếp theo và trang cuối
    if ($_GET['page'] < $maxPage) {
        echo "<a href='room.php?page=" . ($_GET['page'] + 1) . "'> > </a>";
        echo "<a href='room.php?page=" . $maxPage . "'>>></a>";
    }

    echo "</p>";
    ?>
</div>

<?php
$conn->close();
include('includes/footer.html');
?>
