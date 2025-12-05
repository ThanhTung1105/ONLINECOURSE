<?php include 'views/layouts/header.php'; ?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-primary"><i class="fas fa-user-graduate me-2"></i>Danh sách học viên</h2>
        <h5 class="text-secondary mt-2">Khóa học: <strong class="text-dark"><?php echo htmlspecialchars($course_title); ?></strong></h5>
    </div>
    <a href="index.php?controller=instructor&action=dashboard" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Quay lại Dashboard
    </a>
</div>

    <div class="card shadow border-0">
        <div class="card-body p-0">
            
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="text-center py-3">#</th>
                            <th width="20%" class="py-3">Họ và tên</th>
                            <th width="20%" class="py-3">Email</th>
                            <th width="25%" class="py-3">Khóa học đăng ký</th>
                            <th width="15%" class="py-3 text-center">Tiến độ</th>
                            <th width="15%" class="py-3 text-center">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($students)): ?>
                            <tr><td colspan="6" class="text-center py-5 text-muted">Chưa có học viên nào đăng ký khóa học của bạn.</td></tr>
                        <?php else: ?>
                            <?php foreach ($students as $index => $stu): ?>
                            <tr>
                                <td class="text-center fw-bold text-secondary"><?php echo $index + 1; ?></td>
                                
                                <td>
                                    <div class="fw-bold text-dark"><?php echo htmlspecialchars($stu['fullname']); ?></div>
                                </td>
                                <td>
                                    <span class="text-muted small"><?php echo htmlspecialchars($stu['email']); ?></span>
                                </td>

                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <?php echo htmlspecialchars($stu['course_title']); ?>
                                    </span>
                                    <div class="small text-muted mt-1">
                                        Ngày ĐK: <?php echo date('d/m/Y', strtotime($stu['enrolled_date'])); ?>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <div class="progress" style="height: 6px; width: 80%; margin: 0 auto;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: <?php echo $stu['progress']; ?>%">
                                        </div>
                                    </div>
                                    <small class="text-success fw-bold"><?php echo $stu['progress']; ?>%</small>
                                </td>

                                <td class="text-center">
                                    <?php if ($stu['status'] == 'completed'): ?>
                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Hoàn thành</span>
                                    <?php elseif ($stu['status'] == 'dropped'): ?>
                                        <span class="badge bg-danger">Đã hủy</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Đang học</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>