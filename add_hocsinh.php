<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Lấy danh sách lớp và năm học
$sql_lop = "SELECT maLop, tenLop FROM lop";
$result_lop = $conn->query($sql_lop);

$sql_namhoc = "SELECT maNamHoc, nienKhoa FROM namhoc";
$result_namhoc = $conn->query($sql_namhoc);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maHS = $_POST['maHS'];
    $hoTen = $_POST['hoTen'];
    $gioiTinh = $_POST['gioiTinh'];
    $ngaySinh = $_POST['ngaySinh'];
    $sdtPH = $_POST['sdtPH'];
    $maLop = $_POST['maLop'];
    $diaChi = $_POST['diaChi'];

    // Kiểm tra nếu mã học sinh đã tồn tại
    $check_query = "SELECT maHS FROM hocsinh WHERE maHS = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $maHS);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Mã Học Sinh đã tồn tại. Vui lòng nhập mã khác.'); window.location.href = 'add_hocsinh.php';</script>";
    } else {
        // Lấy số lượng học sinh trong lớp hiện tại
        $checkStudentQuery = $conn->prepare("SELECT COUNT(*) AS soSinhVien FROM hocSinh WHERE maLop = ?");
        $checkStudentQuery->bind_param("s", $maLop);
        $checkStudentQuery->execute();
        $studentResult = $checkStudentQuery->get_result();
        $studentRow = $studentResult->fetch_assoc();
        $soSinhVien = $studentRow['soSinhVien']; // Số lượng học sinh trong lớp

        // Lấy số chỗ tối đa của phòng học qua bảng phonglop
        $checkRoomCapacityQuery = $conn->prepare("SELECT ph.soChoToiDa 
                                                   FROM phonglop pl 
                                                   JOIN phonghoc ph ON pl.maPhong = ph.maPhong 
                                                   WHERE pl.maLop = ? AND pl.maPhong = ?");
        $checkRoomCapacityQuery->bind_param("ss", $maLop, $maPhong_new);
        $checkRoomCapacityQuery->execute();
        $roomCapacityResult = $checkRoomCapacityQuery->get_result();
        $roomCapacityRow = $roomCapacityResult->fetch_assoc();
        $soChoToiDa = $roomCapacityRow['soChoToiDa']; // Số chỗ tối đa của phòng học

        // Kiểm tra nếu số lượng học sinh vượt quá số chỗ tối đa của phòng học
        if ($soSinhVien > $soChoToiDa) {
            echo "<script>alert('Lớp đã đầy! Vui lòng chọn lớp khác.');window.location.href = 'add_hocsinh.php';</script>";
        } else {
            // Thêm học sinh mới nếu không trùng mã
            $sql = "INSERT INTO hocsinh (maHS, hoTen, gioiTinh, ngaySinh, diaChi, sdtPH, maLop) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $maHS, $hoTen, $gioiTinh, $ngaySinh, $diaChi, $sdtPH, $maLop);

            if ($stmt->execute()) {
                echo "<script>alert('Thêm Học Sinh thành công!'); window.location.href = 'hocsinh.php';</script>";
            } else {
                echo "Lỗi khi thêm Học Sinh: " . $stmt->error;
            }

            $stmt->close();
        }

        $check_stmt->close();
    }

    $conn->close();
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Học Sinh</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="hocsinh.php">Học sinh</a></li>
                <li class="breadcrumb-item active">Thêm Học Sinh</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thêm Học Sinh</h5>

                        <!-- Biểu mẫu thêm Học Sinh -->
                        <form action="" method="POST">
                            <!-- Năm học -->
                            <!-- Năm học -->


                            <!-- Mã Học Sinh -->
                            <div class="row mb-3">
                                <label for="maHS" class="col-sm-2 col-form-label">Mã Học Sinh</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maHS" name="maHS" value="<?php echo isset($_POST['maHS']) ? $_POST['maHS'] : ''; ?>" required>
                                </div>
                            </div>

                            <!-- Họ Tên -->
                            <div class="row mb-3">
                                <label for="hoTen" class="col-sm-2 col-form-label">Họ Tên</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="hoTen" name="hoTen" value="<?php echo isset($_POST['hoTen']) ? $_POST['hoTen'] : ''; ?>" required>
                                </div>
                            </div>

                            <!-- Giới Tính -->
                            <div class="row mb-3">
                                <label for="gioiTinh" class="col-sm-2 col-form-label">Giới Tính</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="gioiTinh" name="gioiTinh" required>
                                        <option value="">Chọn giới tính</option>
                                        <option value="Nam" <?php echo (isset($_POST['gioiTinh']) && $_POST['gioiTinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                        <option value="Nữ" <?php echo (isset($_POST['gioiTinh']) && $_POST['gioiTinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                                        <option value="Khác" <?php echo (isset($_POST['gioiTinh']) && $_POST['gioiTinh'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Năm học -->
                            <div class="row mb-3">
                                <label for="maNamHoc" class="col-sm-2 col-form-label">Năm học</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="maNamHoc" name="maNamHoc" onchange="getClasses(this.value)">
                                        <option value="">Chọn năm học</option>
                                        <?php while ($row = $result_namhoc->fetch_assoc()): ?>
                                            <option value="<?php echo $row['maNamHoc']; ?>" <?php echo (isset($_POST['maNamHoc']) && $_POST['maNamHoc'] == $row['maNamHoc']) ? 'selected' : ''; ?>>
                                                <?php echo $row['nienKhoa']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Lớp -->
                            <div class="row mb-3">
                                <label for="maLop" class="col-sm-2 col-form-label">Lớp</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="maLop" name="maLop" required>
                                        <option value="">Chọn Lớp</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Ngày Sinh -->
                            <div class="row mb-3">
                                <label for="ngaySinh" class="col-sm-2 col-form-label">Ngày Sinh</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" value="<?php echo isset($_POST['ngaySinh']) ? $_POST['ngaySinh'] : ''; ?>" required>
                                </div>
                            </div>

                            <!-- Số Điện Thoại Phụ Huynh -->
                            <div class="row mb-3">
                                <label for="sdtPH" class="col-sm-2 col-form-label">Số Điện Thoại Phụ Huynh</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="sdtPH" name="sdtPH" value="<?php echo isset($_POST['sdtPH']) ? $_POST['sdtPH'] : ''; ?>" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                </div>
                            </div>

                            <!-- Địa Chỉ -->
                            <div class="row mb-3">
                                <label for="diaChi" class="col-sm-2 col-form-label">Địa Chỉ</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="diaChi" name="diaChi" rows="3" required><?php echo isset($_POST['diaChi']) ? $_POST['diaChi'] : ''; ?></textarea>
                                </div>
                            </div>

                            <!-- Thêm Học Sinh -->
                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Thêm Học Sinh</button>
                                </div>
                            </div>

                        </form><!-- End Biểu mẫu thêm Học Sinh -->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
<script>
document.getElementById("maNamHoc").addEventListener("change", function() {
    const maNamHoc = this.value;
    if (maNamHoc) {
        fetchClasses(maNamHoc);
    } else {
        document.getElementById("maLop").innerHTML = "<option value=''>Chọn Lớp</option>";
    }
});

function fetchClasses(maNamHoc) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "get_lop.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("maLop").innerHTML = xhr.responseText;
        }
    };
    xhr.send("maNamHoc=" + encodeURIComponent(maNamHoc));
}
</script>
<?php include('partials/footer.php'); ?>


