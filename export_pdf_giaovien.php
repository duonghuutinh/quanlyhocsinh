<?php  
require_once('libraries/TCPDF-main/TCPDF-main/tcpdf.php');
include('partials/connectDB.php'); // Kết nối cơ sở dữ liệu

// Lấy tham số tìm kiếm và sắp xếp từ URL
$column = isset($_GET['column']) ? $_GET['column'] : '';
$keyword = isset($_GET['keyword']) ? '%' . $_GET['keyword'] . '%' : '%';
$orderColumn = isset($_GET['column']) && $_GET['column'] != '' ? $_GET['column'] : 'maGV';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Tạo câu truy vấn SQL với điều kiện tìm kiếm
$sql = "SELECT * FROM giaovien WHERE 
        (maGV LIKE ? OR hoTen LIKE ? OR gioiTinh LIKE ? OR ngaySinh LIKE ? OR SDT LIKE ? OR email LIKE ? OR diaChi LIKE ?)
        ORDER BY $orderColumn $order";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $keyword, $keyword, $keyword, $keyword, $keyword, $keyword, $keyword);
$stmt->execute();
$result = $stmt->get_result();

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
$pdf->Cell(10, 8, 'STT', 1, 0, 'C', 1);
$pdf->Cell(25, 8, 'Mã Giáo Viên', 1, 0, 'C', 1);
$pdf->Cell(50, 8, 'Họ và Tên', 1, 0, 'C', 1);
$pdf->Cell(20, 8, 'Giới Tính', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Ngày Sinh', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'SĐT', 1, 0, 'C', 1);
$pdf->Cell(70, 8, 'Email', 1, 0, 'C', 1);
$pdf->Cell(30, 8, 'Địa chỉ', 1, 1, 'C', 1);

// Hiển thị dữ liệu từ kết quả tìm kiếm
$stt = 1;
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 8, $stt, 1, 0, 'C');
    $pdf->Cell(25, 8, $row['maGV'], 1, 0, 'C');
    $pdf->Cell(50, 8, $row['hoTen'], 1, 0, 'L');
    $pdf->Cell(20, 8, $row['gioiTinh'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['ngaySinh'], 1, 0, 'C');
    $pdf->Cell(30, 8, $row['SDT'], 1, 0, 'C');
    $pdf->Cell(70, 8, $row['email'], 1, 0, 'L');
    $pdf->Cell(30, 8, $row['diaChi'], 1, 1, 'L');
    $stt++;
}

// Xuất file PDF
$pdf->Output('danh_sach_giao_vien.pdf', 'I');
?>
