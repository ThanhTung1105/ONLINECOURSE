<?php include 'views/layouts/header.php'; ?>

<div class="py-5" style="background: linear-gradient(to right, #2c3e50, #4ca1af); color: white;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark mb-2">
                    <?= htmlspecialchars($course['category_name']) ?>
                </span>
                <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($course['title']) ?></h1>
                
                <p class="lead mb-4" style="opacity: 0.9; font-size: 16px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    <?= htmlspecialchars($course['description']) ?>
                </p>
                
                <div class="d-flex flex-wrap align-items-center gap-4 text-white-50 small">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-tie me-2"></i>
                        <span>Giảng viên: <strong class="text-white ms-1"><?= htmlspecialchars($course['instructor_name']) ?></strong></span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="far fa-clock me-2"></i>
                        <span>Cập nhật: <strong class="text-white ms-1"><?= date('d/m/Y', strtotime($course['updated_at'])) ?></strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <ul class="nav nav-tabs nav-fill mb-4" id="courseTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#intro" type="button">Giới thiệu</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#curriculum" type="button">
                        Nội dung bài học (<?= count($lessons) ?> bài)
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="courseTabContent">
                <div class="tab-pane fade show active" id="intro">
                    <h4 class="fw-bold mb-3">Về khóa học này</h4>
                    <div class="text-secondary" style="line-height: 1.8; text-align: justify;">
                        <?= nl2br(htmlspecialchars($course['description'])) ?>
                    </div>
                </div>

                <div class="tab-pane fade" id="curriculum">
                    <div class="accordion" id="accordionLessons">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    <strong>Danh sách bài học</strong>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show">
                                <div class="accordion-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <?php if (count($lessons) > 0): ?>
                                            <?php foreach ($lessons as $index => $lesson): ?>
                                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                                    <span>
                                                        <i class="fas fa-play-circle text-primary me-3"></i>
                                                        <strong>Bài <?= $index + 1 ?>:</strong> <?= htmlspecialchars($lesson['title']) ?>
                                                    </span>
                                                    <span class="badge bg-light text-dark border">Video</span>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li class="list-group-item text-center py-4 text-muted">
                                                Giảng viên chưa đăng tải bài học nào cho khóa này.
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow border-0 mb-4" style="position: sticky; top: 100px; z-index: 10;">
                <div style="position: relative;">
                    <img src="<?= !empty($course['image']) ? 'upload/courses/' . $course['image'] : 'https://via.placeholder.com/600x400?text=Course' ?>" 
                         class="card-img-top" alt="Course Img" style="height: 200px; object-fit: cover;">
                </div>

                <div class="card-body p-4">
                    <h2 class="fw-bold text-primary mb-3 text-center">
                        <?= number_format($course['price'], 0, ',', '.') ?> đ
                    </h2>
                    
                    <div class="d-grid gap-2 mb-4">
                        <a href="index.php?controller=course&action=register&id=<?= $course['id'] ?>" 
                           class="btn btn-primary btn-lg fw-bold shadow-sm"
                           onclick="return confirm('Bạn có chắc chắn muốn đăng ký khóa học này không?');">
                            Đăng ký học ngay
                        </a>
                    </div>

                    <ul class="list-group list-group-flush small text-secondary">
                        <li class="list-group-item bg-transparent border-bottom px-0 py-2 d-flex justify-content-between">
                            <span><i class="fas fa-signal me-2"></i>Trình độ</span>
                            <strong><?= htmlspecialchars($course['level']) ?></strong>
                        </li>
                        <li class="list-group-item bg-transparent border-bottom px-0 py-2 d-flex justify-content-between">
                            <span><i class="far fa-clock me-2"></i>Thời lượng</span>
                            <strong><?= $course['duration_weeks'] ?> tuần</strong>
                        </li>
                        <li class="list-group-item bg-transparent border-bottom px-0 py-2 d-flex justify-content-between">
                            <span><i class="fas fa-video me-2"></i>Hình thức</span>
                            <strong>Online 100%</strong>
                        </li>
                        <li class="list-group-item bg-transparent border-bottom px-0 py-2 d-flex justify-content-between">
                            <span><i class="fas fa-book me-2"></i>Số bài học</span>
                            <strong><?= count($lessons) ?> bài</strong>
                        </li>
                        <li class="list-group-item bg-transparent px-0 py-2 d-flex justify-content-between">
                            <span><i class="fas fa-certificate me-2"></i>Chứng chỉ</span>
                            <strong>Có</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>


