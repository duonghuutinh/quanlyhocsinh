<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Lấy mã năm học từ URL
if (isset($_GET['maNamHoc'])) {
    $maNamHoc = $_GET['maNamHoc'];

    // Truy vấn để lấy thông tin năm học
    $sql = "SELECT * FROM namhoc WHERE maNamHoc = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maNamHoc);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $namHoc = $result->fetch_assoc();
    } else {
        echo "<script>alert('Năm học không tồn tại'); window.location.href = 'namhoc.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Không tìm thấy mã năm học'); window.location.href = 'namhoc.php';</script>";
    exit();
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Năm Học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="namhoc.php">Năm Học</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa Năm Học</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chỉnh Sửa Năm Học</h5>

                        <!-- Biểu mẫu chỉnh sửa Năm Học -->
                        <form action="edit_namhoc.php?maNamHoc=<?php echo $maNamHoc; ?>" method="POST">
                            <div class="row mb-3">
                                <label for="maNamHoc" class="col-sm-2 col-form-label">Mã Năm Học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maNamHoc" name="maNamHoc" value="<?php echo $namHoc['maNamHoc']; ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nienKhoa" class="col-sm-2 col-form-label">Niên Khoá</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nienKhoa" name="nienKhoa" value="<?php echo $namHoc['nienKhoa']; ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Cập Nhật Năm Học</button>
                                </div>
                            </div>
                        </form><!-- End Biểu mẫu chỉnh sửa Năm Học -->

                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    // Kiểm tra phương thức gửi biểu mẫu
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ biểu mẫu
        $nienKhoa = $_POST['nienKhoa'];

        // Câu lệnh SQL để cập nhật Năm Học
        $sql = "UPDATE namhoc SET nienKhoa = ? WHERE maNamHoc = ?";
        $stmt = $conn->prepare($sql);

        // Kiểm tra chuẩn bị câu lệnh SQL
        if ($stmt === false) {
            die("Lỗi chuẩn bị câu lệnh: " . $conn->error);
        }

        // Gán giá trị vào câu lệnh SQL
        $stmt->bind_param("ss", $nienKhoa, $maNamHoc);

        // Thực thi câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            echo "<script>alert('Cập nhật Năm Học thành công!'); window.location.href = 'namhoc.php';</script>";
        } else {
            echo "Lỗi khi cập nhật Năm Học: " . $stmt->error;
        }

        // Đóng câu lệnh và kết nối
        $stmt->close();
        $conn->close();
    }
    ?>

</main><!-- End #main -->

<?php include('partials/footer.php'); ?>
