<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Lấy các tham số từ URL
$maLop = isset($_GET['maLop']) ? $_GET['maLop'] : '';
$nienKhoa = isset($_GET['nienKhoa']) ? $_GET['nienKhoa'] : '';

// Kiểm tra nếu các tham số có giá trị
if ($maLop && $nienKhoa) {
    // Truy vấn cơ sở dữ liệu để lấy thông tin lớp và niên khoá
    $query = $conn->prepare("SELECT l.tenLop, nh.nienKhoa, ph.soPhong, ph.soChoToiDa FROM phonglop pl 
                             JOIN phonghoc ph ON pl.maPhong = ph.maPhong 
                             JOIN lop l ON pl.maLop = l.maLop 
                             JOIN namhoc nh ON l.maNamHoc = nh.maNamHoc 
                             WHERE pl.maLop = ? AND nh.nienKhoa = ?");
    $query->bind_param("ss", $maLop, $nienKhoa);
    $query->execute();
    $result = $query->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tenLop = $row['tenLop']; // Tên lớp
        $nienKhoa = $row['nienKhoa']; // Niên khoá
        $soPhong = $row['soPhong']; // Số phòng
        $soChoToiDa = $row['soChoToiDa']; // Số chỗ tối đa
    } else {
        echo "Không tìm thấy thông tin phòng lớp.";
    }
} else {
    echo "Dữ liệu không hợp lệ.";
}

// Xử lý khi biểu mẫu được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận giá trị từ biểu mẫu
    $maPhong_new = $_POST['maPhong'];
    // Kiểm tra nếu phòng học đã được sử dụng cho lớp khác trong cùng niên khoá này
    $checkRoomQuery = $conn->prepare("SELECT * FROM phonglop pl 
        JOIN lop l ON pl.maLop = l.maLop 
        JOIN phonghoc ph ON pl.maPhong = ph.maPhong 
        WHERE pl.maPhong = ? AND l.maNamHoc = (SELECT maNamHoc FROM namhoc WHERE nienKhoa = ?) 
        AND pl.maLop != ?");
    $checkRoomQuery->bind_param("sss", $maPhong_new, $nienKhoa, $maLop);
    $checkRoomQuery->execute();
    $checkRoomResult = $checkRoomQuery->get_result();

    if ($checkRoomResult && $checkRoomResult->num_rows > 0) {
        // Nếu phòng học đã được sử dụng cho lớp khác trong niên khoá này
        echo "<script>alert('Phòng học này đã được sử dụng cho lớp khác trong niên khoá này!');</script>";
    } else {
        // Lấy số lượng học sinh trong lớp hiện tại
        $checkStudentQuery = $conn->prepare("SELECT COUNT(*) AS soSinhVien FROM hocSinh WHERE maLop = ?");
        $checkStudentQuery->bind_param("s", $maLop);
        $checkStudentQuery->execute();
        $studentResult = $checkStudentQuery->get_result();
        $studentRow = $studentResult->fetch_assoc();
        $soSinhVien = $studentRow['soSinhVien']; // Số lượng học sinh trong lớp

        // Lấy số chỗ tối đa của phòng học mới
        $checkRoomCapacityQuery = $conn->prepare("SELECT soChoToiDa FROM phonghoc WHERE maPhong = ?");
        $checkRoomCapacityQuery->bind_param("s", $maPhong_new);
        $checkRoomCapacityQuery->execute();
        $roomCapacityResult = $checkRoomCapacityQuery->get_result();
        $roomCapacityRow = $roomCapacityResult->fetch_assoc();
        $soChoToiDa = $roomCapacityRow['soChoToiDa']; // Số chỗ tối đa của phòng học mới

        // Kiểm tra nếu số lượng học sinh vượt quá số chỗ tối đa của phòng học
        if ($soSinhVien > $soChoToiDa) {
            echo "<script>alert('Sĩ số lớp vượt quá số chỗ tối đa của phòng học!');</script>";
        } else {
            // Cập nhật phòng học trong cơ sở dữ liệu
            if ($maPhong_new) {
                $updateQuery = $conn->prepare("UPDATE phonglop SET maPhong = ? WHERE maLop = ? AND maLop IN (SELECT maLop FROM lop WHERE maNamHoc = (SELECT maNamHoc FROM namhoc WHERE nienKhoa = ?))");
                $updateQuery->bind_param("sss", $maPhong_new, $maLop, $nienKhoa);

                if ($updateQuery->execute()) {
                    echo "<script>alert('Cập nhật phòng lớp thành công!'); window.location.href = 'phonglop.php';</script>";
                } else {
                    echo "Có lỗi xảy ra trong quá trình cập nhật.";
                }
            } else {
                echo "Vui lòng chọn phòng học.";
            }
        }
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Phòng Lớp</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Chỉnh Sửa Phòng Lớp</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chỉnh Sửa Phòng Lớp</h5>
                        <!-- Biểu mẫu chỉnh sửa phòng lớp -->
                        <form action="edit_phonglop.php?maLop=<?php echo $maLop; ?>&nienKhoa=<?php echo $nienKhoa; ?>" method="POST">

                            <!-- Chọn phòng -->
                            <div class="row mb-3">
                                <label for="maPhong" class="col-sm-2 col-form-label">Phòng</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="maPhong" name="maPhong" required>
                                        <option value="">Chọn phòng</option>
                                        <?php
                                        // Lấy danh sách phòng học để hiển thị trong select
                                        $query_phong = "SELECT * FROM phonghoc";
                                        $result_phong = $conn->query($query_phong);
                                        while ($row_phong = $result_phong->fetch_assoc()) :
                                        ?>
                                            <option value="<?php echo $row_phong['maPhong']; ?>" <?php echo ($soPhong == $row_phong['soPhong']) ? 'selected' : ''; ?>>
                                                <?php echo $row_phong['soPhong']; ?> (<?php echo $row_phong['soChoToiDa']; ?> chỗ ngồi)
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nienKhoa" class="col-sm-2 col-form-label">Năm học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nienKhoa" value="<?php echo $nienKhoa; ?>" disabled />
                                </div>
                            </div>

                            <!-- Lớp và niên khoá (Chỉ hiển thị, không chỉnh sửa) -->
                            <div class="row mb-3">
                                <label for="maLop" class="col-sm-2 col-form-label">Lớp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="maLop" value="<?php echo $tenLop; ?>" disabled />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
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