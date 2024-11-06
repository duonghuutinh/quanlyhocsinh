<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Lớp</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Thêm Lớp</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thêm Lớp </h5>

                        <!-- Biểu mẫu thêm Lớp -->
                        <form action="add_lop.php" method="POST">
                            <div class="row mb-3">
                                <label for="maLop" class="col-sm-2 col-form-label">Mã Lớp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maLop" name="maLop" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="tenLop" class="col-sm-2 col-form-label">Tên Lớp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="tenLop" name="tenLop" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="nienKhoa" class="col-sm-2 col-form-label">Niên Khoá</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nienKhoa" name="nienKhoa" required>
                                </div>
                            </div>
                            </div>
                           

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Thêm Lớp</button>
                                </div>
                            </div>
                        </form><!-- End Biểu mẫu thêm Lớp -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
   
    // Kiểm tra phương thức gửi biểu mẫu
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ biểu mẫu
        $maLop = $_POST['maLop'];
        $tenLop = $_POST['tenLop'];
        $nienKhoa = $_POST['nienKhoa'];
        // Câu lệnh SQL để thêm Lớp vào bảng lop
        $sql = "INSERT INTO lop (maLop, tenLop, nienKhoa) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Kiểm tra chuẩn bị câu lệnh SQL
        if ($stmt === false) {
            die("Lỗi chuẩn bị câu lệnh: " . $conn->error);
        }

        // Gán giá trị vào câu lệnh SQL
        $stmt->bind_param("sss", $maLop, $tenLop, $nienKhoa);

        // Thực thi câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            echo "<script>alert('Thêm Lớp thành công!'); window.location.href = 'lop.php';</script>";
        } else {
            echo "Lỗi khi thêm Lớp: " . $stmt->error;
        }

        // Đóng câu lệnh và kết nối
        $stmt->close();
        $conn->close();
    }
    ?>


</main><!-- End #main -->

<?php include('partials/footer.php'); ?>