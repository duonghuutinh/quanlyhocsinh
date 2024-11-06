<?php

// Thông tin kết nối
$servername = "localhost"; // hoặc tên máy chủ của bạn
$username = "root"; // tên người dùng mặc định của XAMPP
$password = "kunieucoi1994"; // mật khẩu mặc định thường để trống
$dbname = "quanlyhocsinh"; // tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
