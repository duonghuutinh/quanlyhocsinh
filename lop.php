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
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
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
                <a href="#" class="btn btn-success"><i class="ri-file-word-2-line"></i> Xuất Excel</a>
              </div>
            </h5>
            <table class="table datatable">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Tên lớp</th>
                  <th scope="col">Sĩ số</th>
                  <th scope="col">Chủ nhiệm</th>
                  <th scope="col">Phòng học</th>
                  <th scope="col">Niên Khoá</th>
                  <th scope="col">Thao tác</th>
              </thead>
              <tbody>
                <?php
              $sql = "SELECT lop.maLop, lop.tenLop, 
              COUNT(hocsinh.maHS) AS soHocSinh, 
              giaovien.hoTen AS giaoVienChuNhiem, 
              phongLop.maPhong,  -- Thêm maPhong từ bảng phongLop
              chunhiem.namHoc
              FROM lop
              LEFT JOIN hocsinh ON lop.maLop = hocsinh.maLop
              LEFT JOIN chunhiem ON lop.maLop = chunhiem.maLop
              LEFT JOIN giaovien ON chunhiem.maGV = giaovien.maGV
              LEFT JOIN phongLop ON lop.maLop = phongLop.maLop  -- Kết nối bảng lop với phongLop
              GROUP BY lop.maLop, lop.tenLop, giaovien.hoTen, chunhiem.namHoc, phongLop.maPhong";
      
      
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  $stt = 1;
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                <th scope='row'>{$stt}</th>
                <td>{$row['tenLop']}</td>
                <td>{$row['soHocSinh']}</td>
                <td>{$row['giaoVienChuNhiem']}</td>
                <td>{$row['maPhong']}</td>
                <td>{$row['namHoc']}</td>
                <td>
                       <a href='edit_lop.php?maLop=" . $row['maLop'] . "' class='btn btn-success'><i class='bi bi-pencil-square'></i></a>
                        <a href='lop.php?delete=true&maLop=" . $row['maLop'] . "' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'><i class='bi bi-trash'></i></a>
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
    // Thực hiện câu lệnh xóa
    $query = "DELETE FROM lop WHERE maLop = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $maLop);

    if ($stmt->execute()) {
      echo "<script>alert('Xoá thành công!'); window.location.href = 'lop.php';</script>";
  } else {
      echo "Lỗi khi xoá học sinh: " . $stmt->error;
  }
}
?>
<?php
include('partials/footer.php');
