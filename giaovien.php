<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');
?>
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Giáo Viên</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Giáo viên</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <div class="pagetitle">
    <h1>Danh sách giáo viên</h1>
  </div>
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">

              <!-- Group buttons and search form in the same row -->
              <div class="d-flex align-items-center w-100 ">
                <!-- Add and Export PDF buttons -->
                <a href="add_giaovien.php" class="btn btn-primary me-2">Thêm</a>
                <a href="export_pdf_giaovien.php?column=<?php echo isset($_GET['column']) ? $_GET['column'] : ''; ?>&keyword=<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>&order=<?php echo isset($_GET['order']) ? $_GET['order'] : 'asc'; ?>" class="btn btn-success me-4">
    <i class="ri-file-pdf-line"></i> Xuất PDF
</a>
                <!-- Search Form -->
              </div>

            </h5>
            <div class="row">
              <form method="GET" action="" class="d-flex align-items-center  w-50 ">
                <div class="me-2" style="flex: 1;">
                  <select name="column" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="maGV">Mã Giáo Viên</option>
                    <option value="hoTen">Họ và tên</option>
                    <option value="gioiTinh">Giới tính</option>
                    <option value="ngaySinh">Ngày sinh</option>
                    <option value="SDT">Số điện thoại</option>
                    <option value="email">Email</option>
                    <option value="diaChi">Địa chỉ</option>
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
                    <option value="maGV">Mã Giáo Viên</option>
                    <option value="hoTen">Họ và tên</option>
                    <option value="gioiTinh">Giới tính</option>
                    <option value="ngaySinh">Ngày sinh</option>
                    <option value="SDT">Số điện thoại</option>
                    <option value="email">Email</option>
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

            <!-- Search Form -->
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col">Mã Giáo Viên</th>
                  <th scope="col">Họ và tên</th>
                  <th scope="col">Giới tính</th>
                  <th scope="col">Ngày sinh</th>
                  <th scope="col">Số điện thoại</th>
                  <th scope="col">Email</th>
                  <th scope="col">Địa chỉ</th>
                  <th scope="col">Thao tác</th>
                </tr>
              </thead>

              <tbody>
                <?php
                // Kiểm tra và tạo SQL cho việc tìm kiếm
                $sql = "SELECT * FROM giaovien";

                // Thêm phần tìm kiếm vào SQL nếu có
                if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
                  $column = $_GET['column'];
                  $keyword = $_GET['keyword'];
                  $searchTerm = "%" . $keyword . "%";

                  if ($column) {
                    $sql .= " WHERE $column LIKE ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $searchTerm);
                  } else {
                    // Tìm kiếm trong nhiều cột
                    $sql .= " WHERE maGV LIKE ? OR hoTen LIKE ? OR gioiTinh LIKE ? OR ngaySinh LIKE ? OR SDT LIKE ? OR email LIKE ? OR diaChi LIKE ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
                  }
                } else {
                  $stmt = $conn->prepare($sql);
                }

                // Thêm sắp xếp nếu có
                if (isset($_GET['column']) && isset($_GET['order']) && in_array($_GET['column'], ['maGV', 'hoTen', 'gioiTinh', 'ngaySinh', 'SDT', 'email', 'diaChi'])) {
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
                      <td>{$row['maGV']}</td>
                      <td>{$row['hoTen']}</td>
                      <td>{$row['gioiTinh']}</td>
                      <td>{$row['ngaySinh']}</td>
                      <td>{$row['SDT']}</td>
                      <td>{$row['email']}</td>
                      <td>{$row['diaChi']}</td>          
                      <td>
                        <a href='edit_giaovien.php?maGV=" . $row['maGV'] . "' class='btn btn-success'><i class='bi bi-pencil-square'></i></a>
                        <a href='giaovien.php?delete=true&maGV=" . $row['maGV'] . "' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'><i class='bi bi-trash'></i></a>
                      </td>
                    </tr>";
                    $stt++;
                  }
                } else {
                  echo "<tr><td colspan='9' class='text-center'>Không có dữ liệu nào</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  if (isset($_GET['delete']) && isset($_GET['maGV'])) {
    $maGV = $_GET['maGV'];
    $query = "DELETE FROM giaovien WHERE maGV = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $maGV);

    if ($stmt->execute()) {
      echo "<script>alert('Xoá thành công!'); window.location.href = 'giaovien.php';</script>";
    } else {
      echo "Lỗi khi xoá giáo viên: " . $stmt->error;
    }
  }
  ?>
</main><!-- End #main -->
<?php
include('partials/footer.php');


