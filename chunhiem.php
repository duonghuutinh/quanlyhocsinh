<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Kiểm tra nếu có yêu cầu xóa
if (isset($_GET['delete']) && isset($_GET['maGV']) && isset($_GET['maLop'])) {
  $maGV = $_GET['maGV'];
  $maLop = $_GET['maLop'];

  // Câu truy vấn để xóa dữ liệu
  $sql = "DELETE FROM chunhiem WHERE maGV = '$maGV' AND maLop = '$maLop'";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Xoá thành công!'); window.location.href = 'chunhiem.php';</script>";
  } else {
    echo "<script>alert('Lỗi: " . $conn->error . "');</script>";
  }
}
?>
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Chủ Nhiệm</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Chủ nhiệm</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="pagetitle">
    <h1>Danh sách chủ nhiệm</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
              <div>
                <a href="add_chunhiem.php" class="btn btn-primary me-2">Thêm</a>
                <a href="#" class="btn btn-success"><i class="ri-file-word-2-line"></i> Xuất Excel</a>
              </div>
            </h5>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col">Mã giáo viên</th>
                  <th scope="col">Họ và Tên</th>
                  <th scope="col">Lớp</th>
                  <th scope="col">Năm học</th>
                  <th scope="col">Thao tác</th>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT giaovien.maGV, giaovien.hoTen AS tenGiaoVien, lop.tenLop, lop.maLop, namhoc.nienKhoa
                FROM chunhiem
                JOIN giaovien ON chunhiem.maGV = giaovien.maGV
                JOIN lop ON chunhiem.maLop = lop.maLop
                JOIN namhoc ON chunhiem.maNamHoc = namhoc.maNamHoc"; // Truy vấn nienKhoa từ bảng namhoc

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  $stt = 1;
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <th scope='row'>{$stt}</th>
                            <td>{$row['maGV']}</td>
                            <td>{$row['tenGiaoVien']}</td>
                            <td>{$row['tenLop']}</td>
                            <td>{$row['nienKhoa']}</td>  <!-- Hiển thị nienKhoa từ bảng namhoc -->
                            <td>
                              <a href='edit_chunhiem.php?maGV=" . urlencode($row['maGV']) . "&maLop=" . urlencode($row['maLop']) . "&nienKhoa=" . urlencode($row['nienKhoa']) . "' class='btn btn-success'>
                                <i class='bi bi-pencil-square'></i>
                              </a>
                              <!-- Nút xóa -->
                              <a href='chunhiem.php?delete=true&maGV=" . urlencode($row['maGV']) . "&maLop=" . urlencode($row['maLop']) . "' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa không?\")'>
                                <i class='bi bi-trash'></i>
                              </a>
                            </td>
                          </tr>";
                    $stt++;
                  }
                } else {
                  echo "<tr><td colspan='6' class='text-center'>Không có dữ liệu nào</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->

<?php
include('partials/footer.php');
?>
