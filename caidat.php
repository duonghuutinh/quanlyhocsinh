<?php
session_start();
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    die("Bạn chưa đăng nhập. Vui lòng đăng nhập trước khi tiếp tục.");
}

include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

// Khởi tạo biến để lưu thông báo lỗi và trạng thái
$error_message = '';
$success_message = '';

// Kiểm tra xem có phải là yêu cầu POST không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận dữ liệu từ biểu mẫu
    $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $username = $_SESSION['username']; // Sử dụng tài khoản từ phiên

    // Kiểm tra các trường không trống
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error_message = "Vui lòng điền tất cả các trường.";
    } elseif ($new_password !== $confirm_password) {
        $error_message = "Mật khẩu mới và xác nhận mật khẩu không khớp.";
    } else {
        // Lấy thông tin người dùng từ cơ sở dữ liệu
        $stmt = $conn->prepare("SELECT matkhau FROM taikhoan WHERE taikhoan = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $error_message = "Người dùng không tồn tại.";
        } else {
            $user = $result->fetch_assoc();
            // Kiểm tra mật khẩu hiện tại
            if (!password_verify($current_password, $user['matkhau'])) {
                $error_message = "Mật khẩu hiện tại không đúng.";
            } else {
                // Bảo mật mật khẩu mới
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                // Cập nhật mật khẩu mới vào cơ sở dữ liệu
                $stmt_update = $conn->prepare("UPDATE taikhoan SET matkhau = ? WHERE taikhoan = ?");
                $stmt_update->bind_param("ss", $hashed_new_password, $username);

                if ($stmt_update->execute()) {
                    $success_message = "Đổi mật khẩu thành công!";
                } else {
                    $error_message = "Lỗi khi cập nhật mật khẩu: " . $conn->error;
                }
            }
        }
    }
}

// Đóng kết nối
$conn->close();
?>

<main id="main" class="main">
    <div class="pagetitle">
    <h1>Cài Đặt</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Cài đặt</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Đổi mật khẩu</h5>
                        <!-- Hiển thị thông báo lỗi nếu có -->
                        <?php if (!empty($error_message)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Hiển thị thông báo thành công nếu có -->
                        <?php if (!empty($success_message)): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $success_message; ?>
                            </div>
                        <?php endif; ?>

                        <form action="" method="post">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Mật khẩu hiện tại<span style="color: red;">*</span></label>
                                <div class="col-sm-10">
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Mật khẩu mới<span style="color: red;">*</span></label>
                                <div class="col-sm-10">
                                    <input type="password" name="new_password" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Nhập lại mật khẩu<span style="color: red;">*</span></label>
                                <div class="col-sm-10">
                                    <input type="password" name="confirm_password" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
include('partials/footer.php');
?>
