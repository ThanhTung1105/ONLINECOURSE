<?php include 'views/layouts/header.php'; ?>
<div class="container mt-5">
    <div class="card shadow-sm col-md-8 mx-auto">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Chỉnh sửa bài học</h4>
        </div>
        <div class="card-body">
            <form action="index.php?controller=lesson&action=edit&id=<?php echo $lesson['id']; ?>" method="POST">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Tiêu đề bài học</label>
                    <input type="text" name="title" class="form-control" required value="<?php echo htmlspecialchars($lesson['title']); ?>">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Thứ tự hiển thị</label>
                        <input type="number" name="ordering" class="form-control" value="<?php echo $lesson['ordering']; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Video URL</label>
                        <input type="text" name="video_url" class="form-control" value="<?php echo htmlspecialchars($lesson['video_url']); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nội dung chi tiết</label>
                    <textarea name="content" class="form-control" rows="5"><?php echo htmlspecialchars($lesson['content']); ?></textarea>
                </div>

                <button type="submit" class="btn btn-warning">Cập nhật</button>
                <a href="index.php?controller=lesson&action=manage&course_id=<?php echo $lesson['course_id']; ?>" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>