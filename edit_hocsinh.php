<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Kiểm tra nếu `maHS` và `nienKhoa` được truyền vào URL
if (isset($_GET['maHS']) && isset($_GET['nienKhoa'])) {
    $maHS = $_GET['maHS'];
    $nienKhoa = $_GET['nienKhoa'];

    // Truy vấn thông tin học sinh từ cơ sở dữ liệu
    $query = "SELECT * FROM hocsinh WHERE maHS = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $maHS);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!$student) {
        echo "Không tìm thấy học sinh.";
        exit;
    }
} else {
    echo "Mã học sinh không hợp lệ.";
    exit;
}

// Lấy thông tin lớp và năm học của học sinh
$sql_lop = "SELECT l.tenLop, l.maNamHoc FROM lop l WHERE l.maLop = ?";
$stmt_lop = $conn->prepare($sql_lop);
$stmt_lop->bind_param("s", $student['maLop']);
$stmt_lop->execute();
$result_lop = $stmt_lop->get_result();
$row_lop = $result_lop->fetch_assoc();
$maNamHoc = $row_lop['maNamHoc']; // Lấy mã năm học
$tenLop = $row_lop['tenLop']; // Lấy tên lớp

// Truy vấn danh sách năm học
$sql_namhoc = "SELECT maNamHoc, nienKhoa FROM namhoc";
$result_namhoc = $conn->query($sql_namhoc);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoTen = $_POST['hoTen'];
    $gioiTinh = $_POST['gioiTinh'];
    $ngaySinh = $_POST['ngaySinh'];
    $diaChi = $_POST['diaChi'];
    $sdtPH = $_POST['sdtPH'];
    $maLop = $_POST['maLop'];
    $maNamHoc = $_POST['maNamHoc'];

    // Kiểm tra xem lớp có thuộc năm học đã chọn không
    $sql_check_lop = "SELECT * FROM lop WHERE maLop = ? AND maNamHoc = ?";
    $stmt_check_lop = $conn->prepare($sql_check_lop);
    $stmt_check_lop->bind_param("ss", $maLop, $maNamHoc);
    $stmt_check_lop->execute();
    $result_check_lop = $stmt_check_lop->get_result();

    if ($result_check_lop->num_rows > 0) {
        // Cập nhật thông tin học sinh
        $update_query = "UPDATE hocsinh SET hoTen = ?, gioiTinh = ?, ngaySinh = ?, diaChi = ?, sdtPH = ?, maLop = ? WHERE maHS = ?";
        $stmt_update = $conn->prepare($update_query);
        $stmt_update->bind_param("sssssss", $hoTen, $gioiTinh, $ngaySinh, $diaChi, $sdtPH, $maLop, $maHS);

        if ($stmt_update->execute()) {
            echo "<script>alert('Chỉnh sửa thông tin học sinh thành công!'); window.location.href = 'hocsinh.php';</script>";
        } else {
            echo "Lỗi khi cập nhật học sinh: " . $stmt_update->error;
        }
    } else {
        echo "<script>alert('Lớp không thuộc năm học đã chọn. Vui lòng chọn lớp khác.');</script>";
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chỉnh Sửa Thông tin học sinh</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="hocsinh.php">Học sinh</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa Thông tin học sinh</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chỉnh Sửa Thông tin học sinh</h5>

                        <!-- Biểu mẫu sửa học sinh -->
                        <form action="" method="POST">
                            <div class="row mb-3">
                                <label for="maHS" class="col-sm-2 col-form-label">Mã học sinh</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maHS" name="maHS" value="<?php echo htmlspecialchars($student['maHS']); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="hoTen" class="col-sm-2 col-form-label">Họ Tên</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="hoTen" name="hoTen" value="<?php echo htmlspecialchars($student['hoTen']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="gioiTinh" class="col-sm-2 col-form-label">Giới Tính</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="gioiTinh" name="gioiTinh" required>
                                        <option value="">Chọn giới tính</option>
                                        <option value="Nam" <?php if ($student['gioiTinh'] == "Nam") echo "selected"; ?>>Nam</option>
                                        <option value="Nữ" <?php if ($student['gioiTinh'] == "Nữ") echo "selected"; ?>>Nữ</option>
                                        <option value="Khác" <?php if ($student['gioiTinh'] == "Khác") echo "selected"; ?>>Khác</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Năm học -->
                            <div class="row mb-3">
                                <label for="maNamHoc" class="col-sm-2 col-form-label">Năm học</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="maNamHoc" name="maNamHoc" required>
                                        <?php
                                        while ($row = $result_namhoc->fetch_assoc()) {
                                            $selected = ($row['maNamHoc'] == $maNamHoc) ? 'selected' : '';
                                            echo "<option value='" . $row['maNamHoc'] . "' $selected>" . $row['nienKhoa'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Lớp -->
                            <div class="row mb-3">
                                <label for="maLop" class="col-sm-2 col-form-label">Lớp</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="maLop" name="maLop" required>
                                        <!-- Hiển thị lớp hiện tại của học sinh và loại bỏ nó khỏi danh sách lớp -->
                                        <option value=''>Chọn Lớp</option>
                                        <option value="<?php echo $student['maLop']; ?>" selected><?php echo $tenLop; ?></option>
                                        
                                        <?php
                                        // Truy vấn để lấy danh sách lớp thuộc năm học đã chọn
                                        $sql_lop = "SELECT maLop, tenLop FROM lop WHERE maNamHoc = ?";
                                        $stmt_lop = $conn->prepare($sql_lop);
                                        $stmt_lop->bind_param("s", $maNamHoc);
                                        $stmt_lop->execute();
                                        $result_lop = $stmt_lop->get_result();
                                        while ($row = $result_lop->fetch_assoc()) {
                                            // Kiểm tra nếu lớp hiện tại không phải là lớp của học sinh
                                            if ($row['maLop'] != $student['maLop']) {
                                                echo "<option value='" . $row['maLop'] . "'>" . $row['tenLop'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="ngaySinh" class="col-sm-2 col-form-label">Ngày Sinh</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" value="<?php echo htmlspecialchars($student['ngaySinh']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="sdtPH" class="col-sm-2 col-form-label">Số Điện Thoại Phụ Huynh</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="sdtPH" name="sdtPH" pattern="[0-9]{10}" maxlength="10" value="<?php echo htmlspecialchars($student['sdtPH']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="diaChi" class="col-sm-2 col-form-label">Địa Chỉ</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="diaChi" name="diaChi" rows="3" required><?php echo htmlspecialchars($student['diaChi']); ?></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                </div>
                            </div>
                        </form><!-- End Biểu mẫu sửa học sinh -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<script>
    document.getElementById("maNamHoc").addEventListener("change", function() {
        const maNamHoc = this.value;
        fetchClasses(maNamHoc); // Gọi hàm cập nhật danh sách lớp
    });

    function fetchClasses(maNamHoc) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "get_lop.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const response = xhr.responseText;
                const classSelect = document.getElementById("maLop");
                classSelect.innerHTML = response; // Cập nhật lại danh sách lớp
            }
        };
        xhr.send("maNamHoc=" + encodeURIComponent(maNamHoc));
    }
</script>

<?php
include('partials/footer.php');
?>