<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['maNamHoc'])) {
    $maNamHoc = $_GET['maNamHoc'];
    $sql = "DELETE FROM namhoc WHERE maNamHoc = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $maNamHoc);
        if ($stmt->execute()) {
            echo "<script>alert('Xóa năm học thành công!'); window.location.href = 'namhoc.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi xóa năm học: " . $stmt->error . "'); window.location.href = 'namhoc.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Lỗi chuẩn bị câu lệnh: " . $conn->error . "');</script>";
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Năm Học</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                <li class="breadcrumb-item active">Danh sách khối</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            <div>
                                <a href="#" class="btn btn-primary me-2">Thêm</a>
                                <a href="export_pdf_namhoc.php" class="btn btn-success"><i class="ri-file-word-2-line"></i> Xuất PDF</a>
                            </div>
                        </h5>
                        <div class="row">
                            <form method="GET" action="" class="d-flex align-items-center w-50">
                                <div class="me-2" style="flex: 1;">
                                    <select name="column" class="form-select">
                                        <option value="">Tất cả</option>
                                        <option value="khoi">Khối</option>
                                        <option value="soSiSo">Sĩ số</option>
                                        <option value="nienKhoa">Năm học</option>
                                    </select>
                                </div>
                                <div class="me-2" style="flex: 1;">
                                    <input type="text" name="keyword" class="form-control" placeholder="Nhập từ khóa tìm kiếm">
                                </div>
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </form>
                            <form method="GET" action="" class="d-flex align-items-center w-50">
                                <div class="me-2" style="flex: 1;">
                                    <select name="sort_column" class="form-select">
                                        <option value="">Chọn cột sắp xếp</option>
                                        <option value="khoi">Khối</option>
                                        <option value="soSiSo">Sĩ số</option>
                                        <option value="nienKhoa">Năm học</option>
                                    </select>
                                </div>
                                <div class="me-2" style="flex: 1;">
                                    <select name="sort_order" class="form-select">
                                        <option value="asc">Tăng dần</option>
                                        <option value="desc">Giảm dần</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Sắp xếp</button>
                            </form>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Khối</th>
                                    <th scope="col">Sĩ Số</th>
                                    <th scope="col">Năm học</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT 
                                    CASE 
                                        WHEN l.tenLop LIKE '10%' THEN 'Khối 10'
                                        WHEN l.tenLop LIKE '11%' THEN 'Khối 11'
                                        WHEN l.tenLop LIKE '12%' THEN 'Khối 12'
                                        ELSE 'Khối Khác'
                                    END AS khoi,
                                    COUNT(h.maHS) AS soSiSo,
                                    n.maNamHoc, 
                                    n.nienKhoa
                                FROM 
                                    namhoc n
                                JOIN 
                                    lop l ON n.maNamHoc = l.maNamHoc
                                JOIN 
                                    hocsinh h ON l.maLop = h.maLop
                                GROUP BY 
                                    khoi, n.maNamHoc, n.nienKhoa";

                                $params = [];
                                if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
                                    $column = $_GET['column'];
                                    $keyword = "%" . $_GET['keyword'] . "%";

                                    if ($column) {
                                        $sql .= " HAVING $column LIKE ?";
                                        $params[] = $keyword;
                                    } else {
                                        $sql .= " HAVING khoi LIKE ? OR nienKhoa LIKE ?";
                                        $params[] = $keyword;
                                        $params[] = $keyword;
                                    }
                                }

                                if (isset($_GET['sort_column']) && isset($_GET['sort_order']) && 
                                    in_array($_GET['sort_column'], ['khoi', 'soSiSo', 'nienKhoa']) && 
                                    in_array($_GET['sort_order'], ['asc', 'desc'])) {
                                    $sort_column = $_GET['sort_column'];
                                    $sort_order = $_GET['sort_order'];
                                    $sql .= " ORDER BY $sort_column $sort_order";
                                }

                                $stmt = $conn->prepare($sql);
                                if ($params) {
                                    $stmt->bind_param(str_repeat("s", count($params)), ...$params);
                                }
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    $stt = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <th scope='row'>{$stt}</th>
                                            <td>{$row['khoi']}</td>
                                            <td>{$row['soSiSo']}</td>
                                            <td>{$row['nienKhoa']}</td>
                                        </tr>";
                                        $stt++;
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>Không có dữ liệu nào</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include('partials/footer.php'); ?>
