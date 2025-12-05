<?php include 'views/layouts/header.php'; ?>
<div class="container mt-5">
    <div class="card shadow-sm col-md-8 mx-auto">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Thêm bài học mới</h4>
        </div>
        <div class="card-body">
            <form action="index.php?controller=lesson&action=create" method="POST">
                <input type="hidden" name="course_id" value="<?php echo $_GET['course_id']; ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold">Tiêu đề bài học</label>
                    <input type="text" name="title" class="form-control" required placeholder="Ví dụ: Bài 1 - Giới thiệu...">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Thứ tự hiển thị</label>
                        <input type="number" name="ordering" class="form-control" value="1">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Video URL (YouTube/Drive)</label>
                        <input type="text" name="video_url" class="form-control" placeholder="https://youtube.com/...">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nội dung chi tiết</label>
                    <textarea name="content" class="form-control" rows="5"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Lưu bài học</button>
                <a href="index.php?controller=lesson&action=manage&course_id=<?php echo $_GET['course_id']; ?>" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>