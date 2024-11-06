<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Lấy các tham số từ URL
$maGV = isset($_GET['maGV']) ? $_GET['maGV'] : '';
$maLop = isset($_GET['maLop']) ? $_GET['maLop'] : '';
$nienKhoa = isset($_GET['nienKhoa']) ? $_GET['nienKhoa'] : '';

// Kiểm tra nếu các tham số có giá trị
if ($maGV && $maLop && $nienKhoa) {
    // Truy vấn cơ sở dữ liệu để lấy thông tin chủ nhiệm, lớp và niên khoá
    $query = $conn->prepare("SELECT gv.hoTen, l.tenLop, nh.nienKhoa FROM chunhiem c JOIN giaovien gv ON c.maGV = gv.maGV JOIN lop l ON c.maLop = l.maLop JOIN namhoc nh ON c.maNamHoc = nh.maNamHoc WHERE c.maGV = ? AND c.maLop = ? AND nh.nienKhoa = ?");
    $query->bind_param("sss", $maGV, $maLop, $nienKhoa);
    $query->execute();
    $result = $query->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hoTen = $row['hoTen']; // Tên giáo viên
        $tenLop = $row['tenLop']; // Tên lớp
        $nienKhoa = $row['nienKhoa']; // Niên khoá
    } else {
        echo "Không tìm thấy thông tin chủ nhiệm.";
    }
} else {
    echo "Dữ liệu không hợp lệ.";
}

// Xử lý khi biểu mẫu được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận giá trị từ biểu mẫu
    $maGV_new = $_POST['maGV'];

    // Kiểm tra nếu giáo viên đã làm chủ nhiệm lớp khác trong cùng niên khoá này
    $checkTeacherQuery = $conn->prepare("SELECT * FROM chunhiem WHERE maGV = ? AND maNamHoc = (SELECT maNamHoc FROM namhoc WHERE nienKhoa = ?) AND maLop != ?");
    $checkTeacherQuery->bind_param("sss", $maGV_new, $nienKhoa, $maLop);
    $checkTeacherQuery->execute();
    $checkTeacherResult = $checkTeacherQuery->get_result();

    if ($checkTeacherResult && $checkTeacherResult->num_rows > 0) {
        // Nếu giáo viên đã là chủ nhiệm của lớp khác trong niên khoá này
        echo "<script>alert('Giáo viên này đã làm chủ nhiệm của lớp khác trong niên khoá này!');</script>";
    } else {
        // Cập nhật giáo viên chủ nhiệm trong cơ sở dữ liệu
        if ($maGV_new) {
            $updateQuery = $conn->prepare("UPDATE chunhiem SET maGV = ? WHERE maGV = ? AND maLop = ? AND maNamHoc = (SELECT maNamHoc FROM namhoc WHERE nienKhoa = ?)");
            $updateQuery->bind_param("ssss", $maGV_new, $maGV, $maLop, $nienKhoa);
            if ($updateQuery->execute()) {
                echo "<script>alert('Cập nhật thành công!'); window.location.href = 'chunhiem.php';</script>";
            } else {
                echo "Có lỗi xảy ra trong quá trình cập nhật.";
            }
        } else {
            echo "Vui lòng chọn giáo viên.";
        }
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chủ Nhiệm</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa Chủ Nhiệm</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chỉnh Sửa Chủ Nhiệm</h5>

                        <!-- Biểu mẫu chỉnh sửa chủ nhiệm -->
                        <form action="edit_chunhiem.php?maGV=<?php echo $maGV; ?>&maLop=<?php echo $maLop; ?>&nienKhoa=<?php echo $nienKhoa; ?>" method="POST">

                            <!-- Giáo viên -->
                            <div class="row mb-3">
                                <label for="maGV" class="col-sm-2 col-form-label">Giáo Viên:</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="maGV" name="maGV" required>
                                        <option value="">Chọn Giáo Viên</option>
                                        <?php
                                        // Truy vấn tất cả các giáo viên để hiển thị trong dropdown
                                        $result_giaovien = $conn->query("SELECT * FROM giaovien");
                                        while ($row_gv = $result_giaovien->fetch_assoc()):
                                        ?>
                                            <option value="<?php echo $row_gv['maGV']; ?>" <?php echo ($row_gv['maGV'] == $maGV) ? 'selected' : ''; ?>>
                                                <?php echo $row_gv['hoTen']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Lớp và niên khoá (Chỉ hiển thị, không chỉnh sửa) -->
                            <div class="row mb-3">
                                <label for="maLop" class="col-sm-2 col-form-label">Lớp:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maLop" value="<?php echo $tenLop; ?>" disabled />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nienKhoa" class="col-sm-2 col-form-label">Niên Khoá:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nienKhoa" value="<?php echo $nienKhoa; ?>" disabled />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Cập Nhật Chủ Nhiệm</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php include('partials/footer.php'); ?>
