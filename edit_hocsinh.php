<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Kiểm tra nếu `maHS` được truyền vào URL
if (isset($_GET['maHS'])) {
    $maHS = $_GET['maHS'];

    // Truy vấn thông tin học sinh từ cơ sở dữ liệu
    $query = "SELECT * FROM hocsinh WHERE maHS = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $maHS);
    $stmt->execute();
    $result = $stmt->get_result();
    $teacher = $result->fetch_assoc();

    if (!$teacher) {
        echo "Không tìm thấy học sinh.";
        exit;
    }
} else {
    echo "Mã học sinh không hợp lệ.";
    exit;
}

// Kiểm tra nếu form được submit để cập nhật thông tin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoTen = $_POST['hoTen'];
    $ngaySinh = $_POST['ngaySinh'];
    $diaChi = $_POST['diaChi'];
    $sdtPH = $_POST['sdtPH'];
    $maLop = $_POST['maLop'];

    // Cập nhật thông tin học sinh
    $update_query = "UPDATE hocsinh SET hoTen = ?, ngaySinh = ?, diaChi = ?, sdtPH = ? , maLop = ? WHERE maHS = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssss", $hoTen, $ngaySinh, $diaChi, $sdtPH, $maHS , $maLop);

    if ($stmt->execute()) {
        echo "<script>alert('Chỉnh sửa thông tin học sinh thành công!'); window.location.href = 'hocsinh.php';</script>";
    } else {
        echo "Lỗi khi thêm học sinh: " . $stmt->error;
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chỉnh Sửa Thông tin học sinh</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
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
                                    <input type="text" class="form-control" id="maHS" name="maHS" value="<?php echo htmlspecialchars($teacher['maHS']); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="hoTen" class="col-sm-2 col-form-label">Họ Tên</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="hoTen" name="hoTen" value="<?php echo htmlspecialchars($teacher['hoTen']); ?>" required>
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
                                <label for="sdtPH" class="col-sm-2 col-form-label">Số Điện Thoại Phụ Huynh</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="sdtPH" name="sdtPH" pattern="[0-9]{10}" maxlength="10" value="<?php echo htmlspecialchars($teacher['sdtPH']); ?>" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="maLop" class="col-sm-2 col-form-label">Mã Lớp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maLop" name="maLop" value="<?php echo htmlspecialchars($teacher['maLop']); ?>" readonly>
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

<?php include('partials/footer.php'); ?>
