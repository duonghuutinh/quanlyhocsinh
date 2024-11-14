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

// Lấy danh sách năm học
$sql_namhoc = "SELECT maNamHoc, nienKhoa FROM namhoc";
$result_namhoc = $conn->query($sql_namhoc);


// Kiểm tra xem dữ liệu có được gửi đi không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $maGV = $_POST['maGV'];
    $maLop = $_POST['maLop'];
    $maNamHoc = $_POST['maNamHoc'];

    // Kiểm tra nếu giáo viên đã chủ nhiệm 1 lớp nào đó trong năm học này
    $sql_check_giaovien = "SELECT * FROM chunhiem WHERE maGV = '$maGV' AND maNamHoc = '$maNamHoc'";
    $result_check_giaovien = $conn->query($sql_check_giaovien);

    if ($result_check_giaovien->num_rows > 0) {
        // Nếu giáo viên đã chủ nhiệm lớp trong năm học này
        echo "<script>alert('Giáo viên đã chủ nhiệm lớp trong năm học này.'); window.location.href = 'add_chunhiem.php';</script>";
        exit;
    }

    // Kiểm tra nếu lớp đã có giáo viên chủ nhiệm trong năm học này
    $sql_check_lop = "SELECT * FROM chunhiem WHERE maLop = '$maLop' AND maNamHoc = '$maNamHoc'";
    $result_check_lop = $conn->query($sql_check_lop);

    if ($result_check_lop->num_rows > 0) {
        // Nếu lớp đã có giáo viên chủ nhiệm
        echo "<script>alert('Lớp này đã có giáo viên chủ nhiệm trong năm học này.'); window.location.href = 'add_chunhiem.php';</script>";
        exit;
    }

    // Thực hiện thêm chủ nhiệm
    $sql_insert = "INSERT INTO chunhiem (maGV, maLop, maNamHoc) VALUES ('$maGV', '$maLop', '$maNamHoc')";
    
    if ($conn->query($sql_insert) === TRUE) {
        echo "<script>alert('Thêm chủ nhiệm thành công!'); window.location.href = 'chunhiem.php';</script>";
    } else {
        echo "<script>alert('Có lỗi khi thêm chủ nhiệm.'); window.history.back();</script>";
    }
}

?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chủ Nhiệm</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="chunhiem.php">Chủ nhiệm</a></li>
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

                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">Thêm Chủ Nhiệm</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
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
