
<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Kiểm tra kết nối cơ sở dữ liệu
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy dữ liệu lớp
$sql_lop = "SELECT maLop, tenLop FROM lop";
$result_lop = $conn->query($sql_lop);
if (!$result_lop) {
    die("Lỗi truy vấn lớp: " . $conn->error);
}

// Lấy dữ liệu năm học
$sql_namhoc = "SELECT maNamHoc, nienKhoa FROM namhoc";
$result_namhoc = $conn->query($sql_namhoc);
if (!$result_namhoc) {
    die("Lỗi truy vấn năm học: " . $conn->error);
}

// Lấy danh sách phòng
$query_phong = "SELECT * FROM phonghoc";
$result_phong = $conn->query($query_phong);
if (!$result_phong) {
    die("Lỗi truy vấn phòng học: " . $conn->error);
}

?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Phòng Lớp</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="phonglop.php">Phòng lớp</a></li>
                <li class="breadcrumb-item active">Thêm Phòng Lớp</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Thêm Phòng Lớp</h5>

                        <!-- Biểu mẫu thêm Phòng Lớp -->
                        <form action="add_phonglop.php" method="POST">
                            <!-- Năm học -->
                            <div class="row mb-3">
                                <label for="maNamHoc" class="col-sm-2 col-form-label">Năm học</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="maNamHoc" name="maNamHoc" onchange="getClasses(this.value)">
                                        <option value="">Chọn năm học</option>
                                        <?php while ($row = $result_namhoc->fetch_assoc()): ?>
                                            <option value="<?php echo $row['maNamHoc']; ?>" <?php echo (isset($_POST['maNamHoc']) && $_POST['maNamHoc'] == $row['maNamHoc']) ? 'selected' : ''; ?>>
                                                <?php echo $row['nienKhoa']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Lớp -->
                            <div class="row mb-3">
                                <label for="maLop" class="col-sm-2 col-form-label">Lớp</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="maLop" name="maLop" required>
                                        <option value="">Chọn Lớp</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Chọn phòng -->
                            <div class="row mb-3">
                                <label for="maPhong" class="col-sm-2 col-form-label">Phòng</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="maPhong" name="maPhong" required>
                                        <option value="">Chọn phòng</option>
                                        <?php while ($row_phong = $result_phong->fetch_assoc()): ?>
                                            <option value="<?php echo $row_phong['maPhong']; ?>">
                                                <?php echo $row_phong['soPhong']; ?> (<?php echo $row_phong['soChoToiDa']; ?> chỗ ngồi)
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Thêm Phòng Lớp</button>
                                </div>
                            </div>
                        </form><!-- End Biểu mẫu thêm Phòng Lớp -->

                    
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    // Kiểm tra phương thức gửi biểu mẫu
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ biểu mẫu
        $maPhong = $_POST['maPhong'];
        $maLop = $_POST['maLop'];
        $maNamHoc = $_POST['maNamHoc']; // lấy năm học từ POST

       
            // Truy vấn để lấy số lượng học sinh trong lớp
            $query_siso = "SELECT COUNT(*) AS siso FROM hocsinh WHERE maLop = ?";
            $stmt_siso = $conn->prepare($query_siso);
            $stmt_siso->bind_param("s", $maLop);
            $stmt_siso->execute();
            $result_siso = $stmt_siso->get_result();
            $row_siso = $result_siso->fetch_assoc();
            $siso = $row_siso['siso'];

            // Truy vấn để lấy số chỗ ngồi của phòng đã chọn
            $query_phong = "SELECT * FROM phonghoc WHERE maPhong = ?";
            $stmt_phong = $conn->prepare($query_phong);
            $stmt_phong->bind_param("s", $maPhong);
            $stmt_phong->execute();
            $result_phong = $stmt_phong->get_result();
            $row_phong = $result_phong->fetch_assoc();
            $soChoToiDa = $row_phong['soChoToiDa'];

            // Kiểm tra nếu số học sinh lớn hơn số chỗ ngồi
            if ($siso > $soChoToiDa) {
                echo "<script>alert('Sĩ số lớp lớn hơn số chỗ ngồi của phòng. Vui lòng chọn phòng khác!'); window.location.href = 'add_phonglop.php';</script>";
            } else {
                // Kiểm tra xem lớp đã có phòng trong năm học này chưa
                $sql_check_lop = "SELECT pl.* 
                  FROM phonglop pl
                  JOIN lop l ON pl.maLop = l.maLop
                  WHERE pl.maLop = ? AND l.maNamHoc = ?";
                $stmt_check_lop = $conn->prepare($sql_check_lop);
                $stmt_check_lop->bind_param("ss", $maLop, $maNamHoc);
                $stmt_check_lop->execute();
                $result_check_lop = $stmt_check_lop->get_result();
                
                // Nếu lớp đã có phòng, thông báo lỗi
                if ($result_check_lop->num_rows > 0) {
                    echo "<script>alert('Lớp này đã có phòng trong năm học này. Vui lòng chọn lớp khác!'); window.location.href = 'add_phonglop.php';</script>";
                 
                } else {
                    // Kiểm tra xem phòng đã có lớp trong năm học này chưa
                    $sql_check_phong = "SELECT pl.* 
                    FROM phonglop pl
                    JOIN lop l ON pl.maLop = l.maLop
                    WHERE pl.maPhong = ? AND l.maNamHoc = ?";
                    $stmt_check_phong = $conn->prepare($sql_check_phong);
                    $stmt_check_phong->bind_param("ss", $maPhong, $maNamHoc);
                    $stmt_check_phong->execute();
                    $result_check_phong = $stmt_check_phong->get_result();
                
                    // Nếu phòng đã có lớp, thông báo lỗi
                    if ($result_check_phong->num_rows > 0) {
                        echo "<script>alert('Phòng này đã có lớp trong năm học này. Vui lòng chọn phòng khác!'); window.location.href = 'add_phonglop.php';</script>";
                     
                    } else {
                        // Thực hiện thêm mới nếu không vi phạm điều kiện
                        $sql = "INSERT INTO phonglop (maPhong, maLop) VALUES (?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ss", $maPhong, $maLop);
                        if ($stmt->execute()) {
                            
                            echo "<script>alert('Thêm phòng lớp thành công!'); window.location.href = 'phonglop.php';</script>";
                        } else {
                            echo "Lỗi khi thêm Phòng Lớp: " . $stmt->error;
                        }
                        $stmt->close();
                    }
                }
            }
     
    }
    ?>

</main><!-- End #main -->




<script>
document.getElementById("maNamHoc").addEventListener("change", function() {
    const maNamHoc = this.value;
    if (maNamHoc) {
        fetchClasses(maNamHoc);
    } else {
        document.getElementById("maLop").innerHTML = "<option value=''>Chọn Lớp</option>";
    }
});

function fetchClasses(maNamHoc) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "get_lop.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("maLop").innerHTML = xhr.responseText;
        }
    };
    xhr.send("maNamHoc=" + encodeURIComponent(maNamHoc));
}
</script>

<?php include('partials/footer.php'); ?>
