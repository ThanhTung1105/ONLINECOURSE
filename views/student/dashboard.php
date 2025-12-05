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
            <p class="mb-0 opacity-75">Chào mừng  <strong><?= htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['username']) ?></strong>!</p>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <?php
    // 1. KẾT NỐI VÀ LẤY DỮ LIỆU THỐNG KÊ
    // Kiểm tra nếu chưa có kết nối thì tạo mới (đề phòng lỗi undefined variable)
    if (!isset($conn)) {
        $conn = mysqli_connect("localhost", "root", "", "onlinecourse");
        mysqli_set_charset($conn, 'utf8');
    }

    // Khởi tạo giá trị mặc định
    $dang_hoc = 0;
    $hoan_thanh = 0;
    $trung_binh = 0;

    if (isset($_SESSION['username'])) {
        // B1: Lấy ID của học viên từ username
        $sql_get_id = "SELECT id FROM users WHERE username = '" . $_SESSION['username'] . "'";
        $res_id = mysqli_query($conn, $sql_get_id);
        
        if ($res_id && mysqli_num_rows($res_id) > 0) {
            $row_user = mysqli_fetch_assoc($res_id);
            $student_id = $row_user['id'];

            // B2: Đếm khóa học đang học (status = 'active')
            $sql_active = "SELECT COUNT(*) as total FROM enrollments 
                           WHERE student_id = $student_id AND status = 'active'";
            $res_active = mysqli_query($conn, $sql_active);
            $data_active = mysqli_fetch_assoc($res_active);
            $dang_hoc = $data_active['total'];

            // B3: Đếm khóa học đã hoàn thành (status = 'completed')
            $sql_completed = "SELECT COUNT(*) as total FROM enrollments 
                              WHERE student_id = $student_id AND status = 'completed'";
            $res_completed = mysqli_query($conn, $sql_completed);
            $data_completed = mysqli_fetch_assoc($res_completed);
            $hoan_thanh = $data_completed['total'];

            // B4: Tính % trung bình (AVG progress)
            $sql_avg = "SELECT AVG(progress) as avg_prog FROM enrollments WHERE student_id = $student_id";
            $res_avg = mysqli_query($conn, $sql_avg);
            $data_avg = mysqli_fetch_assoc($res_avg);
            // Làm tròn số (ví dụ 45.6 -> 46)
            $trung_binh = round($data_avg['avg_prog'] ?? 0); 
        }
    }
    ?>

    <div class="col-md-4 mb-3 mb-md-0">
        <div class="stats-card">
            <i class="fas fa-book text-info" style="font-size: 28px;"></i>
            <h3><?= $dang_hoc ?></h3>
            <p>Khóa học đang học</p>
        </div>
    </div>

    <div class="col-md-4 mb-3 mb-md-0">
        <div class="stats-card">
            <i class="fas fa-chart-line text-success" style="font-size: 28px;"></i>
            <h3><?= $trung_binh ?>%</h3>
            <p>Mức độ hoàn thành trung bình</p>
        </div>
    </div>

    <div class="col-md-4 mb-3 mb-md-0">
        <div class="stats-card">
            <i class="fas fa-trophy text-warning" style="font-size: 28px;"></i>
            <h3><?= $hoan_thanh ?></h3>
            <p>Khóa học hoàn thành</p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row mt-5">
    <!-- Sidebar Profile -->
    <div class="col-lg-3 mb-4">
    <style>
    /* Thêm CSS để style icon thay cho ảnh */
    .profile-avatar-icon {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 5px solid #667eea; /* Viền đồng bộ với dashboard */
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f0f0f0;
    }
    .profile-avatar-icon i {
        font-size: 60px; 
        color: #764ba2; /* Màu icon */
    }
</style>

<div class="profile-card text-center">
    <div class="bg-light p-4">
        <div class="profile-avatar-icon">
            <i class="fas fa-user-graduate"></i> 
        </div>
        
        <h5 class="mb-1">
            <?= htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['username']) ?>
        </h5>
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
            <?php 
                // --- BỎ TRUY VẤN CSDL Ở ĐÂY ---
                // Dữ liệu email và created_at nên được Controller (ví dụ: StudentController) lấy
                // và truyền qua View. Tạm thời sử dụng dữ liệu giả định/SESSION.
                
                // Giả định Controller đã truyền $user_data (Hoặc dùng SESSION nếu đã lưu)
                $user_email = $user_data['email'] ?? $_SESSION['email'] ?? 'Đang cập nhật';
                $created_at = $user_data['created_at'] ?? '2025-12-05';
            ?>

            <p class="mb-2">
                <strong>Email:</strong><br>
                <?= htmlspecialchars($user_email) ?>
            </p>
            
            <p class="mb-0">
                <strong>Tham gia:</strong><br>
                <?= date('d/m/Y', strtotime($created_at)) ?>
            </p>
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

    <?php if (count($my_courses) > 0): ?>
        <?php foreach ($my_courses as $myCourse): ?>
            <div class="course-card-item">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?= BASE_URL ?>assets/uploads/courses/<?= htmlspecialchars($myCourse['image']) ?>" 
     class="course-thumbnail w-100 h-100" style="object-fit: cover;" alt="Course Img">
                             
                    </div>
                    <div class="col-md-8">
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title mb-1"><?= htmlspecialchars($myCourse['title']) ?></h5>
                                    <p class="text-muted mb-0">
                                        <i class="fas fa-user-tie me-2"></i>GV: <?= htmlspecialchars($myCourse['instructor_name']) ?>
                                    </p>
                                </div>
                                <?php if($myCourse['progress'] == 100): ?>
                                    <span class="badge bg-success">Hoàn thành</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Đang học</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-muted">Tiến độ học tập</small>
                                    <small class="fw-bold text-primary"><?= $myCourse['progress'] ?>%</small>
                                </div>
                                <div class="progress-custom" style="height: 8px; background: #e9ecef; border-radius: 10px; overflow: hidden;">
    <div class="progress-bar bg-success" role="progressbar" 
         style="width: <?= $myCourse['progress'] ?>%; height: 100%; border-radius: 10px; transition: width 0.5s;">
    </div>
