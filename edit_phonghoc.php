<?php 
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Kiểm tra nếu `maPhong` được truyền vào URL
if (isset($_GET['maPhong'])) {
    $maPhong = $_GET['maPhong'];

    // Truy vấn thông tin M từ cơ sở dữ liệu
    $query = "SELECT * FROM phonghoc WHERE maPhong = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $maPhong);
    $stmt->execute();
    $result = $stmt->get_result();
    $phonghoc = $result->fetch_assoc();

    if (!$phonghoc) {
        echo "Không tìm thấy Phòng học.";
        exit;
    }
} else {
    echo "Mã Phòng không hợp lệ.";
    exit;
}

// Kiểm tra nếu form được submit để cập nhật thông tin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $soPhong = $_POST['soPhong'];
    $soChoToiDa = $_POST['soChoToiDa'];

    // Cập nhật thông tin M
    $update_query = "UPDATE phonghoc SET soPhong = ?, soChoToiDa = ? WHERE maPhong = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sss", $soPhong, $soChoToiDa, $maPhong);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thông tin Phòng học thành công!'); window.location.href = 'phonghoc.php';</script>";
    } else {
        echo "Lỗi khi cập nhật Phòng học: " . $stmt->error;
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chỉnh Sửa Thông Tin Phòng học</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="phonghoc.php">Phòng học</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa Thông Tin Phòng học</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chỉnh Sửa Thông Tin Phòng học</h5>

                        <!-- Form chỉnh sửa M -->
                        <form action="" method="POST">
                            <div class="row mb-3">
                                <label for="maPhong" class="col-sm-2 col-form-label">Mã Phòng học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maPhong" name="maPhong" value="<?php echo htmlspecialchars($phonghoc['maPhong']); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="soPhong" class="col-sm-2 col-form-label">Tên Phòng học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="soPhong" name="soPhong" value="<?php echo htmlspecialchars($phonghoc['soPhong']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="soChoToiDa" class="col-sm-2 col-form-label">Số chỗ tối đa</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="soChoToiDa" name="soChoToiDa" value="<?php echo htmlspecialchars($phonghoc['soChoToiDa']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                </div>
                            </div>
                        </form><!-- End Form chỉnh sửa Phòng học-->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php include('partials/footer.php'); ?>
