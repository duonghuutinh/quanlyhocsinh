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
        <h1>Thêm điểm</h1>
    </div>

    <!-- Form to add student scores -->
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nhập Điểm Học Sinh</h5>

                <form action="add_score.php" method="post">
                    <div class="row mb-3">
                        <label for="maHS" class="col-sm-2 col-form-label">Mã Học Sinh</label>
                        <div class="col-sm-10">
                            <input type="text" name="maHS" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="maMon" class="col-sm-2 col-form-label">Mã Môn Học</label>
                        <div class="col-sm-10">
                            <input type="text" name="maMon" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="diemMieng" class="col-sm-2 col-form-label">Điểm Miệng</label>
                        <div class="col-sm-10">
                            <input type="number" step="0.1" name="diemMieng" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="diem15Phut" class="col-sm-2 col-form-label">Điểm 15 Phút</label>
                        <div class="col-sm-10">
                            <input type="number" step="0.1" name="diem15Phut" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="diem1Tiet" class="col-sm-2 col-form-label">Điểm 1 Tiết</label>
                        <div class="col-sm-10">
                            <input type="number" step="0.1" name="diem1Tiet" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="diemThi" class="col-sm-2 col-form-label">Điểm Thi</label>
                        <div class="col-sm-10">
                            <input type="number" step="0.1" name="diemThi" class="form-control">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Thêm Điểm</button>
                        <button type="reset" class="btn btn-secondary">Đặt Lại</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
include('partials/footer.php');
?>
