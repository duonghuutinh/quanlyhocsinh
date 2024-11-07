<?php
require_once('libraries/TCPDF-main/TCPDF-main/tcpdf.php');
include('partials/connectDB.php');

// Tạo đối tượng TCPDF và thiết lập hướng dọc (Portrait)
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tên Tác Giả');
$pdf->SetTitle('Danh sách Chủ Nhiệm');

// Thiết lập font và trang
$pdf->SetFont('dejavusans', '', 12);
$pdf->AddPage();

// Tiêu đề chính căn giữa
$pdf->Cell(0, 10, 'Danh sách Chủ Nhiệm', 0, 1, 'C');

// Thiết lập màu nền và độ dày đường viền cho tiêu đề cột
$pdf->SetFillColor(230, 230, 230);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetDrawColor(50, 50, 100);
$pdf->SetLineWidth(0.3);

// Tạo tiêu đề các cột
$pdf->Cell(10, 8, 'STT', 1, 0, 'C', 1);
$pdf->Cell(40, 8, 'Mã giáo viên', 1, 0, 'C', 1);
$pdf->Cell(60, 8, 'Họ và Tên', 1, 0, 'C', 1);
$pdf->Cell(40, 8, 'Lớp', 1, 0, 'C', 1);
$pdf->Cell(40, 8, 'Năm học', 1, 1, 'C', 1);

// Truy vấn SQL lấy danh sách chủ nhiệm
$sql = "SELECT giaovien.maGV, giaovien.hoTen AS tenGiaoVien, lop.tenLop, lop.maLop, namhoc.nienKhoa
        FROM chunhiem
        JOIN giaovien ON chunhiem.maGV = giaovien.maGV
        JOIN lop ON chunhiem.maLop = lop.maLop
        JOIN namhoc ON chunhiem.maNamHoc = namhoc.maNamHoc"; // Truy vấn nienKhoa từ bảng namhoc

$result = $conn->query($sql);
$stt = 1;

while ($row = $result->fetch_assoc()) {
    // Thiết lập các ô với kích thước tương tự tiêu đề để dữ liệu hiển thị đều nhau
    $pdf->Cell(10, 8, $stt, 1, 0, 'C');
    $pdf->Cell(40, 8, $row['maGV'], 1, 0, 'C');
    $pdf->Cell(60, 8, $row['tenGiaoVien'], 1, 0, 'C');
    $pdf->Cell(40, 8, $row['tenLop'], 1, 0, 'C');
    $pdf->Cell(40, 8, $row['nienKhoa'], 1, 1, 'C');
    $stt++;
}

// Xuất file PDF
$pdf->Output('danh_sach_chunhiem.pdf', 'I');
?>
