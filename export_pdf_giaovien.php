<?php    
require_once('libraries/TCPDF-main/TCPDF-main/tcpdf.php');
include('partials/connectDB.php');

// Lấy các tham số từ URL
$column = isset($_GET['column']) ? $_GET['column'] : '';
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Câu lệnh SQL cơ bản
$sql = "SELECT * FROM giaovien";

// Thêm điều kiện tìm kiếm nếu có
if ($keyword != "") {
    $searchTerm = "%" . $keyword . "%";
    if ($column) {
        $sql .= " WHERE $column LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $searchTerm);
    } else {
        $sql .= " WHERE maGV LIKE ? OR hoTen LIKE ? OR gioiTinh LIKE ? OR ngaySinh LIKE ? OR SDT LIKE ? OR email LIKE ? OR diaChi LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    }
} else {
    $stmt = $conn->prepare($sql);
}

// Thêm sắp xếp nếu có
if ($column && in_array($column, ['maGV', 'hoTen', 'gioiTinh', 'ngaySinh', 'SDT', 'email', 'diaChi'])) {
    $sql .= " ORDER BY $column $order";
}

$stmt->execute();
$result = $stmt->get_result();

// Thiết lập đối tượng TCPDF và tạo PDF
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tên Tác Giả');
$pdf->SetTitle('Danh sách Giáo Viên');
$pdf->SetHeaderData('', 0, 'Danh sách Giáo Viên', '');

$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage();

// Tạo tiêu đề bảng
$pdf->Cell(10, 8, 'STT', 1, 0, 'C');
$pdf->Cell(25, 8, 'Mã GV', 1, 0, 'C');
$pdf->Cell(50, 8, 'Họ Tên', 1, 0, 'L');
$pdf->Cell(20, 8, 'Giới Tính', 1, 0, 'C');
$pdf->Cell(30, 8, 'Ngày Sinh', 1, 0, 'C');
$pdf->Cell(30, 8, 'SĐT', 1, 0, 'C');
$pdf->Cell(70, 8, 'Email', 1, 0, 'L');
$pdf->Cell(60, 8, 'Địa Chỉ', 1, 1, 'L'); // Giảm chiều rộng cột Địa Chỉ

// Hiển thị dữ liệu từ truy vấn
$stt = 1;
while ($row = $result->fetch_assoc()) {
    $pdf->MultiCell(10, 8, $stt, 1, 'C', 0, 0);
    $pdf->MultiCell(25, 8, $row['maGV'], 1, 'C', 0, 0);
    $pdf->MultiCell(50, 8, $row['hoTen'], 1, 'L', 0, 0);
    $pdf->MultiCell(20, 8, $row['gioiTinh'], 1, 'C', 0, 0);
    $pdf->MultiCell(30, 8, $row['ngaySinh'], 1, 'C', 0, 0);
    $pdf->MultiCell(30, 8, $row['SDT'], 1, 'C', 0, 0);
    $pdf->MultiCell(70, 8, $row['email'], 1, 'L', 0, 0);
    $pdf->MultiCell(60, 8, $row['diaChi'], 1, 'L', 0, 1); // Điều chỉnh chiều rộng và chiều cao cho Địa Chỉ
    $stt++;
}

$pdf->Output('danh_sach_giao_vien.pdf', 'I');

