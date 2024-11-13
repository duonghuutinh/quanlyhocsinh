<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Kiểm tra nếu có yêu cầu xóa
if (isset($_GET['delete']) && isset($_GET['maGV']) && isset($_GET['maLop'])) {
  $maGV = $_GET['maGV'];
  $maLop = $_GET['maLop'];

  // Câu truy vấn để xóa dữ liệu
  $sql = "DELETE FROM chunhiem WHERE maGV = ? AND maLop = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $maGV, $maLop);

  if ($stmt->execute()) {
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
                <a href="export_pdf_chunhiem.php?column=<?php echo isset($_GET['column']) ? $_GET['column'] : ''; ?>&keyword=<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>&order=<?php echo isset($_GET['order']) ? $_GET['order'] : 'asc'; ?>" class="btn btn-success me-4">
                  <i class="ri-file-pdf-line"></i> Xuất PDF
                </a>
              </div>
            </h5>
            <div class="row">
              <form method="GET" action="" class="d-flex align-items-center  w-50 ">
                <div class="me-2" style="flex: 1;">
                  <select name="column" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="maGV">Mã giáo viên</option>
                    <option value="hoTen">Họ và tên</option>
                    <option value="tenLop">Lớp</option>
                    <option value="nienKhoa">Niên khoá</option>
                  </select>
                </div>
                <div class="me-2" style="flex: 1;">
                  <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa tìm kiếm">
                </div>
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
              </form>
              <form method="GET" action="" class="d-flex align-items-center  w-50">
                <div class="me-2" style="flex: 1;">
                  <select name="column" class="form-select">
                    <option value="">Chọn cột sắp xếp</option>
                    <option value="maGV">Mã giáo viên</option>
                    <option value="hoTen">Họ và tên</option>
                    <option value="tenLop">Lớp</option>
                    <option value="nienKhoa">Niên khoá</option>
                  </select>
                </div>
                <div class="me-2" style="flex: 1;">
                  <select name="order" class="form-select">
                    <option value="asc">Tăng dần</option>
                    <option value="desc">Giảm dần</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary">Sắp xếp</button>
              </form>
            </div>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col">Mã giáo viên</th>
                  <th scope="col">Họ và Tên</th>
                  <th scope="col">Lớp</th>
                  <th scope="col">Năm học</th>
                  <th scope="col">Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Truy vấn cơ sở dữ liệu
                $sql = "SELECT giaovien.maGV, giaovien.hoTen AS tenGiaoVien, lop.tenLop, lop.maLop, namhoc.nienKhoa
                        FROM chunhiem
                        JOIN giaovien ON chunhiem.maGV = giaovien.maGV
                        JOIN lop ON chunhiem.maLop = lop.maLop
                        JOIN namhoc ON chunhiem.maNamHoc = namhoc.maNamHoc";

                $params = [];
                $types = '';

                // Điều kiện tìm kiếm
                if (!empty($_GET['keyword'])) {
                  $keyword = '%' . $_GET['keyword'] . '%';
                  $types .= 's';

                  if (!empty($_GET['column'])) {
                    $column = $_GET['column'];
                    $sql .= " WHERE $column LIKE ?";
                    $params[] = $keyword;
                  } else {
                    $sql .= " WHERE giaovien.maGV LIKE ? OR giaovien.hoTen LIKE ? OR lop.tenLop LIKE ? OR namhoc.nienKhoa LIKE ?";
                    $params = array_fill(0, 4, $keyword);
                    $types .= str_repeat('s', 3);
                  }
                }

                // Điều kiện sắp xếp
                if (!empty($_GET['column']) && !empty($_GET['order'])) {
                  $sort_column = $_GET['column'];
                  $sort_order = $_GET['order'];
                  $sql .= " ORDER BY $sort_column $sort_order";
                }

                // Chuẩn bị và thực thi truy vấn
                $stmt = $conn->prepare($sql);
                if (!empty($params)) {
                  $stmt->bind_param($types, ...$params);
                }
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                  $stt = 1;
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <th scope='row'>{$stt}</th>
                            <td>{$row['maGV']}</td>
                            <td>{$row['tenGiaoVien']}</td>
                            <td>{$row['tenLop']}</td>
                            <td>{$row['nienKhoa']}</td>
                            <td>
                              <a href='edit_chunhiem.php?maGV=" . urlencode($row['maGV']) . "&maLop=" . urlencode($row['maLop']) . "&nienKhoa=" . urlencode($row['nienKhoa']) . "' class='btn btn-success'>
                                <i class='bi bi-pencil-square'></i>
                              </a>
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
