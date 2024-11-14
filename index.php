<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Lấy số lượng từ các bảng
$giaovien_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM giaovien"))['count'];
$chunhiem_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM chunhiem"))['count'];
$hocsinh_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM hocsinh"))['count'];
$lop_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM lop"))['count'];
$phonghoc_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM phonghoc"))['count'];
$namhoc_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM namhoc"))['count'];
$hocky_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM hocky"))['count'];
?>

<main id="main" class="main">
    <div class="pagetitle">
      <h1>Trang chủ</h1>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="container">
          <div class="row">
              <!-- Giáo viên -->
              <div class="col-xxl-3 col-md-6 mb-4">
                  <div class="card info-card sales-card">
                      <div class="card-body">
                          <h5 class="card-title">Giáo viên</h5>
                          <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                  <i class="ri-admin-line"></i>
                              </div>
                              <div class="ps-3">
                                  <h6><?php echo $giaovien_count; ?></h6>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Chủ nhiệm -->
              <div class="col-xxl-3 col-md-6 mb-4">
                  <div class="card info-card revenue-card">
                      <div class="card-body">
                          <h5 class="card-title">Chủ nhiệm</h5>
                          <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                  <i class="ri-user-follow-line"></i>
                              </div>
                              <div class="ps-3">
                                  <h6><?php echo $chunhiem_count; ?></h6>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Học sinh -->
              <div class="col-xxl-3 col-md-6 mb-4">
                  <div class="card info-card revenue-card">
                      <div class="card-body">
                          <h5 class="card-title">Học Sinh</h5>
                          <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                  <i class="ri-team-line"></i>
                              </div>
                              <div class="ps-3">
                                  <h6><?php echo $hocsinh_count; ?></h6>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Lớp -->
              <div class="col-xxl-3 col-md-6 mb-4">
                  <div class="card info-card revenue-card">
                      <div class="card-body">
                          <h5 class="card-title">Lớp</h5>
                          <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                  <i class="ri-building-4-line"></i>
                              </div>
                              <div class="ps-3">
                                  <h6><?php echo $lop_count; ?></h6>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Phòng học -->
              <div class="col-xxl-3 col-md-6 mb-4">
                  <div class="card info-card sales-card">
                      <div class="card-body">
                          <h5 class="card-title">Phòng Học</h5>
                          <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                  <i class="ri-layout-4-line"></i>
                              </div>
                              <div class="ps-3">
                                  <h6><?php echo $phonghoc_count; ?></h6>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Năm Học -->
              <div class="col-xxl-3 col-md-6 mb-4">
                  <div class="card info-card revenue-card">
                      <div class="card-body">
                          <h5 class="card-title">Năm Học</h5>
                          <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                  <i class="ri-book-open-line"></i>
                              </div>
                              <div class="ps-3">
                                  <h6><?php echo $namhoc_count; ?></h6>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <!-- Học Kỳ -->
              <div class="col-xxl-3 col-md-6 mb-4">
                  <div class="card info-card revenue-card">
                      <div class="card-body">
                          <h5 class="card-title">Học Kỳ</h5>
                          <div class="d-flex align-items-center">
                              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                  <i class="ri-clipboard-line"></i>
                              </div>
                              <div class="ps-3">
                                  <h6><?php echo $hocky_count; ?></h6>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</main><!-- End #main -->

<?php
include('partials/footer.php');
?>
