<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Kiểm tra nếu `maGV` được truyền vào URL
if (isset($_GET['maGV'])) {
    $maGV = $_GET['maGV'];

    // Truy vấn thông tin giáo viên từ cơ sở dữ liệu
    $query = "SELECT * FROM giaovien WHERE maGV = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $maGV);
    $stmt->execute();
    $result = $stmt->get_result();
    $teacher = $result->fetch_assoc();

    if (!$teacher) {
        echo "Không tìm thấy giáo viên.";
        exit;
    }
} else {
    echo "Mã giáo viên không hợp lệ.";
    exit;
}

// Kiểm tra nếu form được submit để cập nhật thông tin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoTen = $_POST['hoTen'];
    $gioiTinh = $_POST['gioiTinh'];
    $ngaySinh = $_POST['ngaySinh'];
    $diaChi = $_POST['diaChi'];
    $SDT = $_POST['SDT'];
    $email = $_POST['email']; // Thêm email

    // Cập nhật thông tin giáo viên
    $update_query = "UPDATE giaovien SET hoTen = ?, gioiTinh = ?, ngaySinh = ?, diaChi = ?, SDT = ?, email = ? WHERE maGV = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssss", $hoTen, $gioiTinh, $ngaySinh, $diaChi, $SDT, $email, $maGV);

    if ($stmt->execute()) {
        echo "<script>alert('Chỉnh sửa thông tin giáo viên thành công!'); window.location.href = 'giaovien.php';</script>";
    } else {
        echo "Lỗi khi cập nhật thông tin giáo viên: " . $stmt->error;
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chỉnh Sửa Thông tin giáo viên</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="giaovien.php">Giáo viên</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa Thông tin giáo viên</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chỉnh Sửa Thông tin giáo viên</h5>

                        <form action="" method="POST">
                            <div class="row mb-3">
                                <label for="maGV" class="col-sm-2 col-form-label">Mã Giáo Viên</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maGV" name="maGV" value="<?php echo htmlspecialchars($teacher['maGV']); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="hoTen" class="col-sm-2 col-form-label">Họ Tên</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="hoTen" name="hoTen" value="<?php echo htmlspecialchars($teacher['hoTen']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="gioiTinh" class="col-sm-2 col-form-label">Giới Tính</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="gioiTinh" name="gioiTinh" required>
                                        <option value="" <?php echo $teacher['gioiTinh'] == '' ? 'selected' : ''; ?>>Chọn giới tính</option>
                                        <option value="Nam" <?php echo $teacher['gioiTinh'] == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                                        <option value="Nữ" <?php echo $teacher['gioiTinh'] == 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                                        <option value="Khác" <?php echo $teacher['gioiTinh'] == 'Khác' ? 'selected' : ''; ?>>Khác</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ngaySinh" class="col-sm-2 col-form-label">Ngày Sinh</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" value="<?php echo htmlspecialchars($teacher['ngaySinh']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="diaChi" class="col-sm-2 col-form-label">Địa Chỉ</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="diaChi" name="diaChi" rows="3" required><?php echo htmlspecialchars($teacher['diaChi']); ?></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="SDT" class="col-sm-2 col-form-label">Số Điện Thoại</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="SDT" name="SDT" pattern="[0-9]{10}" maxlength="10" value="<?php echo htmlspecialchars($teacher['SDT']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($teacher['email']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php include('partials/footer.php'); ?>
