<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Phòng Lớp</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Thêm Phòng Lớp</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thêm Phòng Lớp </h5>

                        <!-- Biểu mẫu thêm Phòng Lớp -->
                        <form action="add_phonglop.php" method="POST">
                            <div class="row mb-3">
                                <label for="maPhong" class="col-sm-2 col-form-label">Mã Phòng</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maPhong" name="maPhong" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="maLop" class="col-sm-2 col-form-label">Mã Lớp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maLop" name="maLop" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="hocKyNamHoc" class="col-sm-2 col-form-label">Học Kỳ Năm Học</label>
                                <div class="col-sm-10">
                                    <input type="TEXT" class="form-control" id="hocKyNamHoc" name="hocKyNamHoc" required>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Thêm Phòng Lớp</button>
                                </div>
                            </div>
                        </form><!-- End Biểu mẫu thêm Phòng Lớp -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
   
    // Kiểm tra phương thức gửi biểu mẫu
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ biểu mẫu
        $maPhong = $_POST['maPhong'];
        $maLop = $_POST['maLop'];
        $hocKyNamHoc = $_POST['hocKyNamHoc'];

        // Câu lệnh SQL để thêm Phòng Lớp vào bảng hocsinh
        $sql = "INSERT INTO phonglop (maPhong, maLop, hocKyNamHoc) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Kiểm tra chuẩn bị câu lệnh SQL
        if ($stmt === false) {
            die("Lỗi chuẩn bị câu lệnh: " . $conn->error);
        }

        // Gán giá trị vào câu lệnh SQL
        $stmt->bind_param("sss", $maPhong, $maLop, $hocKyNamHoc);

        // Thực thi câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            echo "<script>alert('Thêm Phòng Lớp thành công!'); window.location.href = 'phonglop.php';</script>";
        } else {
            echo "Lỗi khi thêm Phòng Lớp: " . $stmt->error;
        }

        // Đóng câu lệnh và kết nối
        $stmt->close();
        $conn->close();
    }
    ?>


</main><!-- End #main -->

<?php include('partials/footer.php'); ?>