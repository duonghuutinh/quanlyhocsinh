<?php
require_once('libraries/TCPDF-main/TCPDF-main/tcpdf.php');
include('partials/connectDB.php');

// Tạo đối tượng TCPDF và thiết lập hướng dọc (Portrait)
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tên Tác Giả');
$pdf->SetTitle('Danh sách Học Sinh');
$pdf->SetHeaderData('', 0, 'Danh sách Học Sinh', '');

// Thiết lập font và trang
$pdf->SetFont('dejavusans', '', 12);
$pdf->AddPage();

// Tiêu đề chính căn giữa
$pdf->Cell(0, 10, 'Danh sách Học Sinh', 0, 1, 'C');

// Thiết lập màu nền và độ dày đường viền cho tiêu đề cột
$pdf->SetFillColor(230, 230, 230);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetDrawColor(50, 50, 100);
$pdf->SetLineWidth(0.3);

// Tạo tiêu đề các cột
$pdf->Cell(10, 8, 'STT', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Mã học sinh', 1, 0, 'C', 1);
$pdf->Cell(60, 8, 'Họ và tên', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Giới tính', 1, 0, 'C', 1);
$pdf->Cell(40, 8, 'Lớp', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Ngày sinh', 1, 0, 'C', 1);
$pdf->Cell(40, 8, 'Số điện thoại', 1, 0, 'C', 1);
$pdf->Cell(40, 8, 'Địa chỉ', 1, 1, 'C', 1);

// Truy vấn SQL lấy danh sách học sinh
$sql = "SELECT hocsinh.*, lop.tenLop 
        FROM hocsinh 
        JOIN lop ON hocsinh.maLop = lop.maLop"; 

$result = $conn->query($sql);
$stt = 1;

while ($row = $result->fetch_assoc()) {
    // Thiết lập các ô với kích thước tương tự tiêu đề để dữ liệu hiển thị đều nhau
    $pdf->Cell(10, 8, $stt, 1, 0, 'C');
    $pdf->Cell(30, 8, $row['maHS'], 1, 0, 'C');
    $pdf->Cell(60, 8, $row['hoTen'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['gioiTinh'], 1, 0, 'C');
    $pdf->Cell(40, 8, $row['tenLop'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['ngaySinh'], 1, 0, 'C');
    $pdf->Cell(40, 8, $row['sdtPH'], 1, 0, 'C');
    $pdf->Cell(40, 8, $row['diaChi'], 1, 1, 'C');
    $stt++;
}

// Xuất file PDF
$pdf->Output('danh_sach_hocsinh.pdf', 'I');
?>
