<?php
require_once('libraries/TCPDF-main/TCPDF-main/tcpdf.php');
include('partials/connectDB.php');

// Tạo đối tượng TCPDF và thiết lập hướng dọc (Portrait)
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tên Tác Giả');
$pdf->SetTitle('Danh sách Lớp');

// Thiết lập font và trang
$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage();

// Tiêu đề chính được căn giữa
$pdf->Cell(0, 10, 'Danh sách Lớp', 0, 1, 'C');

// Thiết lập màu nền và độ dày đường viền cho tiêu đề cột
$pdf->SetFillColor(230, 230, 230);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetDrawColor(50, 50, 100);
$pdf->SetLineWidth(0.3);

// Tạo tiêu đề các cột
$pdf->Cell(10, 8, 'STT', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Tên lớp', 1, 0, 'C', 1);
$pdf->Cell(20, 8, 'Sĩ số', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Phòng học', 1, 0, 'C', 1);
$pdf->Cell(50, 8, 'Chủ nhiệm', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Niên khoá', 1, 1, 'C', 1);

// Truy vấn SQL lấy danh sách lớp
$sql = "SELECT lop.maLop, lop.tenLop, 
        COUNT(hocsinh.maHS) AS soHocSinh, 
        giaovien.hoTen AS giaoVienChuNhiem,                       
        namhoc.nienKhoa,
        phonghoc.soPhong AS phongHoc
        FROM lop
        LEFT JOIN hocsinh ON lop.maLop = hocsinh.maLop
        LEFT JOIN chunhiem ON lop.maLop = chunhiem.maLop
        LEFT JOIN giaovien ON chunhiem.maGV = giaovien.maGV
        LEFT JOIN namhoc ON namhoc.maNamHoc = lop.maNamHoc
        LEFT JOIN phonglop ON lop.maLop = phonglop.maLop
        LEFT JOIN phonghoc ON phonglop.maPhong = phonghoc.maPhong
        GROUP BY lop.maLop, lop.tenLop, giaovien.hoTen, lop.maNamHoc, phonghoc.soPhong";

$result = $conn->query($sql);
$stt = 1;

while ($row = $result->fetch_assoc()) {
    // Thiết lập các ô với kích thước tương tự tiêu đề để dữ liệu hiển thị đều nhau
    $pdf->Cell(10, 8, $stt, 1, 0, 'C');
    $pdf->Cell(30, 8, $row['tenLop'], 1, 0, 'L');
    $pdf->Cell(20, 8, $row['soHocSinh'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['phongHoc'], 1, 0, 'C');
    $pdf->Cell(50, 8, $row['giaoVienChuNhiem'], 1, 0, 'L');
    $pdf->Cell(30, 8, $row['nienKhoa'], 1, 1, 'C');
    $stt++;
}

// Xuất file PDF
$pdf->Output('danh_sach_lop.pdf', 'I');
?>
