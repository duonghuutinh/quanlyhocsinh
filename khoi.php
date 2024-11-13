<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Khởi tạo tham số tìm kiếm và sắp xếp
$column = isset($_GET['column']) ? $_GET['column'] : null;
$keyword = isset($_GET['keyword']) ? '%' . $_GET['keyword'] . '%' : null;
$order_column = isset($_GET['order_column']) ? $_GET['order_column'] : 'khoi';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Gọi thủ tục `getStudentCountByClass` với các tham số
$stmt = $conn->prepare("CALL getStudentCountByClass(?, ?, ?, ?)");
$stmt->bind_param("ssss", $column, $keyword, $order_column, $order);
$stmt->execute();
$result = $stmt->get_result();
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Danh sách Khối</h1>
  </div>
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center w-100">
                <a href="export_pdf_khoi.php?column=<?php echo isset($_GET['column']) ? $_GET['column'] : ''; ?>&keyword=<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>&order=<?php echo isset($_GET['order']) ? $_GET['order'] : 'asc'; ?>" class="btn btn-success me-4">
                  <i class="ri-file-pdf-line"></i> Xuất PDF
                </a>
              </div>
            </h5>

            <!-- Form tìm kiếm -->
            <div class="row">
                <form method="GET" action="" class="d-flex align-items-center w-50">
                <div class="me-2" style="flex: 1;">
                    <select name="column" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="khoi" <?php if ($column === 'khoi') echo 'selected'; ?>>Khối</option>
                    <option value="soSiSo" <?php if ($column === 'soSiSo') echo 'selected'; ?>>Sĩ số</option>
                    <option value="nienKhoa" <?php if ($column === 'nienKhoa') echo 'selected'; ?>>Năm học</option>
                    </select>
                </div>
                <div class="me-2" style="flex: 1;">
                    <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa tìm kiếm" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form>

                <!-- Form sắp xếp -->
                <form method="GET" action="" class="d-flex align-items-center w-50">
                    <div class="me-2" style="flex: 1;">
                        <select name="order_column" class="form-select">
                        <option value="khoi" <?php if ($order_column === 'khoi') echo 'selected'; ?>>Khối</option>
                        <option value="soSiSo" <?php if ($order_column === 'soSiSo') echo 'selected'; ?>>Sĩ số</option>
                        <option value="nienKhoa" <?php if ($order_column === 'nienKhoa') echo 'selected'; ?>>Năm học</option>
                        </select>
                    </div>
                    <div class="me-2" style="flex: 1;">
                        <select name="order" class="form-select">
                        <option value="asc" <?php if ($order === 'asc') echo 'selected'; ?>>Tăng dần</option>
                        <option value="desc" <?php if ($order === 'desc') echo 'selected'; ?>>Giảm dần</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Sắp xếp</button>
                </form>
            </div>
            <!-- Bảng hiển thị danh sách khối -->
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col">Khối</th>
                  <th scope="col">Sĩ Số</th>
                  <th scope="col">Năm Học</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($result->num_rows > 0) {
                  $stt = 1;
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                      <th scope='row'>{$stt}</th>
                      <td>{$row['khoi']}</td>
                      <td>{$row['soSiSo']}</td>
                      <td>{$row['nienKhoa']}</td>
                    </tr>";
                    $stt++;
                  }
                } else {
                  echo "<tr><td colspan='4' class='text-center'>Không có dữ liệu nào</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php include('partials/footer.php'); ?>
