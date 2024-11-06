<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Chủ Nhiệm</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Chủ nhiệm</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="pagetitle">
    <h1>Danh sách chủ nhiệm</h1>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title d-flex justify-content-between align-items-center">
              <div>
                <a href="add_chunhiem.php" class="btn btn-primary me-2">Thêm</a>
                <a href="#" class="btn btn-success"><i class="ri-file-word-2-line"></i> Xuất Excel</a>
              </div>
            </h5>
            <table class="table datatable">
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col">Mã giáo viên</th>
                  <th scope="col">Họ và Tên</th>
                  <th scope="col">Lớp</th>
                  <th scope="col">Năm học</th>
                  <th scope="col">Thao tác</th>
              </thead>
              <tbody>
                <?php
                // Lấy dữ liệu từ cơ sở dữ liệu
                $sql = "SELECT giaovien.maGV, giaovien.hoTen AS tenGiaoVien, lop.tenLop, lop.maLop, chunhiem.namHoc
                FROM chunhiem
                JOIN giaovien ON chunhiem.maGV = giaovien.maGV
                JOIN lop ON chunhiem.maLop = lop.maLop"; // Thực hiện JOIN với các bảng liên quan

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  $stt = 1;
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <th scope='row'>{$stt}</th>
                        <td>{$row['maGV']}</td>
                        <td>{$row['tenGiaoVien']}</td>
                        <td>{$row['tenLop']}</td>
                        <td>{$row['namHoc']}</td>
                        <td>
                        <!-- Sửa liên kết để sử dụng maLop thay vì tenLop -->
                        <a href='edit_chunhiem.php?maGV={$row['maGV']}&maLop={$row['maLop']}' class='btn btn-success'>
                            <i class='bi bi-pencil-square'></i> 
                        </a>
                        <a href='' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete?\")'>
                            <i class='bi bi-trash'></i>
                        </a>
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
include('partials/footer.php');
?>
