<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Giáo Viên</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Thêm Giáo viên</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thêm giáo viên</h5>

                        <!-- Form thêm giáo viên -->
                        <form action="" method="POST">
                            <div class="row mb-3">
                                <label for="maGV" class="col-sm-2 col-form-label">Mã Giáo Viên</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maGV" name="maGV" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="hoTen" class="col-sm-2 col-form-label">Họ Tên</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="hoTen" name="hoTen" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="gioiTinh" class="col-sm-2 col-form-label">Giới Tính</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="gioiTinh" name="gioiTinh" required>
                                        <option value="">Chọn giới tính</option>
                                        <option value="Nam">Nam</option>
                                        <option value="Nữ">Nữ</option>
                                        <option value="Khác">Khác</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="ngaySinh" class="col-sm-2 col-form-label">Ngày Sinh</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="SDT" class="col-sm-2 col-form-label">Số Điện Thoại</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="SDT" name="SDT" pattern="[0-9]{10}" maxlength="10" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="diaChi" class="col-sm-2 col-form-label">Địa Chỉ</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="diaChi" name="diaChi" rows="3" required></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Thêm Giáo Viên</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    // Kiểm tra phương thức gửi biểu mẫu
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ biểu mẫu
        $maGV = $_POST['maGV'];
        $hoTen = $_POST['hoTen'];
        $ngaySinh = $_POST['ngaySinh'];
        $diaChi = $_POST['diaChi'];
        $SDT = $_POST['SDT'];
        $email = $_POST['email'];
        $gioiTinh = $_POST['gioiTinh'];

        // Kiểm tra mã giáo viên đã tồn tại hay chưa
        $checkQuery = "SELECT * FROM giaovien WHERE maGV = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $maGV);
        $stmt->execute();
        $result = $stmt->get_result();

        // Nếu mã giáo viên đã tồn tại
        if ($result->num_rows > 0) {
            echo "<script>alert('Mã giáo viên đã tồn tại. Vui lòng nhập mã khác.');</script>";
        } else {
            // Câu lệnh SQL để thêm giáo viên vào bảng giaovien
            $sql = "INSERT INTO giaovien (maGV, hoTen, ngaySinh, diaChi, SDT, email, gioiTinh) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            // Kiểm tra chuẩn bị câu lệnh SQL
            if ($stmt === false) {
                die("Lỗi chuẩn bị câu lệnh: " . $conn->error);
            }

            // Gán giá trị vào câu lệnh SQL
            $stmt->bind_param("sssssss", $maGV, $hoTen, $ngaySinh, $diaChi, $SDT, $email, $gioiTinh);

            // Thực thi câu lệnh và kiểm tra kết quả
            if ($stmt->execute()) {
                echo "<script>alert('Thêm giáo viên thành công!'); window.location.href = 'giaovien.php';</script>";
            } else {
                echo "Lỗi khi thêm giáo viên: " . $stmt->error;
            }
        }

        // Đóng câu lệnh và kết nối
        $stmt->close();
        $conn->close();
    }
    ?>

</main><!-- End #main -->

<?php include('partials/footer.php'); ?>
