<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');
?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Phòng Học</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Phòng học</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="pagetitle">
        <h1>Danh sách phòng học</h1>
    </div>

    <section class="section">
      <div class="row">
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-body">
                         <h5 class="card-title d-flex justify-content-between align-items-center">
                              <div>
                                  <a href="add_phonghoc.php" class="btn btn-primary me-2">Thêm</a>
                                  <a href="export_pdf_phonghoc.php" class="btn btn-success"><i class="ri-file-word-2-line"></i> Xuất PDF</a>
                              </div>                          
                          </h5>
                          <div class="row">
                            <form method="GET" action="" class="d-flex align-items-center w-50">
                              <div class="me-2" style="flex: 1;">
                                <select name="column" class="form-select">
                                  <option value="">Tất cả</option>
                                  <option value="maPhong">Mã phòng</option>
                                  <option value="soPhong">Số phòng</option>
                                  <option value="soChoToiDa">Số chỗ tối đa</option>
                                </select>
                              </div>
                              <div class="me-2" style="flex: 1;">
                                <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa tìm kiếm">
                              </div>
                              <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </form>
                            <form method="GET" action="" class="d-flex align-items-center w-50">
                              <div class="me-2" style="flex: 1;">
                                <select name="column" class="form-select">
                                  <option value="">Chọn cột sắp xếp</option>
                                  <option value="maPhong">Mã phòng</option>
                                  <option value="soPhong">Số phòng</option>
                                  <option value="soChoToiDa">Số chỗ tối đa</option>
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
                                  <th scope="col">Mã phòng</th>
                                  <th scope="col">Số phòng</th>
                                  <th scope="col">Số chỗ tối đa</th>
                                  <th scope="col">Thao tác</th>
                          </thead>
                          <tbody>
                          <?php
                          $sql = "SELECT * FROM phonghoc"; // Thay đổi tên bảng nếu cần

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
                              $sql .= " WHERE maPhong LIKE ? OR soPhong LIKE ? OR soChoToiDa LIKE ?";
                              $stmt = $conn->prepare($sql);
                              $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
                            }
                          } else {
                            $stmt = $conn->prepare($sql);
                          }
          
                          // Thêm sắp xếp nếu có
                          if (isset($_GET['column']) && isset($_GET['order']) && in_array($_GET['column'], ['maPhong', 'soPhong', 'soChoToiDa'])) {
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
                          <td>{$row['maPhong']}</td>
                          <td>{$row['soPhong']}</td>
                          <td>{$row['soChoToiDa']}</td>
                          <td>
                         <a href='edit_phonghoc.php?maPhong=" . $row['maPhong'] . "' class='btn btn-success'><i class='bi bi-pencil-square'></i></a>
                      <a href='phonghoc.php?delete=true&maPhong=" . $row['maPhong'] . "' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>
                      <i class='bi bi-trash'></i></a>
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
if (isset($_GET['delete']) && isset($_GET['maPhong'])) {
  $maPhong = $_GET['maPhong'];
  
  // Sanitize the maPhong to prevent any malicious input
  $maPhong = htmlspecialchars($maPhong);
  
  // Prepare and execute delete statement
  $query = "DELETE FROM phonghoc WHERE maPhong = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $maPhong);
  
  if ($stmt->execute()) {
      echo "<script>alert('Xoá thành công!'); window.location.href = 'phonghoc.php';</script>";
  } else {
      echo "Lỗi khi xoá Phòng học: " . $stmt->error;
  }
}
?>

<?php
include('partials/footer.php');
?>
