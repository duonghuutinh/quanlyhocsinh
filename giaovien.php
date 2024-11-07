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
              <div>
                <a href="add_giaovien.php" class="btn btn-primary me-2">Thêm</a>
                <a href="export_pdf_giaovien.php" class="btn btn-success"><i class="ri-file-word-2-line"></i> Xuất PDF</a>
              </div>
            </h5>
            <table class="table">
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
              </thead>

              <tbody>
                <?php
                $sql = "SELECT * FROM giaovien";
                $result = $conn->query($sql);
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
  
  <?php
  if (isset($_GET['delete']) && isset($_GET['maGV'])) {
    $maGV = $_GET['maGV'];
    // Thực hiện câu lệnh xóa
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