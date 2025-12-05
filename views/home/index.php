<?php include 'views/layouts/header.php'; ?>

<div class="text-white py-5" style="background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInLeft">
                  Thành công bắt đầu từ một khóa học.
                </h1>
                <p class="lead mb-4 opacity-75">
                    Hệ thống học tập trực tuyến hàng đầu với các khóa học thực chiến từ cơ bản đến chuyên sâu. Học mọi lúc, mọi nơi.
                </p>
                <div class="d-flex gap-3">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php
                            // Lấy vai trò của người dùng (0: Học viên, 1: Giảng viên, 2: Admin)
                            $role = $_SESSION['role'];
                            $dashboardController = 'student'; // Mặc định là Học viên (Role 0)
                            
                            if ($role == 1) { // Giảng viên
                                $dashboardController = 'instructor';
                            } elseif ($role == 2) { // Admin
                                $dashboardController = 'admin';
                            }
                            // Tạo URL chuyển hướng
                            $dashboardUrl = "index.php?controller={$dashboardController}&action=dashboard";
                        ?>
                        <a href="<?= $dashboardUrl ?>" class="btn btn-light btn-lg fw-bold text-primary px-4 shadow">
                            <i class="fas fa-graduation-cap me-2"></i>Vào khu vực của tôi
                        </a>
                    <?php else: ?>
                        <a href="index.php?controller=auth&action=register" class="btn btn-light btn-lg fw-bold text-primary px-4 shadow">
                            <i class="fas fa-user-plus me-2"></i>Đăng ký tài khoản
                        </a>
                        <a href="#featured-courses" class="btn btn-outline-light btn-lg px-4 fw-bold">
                            Khám phá
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/4729/4729351.png" alt="Learning" class="img-fluid" style="max-height: 400px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));">
            </div>
        </div>
    </div>
</div>

<div class="py-5 bg-white">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="p-3">
                    <div class="mb-3 text-primary">
                        <i class="fas fa-chalkboard-teacher fa-3x"></i>
                    </div>
                    <h4 class="fw-bold">Giảng viên uy tín</h4>
                    <p class="text-muted">Đội ngũ giảng viên giàu kinh nghiệm thực tế từ các tập đoàn công nghệ lớn.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <div class="mb-3 text-success">
                        <i class="fas fa-laptop-code fa-3x"></i>
                    </div>
                    <h4 class="fw-bold">Học đi đôi với hành</h4>
                    <p class="text-muted">Chương trình học tập trung vào thực hành dự án, cam kết làm được việc.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <div class="mb-3 text-warning">
                        <i class="fas fa-certificate fa-3x"></i>
                    </div>
                    <h4 class="fw-bold">Cấp chứng chỉ</h4>
                    <p class="text-muted">Nhận chứng chỉ hoàn thành khóa học để bổ sung vào hồ sơ năng lực của bạn.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="featured-courses" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase">Khám phá tri thức</h6>
            <h2 class="fw-bold">Khóa học nổi bật nhất</h2>
        </div>

        <div class="row g-4">
            <?php foreach ($featured_courses as $course): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="position-relative">
                            <img src="<?= !empty($course['image']) ? 'upload/courses/' . $course['image'] : 'https://via.placeholder.com/400x250?text=Course' ?>" 
                                 class="card-img-top" alt="Course" style="height: 200px; object-fit: cover;">
                            <span class="badge bg-primary position-absolute top-0 end-0 m-3">
                                <?= htmlspecialchars($course['level']) ?>
                            </span>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">
                                <a href="index.php?controller=course&action=detail&id=<?= $course['id'] ?>" class="text-decoration-none text-dark stretched-link">
                                    <?= htmlspecialchars($course['title']) ?>
                                </a>
                            </h5>
                            
                            <p class="card-text text-muted small mb-3">
                                <i class="fas fa-user-tie me-1"></i> <?= htmlspecialchars($course['instructor_name']) ?>
                            </p>
                            
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary fs-5">
                                    <?= number_format($course['price'], 0, ',', '.') ?> đ
                                </span>
                                <div class="text-warning small">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="text-muted">(4.8)</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white border-top-0 py-3">
                            <div class="d-grid">
                                <a href="index.php?controller=course&action=detail&id=<?= $course['id'] ?>" class="btn btn-outline-primary fw-bold rounded-pill">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="index.php?controller=course&action=index" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
    Xem tất cả khóa học <i class="fas fa-arrow-right ms-2"></i>
</a>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>

<?php include 'views/layouts/footer.php'; ?>