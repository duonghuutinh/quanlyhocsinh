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
                                <label for="nienKhoa" class="col-sm-2 col-form-label">Niên Khoá</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="nienKhoa" name="nienKhoa" required>
                                        <option value="">Chọn niên khoá</option>
                                        <?php
                                        // Lấy danh sách niên khoá từ bảng namhoc
                                        $sql_nienKhoa = "SELECT maNamHoc, nienKhoa FROM namhoc";
                                        $result_nienKhoa = $conn->query($sql_nienKhoa);

                                        if ($result_nienKhoa->num_rows > 0) {
                                            while ($row = $result_nienKhoa->fetch_assoc()) {
                                                echo "<option value='" . $row['nienKhoa'] . "'>" . $row['nienKhoa'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Không có niên khoá</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="tenKhoi" class="col-sm-2 col-form-label">Khối</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="tenKhoi" name="tenKhoi" required>
                                        <option value="">Chọn khối</option>
                                        <?php
                                        // Lấy danh sách khối từ bảng khoi
                                        $sql_khoi = "SELECT maKhoi, tenKhoi FROM khoi";
                                        $result_khoi = $conn->query($sql_khoi);

                                        if ($result_khoi->num_rows > 0) {
                                            while ($row = $result_khoi->fetch_assoc()) {
                                                echo "<option value='" . $row['maKhoi'] . "'>" . $row['tenKhoi'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Không có khối</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="tenLop" class="col-sm-2 col-form-label">Tên Lớp</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="tenLop" name="tenLop" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Thêm Lớp</button>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ biểu mẫu
        $tenLop = $_POST['tenLop'];
        $nienKhoa = $_POST['nienKhoa'];
        $maKhoi = $_POST['tenKhoi'];  // Lấy mã khối

        // Kiểm tra xem lớp với tên và niên khoá có trùng không
        $sql_check_name = "SELECT l.* FROM lop l
                       JOIN namhoc n ON l.maNamHoc = n.maNamHoc
                       WHERE l.tenLop = ? AND n.nienKhoa = ?";
        $stmt_check_name = $conn->prepare($sql_check_name);
        $stmt_check_name->bind_param("ss", $tenLop, $nienKhoa);
        $stmt_check_name->execute();
        $result_check_name = $stmt_check_name->get_result();

        if ($result_check_name->num_rows > 0) {
            // Nếu lớp với tên và niên khoá đã tồn tại
            echo "<script>alert('Lớp với tên và niên khoá này đã tồn tại. Vui lòng nhập lại thông tin khác.');</script>";
        } else {
            // Lấy mã niên khoá từ bảng namhoc
            $sql_get_maNamHoc = "SELECT maNamHoc FROM namhoc WHERE nienKhoa = ?";
            $stmt_get_maNamHoc = $conn->prepare($sql_get_maNamHoc);
            $stmt_get_maNamHoc->bind_param("s", $nienKhoa);
            $stmt_get_maNamHoc->execute();
            $result_get_maNamHoc = $stmt_get_maNamHoc->get_result();

            if ($result_get_maNamHoc->num_rows > 0) {
                $row = $result_get_maNamHoc->fetch_assoc();
                $maNamHoc = $row['maNamHoc'];

                // Thêm lớp vào bảng lop (không cần maLop vì đã tự động tăng)
                $sql = "INSERT INTO lop (tenLop, maNamHoc, maKhoi) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $tenLop, $maNamHoc, $maKhoi);

                if ($stmt->execute()) {
                    echo "<script>alert('Thêm Lớp thành công!'); window.location.href = 'lop.php';</script>";
                } else {
                    echo "Lỗi khi thêm Lớp: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "<script>alert('Niên Khoá không hợp lệ.');</script>";
            }

            $stmt_get_maNamHoc->close();
        }

        $stmt_check_name->close();
        $conn->close();
    }

    ?>
</main><!-- End #main -->
<?php include('partials/footer.php'); ?>