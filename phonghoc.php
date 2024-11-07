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
                      <table class="table ">
                          <thead>
                              <tr>
                                  <th scope="col">STT</th>
                                  <th scope="col">Mã phòng</th>
                                  <th scope="col">Số phòng</th>
                                  <th scope="col">Số ngồi tối đa</th>
                                  <th scope="col">Thao tác</th>
                          </thead>
                          <tbody>
                          <?php
                          $sql = "SELECT * FROM phonghoc"; // Thay đổi tên bảng nếu cần
                          $result = $conn->query($sql);
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
                        <a href='phonghoc.php?delete=true&maphonghoc=" . $row['maPhong'] . "' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'><i class='bi bi-trash'></i></a>
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
    // Thực hiện câu lệnh xóa
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
