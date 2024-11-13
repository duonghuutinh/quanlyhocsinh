<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Phòng Lớp</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Phòng lớp</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="pagetitle">
    <h1>Danh sách phòng lớp</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
              <div>
                <a href="add_phonglop.php" class="btn btn-primary me-2">Thêm</a>
                <a href="export_pdf_phonglop.php?column=<?php echo isset($_GET['column']) ? $_GET['column'] : ''; ?>&keyword=<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>&order=<?php echo isset($_GET['order']) ? $_GET['order'] : 'asc'; ?>" class="btn btn-success me-4">
                  <i class="ri-file-pdf-line"></i> Xuất PDF
                </a>
              </div>
            </h5>
            <div class="row">
              <form method="GET" action="" class="d-flex align-items-center w-50">
                <div class="me-2" style="flex: 1;">
                  <select name="column" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="maPhong">Số phòng</option>
                    <option value="tenLop">Lớp</option>
                    <option value="maNamHoc">Năm học</option>
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
                    <option value="maPhong">Số phòng</option>
                    <option value="tenLop">Lớp</option>
                    <option value="nienKhoa">Năm học</option>
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
                  <th scope="col">Số phòng</th>
                  <th scope="col">Lớp</th>
                  <th scope="col">Năm học</th>
                  <th scope="col">Thao Tác</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT phonglop.*, lop.tenLop, namhoc.nienKhoa
                        FROM phonglop
                        JOIN lop ON phonglop.maLop = lop.maLop
                        JOIN namhoc ON lop.maNamHoc = namhoc.maNamHoc";

                if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
                  $column = $_GET['column'];
                  $keyword = "%" . $_GET['keyword'] . "%";

                  if ($column) {
                    $sql .= " WHERE $column LIKE ?";
                    $params = [$keyword];
                  } else {
                    $sql .= " WHERE maPhong LIKE ? OR tenLop LIKE ? OR nienKhoa LIKE ?";
                    $params = [$keyword, $keyword, $keyword];
                  }
                } else {
                  $params = [];
                }


                if (isset($_GET['sort_column']) && isset($_GET['sort_order'])) {
                  $sort_column = $_GET['sort_column'];
                  $sort_order = $_GET['sort_order'];

                  if (in_array($sort_column, ['maPhong', 'tenLop', 'nienKhoa']) && in_array($sort_order, ['asc', 'desc'])) {
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
                            <td>{$row['maPhong']}</td>
                            <td>{$row['tenLop']}</td>
                            <td>{$row['nienKhoa']}</td>
                            <td>
                              <a href='edit_phonglop.php?maPhong={$row['maPhong']}&nienKhoa={$row['nienKhoa']}&maLop={$row['maLop']}' class='btn btn-success'>
                                <i class='bi bi-pencil-square'></i>
                              </a>
                              <a href='phonglop.php?delete=true&maPhong={$row['maPhong']}' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>
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
// Xử lý xóa
if (isset($_GET['delete']) && isset($_GET['maPhong'])) {
  $maPhong = $_GET['maPhong'];
  $query = "DELETE FROM phonglop WHERE maPhong = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $maPhong);

  if ($stmt->execute()) {
    echo "<script>alert('Xoá thành công!'); window.location.href = 'phonglop.php';</script>";
  } else {
    echo "Lỗi khi xoá Phòng lớp: " . $stmt->error;
  }
}
include('partials/footer.php');
?>
