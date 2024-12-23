<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Học Sinh</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
        <li class="breadcrumb-item active">Học Sinh</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="pagetitle">
    <h1>Danh sách học sinh</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
              <div>
                <a href="add_hocsinh.php" class="btn btn-primary me-2">Thêm</a>
                <a href="export_pdf_hocsinh.php?column=<?php echo isset($_GET['column']) ? $_GET['column'] : ''; ?>&keyword=<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>&order=<?php echo isset($_GET['order']) ? $_GET['order'] : 'asc'; ?>" class="btn btn-success me-4">
                  <i class="ri-file-pdf-line"></i> Xuất PDF
                </a>
              </div>
            </h5>

            <div class="row">
              <!-- Form tìm kiếm -->
              <form method="GET" action="" class="d-flex align-items-center w-50">
                <div class="me-2" style="flex: 1;">
                  <select name="column" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="maHS">Mã học sinh</option>
                    <option value="hoTen">Họ và tên</option>
                    <option value="gioiTinh">Giới tính</option>
                    <option value="maLop">Lớp</option>
                    <option value="nienKhoa">Niên khoá</option>
                    <option value="ngaySinh">Ngày sinh</option>
                    <option value="sdtPH">Số điện thoại phụ huynh</option>
                    <option value="diaChi">Địa chỉ</option>
                  </select>
                </div>
                <div class="me-2" style="flex: 1;">
                  <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa tìm kiếm">
                </div>
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
              </form>

              <!-- Form sắp xếp -->
              <form method="GET" action="" class="d-flex align-items-center w-50">
                <div class="me-2" style="flex: 1;">
                  <select name="column" class="form-select">
                    <option value="">Chọn cột sắp xếp</option>
                    <option value="maHS">Mã học sinh</option>
                    <option value="hoTen">Họ và tên</option>
                    <option value="gioiTinh">Giới tính</option>
                    <option value="maLop">Lớp</option>
                    <option value="nienKhoa">Niên khoá</option>
                    <option value="ngaySinh">Ngày sinh</option>
                    <option value="sdtPH">Số điện thoại phụ huynh</option>
                    <option value="diaChi">Địa chỉ</option>
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

            <!-- Bảng dữ liệu học sinh -->
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col">Mã học sinh</th>
                  <th scope="col">Họ và tên</th>
                  <th scope="col">Giới Tính</th>
                  <th scope="col">Lớp</th>
                  <th scope="col">Niên khoá</th>
                  <th scope="col">Ngày sinh</th>
                  <th scope="col">Số điện thoại</th>
                  <th scope="col">Địa chỉ</th>
                  <th scope="col">Thao Tác</th>
                </tr>
              </thead>
              <tbody>
                <?php
<<<<<<< HEAD
                $sql = "SELECT hocsinh.*, lop.tenLop, namhoc.nienKhoa
                        FROM hocsinh
                        JOIN lop ON hocsinh.maLop = lop.maLop
                        JOIN namhoc ON lop.maNamHoc = namhoc.maNamHoc";
// Thêm phần tìm kiếm vào SQL nếu có
if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
  $column = $_GET['column'];
  $keyword = $_GET['keyword'];
  $searchTerm = "%" . $keyword . "%";

  if ($column) {
      // If the column is provided, we directly search in the specified column
      if ($column === 'maLop') {
          $sql .= " WHERE hocsinh.maLop LIKE ?";  // Explicitly reference maLop from the hocsinh table
      } else {
          $sql .= " WHERE $column LIKE ?";  
      }
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $searchTerm);
  } else {
      // Tìm kiếm trong nhiều cột, including columns from the joined tables (lop and namhoc)
      $sql .= " WHERE hocsinh.maHS LIKE ? OR hocsinh.hoTen LIKE ? OR hocsinh.gioiTinh LIKE ? OR lop.tenLop LIKE ? OR namhoc.nienKhoa LIKE ? OR hocsinh.ngaySinh LIKE ? OR hocsinh.sdtPH LIKE ? OR hocsinh.diaChi LIKE ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
  }
} else {
  $stmt = $conn->prepare($sql);
}
=======
                $sql = "SELECT * FROM danhsachhocsinh";
