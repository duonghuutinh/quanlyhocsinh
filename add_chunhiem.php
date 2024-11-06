<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Lấy danh sách giáo viên
$sql_giaovien = "SELECT maGV, hoTen FROM giaovien";
$result_giaovien = $conn->query($sql_giaovien);

// Lấy danh sách lớp
$sql_lop = "SELECT maLop, tenLop FROM lop";
$result_lop = $conn->query($sql_lop);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chủ Nhiệm</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Thêm Chủ Nhiệm</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thêm Chủ Nhiệm</h5>

                        <!-- Biểu mẫu thêm giáo viên -->
                        <form action="add_chunhiem.php" method="POST">
                            <!-- Chọn giáo viên -->
                            <div class="row mb-3">
                                <label for="maGV" class="col-sm-2 col-form-label">Giáo Viên</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="maGV" name="maGV" required>
                                        <option value="">Chọn Giáo Viên</option>
                                        <?php while($row = $result_giaovien->fetch_assoc()): ?>
                                            <option value="<?php echo $row['maGV']; ?>"><?php echo $row['hoTen']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Chọn lớp -->
                            <div class="row mb-3">
                                <label for="maLop" class="col-sm-2 col-form-label">Lớp</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="maLop" name="maLop" required>
                                        <option value="">Chọn Lớp</option>
                                        <?php while($row = $result_lop->fetch_assoc()): ?>
                                            <option value="<?php echo $row['maLop']; ?>"><?php echo $row['tenLop']; ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Nhập năm học -->
                            <div class="row mb-3">
                                <label for="namHoc" class="col-sm-2 col-form-label">Năm Học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="namHoc" name="namHoc" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Thêm Chủ Nhiệm</button>
                                </div>
                            </div>
                        </form><!-- End Biểu mẫu thêm giáo viên -->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
<?php
// Kiểm tra xem form đã được gửi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $maGV = $_POST['maGV'];
    $maLop = $_POST['maLop'];
    $namHoc = $_POST['namHoc'];

    // Kiểm tra xem lớp đã có giáo viên chủ nhiệm chưa
    $sql_check_lop = "SELECT * FROM chunhiem WHERE maLop = ? AND namHoc = ?";
    $stmt_check_lop = $conn->prepare($sql_check_lop);
    $stmt_check_lop->bind_param("is", $maLop, $namHoc);
    $stmt_check_lop->execute();
    $result_check_lop = $stmt_check_lop->get_result();

    // Kiểm tra xem giáo viên đã chủ nhiệm lớp nào trong năm học này chưa
    $sql_check_gv = "SELECT * FROM chunhiem WHERE maGV = ? AND namHoc = ?";
    $stmt_check_gv = $conn->prepare($sql_check_gv);
    $stmt_check_gv->bind_param("is", $maGV, $namHoc);
    $stmt_check_gv->execute();
    $result_check_gv = $stmt_check_gv->get_result();

    if ($result_check_lop->num_rows > 0) {
        // Nếu lớp đã có giáo viên chủ nhiệm, thông báo lỗi
        echo "<script>alert('Lớp này đã có giáo viên chủ nhiệm cho năm học này!'); window.location.href = 'add_chunhiem.php';</script>";
    } elseif ($result_check_gv->num_rows > 0) {
        // Nếu giáo viên đã chủ nhiệm một lớp khác, thông báo lỗi
        echo "<script>alert('Giáo viên này đã chủ nhiệm một lớp khác trong năm học này!'); window.location.href = 'add_chunhiem.php';</script>";
    } else {
        // Nếu cả hai điều kiện đều thỏa mãn, thêm giáo viên chủ nhiệm vào lớp
        $sql_insert = "INSERT INTO chunhiem (maGV, maLop, namHoc) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sis", $maGV, $maLop, $namHoc);

        if ($stmt_insert->execute()) {
            echo "<script>alert('Thêm giáo viên chủ nhiệm thành công!'); window.location.href = 'chunhiem.php';</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại!'); window.location.href = 'add_chunhiem.php';</script>";
        }
    }

    // Đóng kết nối
    $stmt_check_lop->close();
    $stmt_check_gv->close();
    $stmt_insert->close();
    $conn->close();
}
?>




<?php include('partials/footer.php'); ?>
