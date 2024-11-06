<?php  
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Lấy danh sách lớp
$sql_lop = "SELECT maLop, tenLop FROM lop";
$result_lop = $conn->query($sql_lop);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Học Sinh</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Thêm Học Sinh</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thêm Học Sinh</h5>

                        <!-- Biểu mẫu thêm Học Sinh -->
                        <form action="" method="POST">
                            <div class="row mb-3">
                                <label for="maHS" class="col-sm-2 col-form-label">Mã Học Sinh</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maHS" name="maHS" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="hoTen" class="col-sm-2 col-form-label">Họ Tên</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="hoTen" name="hoTen" required>
                                </div>
                            </div>

                            <!-- Giới Tính -->
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

                            <!-- Lớp -->
                            <div class="row mb-3">
                                <label for="maLop" class="col-sm-2 col-form-label">Lớp</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="maLop" name="maLop" required>
                                        <option value="">Chọn Lớp</option>
                                        <?php while ($row = $result_lop->fetch_assoc()): ?>
                                            <option value="<?php echo $row['maLop']; ?>"><?php echo $row['tenLop']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Ngày Sinh -->
                            <div class="row mb-3">
                                <label for="ngaySinh" class="col-sm-2 col-form-label">Ngày Sinh</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" required>
                                </div>
                            </div>

                            <!-- Số Điện Thoại Phụ Huynh -->
                            <div class="row mb-3">
                                <label for="sdtPH" class="col-sm-2 col-form-label">Số Điện Thoại Phụ Huynh</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="sdtPH" name="sdtPH" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                </div>
                            </div>

                            <!-- Địa Chỉ -->
                            <div class="row mb-3">
                                <label for="diaChi" class="col-sm-2 col-form-label">Địa Chỉ</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="diaChi" name="diaChi" rows="3" required></textarea>
                                </div>
                            </div>

                            <!-- Thêm Học Sinh -->
                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Thêm Học Sinh</button>
                                </div>
                            </div>
                        </form><!-- End Biểu mẫu thêm Học Sinh -->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
// Kiểm tra phương thức gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $maHS = $_POST['maHS'];
    $hoTen = $_POST['hoTen'];
    $gioiTinh = $_POST['gioiTinh'];
    $ngaySinh = $_POST['ngaySinh'];
    $sdtPH = $_POST['sdtPH'];
    $maLop = $_POST['maLop'];
    $diaChi = $_POST['diaChi'];

    // Kiểm tra nếu mã học sinh đã tồn tại
    $check_query = "SELECT maHS FROM hocsinh WHERE maHS = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $maHS);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Mã Học Sinh đã tồn tại. Vui lòng nhập mã khác.'); window.history.back();</script>";
    } else {
        // Thêm học sinh mới nếu không trùng mã
        $sql = "INSERT INTO hocsinh (maHS, hoTen, gioiTinh, ngaySinh, diaChi, sdtPH, maLop) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Lỗi chuẩn bị câu lệnh: " . $conn->error);
        }

        $stmt->bind_param("sssssss", $maHS, $hoTen, $gioiTinh, $ngaySinh, $diaChi, $sdtPH, $maLop);

        if ($stmt->execute()) {
            echo "<script>alert('Thêm Học Sinh thành công!'); window.location.href = 'hocsinh.php';</script>";
        } else {
            echo "Lỗi khi thêm Học Sinh: " . $stmt->error;
        }

        $stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>

<?php include('partials/footer.php'); ?>
