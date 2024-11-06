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
    $stmt->bind_param("s", $maLop);
    $stmt->execute();
    $result = $stmt->get_result();
    $lop = $result->fetch_assoc();

    if (!$lop) {
        echo "Không tìm thấy lớp.";
        exit;
    }
} else {
    echo "Mã lớp không hợp lệ.";
    exit;
}

// Kiểm tra nếu form được submit để cập nhật thông tin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenLop = $_POST['tenLop'];
    $nienKhoa = $_POST['nienKhoa'];

    // Cập nhật thông tin lớp
    $update_query = "UPDATE lop SET tenLop = ?, nienKhoa = ? WHERE maLop = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sss", $tenLop, $nienKhoa, $maLop);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thông tin lớp thành công!'); window.location.href = 'lop.php';</script>";
    } else {
        echo "Lỗi khi cập nhật lớp: " . $stmt->error;
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chỉnh Sửa Thông Tin Lớp</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
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
                                    <input type="text" class="form-control" id="maLop" name="maLop" value="<?php echo htmlspecialchars($lop['maLop']); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="tenLop" class="col-sm-2 col-form-label">Tên Lớp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="tenLop" name="tenLop" value="<?php echo htmlspecialchars($lop['tenLop']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nienKhoa" class="col-sm-2 col-form-label">Niên Khóa</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nienKhoa" name="nienKhoa" value="<?php echo htmlspecialchars($lop['nienKhoa']); ?>" required>
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
