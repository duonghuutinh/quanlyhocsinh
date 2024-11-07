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
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
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
                <a href="export_pdf_hocsinh.php" class="btn btn-success"><i class="ri-file-word-2-line"></i> Xuất PDF</a>
              </div>
            </h5>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Mã học sinh</th>
                  <th scope="col">Họ và tên</th>
                  <th scope="col">Giới Tính</th>
                  <th scope="col">Lớp</th>
                  <th scope="col">Ngày sinh</th>
                  <th scope="col">Số điện thoại</th>
                  <th scope="col">Địa chỉ</th>
                  <th scope="col">Thao Tác</th>
              </thead>

              <tbody>
                <?php
                
                  $sql = "SELECT hocsinh.*, lop.tenLop 
                  FROM hocsinh 
                  JOIN lop ON hocsinh.maLop = lop.maLop;
                  "; 
                   
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  $stt = 1;
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <th scope='row'>{$stt}</th>
                    <td>" . (isset($row['maHS']) ? $row['maHS'] : 'N/A') . "</td> <!-- Kiểm tra tồn tại -->
                    <td>" . (isset($row['hoTen']) ? $row['hoTen'] : 'N/A') . "</td> <!-- Kiểm tra tồn tại -->
                    <td>" . (isset($row['gioiTinh']) ? $row['gioiTinh'] : 'N/A') . "</td> <!-- Kiểm tra tồn tại -->
                    <td>" . (isset($row['tenLop']) ? $row['tenLop'] : 'N/A') . "</td> <!-- Kiểm tra tồn tại -->
                    <td>" . (isset($row['ngaySinh']) ? $row['ngaySinh'] : 'N/A') . "</td> <!-- Kiểm tra tồn tại -->
                    <td>" . (isset($row['sdtPH']) ? $row['sdtPH'] : 'N/A') . "</td> <!-- Kiểm tra tồn tại -->
                    <td>" . (isset($row['diaChi']) ? $row['diaChi'] : 'N/A') . "</td> <!-- Kiểm tra tồn tại -->
                    <td>
                       <a href='edit_hocsinh.php?maHS=" . $row['maHS'] . "' class='btn btn-success'><i class='bi bi-pencil-square'></i></a>
                        <a href='hocsinh.php?delete=true&maHS=" . $row['maHS'] . "' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'><i class='bi bi-trash'></i></a>
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
  if (isset($_GET['delete']) && isset($_GET['maHS'])) {
    $maHS = $_GET['maHS'];
    // Thực hiện câu lệnh xóa
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

<?php
include('partials/footer.php');
