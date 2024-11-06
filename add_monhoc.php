<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Môn Học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Thêm Môn Học</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thêm Môn Học </h5>

                        <!-- Biểu mẫu thêm Môn Học -->
                        <form action="add_monhoc.php" method="POST">
                            <div class="row mb-3">
                                <label for="maMon" class="col-sm-2 col-form-label">Mã Môn Học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maMon" name="maMon" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="tenMonhoc" class="col-sm-2 col-form-label">Tên Môn Học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="tenMonhoc" name="tenMonHoc" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="khoi" class="col-sm-2 col-form-label">Khối</label>
                                <div class="col-sm-10">
                                    <input type="TEXT" class="form-control" id="khoi" name="khoi" required>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Thêm Môn Học</button>
                                </div>
                            </div>
                        </form><!-- End Biểu mẫu thêm Môn Học -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
   
    // Kiểm tra phương thức gửi biểu mẫu
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ biểu mẫu
        $maMon = $_POST['maMon'];
        $tenMonHoc = $_POST['tenMonHoc'];
        $khoi = $_POST['khoi'];

        // Câu lệnh SQL để thêm Môn Học vào bảng hocsinh
        $sql = "INSERT INTO monhoc (maMon, tenMonHoc, khoi) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Kiểm tra chuẩn bị câu lệnh SQL
        if ($stmt === false) {
            die("Lỗi chuẩn bị câu lệnh: " . $conn->error);
        }

        // Gán giá trị vào câu lệnh SQL
        $stmt->bind_param("sss", $maMon, $tenMonHoc, $khoi);

        // Thực thi câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            echo "<script>alert('Thêm Môn Học thành công!'); window.location.href = 'monhoc.php';</script>";
        } else {
            echo "Lỗi khi thêm Môn Học: " . $stmt->error;
        }

        // Đóng câu lệnh và kết nối
        $stmt->close();
        $conn->close();
    }
    ?>


</main><!-- End #main -->

<?php include('partials/footer.php'); ?>