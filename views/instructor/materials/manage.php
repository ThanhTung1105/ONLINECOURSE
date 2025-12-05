<?php include 'views/layouts/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center bg-light">
            <div>
                <h4 class="mb-1">Quản lý tài liệu</h4>
                <p class="mb-0 text-muted">Bài học: <strong><?php echo htmlspecialchars($lesson['title']); ?></strong></p>
            </div>
            <a href="index.php?controller=lesson&action=manage&course_id=<?php echo $lesson['course_id']; ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách bài
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-cloud-upload-alt me-2"></i>Upload tài liệu mới</h5>
                </div>
                <div class="card-body">
                    <form action="index.php?controller=material&action=upload" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="lesson_id" value="<?php echo $lesson_id; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Chọn file</label>
                            <input type="file" name="file_upload" class="form-control" required>
                            <small class="text-muted">Hỗ trợ: PDF, DOC, ZIP, PPT, IMG...</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-upload me-2"></i>Tải lên ngay
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0 text-primary">Danh sách tài liệu đã tải lên</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="50%">Tên file</th>
                                <th width="15%">Loại</th>
                                <th width="15%">Ngày đăng</th>
                                <th width="15%" class="text-center">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($materials)): ?>
                                <tr><td colspan="5" class="text-center py-4 text-muted">Chưa có tài liệu nào.</td></tr>
                            <?php else: ?>
                                <?php foreach ($materials as $index => $mat): ?>
                                <tr>
                                    <td class="text-center fw-bold"><?php echo $index + 1; ?></td>
                                    <td>
                                        <a href="assets/uploads/materials/<?php echo $mat['file_path']; ?>" target="_blank" class="text-decoration-none fw-bold">
                                            <i class="fas fa-file-alt me-2 text-secondary"></i>
                                            <?php echo htmlspecialchars($mat['filename']); ?>
                                        </a>
                                    </td>
                                    <td><span class="badge bg-info text-dark uppercase"><?php echo strtoupper($mat['file_type']); ?></span></td>
                                    <td class="small text-muted"><?php echo date('d/m/Y', strtotime($mat['uploaded_at'])); ?></td>
                                    <td class="text-center">
                                        <a href="index.php?controller=material&action=delete&id=<?php echo $mat['id']; ?>" 
                                           class="btn btn-sm btn-outline-danger border-0" 
                                           onclick="return confirm('Bạn có chắc muốn xóa file này không?')" title="Xóa file">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>