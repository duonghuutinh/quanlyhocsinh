<?php
require_once('libraries/TCPDF-main/TCPDF-main/tcpdf.php');
include('partials/connectDB.php');

// Tạo đối tượng TCPDF và thiết lập hướng dọc (Portrait)
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tên Tác Giả');
$pdf->SetTitle('Danh sách Phòng Lớp');

// Thiết lập font và trang
$pdf->SetFont('dejavusans', '', 12);
$pdf->AddPage();

// Tiêu đề chính căn giữa
$pdf->Cell(0, 10, 'Danh sách Phòng Lớp', 0, 1, 'C');

// Thiết lập màu nền và độ dày đường viền cho tiêu đề cột
$pdf->SetFillColor(230, 230, 230);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetDrawColor(50, 50, 100);
$pdf->SetLineWidth(0.3);

// Tạo tiêu đề các cột
$pdf->Cell(10, 8, 'STT', 1, 0, 'C', 1);
$pdf->Cell(40, 8, 'Số phòng', 1, 0, 'C', 1);
$pdf->Cell(60, 8, 'Lớp', 1, 0, 'C', 1);
$pdf->Cell(50, 8, 'Học kỳ-năm học', 1, 1, 'C', 1);

// Câu truy vấn cơ bản với JOIN
$sql = "SELECT phonglop.*, lop.tenLop, namhoc.nienKhoa
        FROM phonglop
        JOIN lop ON phonglop.maLop = lop.maLop
        JOIN namhoc ON lop.maNamHoc = namhoc.maNamHoc";

// Thêm phần tìm kiếm vào SQL nếu có
if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
    $column = $_GET['column'];
    $keyword = "%" . $_GET['keyword'] . "%";

    if ($column) {
        $sql .= " WHERE $column LIKE ?";
        $params = [$keyword];
    } else {
        // Tìm kiếm trong nhiều cột
        $sql .= " WHERE maPhong LIKE ? OR tenLop LIKE ? OR nienKhoa LIKE ?";
        $params = [$keyword, $keyword, $keyword];
    }
} else {
    $params = [];
}

// Chuẩn bị câu truy vấn với các tham số đã bind
$stmt = $conn->prepare($sql);

// Nếu có tham số, bind chúng vào câu truy vấn
if (!empty($params)) {
    $types = str_repeat('s', count($params)); // Tạo chuỗi kiểu dữ liệu 's' cho các tham số
    $stmt->bind_param($types, ...$params);
}

// Thực thi câu truy vấn và lấy kết quả
$stmt->execute();
$result = $stmt->get_result();

$stt = 1; // Biến đếm cho cột STT

// Xuất dữ liệu ra PDF
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 8, $stt, 1, 0, 'C');
        $pdf->Cell(40, 8, $row['maPhong'], 1, 0, 'C');
        $pdf->Cell(60, 8, $row['tenLop'], 1, 0, 'C');
        $pdf->Cell(50, 8, $row['nienKhoa'], 1, 1, 'C');
        $stt++;
    }
} else {
    $pdf->Cell(0, 8, 'Không có dữ liệu', 0, 1, 'C');
}

// Xuất file PDF
$pdf->Output('danh_sach_phonglop.pdf', 'I');
?>
