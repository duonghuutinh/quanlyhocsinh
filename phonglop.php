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
                                <a href="#" class="btn btn-success"><i class="ri-file-word-2-line"></i> Xuất Excel</a>  
                            </div>                          
                        </h5>
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Số phòng</th>
                                    <th scope="col">Lớp</th>
                                    <th scope="col">Học kỳ-năm học</th>                         
                                    <th scope="col">Thao Tác</th>
                            </thead>
                            <tbody>
                <?php
                // Lấy dữ liệu từ cơ sở dữ liệu
                $sql = "SELECT phonglop.*, lop.tenLop
                FROM phonglop
                JOIN lop ON phonglop.maLop = lop.maLop ";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  $stt = 1;
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                <th scope='row'>{$stt}</th>
                <td>{$row['maPhong']}</td>
                <td>{$row['tenLop']}</td>
                <td>{$row['hocKyNamHoc']}</td>
                <td>
                    <a href='edit_phonglop.php?maPhong=" . $row['maPhong'] . "' class='btn btn-success'><i class='bi bi-pencil-square'></i></a>
                        <a href='phonglop.php?delete=true&maPhong=" . $row['maPhong'] . "' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'><i class='bi bi-trash'></i></a>
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
    $query = "DELETE FROM phonglop WHERE maPhong = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $maPhong);

    if ($stmt->execute()) {
      echo "<script>alert('Xoá thành công!'); window.location.href = 'phonglop.php';</script>";
  } else {
      echo "Lỗi khi xoá Phòng lop: " . $stmt->error;
  }
}
?>
  <?php
include('partials/footer.php');

