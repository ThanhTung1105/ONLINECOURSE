<?php include 'views/layouts/header.php'; ?>

<div class="container py-5">
    <div class="p-5 mb-4 bg-light rounded-3 text-center border">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold text-primary">Hệ Thống Học Tập Trực Tuyến</h1>
            <p class="col-md-8 fs-4 mx-auto my-3">
                Nền tảng kết nối Giảng viên và Học viên. <br>
                Đăng nhập để truy cập vào khoá học và tài liệu của bạn.
            </p>
            <?php if(!isset($_SESSION['user_id'])): ?>
                <a href="index.php?controller=auth&action=login" class="btn btn-primary btn-lg px-4 gap-3">Đăng nhập ngay</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>