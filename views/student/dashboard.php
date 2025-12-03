<?php include 'views/layouts/header.php'; ?>

<style>
    .student-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 0;
        margin-bottom: 40px;
        border-radius: 10px;
    }

    .profile-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 5px solid #667eea;
        object-fit: cover;
    }

    .course-card-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }

    .course-card-item:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }

    .course-thumbnail {
        height: 200px;
        object-fit: cover;
    }

    .stats-card {
        text-align: center;
        padding: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .stats-card h3 {
        color: #667eea;
        font-weight: bold;
        margin: 10px 0;
    }

    .stats-card p {
        color: #999;
        margin: 0;
        font-size: 14px;
    }

    .progress-custom {
        height: 8px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-custom .progress-bar {
        background: linear-gradient(90deg, #667eea, #764ba2);
        transition: width 0.3s ease;
    }

    .nav-tabs .nav-link {
        color: #666;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link.active {
        color: #667eea;
        border-bottom-color: #667eea;
        background: none;
    }

    .nav-tabs .nav-link:hover {
        color: #667eea;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        padding: 10px 25px;
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .filter-section {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .course-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .course-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .course-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }

    .course-card-image {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }

    .course-card-body {
        padding: 15px;
    }

    .course-card-title {
        font-weight: bold;
        font-size: 15px;
        margin-bottom: 8px;
        color: #333;
    }

    .course-card-instructor {
        font-size: 13px;
        color: #999;
        margin-bottom: 10px;
    }

    .course-price {
        color: #667eea;
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .btn-register {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-learning {
        background: #28a745;
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-learning:hover {
        background: #218838;
        color: white;
    }
</style>

<!-- Student Header -->
<div class="student-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2"><i class="fas fa-user-graduate me-3"></i>Bảng điều khiển học viên</h1>
            <p class="mb-0 opacity-75">Chào mừng trở lại, <strong><?= htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['username']) ?></strong>!</p>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="stats-card">
            <i class="fas fa-book text-info" style="font-size: 28px;"></i>
            <h3>5</h3>
            <p>Khóa học đang học</p>
        </div>
    </div>
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="stats-card">
            <i class="fas fa-chart-line text-success" style="font-size: 28px;"></i>
            <h3>45%</h3>
            <p>Mức độ hoàn thành trung bình</p>
        </div>
    </div>
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="stats-card">
            <i class="fas fa-trophy text-warning" style="font-size: 28px;"></i>
            <h3>2</h3>
            <p>Khóa học hoàn thành</p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row mt-5">
    <!-- Sidebar Profile -->
    <div class="col-lg-3 mb-4">
        <div class="profile-card text-center">
            <div class="bg-light p-4">
                <img src="https://via.placeholder.com/120" class="profile-avatar mb-3" alt="Avatar">
                <h5 class="mb-1"><?= htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['username']) ?></h5>
                <p class="text-muted mb-0">Học viên</p>
            </div>
            <div class="p-4">
                <div class="d-grid gap-2 mb-3">
                    <a href="#" class="btn btn-primary btn-sm rounded-pill">
                        <i class="fas fa-user-edit me-2"></i>Chỉnh sửa hồ sơ
                    </a>
                </div>
                <hr>
                <div class="text-start small">
                    <p class="mb-2"><strong>Email:</strong><br><?= htmlspecialchars($_SESSION['email'] ?? 'N/A') ?></p>
                    <p class="mb-0"><strong>Tham gia:</strong><br>01/01/2024</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Section -->
    <div class="col-lg-9">
        <!-- Tabs: Khóa học của tôi vs Khám phá khóa học -->
        <ul class="nav nav-tabs mb-4" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#tab-my-courses" role="tab">
                    <i class="fas fa-graduation-cap me-2"></i>Khóa học của tôi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-explore" role="tab">
                    <i class="fas fa-search me-2"></i>Khám phá khóa học
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Khóa học của tôi -->
            <div class="tab-pane fade show active" id="tab-my-courses" role="tabpanel">
                <h4 class="mb-4 fw-bold">
                    <i class="fas fa-play-circle me-2 text-primary"></i>Khóa học đang học
                </h4>

                <!-- Course 1 -->
                <div class="course-card-item">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="https://via.placeholder.com/400x250?text=PHP+Web" class="course-thumbnail w-100 h-100" alt="PHP Web">
                        </div>
                        <div class="col-md-8">
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title mb-1">Lập trình Web PHP cơ bản</h5>
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-user-tie me-2"></i>Giảng viên: Thầy Giáo Ba
                                        </p>
                                    </div>
                                    <span class="badge bg-primary">3/8 bài học</span>
                                </div>
                                
                                <p class="text-muted mb-3" style="font-size: 14px;">
                                    Học các kiến thức nền tảng về lập trình web với PHP, từ cơ bản đến nâng cao.
                                </p>
                                
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-muted">Tiến độ học tập</small>
                                        <small class="fw-bold text-primary">45%</small>
                                    </div>
                                    <div class="progress-custom">
                                        <div class="progress-bar" role="progressbar" style="width: 45%"></div>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-primary btn-sm rounded-pill">
                                        <i class="fas fa-play me-2"></i>Tiếp tục học
                                    </a>
                                    <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill">
                                        <i class="fas fa-list me-2"></i>Xem bài học
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course 2 -->
                <div class="course-card-item">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="https://via.placeholder.com/400x250?text=JavaScript" class="course-thumbnail w-100 h-100" alt="JavaScript">
                        </div>
                        <div class="col-md-8">
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title mb-1">JavaScript Nâng cao</h5>
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-user-tie me-2"></i>Giảng viên: Thầy A
                                        </p>
                                    </div>
                                    <span class="badge bg-warning">2/10 bài học</span>
                                </div>
                                
                                <p class="text-muted mb-3" style="font-size: 14px;">
                                    Khám phá các kỹ thuật JavaScript hiện đại, async/await, promises và DOM manipulation.
                                </p>
                                
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-muted">Tiến độ học tập</small>
                                        <small class="fw-bold text-primary">20%</small>
                                    </div>
                                    <div class="progress-custom">
                                        <div class="progress-bar" role="progressbar" style="width: 20%"></div>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-primary btn-sm rounded-pill">
                                        <i class="fas fa-play me-2"></i>Tiếp tục học
                                    </a>
                                    <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill">
                                        <i class="fas fa-list me-2"></i>Xem bài học
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-5">

                <h4 class="mb-4 fw-bold">
                    <i class="fas fa-check-circle me-2 text-success"></i>Khóa học đã hoàn thành
                </h4>

                <!-- Completed Course -->
                <div class="course-card-item">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="https://via.placeholder.com/400x250?text=HTML+CSS" class="course-thumbnail w-100 h-100" alt="HTML CSS">
                        </div>
                        <div class="col-md-8">
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title mb-1">HTML & CSS Cơ bản</h5>
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-user-tie me-2"></i>Giảng viên: Thầy B
                                        </p>
                                    </div>
                                    <span class="badge bg-success">8/8 bài học</span>
                                </div>
                                
                                <p class="text-muted mb-3" style="font-size: 14px;">
                                    Khóa học HTML & CSS từ cơ bản đến nâng cao.
                                </p>
                                
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <small class="text-muted">Hoàn thành</small>
                                        <small class="fw-bold text-success">100%</small>
                                    </div>
                                    <div class="progress-custom">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-success btn-sm rounded-pill">
                                        <i class="fas fa-certificate me-2"></i>Xem chứng chỉ
                                    </a>
                                    <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill">
                                        <i class="fas fa-redo me-2"></i>Ôn tập
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Khám phá khóa học -->
            <div class="tab-pane fade" id="tab-explore" role="tabpanel">
                <div class="filter-section">
                    <div class="row align-items-end gap-3">
                        <div class="col-md-4">
                            <label class="form-label"><i class="fas fa-search me-2"></i>Tìm kiếm</label>
                            <input type="text" class="form-control" placeholder="Tìm khóa học...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><i class="fas fa-filter me-2"></i>Danh mục</label>
                            <select class="form-select">
                                <option>Tất cả danh mục</option>
                                <option>Lập trình</option>
                                <option>Thiết kế</option>
                                <option>Marketing</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><i class="fas fa-sort me-2"></i>Sắp xếp</label>
                            <select class="form-select">
                                <option>Phổ biến nhất</option>
                                <option>Mới nhất</option>
                                <option>Giá thấp đến cao</option>
                                <option>Giá cao đến thấp</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="course-grid">
                    <!-- Course Card 1 -->
                    <div class="course-card">
                        <img src="https://via.placeholder.com/300x160?text=React+Basics" class="course-card-image" alt="React">
                        <div class="course-card-body">
                            <h6 class="course-card-title">React.js Từ Cơ Bản Đến Nâng Cao</h6>
                            <p class="course-card-instructor"><i class="fas fa-user me-1"></i>Thầy Minh</p>
                            <p class="course-price">890,000 đ</p>
                            <button class="btn btn-register">
                                <i class="fas fa-plus me-1"></i>Đăng ký
                            </button>
                        </div>
                    </div>

                    <!-- Course Card 2 -->
                    <div class="course-card">
                        <img src="https://via.placeholder.com/300x160?text=Python+Dev" class="course-card-image" alt="Python">
                        <div class="course-card-body">
                            <h6 class="course-card-title">Python cho Lập Trình Viên</h6>
                            <p class="course-card-instructor"><i class="fas fa-user me-1"></i>Thầy Sơn</p>
                            <p class="course-price">750,000 đ</p>
                            <button class="btn btn-register">
                                <i class="fas fa-plus me-1"></i>Đăng ký
                            </button>
                        </div>
                    </div>

                    <!-- Course Card 3 -->
                    <div class="course-card">
                        <img src="https://via.placeholder.com/300x160?text=Web+Design" class="course-card-image" alt="Design">
                        <div class="course-card-body">
                            <h6 class="course-card-title">Thiết Kế Web Responsive</h6>
                            <p class="course-card-instructor"><i class="fas fa-user me-1"></i>Cô Linh</p>
                            <p class="course-price">650,000 đ</p>
                            <button class="btn btn-register">
                                <i class="fas fa-plus me-1"></i>Đăng ký
                            </button>
                        </div>
                    </div>

                    <!-- Course Card 4 -->
                    <div class="course-card">
                        <img src="https://via.placeholder.com/300x160?text=Vue+JS" class="course-card-image" alt="Vue">
                        <div class="course-card-body">
                            <h6 class="course-card-title">Vue.js Master Class</h6>
                            <p class="course-card-instructor"><i class="fas fa-user me-1"></i>Thầy Duy</p>
                            <p class="course-price">920,000 đ</p>
                            <button class="btn btn-register">
                                <i class="fas fa-plus me-1"></i>Đăng ký
                            </button>
                        </div>
                    </div>

                    <!-- Course Card 5 -->
                    <div class="course-card">
                        <img src="https://via.placeholder.com/300x160?text=Digital+Marketing" class="course-card-image" alt="Marketing">
                        <div class="course-card-body">
                            <h6 class="course-card-title">Digital Marketing Toàn Diện</h6>
                            <p class="course-card-instructor"><i class="fas fa-user me-1"></i>Cô Hoa</p>
                            <p class="course-price">580,000 đ</p>
                            <button class="btn btn-register">
                                <i class="fas fa-plus me-1"></i>Đăng ký
                            </button>
                        </div>
                    </div>

                    <!-- Course Card 6 -->
                    <div class="course-card">
                        <img src="https://via.placeholder.com/300x160?text=Node+JS" class="course-card-image" alt="Node">
                        <div class="course-card-body">
                            <h6 class="course-card-title">Node.js API Development</h6>
                            <p class="course-card-instructor"><i class="fas fa-user me-1"></i>Thầy Tuấn</p>
                            <p class="course-price">1,050,000 đ</p>
                            <button class="btn btn-register">
                                <i class="fas fa-plus me-1"></i>Đăng ký
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>