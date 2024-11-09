<?php
session_start(); // Bắt đầu phiên
include('partials/connectDB.php'); // Kết nối tới cơ sở dữ liệu

// Khởi tạo biến để lưu thông báo lỗi và giá trị tên đăng nhập
$error_message = '';
$username_value = ''; // Biến để giữ lại tên đăng nhập

// Kiểm tra xem có phải là yêu cầu POST không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận dữ liệu từ biểu mẫu
    $taikhoan = isset($_POST['username']) ? trim($_POST['username']) : '';
    $matkhau = isset($_POST['password']) ? $_POST['password'] : '';

    // Kiểm tra các trường không trống
    if (empty($taikhoan) || empty($matkhau)) {
        $error_message = "Vui lòng điền tất cả các trường.";
    } else {
        // Sử dụng prepared statements để tránh SQL Injection
        $stmt = $conn->prepare("SELECT * FROM taikhoan WHERE taikhoan = ?");
        $stmt->bind_param("s", $taikhoan); // "s" chỉ định rằng biến là một chuỗi
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Kiểm tra mật khẩu
            if (password_verify($matkhau, $row['matkhau'])) {
                // Nếu mật khẩu chính xác, lưu thông tin vào phiên
                $_SESSION['username'] = $taikhoan;
                $_SESSION['role'] = $row['role']; // Lưu vai trò nếu cần thiết

                // Chuyển hướng tới trang chính hoặc trang người dùng
                header("Location: index.php");
                exit;
            } else {
                $error_message = "Mật khẩu không chính xác.";
            }
        } else {
            $error_message = "Tài khoản không tồn tại.";
        }
    }
    // Giữ lại tên đăng nhập nếu có lỗi
    $username_value = htmlspecialchars($taikhoan); 
}

// Đóng kết nối
$conn->close();
?>


<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Đăng Nhập</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">SmartAdmin</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Đăng Nhập</h5>
                    
                  </div>

                  <!-- Hiển thị thông báo lỗi nếu có -->
                  <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                      <?php echo $error_message; ?>
                    </div>
                  <?php endif; ?>

                  <form class="row g-3 needs-validation" method="POST" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Tài khoản</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" value="<?php echo $username_value; ?>" required>
                        <div class="invalid-feedback">Vui lòng, nhập vào tài khoản!</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Mật khẩu</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Vui lòng, nhập vào mật khẩu!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Ghi nhớ tôi</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Đăng nhập</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Bạn chưa có tài khoản? <a href="dangky.php">Tạo tài khoản</a></p>
                    </div>
                  </form>

                </div>
              </div>
              <div class="credits">
                Thiết kế bởi <a href="">Nhóm_09</a>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>
  </main><!-- End #main -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>
