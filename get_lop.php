<?php
include('partials/connectDB.php');

if (isset($_POST['maNamHoc'])) {
    $maNamHoc = $_POST['maNamHoc'];
    
    // Truy vấn lấy danh sách lớp dựa trên maNamHoc
    $sql = "SELECT maLop, tenLop FROM lop WHERE maNamHoc = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maNamHoc);
    $stmt->execute();
    $result = $stmt->get_result();

    // Tạo HTML cho các tùy chọn lớp
    $options = "<option value=''>Chọn Lớp</option>";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['maLop'] . "'>" . $row['tenLop'] . "</option>";
    }

    echo $options;

    $stmt->close();
}
$conn->close();

