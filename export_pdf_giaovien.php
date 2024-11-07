<?php
require_once('libraries/TCPDF-main/TCPDF-main/tcpdf.php');
include('partials/connectDB.php');

// Tạo đối tượng TCPDF và thiết lập hướng ngang (Landscape)
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tên Tác Giả');
$pdf->SetTitle('Danh sách Giáo Viên');
$pdf->SetHeaderData('', 0, 'Danh sách Giáo Viên', '');

// Thiết lập font và trang
$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage();

// Tiêu đề chính
$pdf->Cell(0, 10, 'Danh sách Giáo Viên', 0, 1, 'C');

// Thiết lập màu nền và độ dày đường viền cho tiêu đề cột
$pdf->SetFillColor(230, 230, 230);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetDrawColor(50, 50, 100);
$pdf->SetLineWidth(0.3);

// Tạo tiêu đề các cột
$pdf->Cell(10, 8, 'STT', 1, 0, 'C', 1);            // STT
$pdf->Cell(25, 8, 'Mã Giáo Viên', 1, 0, 'C', 1);    // Mã Giáo Viên
$pdf->Cell(50, 8, 'Họ và Tên', 1, 0, 'C', 1);       // Họ và Tên 
$pdf->Cell(20, 8, 'Giới Tính', 1, 0, 'C', 1);       // Giới tính
$pdf->Cell(30, 8, 'Ngày Sinh', 1, 0, 'C', 1);       // Ngày sinh
$pdf->Cell(30, 8, 'SĐT', 1, 0, 'C', 1);           // Số điện thoại
$pdf->Cell(70, 8, 'Email', 1, 0, 'C', 1);           // Email 
$pdf->Cell(30, 8, 'Địa chỉ', 1, 1, 'C', 1);         // Địa chỉ 

// Lấy dữ liệu từ CSDL và hiển thị
$sql = "SELECT * FROM giaovien";
$result = $conn->query($sql);
$stt = 1;

while ($row = $result->fetch_assoc()) {
    // Thiết lập các ô với kích thước tương tự tiêu đề để dữ liệu hiển thị đều nhau
    $pdf->Cell(10, 8, $stt, 1, 0, 'C');
    $pdf->Cell(25, 8, $row['maGV'], 1, 0, 'C');
    $pdf->Cell(50, 8, $row['hoTen'], 1, 0, 'L');       // Họ và Tên
    $pdf->Cell(20, 8, $row['gioiTinh'], 1, 0, 'C');    // Giới tính
    $pdf->Cell(30, 8, $row['ngaySinh'], 1, 0, 'C');    // Ngày sinh
    $pdf->Cell(30, 8, $row['SDT'], 1, 0, 'C');         // Số điện thoại
    $pdf->Cell(70, 8, $row['email'], 1, 0, 'L');       // Email
    $pdf->Cell(30, 8, $row['diaChi'], 1, 1, 'L');      // Địa chỉ
    $stt++;
}

// Xuất file PDF
$pdf->Output('danh_sach_giao_vien.pdf', 'I');
?>
