<?php 
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Kiểm tra nếu `maMon` được truyền vào URL
if (isset($_GET['maMon'])) {
    $maMon = $_GET['maMon'];

    // Truy vấn thông tin M từ cơ sở dữ liệu
    $query = "SELECT * FROM monhoc WHERE maMon = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $maMon);
    $stmt->execute();
    $result = $stmt->get_result();
    $monhoc = $result->fetch_assoc();

    if (!$monhoc) {
        echo "Không tìm thấy Môn học.";
        exit;
    }
} else {
    echo "Mã Môn không hợp lệ.";
    exit;
}

// Kiểm tra nếu form được submit để cập nhật thông tin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenMonHoc = $_POST['tenMonHoc'];
    $khoi = $_POST['khoi'];

    // Cập nhật thông tin M
    $update_query = "UPDATE monhoc SET tenMonHoc = ?, khoi = ? WHERE maMon = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sss", $tenMonHoc, $khoi, $maMon);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thông tin Môn Học thành công!'); window.location.href = 'monhoc.php';</script>";
    } else {
        echo "Lỗi khi cập nhật Môn Học: " . $stmt->error;
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chỉnh Sửa Thông Tin Môn Học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa Thông Tin Môn Học</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chỉnh Sửa Thông Tin Môn Học</h5>

                        <!-- Form chỉnh sửa M -->
                        <form action="" method="POST">
                            <div class="row mb-3">
                                <label for="maMon" class="col-sm-2 col-form-label">Mã Môn Học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maMon" name="maMon" value="<?php echo htmlspecialchars($monhoc['maMon']); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="tenMonHoc" class="col-sm-2 col-form-label">Tên Môn Học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="tenMonHoc" name="tenMonHoc" value="<?php echo htmlspecialchars($monhoc['tenMonHoc']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="khoi" class="col-sm-2 col-form-label">Khối</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="khoi" name="khoi" value="<?php echo htmlspecialchars($monhoc['khoi']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                </div>
                            </div>
                        </form><!-- End Form chỉnh sửa Môn Học-->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php include('partials/footer.php'); ?>
