<?php  
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Kiểm tra nếu `maPhong` được truyền vào URL
if (isset($_GET['maPhong'])) {
    $maPhong = $_GET['maPhong'];

    // Truy vấn thông tin từ cơ sở dữ liệu
    $query = "SELECT * FROM phonglop WHERE maPhong = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $maPhong);
    $stmt->execute();
    $result = $stmt->get_result();
    $phonglop = $result->fetch_assoc();

    if (!$phonglop) {
        echo "Không tìm thấy Phòng lớp.";
        exit;
    }
} else {
    echo "Mã Phòng không hợp lệ.";
    exit;
}

// Kiểm tra nếu form được submit để cập nhật thông tin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maLop = $_POST['maLop'];
    $hocKyNamHoc = $_POST['hocKyNamHoc'];

    // Cập nhật thông tin
    $update_query = "UPDATE phonglop SET maLop = ?, hocKyNamHoc = ? WHERE maPhong = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sss", $maLop, $hocKyNamHoc, $maPhong);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thông tin Phòng lớp thành công!'); window.location.href = 'phonglop.php';</script>";
    } else {
        echo "Lỗi khi cập nhật Phòng lớp: " . $stmt->error;
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chỉnh Sửa Thông Tin Phòng lớp</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa Thông Tin Phòng lớp</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chỉnh Sửa Thông Tin Phòng lớp</h5>

                        <!-- Form chỉnh sửa -->
                        <form action="" method="POST">
                            <div class="row mb-3">
                                <label for="maPhong" class="col-sm-2 col-form-label">Mã Phòng lớp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maPhong" name="maPhong" value="<?php echo htmlspecialchars($phonglop['maPhong']); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="maLop" class="col-sm-2 col-form-label">Mã Lớp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maLop" name="maLop" value="<?php echo htmlspecialchars($phonglop['maLop']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="hocKyNamHoc" class="col-sm-2 col-form-label">Học Kỳ Năm Học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="hocKyNamHoc" name="hocKyNamHoc" value="<?php echo htmlspecialchars($phonglop['hocKyNamHoc']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                </div>
                            </div>
                        </form><!-- End Form chỉnh sửa Phòng lớp -->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php include('partials/footer.php'); ?>
