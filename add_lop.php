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
                        <h5 class="card-title">Thêm Lớp</h5>

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

        // Kiểm tra xem mã lớp đã tồn tại trong cơ sở dữ liệu
        $sql_check = "SELECT * FROM lop WHERE maLop = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $maLop);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            // Nếu mã lớp đã tồn tại
            echo "<script>alert('Mã lớp này đã tồn tại. Vui lòng nhập mã lớp khác.');</script>";
        } else {
            // Kiểm tra xem lớp với tên và niên khoá có trùng không
            $sql_check_name = "SELECT * FROM lop WHERE tenLop = ? AND nienKhoa = ?";
            $stmt_check_name = $conn->prepare($sql_check_name);
            $stmt_check_name->bind_param("ss", $tenLop, $nienKhoa);
            $stmt_check_name->execute();
            $result_check_name = $stmt_check_name->get_result();

            if ($result_check_name->num_rows > 0) {
                // Nếu lớp với tên và niên khoá đã tồn tại
                echo "<script>alert('Lớp với tên và niên khoá này đã tồn tại. Vui lòng nhập lại thông tin khác.');</script>";
            } else {
                // Nếu mã lớp và tên niên khoá đều chưa tồn tại, thực hiện thêm lớp vào cơ sở dữ liệu
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
            }

            // Đóng kết nối kiểm tra lớp theo tên và niên khoá
            $stmt_check_name->close();
        }

        // Đóng kết nối
        $stmt_check->close();
        $conn->close();
    }
    ?>
</main><!-- End #main -->

<?php include('partials/footer.php'); ?>
