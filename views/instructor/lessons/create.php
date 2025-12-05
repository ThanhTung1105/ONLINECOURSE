<?php include 'views/layouts/header.php'; ?>

<style>
    /* CSS Tùy chỉnh cho Form Tạo Bài học mới */
    .lesson-form-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden; 
    }

    .form-header-gradient {
        /* Sử dụng gradient tím-xanh đồng bộ với dashboard và form tạo khóa học */
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
        color: white;
        padding: 25px 30px;
        margin-bottom: 30px;
    }
    
    .form-header-gradient h4 {
        margin: 0;
        font-weight: 600;
    }

    .btn-create-lesson {
        /* Màu xanh dương/tím nổi bật */
        background: #007bff; 
        border: none;
        transition: all 0.3s ease;
        padding: 10px 25px;
        font-weight: 600;
    }
    
    .btn-create-lesson:hover {
        background: #0056b3;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.4);
        color: white;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="lesson-form-container">
                
                <div class="form-header-gradient">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Thêm bài học mới
                        <?php if (isset($course_title)): ?>
                            <small class="d-block mt-1 opacity-75 fw-light">Khóa học: <?php echo htmlspecialchars($course_title); ?></small>
                        <?php endif; ?>
                    </h4>
                </div>
                
                <div class="card-body px-4 pb-4">
                    <form action="index.php?controller=lesson&action=create&course_id=<?php echo htmlspecialchars($_GET['course_id'] ?? ''); ?>" 
                          method="POST">
                        
                        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($_GET['course_id'] ?? ''); ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tiêu đề bài học</label>
                            <input type="text" name="title" class="form-control" placeholder="Ví dụ: Bài 1 - Giới thiệu về PHP MVC" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thứ tự hiển thị (Order)</label>
                                <input type="number" name="ordering" class="form-control" value="1" min="1" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Video URL (YouTube/Drive/Khác)</label>
                                <input type="url" name="video_url" class="form-control" placeholder="https://youtube.com/..." required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Nội dung chi tiết (Mô tả bài học)</label>
                            <textarea name="content" class="form-control" rows="8" placeholder="Nhập nội dung lý thuyết, mục tiêu bài học..." required></textarea>
                        </div>

                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="index.php?controller=lesson&action=manage&course_id=<?php echo htmlspecialchars($_GET['course_id'] ?? ''); ?>" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Hủy và Quay lại
                            </a>
                            <button type="submit" class="btn btn-create-lesson">
                                <i class="fas fa-save me-2"></i>Lưu bài học
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>