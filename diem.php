<?php
include('partials/header.php');
include('partials/sidebar.php');
include('partials/connectDB.php');
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Điểm</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Điểm</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="pagetitle">
        <h1>Danh sách điểm</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            <div>
                                <a href="add_diem.php" class="btn btn-primary me-2">Thêm</a>
                                <a href="#" class="btn btn-success"><i class="ri-file-word-2-line"></i> Xuất Excel</a>
                            </div>
                        </h5>
                        <table class="table datatable  ">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Mã Học Sinh</th>
                                    <th scope="col">Họ và tên</th>
                                    <th scope="col">Lớp</th>
                                    <th scope="col">Môn học</th>
                                    <th scope="col">Điểm miệng</th>
                                    <th scope="col">Điểm 15 phút</th>
                                    <th scope="col">Điểm 1 tiết</th>
                                    <th scope="col">Điểm thi</th>
                                    <th scope="col">Thao tác</th>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT diem.*, hocsinh.hoTen , monhoc.tenMonHoc , lop.tenLop 
                                FROM diem 
                                JOIN hocsinh ON diem.maHS = hocsinh.maHS 
                                JOIN lop ON hocsinh.maLop = lop.maLop 
                                JOIN monhoc ON diem.maMon = monhoc.maMon";
                                
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                $stt = 1;
                                while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <th scope='row'>{$stt}</th>
                                    <td>{$row['maHS']}</td>
                                    <td>{$row['hoTen']}</td>
                                    <td>{$row['tenLop']}</td>
                                    <td>{$row['tenMonHoc']}</td>

                                    <td>{$row['diemMieng']}</td>
                                    <td>{$row['diem15Phut']}</td>
                                    <td>{$row['diem1Tiet']}</td>
                                    <td>{$row['diemThi']}</td>
                                    <td>
                                        <a href='' class='btn btn-success'><i class='bi bi-pencil-square'></i></a>
                                        <a href='' class='btn btn-danger'><i class='bi bi-trash'></i></a>
                                    </td>
                                </tr>";
                                $stt++;
                                }
                                } else {
                                echo "<tr>
                                    <td colspan='8' class='text-center'>Không có dữ liệu nào</td>
                                </tr>";
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>



</main><!-- End #main -->

</html>
<?php
include('partials/footer.php');
