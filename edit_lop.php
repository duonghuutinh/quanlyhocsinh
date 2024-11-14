<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Kiểm tra nếu `maLop` được truyền vào URL
if (isset($_GET['maLop'])) {
    $maLop = $_GET['maLop'];

    // Truy vấn thông tin lớp từ cơ sở dữ liệu
    $query = "SELECT * FROM lop WHERE maLop = ?";
    $stmt = $conn->prepare($query);

    // Kiểm tra lỗi trong việc chuẩn bị truy vấn
    if (!$stmt) {
        echo "Lỗi trong việc chuẩn bị truy vấn: " . $conn->error;
        exit;
    }

    $stmt->bind_param("s", $maLop);
    $stmt->execute();
    $result = $stmt->get_result();
    $lop = $result->fetch_assoc();

    // Kiểm tra nếu lớp không tồn tại
    if (!$lop) {
        echo "Không tìm thấy lớp.";
        exit;
    }

    // Truy vấn thông tin niên khoá (năm học) từ bảng namhoc
    $maNamHoc = $lop['maNamHoc'];
    $query_namhoc = "SELECT * FROM namhoc WHERE maNamHoc = ?";
    $stmt_namhoc = $conn->prepare($query_namhoc);
    $stmt_namhoc->bind_param("s", $maNamHoc);
    $stmt_namhoc->execute();
    $result_namhoc = $stmt_namhoc->get_result();
    $namhoc = $result_namhoc->fetch_assoc();

    // Kiểm tra nếu niên khoá không tồn tại
    if (!$namhoc) {
        echo "Không tìm thấy niên khoá.";
        exit;
    }
} else {
    echo "Mã lớp không hợp lệ.";
    exit;
}

// Kiểm tra nếu form được submit để cập nhật thông tin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenLop = $_POST['tenLop'];
    $maNamHoc = $_POST['maNamHoc']; // Chọn maNamHoc thay vì nienKhoa

    // Kiểm tra nếu lớp với tên và niên khoá này đã tồn tại
    $check_query = "SELECT * FROM lop WHERE tenLop = ? AND maNamHoc = ? AND maLop != ?";
    $stmt_check = $conn->prepare($check_query);

    // Kiểm tra lỗi trong việc chuẩn bị truy vấn
    if (!$stmt_check) {
        echo "Lỗi trong việc chuẩn bị truy vấn kiểm tra: " . $conn->error;
        exit;
    }

    $stmt_check->bind_param("sss", $tenLop, $maNamHoc, $maLop);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Nếu lớp với tên và niên khoá đã tồn tại
        echo "<script>alert('Lớp với tên và niên khoá này đã tồn tại. Vui lòng nhập lại thông tin khác.');</script>";
    } else {
        // Cập nhật thông tin lớp
        $update_query = "UPDATE lop SET tenLop = ?, maNamHoc = ? WHERE maLop = ?";
        $stmt_update = $conn->prepare($update_query);

        // Kiểm tra lỗi trong việc chuẩn bị truy vấn cập nhật
        if (!$stmt_update) {
            echo "Lỗi trong việc chuẩn bị truy vấn cập nhật: " . $conn->error;
            exit;
        }

        $stmt_update->bind_param("sss", $tenLop, $maNamHoc, $maLop);

        if ($stmt_update->execute()) {
            echo "<script>alert('Cập nhật thông tin lớp thành công!'); window.location.href = 'lop.php';</script>";
        } else {
            echo "Lỗi khi cập nhật lớp: " . $stmt_update->error;
        }
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chỉnh Sửa Thông Tin Lớp</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="lop.php">Lớp</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa Thông Tin Lớp</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chỉnh Sửa Thông Tin Lớp</h5>

                        <!-- Form chỉnh sửa lớp -->
                        <form action="" method="POST">
                            <div class="row mb-3">
                                <label for="maLop" class="col-sm-2 col-form-label">Mã Lớp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maLop" name="maLop" value="<?php echo htmlspecialchars($lop['maLop']); ?>" readonly required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="tenLop" class="col-sm-2 col-form-label">Tên Lớp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="tenLop" name="tenLop" value="<?php echo htmlspecialchars($lop['tenLop']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="maNamHoc" class="col-sm-2 col-form-label">Niên Khóa</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="maNamHoc" name="maNamHoc" required>
                                        <option value="">Chọn Niên Khóa</option>
                                        <?php
                                        // Truy vấn các niên khoá có sẵn
                                        $query_namhoc = "SELECT * FROM namhoc";
                                        $stmt_namhoc = $conn->prepare($query_namhoc);
                                        $stmt_namhoc->execute();
                                        $result_namhoc = $stmt_namhoc->get_result();

                                        while ($row_namhoc = $result_namhoc->fetch_assoc()) {
                                            $selected = ($lop['maNamHoc'] == $row_namhoc['maNamHoc']) ? 'selected' : '';
                                            echo "<option value='" . $row_namhoc['maNamHoc'] . "' $selected>" . $row_namhoc['nienKhoa'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                </div>
                            </div>
                        </form><!-- End Form chỉnh sửa lớp -->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php include('partials/footer.php'); ?>
