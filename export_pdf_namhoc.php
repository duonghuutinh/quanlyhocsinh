<?php
require_once('libraries/TCPDF-main/TCPDF-main/tcpdf.php');
include('partials/connectDB.php');

// Tạo một đối tượng TCPDF
$pdf = new TCPDF();

// Thiết lập thông tin cơ bản cho PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tên Tác Giả');

// Thiết lập font và trang
$pdf->SetFont('dejavusans', '', 12);
$pdf->AddPage();

// Tạo nội dung PDF từ dữ liệu
$html = '<h1>Danh sách Năm Học</h1><table border="1" cellpadding="5">
<thead>
<tr>
<th>ID</th>
<th>Năm học</th>
<th>Niên khoá</th>
</tr>
</thead>
<tbody>';

// Câu truy vấn cơ bản
$sql = "SELECT * FROM namhoc";

// Xử lý tìm kiếm
if (isset($_GET['keyword']) && $_GET['keyword'] != "") {
    $column = $_GET['column'];
    $keyword = $_GET['keyword'];
    $searchTerm = "%" . $keyword . "%";

    if ($column) {
        $sql .= " WHERE $column LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $searchTerm);
    } else {
        // Tìm kiếm trong nhiều cột
        $sql .= " WHERE maNamHoc LIKE ? OR nienKhoa LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
    }
} else {
    $stmt = $conn->prepare($sql);
}

// Thực thi câu truy vấn và lấy kết quả
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stt = 1; // Biến đếm cho cột ID
    while ($row = $result->fetch_assoc()) {
        $html .= "<tr>
                    <td>{$stt}</td>
                    <td>{$row['maNamHoc']}</td>
                    <td>{$row['nienKhoa']}</td>
                  </tr>";
        $stt++;
    }
} else {
    $html .= "<tr><td colspan='3'>Không có dữ liệu</td></tr>";
}

$html .= '</tbody></table>';

// In ra nội dung HTML trong PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Xuất file PDF
$pdf->Output('danh_sach_nam_hoc.pdf', 'I');
?>
