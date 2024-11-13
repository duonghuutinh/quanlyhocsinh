<?php
require_once('libraries/TCPDF-main/TCPDF-main/tcpdf.php');
include('partials/connectDB.php');

// Lấy tham số tìm kiếm từ URL
$column = isset($_GET['column']) ? $_GET['column'] : '';
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Tạo câu truy vấn SQL lấy danh sách chủ nhiệm với điều kiện tìm kiếm
$sql = "SELECT giaovien.maGV, giaovien.hoTen AS tenGiaoVien, lop.tenLop, lop.maLop, namhoc.nienKhoa
        FROM chunhiem
        JOIN giaovien ON chunhiem.maGV = giaovien.maGV
        JOIN lop ON chunhiem.maLop = lop.maLop
        JOIN namhoc ON chunhiem.maNamHoc = namhoc.maNamHoc";

$params = [];
$types = '';

// Điều kiện tìm kiếm
if (!empty($keyword)) {
    $keyword = '%' . $keyword . '%';
    $types .= 's';

    if (!empty($column)) {
        // Tìm kiếm theo cột cụ thể
        $sql .= " WHERE $column LIKE ?";
        $params[] = $keyword;
    } else {
        // Tìm kiếm trên nhiều cột
        $sql .= " WHERE giaovien.maGV LIKE ? OR giaovien.hoTen LIKE ? OR lop.tenLop LIKE ? OR namhoc.nienKhoa LIKE ?";
        $params = array_fill(0, 4, $keyword);
        $types .= str_repeat('s', 3);
    }
}

// Chuẩn bị truy vấn và bind các tham số tìm kiếm
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

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

$stt = 1;

// Kiểm tra kết quả truy vấn và hiển thị
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Thiết lập các ô với kích thước tương tự tiêu đề để dữ liệu hiển thị đều nhau
        $pdf->Cell(10, 8, $stt, 1, 0, 'C');
        $pdf->Cell(40, 8, $row['maGV'], 1, 0, 'C');
        $pdf->Cell(60, 8, $row['tenGiaoVien'], 1, 0, 'C');
        $pdf->Cell(40, 8, $row['tenLop'], 1, 0, 'C');
        $pdf->Cell(40, 8, $row['nienKhoa'], 1, 1, 'C');
        $stt++;
    }
} else {
    // Thông báo nếu không có kết quả phù hợp
    $pdf->Cell(0, 10, 'Không có kết quả phù hợp với từ khóa tìm kiếm.', 1, 1, 'C');
}

// Xuất file PDF
$pdf->Output('danh_sach_chunhiem.pdf', 'I');
?>
