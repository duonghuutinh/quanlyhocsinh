<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maGV = $_POST['maGV'];  // Mã giáo viên mới
    $maLop = $_POST['maLop']; // Mã lớp
    $namHoc = $_POST['namHoc'];

    // Kiểm tra xem giáo viên đã chủ nhiệm lớp nào khác chưa
    $checkTeacherSql = "SELECT COUNT(*) FROM chunhiem WHERE maGV = ? AND maLop != ?";
    $checkTeacherStmt = $conn->prepare($checkTeacherSql);
    $checkTeacherStmt->bind_param('ss', $maGV, $maLop);
    $checkTeacherStmt->execute();
    $checkTeacherResult = $checkTeacherStmt->get_result();
    $teacherCount = $checkTeacherResult->fetch_row()[0];

    // Kiểm tra xem lớp đã có giáo viên chủ nhiệm chưa (chỉ thay đổi nếu chưa có giáo viên khác)
    $checkClassSql = "SELECT COUNT(*) FROM chunhiem WHERE maLop = ? AND maGV != ?";
    $checkClassStmt = $conn->prepare($checkClassSql);
    $checkClassStmt->bind_param('ss', $maLop, $maGV);
    $checkClassStmt->execute();
    $checkClassResult = $checkClassStmt->get_result();
    $classCount = $checkClassResult->fetch_row()[0];

    // Nếu giáo viên đã chủ nhiệm lớp khác hoặc lớp đã có giáo viên khác làm chủ nhiệm
    if ($teacherCount > 0) {
        echo "<script>alert('Giáo viên này đã chủ nhiệm lớp khác!');</script>";
    } elseif ($classCount > 0) {
        echo "<script>alert('Lớp này đã có giáo viên khác làm chủ nhiệm!');</script>";
    } else {
        // Cập nhật thông tin chủ nhiệm nếu không vi phạm ràng buộc
        $updateSql = "UPDATE chunhiem SET maGV = ?, namHoc = ? WHERE maLop = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param('sss', $maGV, $namHoc, $maLop);

        if ($updateStmt->execute()) {
            echo "<script>alert('Cập nhật chủ nhiệm thành công!'); window.location.href = 'chunhiem.php';</script>";
        } else {
            echo "<script>alert('Cập nhật thất bại!');</script>";
        }
    }
}

?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chỉnh sửa Chủ Nhiệm</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="chunhiem_list.php">Danh sách chủ nhiệm</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin chủ nhiệm</h5>
                        <form method="POST" action="edit_chunhiem.php?maGV=<?php echo $maGV; ?>&maLop=<?php echo $maLop; ?>">

                            <div class="row mb-3">
                                <label for="maGV" class="col-sm-2 col-form-label">Chọn Giáo Viên</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="maGV" name="maGV" required>
                                        <?php
                                        // Lấy danh sách giáo viên từ cơ sở dữ liệu
                                        $teacherSql = "SELECT maGV, hoTen FROM giaovien";
                                        $teacherResult = $conn->query($teacherSql);
                                        while ($teacher = $teacherResult->fetch_assoc()) {
                                            $selected = $teacher['maGV'] == $row['maGV'] ? 'selected' : '';
                                            echo "<option value='{$teacher['maGV']}' $selected>{$teacher['hoTen']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="maLop" class="col-sm-2 col-form-label">Lớp</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="maLop" name="maLop" required>
                                        <?php
                                        // Lấy danh sách lớp để chọn
                                        $lopSql = "SELECT maLop, tenLop FROM lop";
                                        $lopResult = $conn->query($lopSql);
                                        while ($lop = $lopResult->fetch_assoc()) {
                                            $selected = $lop['maLop'] == $row['maLop'] ? 'selected' : '';
                                            echo "<option value='{$lop['maLop']}' $selected>{$lop['tenLop']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="namHoc" class="col-sm-2 col-form-label">Năm học</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="namHoc" name="namHoc" value="<?php echo $row['namHoc']; ?>" required>
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