>>>>>>> caed007 (hocsinh)



                // Thêm sắp xếp nếu có
                if (isset($_GET['column']) && isset($_GET['order']) && in_array($_GET['column'], ['maHS', 'hoTen', 'gioiTinh', 'tenLop', 'nienKhoa', 'ngaySinh', 'sdtPH', 'diaChi'])) {
                  $column = $_GET['column'];
                  $order = $_GET['order'];
                  $sql .= " ORDER BY $column $order";
                  $stmt = $conn->prepare($sql);
                }

                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                  $stt = 1;
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <th scope='row'>{$stt}</th>
                            <td>" . (isset($row['maHS']) ? $row['maHS'] : 'N/A') . "</td>
                            <td>" . (isset($row['hoTen']) ? $row['hoTen'] : 'N/A') . "</td>
                            <td>" . (isset($row['gioiTinh']) ? $row['gioiTinh'] : 'N/A') . "</td>
                            <td>" . (isset($row['tenLop']) ? $row['tenLop'] : 'N/A') . "</td>
                            <td>" . (isset($row['nienKhoa']) ? $row['nienKhoa'] : 'N/A') . "</td>
                            <td>" . (isset($row['ngaySinh']) ? $row['ngaySinh'] : 'N/A') . "</td>
                            <td>" . (isset($row['sdtPH']) ? $row['sdtPH'] : 'N/A') . "</td>
                            <td>" . (isset($row['diaChi']) ? $row['diaChi'] : 'N/A') . "</td>
                            <td>
                              <a href='edit_hocsinh.php?maHS=" . $row['maHS'] . "&nienKhoa=" . $row['nienKhoa'] . "' class='btn btn-success'>
                                <i class='bi bi-pencil-square'></i>
                              </a>
                              <a href='hocsinh.php?delete=true&maHS=" . $row['maHS'] . "' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>
                                <i class='bi bi-trash'></i>
                              </a>
                            </td>
                          </tr>";
                    $stt++;
                  }
                } else {
                  echo "<tr><td colspan='10' class='text-center'>Không có dữ liệu nào</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

<<<<<<< HEAD
  <?php
  // Hiển thị thông tin thống kê lớp học
  $sql = "CALL thong_ke_hocsinh_theo_lop()";
  $result = $conn->query($sql);
  ?>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Thống kê học sinh theo niên khóa và lớp học</h5>
      <?php
      if ($result->num_rows > 0) {
        echo "<table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>Niên khoá</th>
                            <th>Lớp</th>
                            <th>Tổng số học sinh</th>
                            <th>Số nam</th>
                            <th>Số nữ</th>
                            <th>Danh sách học sinh</th>
                        </tr>
                    </thead>
                    <tbody>";
        while ($row = $result->fetch_assoc()) {
          echo "<tr>
                        <td>" . $row['nienKhoa'] . "</td>
                        <td>" . $row['tenLop'] . "</td>
                        <td>" . $row['tongSo'] . "</td>
                        <td>" . $row['soNam'] . "</td>
                        <td>" . $row['soNu'] . "</td>
                        <td>" . $row['danhSachHocsinh'] . "</td>
                      </tr>";
        }
        echo "</tbody></table>";
      } else {
        echo "Không có dữ liệu thống kê";
      }
      ?>
    </div>
  </div>
=======
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Danh sách thống kê theo lớp từng niên khóa</h5>

            <?php
            // Gọi thủ tục tính tổng học sinh theo lớp và niên khoá
            $sql = "CALL tinh_tong_hoc_sinh_theo_lop_nien_khoa()";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table table-bordered'>
                        <thead>
                            <tr>
                                <th>Niên khoá</th>
                                <th>Lớp</th>
                                <th>Tổng số học sinh</th>
                                <th>Số học sinh nam</th>
                                <th>Số học sinh nữ</th>
                            </tr>
                        </thead>
                        <tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['nienKhoa'] . "</td>
                            <td>" . $row['tenLop'] . "</td>
                            <td>" . $row['tongSo'] . "</td>
                            <td>" . $row['soNam'] . "</td>
                            <td>" . $row['soNu'] . "</td>
                          </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "Không có dữ liệu thống kê.";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Tổng số học sinh trường theo niên khóa</h5>

            <?php
            // Call stored procedure for statistics by school and year
            $sql = "CALL tinh_tong_hoc_sinh_truong_theo_nien_khoa()";

            // Make sure the previous query result is cleared before running the new one
            if ($conn->more_results()) {
                $conn->next_result();
            }

            if ($result = $conn->query($sql)) {
                // Check if the query was successful
                if ($result->num_rows > 0) {
                    echo "<table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>Niên khoá</th>
                                    <th>Tổng số học sinh</th>
                                    <th>Số học sinh nam</th>
                                    <th>Số học sinh nữ</th>
                                </tr>
                            </thead>
                            <tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['nienKhoa'] . "</td>
                                <td>" . $row['tongSo'] . "</td>
                                <td>" . $row['soNam'] . "</td>
                                <td>" . $row['soNu'] . "</td>
                              </tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "Không có dữ liệu thống kê.";
                }

                // Free the result set to avoid memory issues
                $result->free();
            } else {
                echo "Error executing query: " . $conn->error;
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>
>>>>>>> caed007 (hocsinh)




</main>

<?php
// Xử lý xóa học sinh
if (isset($_GET['delete']) && isset($_GET['maHS'])) {
  $maHS = $_GET['maHS'];
  $query = "DELETE FROM hocsinh WHERE maHS = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $maHS);

  if ($stmt->execute()) {
    echo "<script>alert('Xoá thành công!'); window.location.href = 'hocsinh.php';</script>";
  } else {
    echo "Lỗi khi xoá học sinh: " . $stmt->error;
  }
}
?>
<<<<<<< HEAD
include('partials/footer.php');
?>
=======

<?php include('partials/footer.php'); ?>
>>>>>>> caed007 (hocsinh)
