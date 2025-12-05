<?php include 'views/layouts/header.php'; ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Quản lý bài học: <span class="text-primary"><?php echo htmlspecialchars($course['title']); ?></span></h3>
        <div>
            <a href="index.php?controller=instructor&action=dashboard" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a href="index.php?controller=lesson&action=create&course_id=<?php echo $course_id; ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Thêm bài học mới
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="10%">Thứ tự</th>
                        <th width="40%">Tiêu đề bài học</th>
                        <th width="30%">Video URL</th>
                        <th width="20%" class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($lessons)): ?>
                        <tr><td colspan="4" class="text-center py-4">Chưa có bài học nào. Hãy thêm bài đầu tiên!</td></tr>
                    <?php else: ?>
                        <?php foreach ($lessons as $lesson): ?>
                        <tr>
                            <td><span class="badge bg-secondary rounded-circle p-2"><?php echo $lesson['ordering']; ?></span></td>
                            <td class="fw-bold"><?php echo htmlspecialchars($lesson['title']); ?></td>
                            <td><a href="<?php echo htmlspecialchars($lesson['video_url']); ?>" target="_blank" class="text-truncate d-inline-block" style="max-width: 200px;"><?php echo htmlspecialchars($lesson['video_url']); ?></a></td>
                            <td class="text-center">
                                <a href="index.php?controller=lesson&action=edit&id=<?php echo $lesson['id']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="index.php?controller=material&action=manage&lesson_id=<?php echo $lesson['id']; ?>" 
   class="btn btn-sm btn-secondary" title="Upload tài liệu">
    <i class="fas fa-paperclip"></i>
</a>
                                <a href="index.php?controller=lesson&action=delete&id=<?php echo $lesson['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa bài học này?')">
                                    <i class="fas fa-trash"></i>
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
<?php include 'views/layouts/footer.php'; ?>