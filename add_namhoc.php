<?php 
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Năm Học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Thêm Năm Học</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thêm Năm Học</h5>

                        <!-- Biểu mẫu thêm Năm Học -->
                        <form action="add_namhoc.php" method="POST">
                            <div class="row mb-3">
                                <label for="maNamHoc" class="col-sm-2 col-form-label">Mã Năm Học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maNamHoc" name="maNamHoc" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nienKhoa" class="col-sm-2 col-form-label">Niên Khoá</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nienKhoa" name="nienKhoa" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Thêm Năm Học</button>
                                </div>
                            </div>
                        </form><!-- End Biểu mẫu thêm Năm Học -->

                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    // Kiểm tra phương thức gửi biểu mẫu
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ biểu mẫu
        $maNamHoc = $_POST['maNamHoc'];
        $nienKhoa = $_POST['nienKhoa'];

        // Câu lệnh SQL để thêm Năm Học vào bảng namhoc
        $sql = "INSERT INTO namhoc (maNamHoc, nienKhoa) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        // Kiểm tra chuẩn bị câu lệnh SQL
        if ($stmt === false) {
            die("Lỗi chuẩn bị câu lệnh: " . $conn->error);
        }

        // Gán giá trị vào câu lệnh SQL
        $stmt->bind_param("ss", $maNamHoc, $nienKhoa);

        // Thực thi câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            echo "<script>alert('Thêm Năm Học thành công!'); window.location.href = 'namhoc.php';</script>";
        } else {
            echo "Lỗi khi thêm Năm Học: " . $stmt->error;
        }

        // Đóng câu lệnh và kết nối
        $stmt->close();
        $conn->close();
    }
    ?>

</main><!-- End #main -->

<?php include('partials/footer.php'); ?>
