<?php 

// Thông tin kết nối đến MySQL
$servername = "localhost";
$username = "root"; // hoặc tên người dùng bạn cấu hình
$password = "kunieucoi1994"; // mật khẩu đã thiết lập
$dbname = "qlhs"; // tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
} else {
    echo "Kết nối thành công!";
}

