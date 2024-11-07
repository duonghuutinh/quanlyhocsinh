<?php
require_once('libraries/TCPDF-main/TCPDF-main/tcpdf.php');
include('partials/connectDB.php');

// Tạo đối tượng TCPDF và thiết lập hướng ngang (Landscape)
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tên Tác Giả');
$pdf->SetTitle('Danh sách Điểm');

// Thiết lập font và trang
$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage();

// Tiêu đề chính căn giữa
$pdf->Cell(0, 10, 'Danh sách Điểm', 0, 1, 'C');

// Thiết lập màu nền và độ dày đường viền cho tiêu đề cột
$pdf->SetFillColor(230, 230, 230);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetDrawColor(50, 50, 100);
$pdf->SetLineWidth(0.3);

// Tạo tiêu đề các cột với độ rộng hợp lý
$pdf->Cell(10, 8, 'STT', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Mã Học Sinh', 1, 0, 'C', 1);
$pdf->Cell(50, 8, 'Họ và tên', 1, 0, 'C', 1);
$pdf->Cell(40, 8, 'Lớp', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Môn học', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Điểm miệng', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Điểm 15 phút', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Điểm 1 tiết', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Điểm thi', 1, 1, 'C', 1);

// Truy vấn SQL lấy danh sách điểm học sinh
$sql = "SELECT diem.*, hocsinh.hoTen , monhoc.tenMonHoc , lop.tenLop 
        FROM diem 
        JOIN hocsinh ON diem.maHS = hocsinh.maHS 
        JOIN lop ON hocsinh.maLop = lop.maLop 
        JOIN monhoc ON diem.maMon = monhoc.maMon"; 

$result = $conn->query($sql);
$stt = 1;

while ($row = $result->fetch_assoc()) {
    // Căn chỉnh các cột dữ liệu để chúng không bị tràn
    $pdf->Cell(10, 8, $stt, 1, 0, 'C');
    $pdf->Cell(30, 8, $row['maHS'], 1, 0, 'C');
    $pdf->Cell(50, 8, $row['hoTen'], 1, 0, 'L');  // L căn trái cho tên học sinh
    $pdf->Cell(40, 8, $row['tenLop'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['tenMonHoc'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['diemMieng'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['diem15Phut'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['diem1Tiet'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['diemThi'], 1, 1, 'C');
    $stt++;
}

// Xuất file PDF
$pdf->Output('danh_sach_diem.pdf', 'I');
?>
