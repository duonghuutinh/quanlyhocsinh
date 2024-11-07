<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Môn Học</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Môn học</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="pagetitle">
    <h1>Danh sách môn học</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
              <div>
                <a href="add_monhoc.php" class="btn btn-primary me-2">Thêm</a>
                <a href="export_pdf_monhoc.php" class="btn btn-success"><i class="ri-file-word-2-line"></i> Xuất PDF</a>

              </div>
            </h5>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Mã môn</th>
                  <th scope="col">Tên môn</th>
                  <th scope="col">Khối</th>
                  <th scope="col">Thao tác</th>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT * FROM monhoc";
                $result = $conn->query($sql);
            
                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
              }
              
             
                

                
               
              
                if ($result->num_rows > 0) {
                  $stt = 1;
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                <th scope='row'>{$stt}</th>
                <td>{$row['maMon']}</td>
                <td>{$row['tenMonHoc']}</td>
                <td>{$row['khoi']}</td>
                <td>
                  <a href='edit_monhoc.php?maMon=" . $row['maMon'] . "' class='btn btn-success'><i class='bi bi-pencil-square'></i></a>
                        <a href='monhoc.php?delete=true&maMonHoc=" . $row['maMon'] . "' class='btn btn-danger' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'><i class='bi bi-trash'></i></a>
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
  if (isset($_GET['delete']) && isset($_GET['maMon'])) {
    $maMon = $_GET['maMon'];
    // Thực hiện câu lệnh xóa
    $query = "DELETE FROM monhoc WHERE maMon = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $maMon);

    if ($stmt->execute()) {
      echo "<script>alert('Xoá thành công!'); window.location.href = 'monhoc.php';</script>";
  } else {
      echo "Lỗi khi xoá giáo viên: " . $stmt->error;
  }
}
?>
<!-- =====
<?php
include('partials/footer.php');
