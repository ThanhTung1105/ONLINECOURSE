<?php include 'views/layouts/header.php'; ?>

<style>
    /* CSS Tùy chỉnh cho Form Chỉnh sửa Bài học */
    .lesson-form-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden; 
    }

    .form-header-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
        color: white;
        padding: 25px 30px;
        margin-bottom: 30px;
    }
    
    .form-header-gradient h4 {
        margin: 0;
        font-weight: 600;
    }

    .btn-update-lesson {
        background: #4CAF50; /* Màu xanh lá cây để chỉ cập nhật */
        border: none;
        transition: all 0.3s ease;
        padding: 10px 25px;
        font-weight: 600;
    }
    
    .btn-update-lesson:hover {
        background: #45a049;
        box-shadow: 0 4px 10px rgba(76, 175, 80, 0.4);
        color: white;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="lesson-form-container">
                
                <div class="form-header-gradient">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Chỉnh sửa bài học
                    </h4>
                </div>
                
                <div class="card-body px-4 pb-4">
                    <form action="index.php?controller=lesson&action=edit&id=<?php echo $lesson['id']; ?>" method="POST">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tiêu đề bài học</label>
                            <input type="text" name="title" class="form-control" required value="<?php echo htmlspecialchars($lesson['title']); ?>">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thứ tự hiển thị</label>
                                <input type="number" name="ordering" class="form-control" value="<?php echo $lesson['ordering']; ?>" min="1" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Video URL</label>
                                <input type="url" name="video_url" class="form-control" value="<?php echo htmlspecialchars($lesson['video_url']); ?>">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Nội dung chi tiết</label>
                            <textarea name="content" class="form-control" rows="8"><?php echo htmlspecialchars($lesson['content']); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="index.php?controller=lesson&action=manage&course_id=<?php echo $lesson['course_id']; ?>" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Hủy và Quay lại
                            </a>
                            <button type="submit" class="btn btn-update-lesson">
                                <i class="fas fa-save me-2"></i>Cập nhật bài học
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>