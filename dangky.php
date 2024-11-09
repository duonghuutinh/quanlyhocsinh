<?php
include('partials/connectDB.php');

// Khởi tạo biến để lưu thông báo lỗi và các giá trị đầu vào
$error_message = '';
$name_value = '';
$email_value = '';
$username_value = '';

// Kiểm tra xem có phải là yêu cầu POST không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận dữ liệu từ biểu mẫu
    $hovaten = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $taikhoan = isset($_POST['username']) ? trim($_POST['username']) : '';
    $matkhau = isset($_POST['password']) ? $_POST['password'] : '';
    $role = 1; 

    // Kiểm tra các trường không trống
    if (empty($hovaten) || empty($email) || empty($taikhoan) || empty($matkhau)) {
        $error_message = "Vui lòng điền tất cả các trường.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Kiểm tra định dạng email
        $error_message = "Địa chỉ email không hợp lệ.";
    } else {
        // Bảo mật mật khẩu
        $hashed_password = password_hash($matkhau, PASSWORD_DEFAULT);

        // Kiểm tra xem tài khoản đã tồn tại chưa
        $stmt_check = $conn->prepare("SELECT * FROM taikhoan WHERE taikhoan = ?");
        $stmt_check->bind_param("s", $taikhoan);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Tài khoản đã tồn tại.";
        } else {
            // Thêm thông tin vào cơ sở dữ liệu
            $stmt_insert = $conn->prepare("INSERT INTO taikhoan (hovaten, email, taikhoan, matkhau, role) VALUES (?, ?, ?, ?, ?)");
            $stmt_insert->bind_param("ssssi", $hovaten, $email, $taikhoan, $hashed_password, $role);

            if ($stmt_insert->execute()) {
                echo "<script>alert('Đăng ký thành công!'); window.location.href = 'dangnhap.php';</script>";
                exit;
            } else {
                $error_message = "Lỗi khi thêm tài khoản: " . $conn->error;
            }
        }
    }

    // Giữ lại giá trị nhập vào nếu có lỗi
    $name_value = htmlspecialchars($hovaten);
    $email_value = htmlspecialchars($email);
    $username_value = htmlspecialchars($taikhoan);
}

// Đóng kết nối
$conn->close();
?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Đăng Ký</title>
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
                                    <h5 class="card-title text-center pb-0 fs-4">Đăng Ký</h5>
                                   
                                </div>

                                <!-- Hiển thị thông báo lỗi nếu có -->
                                <?php if (!empty($error_message)): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error_message; ?>
                                    </div>
                                <?php endif; ?>

                                <form class="row g-3 needs-validation" action="dangky.php" method="POST" novalidate>
                                    <div class="col-12">
                                        <label for="yourName" class="form-label">Họ và tên</label>
                                        <input type="text" name="name" class="form-control" id="yourName" value="<?php echo $name_value; ?>" required>
                                        <div class="invalid-feedback">Vui lòng, nhập vào họ và tên!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourEmail" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="yourEmail" value="<?php echo $email_value; ?>" required>
                                        <div class="invalid-feedback">Vui lòng nhập vào địa chỉ email!</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Tài khoản</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="text" name="username" class="form-control" id="yourUsername" value="<?php echo $username_value; ?>" required>
                                            <div class="invalid-feedback">Vui lòng nhập vào tài khoản.</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Mật khẩu</label>
                                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                                        <div class="invalid-feedback">Vui lòng, nhập vào mật khẩu!</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                                            <label class="form-check-label" for="acceptTerms">Tôi đồng ý và chấp nhận các <a href="#">điều khoản và điều kiện.</a></label>
                                            <div class="invalid-feedback">Bạn phải đồng ý trước khi gửi.</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Đăng ký</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0">Đã có tài khoản? <a href="dangnhap.php">Đăng nhập</a></p>
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