</div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="index.php?controller=lesson&action=learn&course_id=<?= $myCourse['id'] ?>" class="btn btn-primary btn-sm rounded-pill">
    <i class="fas fa-play me-2"></i>Vào học ngay
</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center py-5 bg-white rounded shadow-sm">
            <i class="fas fa-book-open text-muted mb-3" style="font-size: 50px;"></i>
            <h5>Bạn chưa đăng ký khóa học nào</h5>
            <p class="text-muted">Hãy khám phá các khóa học thú vị ngay bên tab "Khám phá" nhé!</p>
        </div>
    <?php endif; ?>
</div>
                  

                
            

                

                

                
                
                          
            

            <!-- Khám phá khóa học -->
            <div class="tab-pane fade" id="tab-explore" role="tabpanel">
                <div class="filter-section">
    <form action="index.php" method="GET">
        <input type="hidden" name="controller" value="student">
        <input type="hidden" name="action" value="dashboard">
        <input type="hidden" name="tab" value="explore"> 

        <div class="row align-items-end gap-3">
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-search me-2"></i>Tìm kiếm</label>
                <input type="text" name="keyword" class="form-control" 
                       placeholder="Tìm khóa học..." 
                       value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label"><i class="fas fa-filter me-2"></i>Danh mục</label>
                <select name="category_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Tất cả danh mục</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (isset($_GET['category_id']) && $_GET['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label"><i class="fas fa-sort me-2"></i>Sắp xếp</label>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="newest" <?= (isset($_GET['sort']) && $_GET['sort'] == 'newest') ? 'selected' : '' ?>>Mới nhất</option>
                    <option value="price_asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : '' ?>>Giá thấp đến cao</option>
                    <option value="price_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : '' ?>>Giá cao đến thấp</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>
</div>
<div class="course-grid">
    <?php if (count($courses) > 0): ?>
        <?php foreach ($courses as $course): ?>
            <div class="course-card">
                <img src="<?= BASE_URL ?>assets/uploads/courses/<?= htmlspecialchars($course['image']) ?>" 
     class="course-card-image" alt="<?= htmlspecialchars($course['title']) ?>">
                
                <div class="course-card-body">
    <div class="d-flex gap-1 mb-2">
        <span class="badge bg-info text-dark" style="font-size: 11px;">
            <?= htmlspecialchars($course['category_name']) ?>
        </span>
        <span class="badge bg-secondary" style="font-size: 11px;">
            <?= htmlspecialchars($course['level']) ?>
        </span>
    </div>

    <h6 class="course-card-title mb-1" style="min-height: 40px;">
        <?= htmlspecialchars($course['title']) ?>
    </h6>

    <p class="course-card-instructor text-muted small mb-2">
        <i class="fas fa-user-tie me-1"></i>GV: <?= htmlspecialchars($course['instructor_name']) ?>
    </p>

    <div class="small text-muted mb-3">
        <p class="mb-1"><i class="far fa-clock me-1"></i>Thời lượng: <?= $course['duration_weeks'] ?? 'Unknown' ?> tuần</p>
        <p class="mb-0" style="font-size: 12px; display: -webkit-box; ; -webkit-box-orient: vertical; overflow: hidden;">
            <?= htmlspecialchars($course['description']) ?>
        </p>
    </div>

    <hr class="my-2" style="opacity: 0.1;">

    <div class="d-flex justify-content-between align-items-center">
        <span class="course-price text-primary fw-bold" style="font-size: 15px;">
            <?= number_format($course['price'], 0, ',', '.') ?> đ
        </span>
        <a href="index.php?controller=course&action=detail&id=<?= $course['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
            Chi tiết <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
</div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5">
            <p class="text-muted">Không tìm thấy khóa học nào phù hợp.</p>
        </div>
    <?php endif; ?>
</div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>