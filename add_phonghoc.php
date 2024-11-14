<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Phòng Học</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="phonghoc.php">Phòng học</a></li>
                <li class="breadcrumb-item active">Thêm Phòng Học</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thêm Phòng Học </h5>

                        <!-- Biểu mẫu thêm Phòng Học -->
                        <form action="add_phonghoc.php" method="POST">
                            <div class="row mb-3">
                                <label for="maPhong" class="col-sm-2 col-form-label">Mã Phòng Học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maPhong" name="maPhong" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="soPhong" class="col-sm-2 col-form-label">Số Phòng Học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="soPhong" name="soPhong" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="soChoToiDa" class="col-sm-2 col-form-label">Số chỗ tối đa</label>
                                <div class="col-sm-10">
                                    <input type="TEXT" class="form-control" id="soChoToiDa" name="soChoToiDa" required>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Thêm Phòng Học</button>
                                </div>
                            </div>
                        </form><!-- End Biểu mẫu thêm Phòng Học -->

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
        $soPhong = $_POST['soPhong'];
        $soChoToiDa = $_POST['soChoToiDa'];

        // Câu lệnh SQL để thêm Phòng Học vào bảng hocsinh
        $sql = "INSERT INTO phonghoc (maPhong, soPhong, soChoToiDa) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Kiểm tra chuẩn bị câu lệnh SQL
        if ($stmt === false) {
            die("Lỗi chuẩn bị câu lệnh: " . $conn->error);
        }

        // Gán giá trị vào câu lệnh SQL
        $stmt->bind_param("sss", $maPhong, $soPhong, $soChoToiDa);

        // Thực thi câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            echo "<script>alert('Thêm Phòng Học thành công!'); window.location.href = 'phonghoc.php';</script>";
        } else {
            echo "Lỗi khi thêm Phòng Học: " . $stmt->error;
        }

        // Đóng câu lệnh và kết nối
        $stmt->close();
        $conn->close();
    }
    ?>


</main><!-- End #main -->

<?php include('partials/footer.php'); ?>