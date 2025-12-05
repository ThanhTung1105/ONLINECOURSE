<?php include 'views/layouts/header.php'; ?>

<?php
// --- TÍNH TOÁN SỐ LIỆU THỐNG KÊ (Mới thêm) ---
$total_courses = count($courses);
$total_students = 0;
$total_revenue = 0;

foreach ($courses as $c) {
    $total_students += $c['student_count'];
    // Giả sử doanh thu = giá * số học viên (tính sơ bộ)
    $total_revenue += ($c['price'] * $c['student_count']); 
}
?>

<style>
    .instructor-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 0;
        margin-bottom: 40px;
        border-radius: 10px;
    }

    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        height: 100%; /* Đều chiều cao */
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .stats-card .icon {
        font-size: 32px;
        margin-bottom: 15px;
    }

    .stats-card h3 {
        font-weight: bold;
        font-size: 32px;
        margin: 10px 0;
        color: #333;
    }

    .stats-card p {
        color: #999;
        margin: 0;
        font-size: 14px;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-bottom: none;
    }

    .table-header h5 {
        margin: 0;
        font-weight: bold;
    }

    .btn-create {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .course-row {
        border-bottom: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .course-row:hover {
        background: #f8f9fa;
    }

    .course-row td {
        vertical-align: middle;
        padding: 15px;
    }

    .course-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }

    .course-description {
        color: #999;
        font-size: 13px;
        margin: 0;
    }

    .course-price {
        color: #f5576c;
        font-weight: bold;
        font-size: 15px;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    /* Style cho các nút hành động */
    .action-btn {
        padding: 6px 12px;
        border-radius: 6px;
        border: none;
        font-size: 13px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
    }

    /* Nút Quản lý bài học */
    .btn-manage-lessons {
        background: #e3f2fd;
        color: #0d47a1;
    }
    .btn-manage-lessons:hover {
        background: #1976d2;
        color: white;
    }

    /* Nút Sửa */
    .btn-edit {
        background: #fff3e0;
        color: #e65100;
    }
    .btn-edit:hover {
        background: #e65100;
        color: white;
    }

    /* Nút Xóa */
    .btn-delete {
        background: #ffebee;
        color: #c62828;
    }
    .btn-delete:hover {
        background: #c62828;
        color: white;
    }

    .pagination {
        padding: 20px;
        border-top: 1px solid #e0e0e0;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #764ba2;
    }

    .filter-section {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .badge-level {
        font-size: 11px;
        padding: 5px 10px;
    }
</style>

<div class="instructor-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2"><i class="fas fa-chalkboard-teacher me-3"></i>Bảng điều khiển Giảng viên</h1>
                <p class="mb-0 opacity-75">Quản lý khóa học, bài giảng và theo dõi học viên của bạn</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="index.php?controller=instructor&action=create" class="btn btn-create">
                    <i class="fas fa-plus-circle me-2"></i>Tạo khóa học mới
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="stats-card">
                <div class="icon text-primary">
                    <i class="fas fa-book"></i>
                </div>
                <h3><?php echo $total_courses; ?></h3>
                <p>Tổng số khóa học</p>
            </div>
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
            <div class="stats-card">
                <div class="icon text-success">
                    <i class="fas fa-users"></i>
                </div>
                <h3><?php echo $total_students; ?></h3>
                <p>Tổng lượt học viên</p>
            </div>
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
            <div class="stats-card">
                <div class="icon text-warning">
                    <i class="fas fa-money-bill"></i>
                </div>
                <h3><?php echo number_format($total_revenue); ?> đ</h3>
                <p>Doanh thu ước tính</p>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Danh sách khóa học của tôi</h5>
            <span class="badge bg-light text-dark"><?php echo $total_courses; ?> khóa học</span>
        </div>

        <div class="filter-section" style="margin: 0; border-radius: 0; box-shadow: none; border-bottom: 1px solid #e0e0e0;">
    <form action="index.php" method="GET">
        <input type="hidden" name="controller" value="instructor">
        <input type="hidden" name="action" value="dashboard">

        <div class="row gap-2">
            <div class="col-md-4">
                <input type="text" 
                       class="form-control" 
                       name="keyword" 
                       value="<?= htmlspecialchars($keyword ?? '') ?>"
                       placeholder="Tìm kiếm tên khóa học...">
            </div>

            <div class="col-md-4">
                <select class="form-select" name="status" onchange="this.form.submit()">
                    <option value="all" <?= ($status == 'all') ? 'selected' : '' ?>>Tất cả trạng thái</option>
                    <option value="approved" <?= ($status == 'approved') ? 'selected' : '' ?>>Đã Duyệt</option>
                    <option value="pending" <?= ($status == 'pending') ? 'selected' : '' ?>>Chờ Duyệt</option>
                    <option value="rejected" <?= ($status == 'rejected') ? 'selected' : '' ?>>Từ Chối</option>
                </select>
            </div>

            <div class="col-md-3">
                <select class="form-select" name="sort" onchange="this.form.submit()">
                    <option value="newest" <?= ($sort == 'newest') ? 'selected' : '' ?>>Mới nhất</option>
                    <option value="oldest" <?= ($sort == 'oldest') ? 'selected' : '' ?>>Cũ nhất</option>
                    <option value="price_desc" <?= ($sort == 'price_desc') ? 'selected' : '' ?>>Giá cao nhất</option>
                    <option value="price_asc" <?= ($sort == 'price_asc') ? 'selected' : '' ?>>Giá thấp nhất</option>
                    <option value="students_desc" <?= ($sort == 'students_desc') ? 'selected' : '' ?>>Học viên nhiều nhất</option>
                </select>
            </div>
            
            <div class="col-md-auto">
                <button type="submit" class="btn btn-primary" style="height: 100%;">Lọc</button>
            </div>
        </div>
    </form>
</div>

        <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th width="20%">Tên khóa học</th>
                    <th width="10%" class="text-center">Trạng thái</th>
                    <th width="15%">Mô tả</th>
                    <th width="10%" class="text-center">Giá</th>
                    <th width="10%" class="text-center">Học viên</th>
                    <th width="30%" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($courses)): ?>
                    <tr><td colspan="7" class="text-center py-5">Bạn chưa có khóa học nào.</td></tr>
                <?php else: ?>
                    <?php foreach ($courses as $index => $course): 
                        // 1. Logic màu Level
                        $badge_class = 'bg-secondary';
                        if ($course['level'] == 'Beginner') $badge_class = 'bg-success'; 
                        elseif ($course['level'] == 'Intermediate') $badge_class = 'bg-warning text-dark'; 
                        elseif ($course['level'] == 'Advanced') $badge_class = 'bg-danger'; 
                        
                        // 2. Logic màu Trạng thái (Status) - MỚI
                        $status_label = 'Chờ duyệt';
                        $status_badge = 'bg-secondary';
                        
                        // Kiểm tra nếu database chưa có cột status (hoặc null) thì coi như là pending
                        $status = isset($course['status']) ? $course['status'] : 'pending';

                        if ($status == 'approved') {
                            $status_label = 'Đã duyệt';
                            $status_badge = 'bg-success'; // Xanh lá
                        } elseif ($status == 'rejected') {
                            $status_label = 'Từ chối';
                            $status_badge = 'bg-danger'; // Đỏ
                        } else {
                            // pending
                            $status_label = 'Chờ duyệt';
                            $status_badge = 'bg-warning text-dark'; // Vàng
                        }
                    ?>
                    <tr class="course-row">
                        <td class="text-center fw-bold"><?php echo $index + 1; ?></td>
                        <td>
                            <div class="course-name"><?php echo htmlspecialchars($course['title']); ?></div>
                            <span class="badge badge-level <?php echo $badge_class; ?>">
                                <?php echo $course['level']; ?>
                            </span>
                        </td>
                        
                        <td class="text-center">
                            <span class="badge rounded-pill <?php echo $status_badge; ?>">
                                <?php echo $status_label; ?>
                            </span>
                        </td>

                        <td>
                            <p class="course-description">
                                <?php echo substr(htmlspecialchars($course['description']), 0, 40) . '...'; ?>
                            </p>
                        </td>
                        <td class="text-center">
                            <span class="course-price"><?php echo number_format($course['price']); ?> đ</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success"><?php echo $course['student_count']; ?> người</span>
                        </td>
                        <td>
                            <div class="action-buttons" style="white-space: nowrap;">
                                <a href="index.php?controller=lesson&action=manage&course_id=<?php echo $course['id']; ?>" 
                                   class="action-btn btn-manage-lessons" 
                                   data-bs-toggle="tooltip" title="Quản lý bài giảng">
                                    <i class="fas fa-book"></i>
                                </a>

                                <a href="index.php?controller=instructor&action=students&course_id=<?php echo $course['id']; ?>" 
                                   class="action-btn btn-view-students" 
                                   style="background: #e8f5e9; color: #2e7d32;"
                                   data-bs-toggle="tooltip" title="Danh sách học viên">
                                    <i class="fas fa-user-graduate"></i>
                                </a>

                                <a href="index.php?controller=instructor&action=edit&id=<?php echo $course['id']; ?>" 
                                   class="action-btn btn-edit" 
                                   data-bs-toggle="tooltip" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="index.php?controller=instructor&action=delete&id=<?php echo $course['id']; ?>" 
                                   class="action-btn btn-delete" 
                                   onclick="return confirm('Bạn chắc chắn muốn xóa khóa học này?')" 
                                   data-bs-toggle="tooltip" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

        <nav class="pagination" aria-label="Page navigation">
            <ul class="pagination justify-content-center mb-0">
                <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">Sau</a></li>
            </ul>
        </nav>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>