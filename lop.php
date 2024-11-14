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
        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
        <li class="breadcrumb-item active">Lớp</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="pagetitle">
    <h1>Danh sách lớp</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
              <div>
                <a href="add_lop.php" class="btn btn-primary me-2">Thêm</a>
                <a href="export_pdf_lop.php?column=<?php echo isset($_GET['column']) ? $_GET['column'] : ''; ?>&keyword=<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>&order=<?php echo isset($_GET['order']) ? $_GET['order'] : 'asc'; ?>" class="btn btn-success me-4">
                  <i class="ri-file-pdf-line"></i> Xuất PDF
                </a>
              </div>
            </h5>
            <div class="row">
              <form method="GET" action="" class="d-flex align-items-center w-50">
                <div class="me-2" style="flex: 1;">
                  <select name="column" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="tenLop">Tên Lớp</option>
                    <option value="soHocSinh">Sĩ số</option>
                    <option value="phongHoc">Phòng học</option>
                    <option value="giaoVienChuNhiem">Chủ nhiệm</option>
                    <option value="nienKhoa">Niên khoá</option>
                  </select>
                </div>
                <div class="me-2" style="flex: 1;">
                  <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa tìm kiếm">
                </div>
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
              </form>
              <form method="GET" action="" class="d-flex align-items-center w-50">
                <div class="me-2" style="flex: 1;">
                  <select name="sort_column" class="form-select">
                    <option value="">Chọn cột sắp xếp</option>
                    <option value="tenLop">Tên Lớp</option>
                    <option value="soHocSinh">Sĩ số</option>
                    <option value="phongHoc">Phòng học</option>
                    <option value="giaoVienChuNhiem">Chủ nhiệm</option>
                    <option value="nienKhoa">Niên khoá</option>
                  </select>
                </div>
                <div class="me-2" style="flex: 1;">
                  <select name="sort_order" class="form-select">
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
                  <th scope="col">Tên lớp</th>
                  <th scope="col">Sĩ số</th>
                  <th scope="col">Phòng học</th>
                  <th scope="col">Chủ nhiệm</th>
                  <th scope="col">Niên Khoá</th>
                  <th scope="col">Thao tác</th>
              </thead>
              <tbody>
                <?php
                // Câu truy vấn cơ bản
                $sql = "SELECT lop.maLop, lop.tenLop, 
                        COUNT(hocsinh.maHS) AS soHocSinh, 
                        giaovien.hoTen AS giaoVienChuNhiem,                       
                        namhoc.nienKhoa,
                        phonghoc.soPhong AS phongHoc 
                        FROM lop
                        LEFT JOIN hocsinh ON lop.maLop = hocsinh.maLop
                        LEFT JOIN chunhiem ON lop.maLop = chunhiem.maLop
                        LEFT JOIN giaovien ON chunhiem.maGV = giaovien.maGV
                        LEFT JOIN namhoc ON namhoc.maNamHoc = lop.maNamHoc
                        LEFT JOIN phonglop ON lop.maLop = phonglop.maLop
                        LEFT JOIN phonghoc ON phonglop.maPhong = phonghoc.maPhong
                        GROUP BY lop.maLop, lop.tenLop, giaovien.hoTen, lop.maNamHoc, phonghoc.soPhong";

                // Xử lý tìm kiếm
                $params = [];
                if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
                  $column = $_GET['column'];
                  $keyword = "%" . $_GET['keyword'] . "%";

                  if ($column) {
                    $sql .= " HAVING $column LIKE ?";
                    $params[] = $keyword;
                  } else {
                    $sql .= " HAVING tenLop LIKE ? OR soHocSinh LIKE ? OR phongHoc LIKE ? OR giaoVienChuNhiem LIKE ? OR nienKhoa LIKE ?";
                    $params = array_fill(0, 5, $keyword);
                  }
                }

                // Xử lý sắp xếp
                if (isset($_GET['sort_column']) && isset($_GET['sort_order'])) {
                  $sort_column = $_GET['sort_column'];
                  $sort_order = $_GET['sort_order'];

                  if (in_array($sort_column, ['tenLop', 'soHocSinh', 'phongHoc', 'giaoVienChuNhiem', 'nienKhoa']) && in_array($sort_order, ['asc', 'desc'])) {
                    $sql .= " ORDER BY $sort_column $sort_order";
                  }
                }

                $stmt = $conn->prepare($sql);
                if (!empty($params)) {
                  $stmt->bind_param(str_repeat("s", count($params)), ...$params);
                }
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                  $stt = 1;
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <th scope='row'>{$stt}</th>
                            <td>{$row['tenLop']}</td>
                            <td>{$row['soHocSinh']}</td>
                            <td>" . (!empty($row['phongHoc']) ? $row['phongHoc'] : 'Chưa có phòng') . "</td>
                            <td>" . (!empty($row['giaoVienChuNhiem']) ? $row['giaoVienChuNhiem'] : 'Chưa có chủ nhiệm') . "</td>
                            <td>{$row['nienKhoa']}</td>
                            <td>
                              <a href='edit_lop.php?maLop=" . $row['maLop'] . "' class='btn btn-success'><i class='bi bi-pencil-square'></i></a>
                              <a href='lop.php?delete=true&maLop=" . $row['maLop'] . "' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa không?\")'><i class='bi bi-trash'></i></a>
                            </td>
                          </tr>";
                    $stt++;
                  }
                } else {
                  echo "<tr><td colspan='7' class='text-center'>Không có dữ liệu nào</td></tr>";
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
if (isset($_GET['delete']) && isset($_GET['maLop'])) {
  $maLop = $_GET['maLop'];
  $query = "DELETE FROM lop WHERE maLop = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $maLop);

  if ($stmt->execute()) {
    echo "<script>alert('Xóa thành công!'); window.location.href = 'lop.php';</script>";
  } else {
    echo "Lỗi khi xóa lớp: " . $stmt->error;
  }
}
?>

<?php include('partials/footer.php'); ?>
