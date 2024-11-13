<?php
require_once('libraries/TCPDF-main/TCPDF-main/tcpdf.php');
include('partials/connectDB.php');

// Lấy tham số tìm kiếm và sắp xếp từ URL
$column = isset($_GET['column']) ? $_GET['column'] : '';
$keyword = isset($_GET['keyword']) ? '%' . $_GET['keyword'] . '%' : '%';
$orderColumn = isset($_GET['column']) && $_GET['column'] != '' ? $_GET['column'] : 'maHS';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Tạo câu truy vấn SQL với điều kiện tìm kiếm
$sql = "SELECT hocsinh.*, lop.tenLop 
        FROM hocsinh 
        JOIN lop ON hocsinh.maLop = lop.maLop
        WHERE (hocsinh.maHS LIKE ? OR hocsinh.hoTen LIKE ? OR hocsinh.gioiTinh LIKE ? 
               OR lop.tenLop LIKE ? OR hocsinh.ngaySinh LIKE ? OR hocsinh.sdtPH LIKE ? 
               OR hocsinh.diaChi LIKE ?)
        ORDER BY $orderColumn $order";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $keyword, $keyword, $keyword, $keyword, $keyword, $keyword, $keyword);
$stmt->execute();
$result = $stmt->get_result();

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
