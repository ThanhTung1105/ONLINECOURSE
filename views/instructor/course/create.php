<?php include 'views/layouts/header.php'; ?>

<style>
    /* CSS Tùy chỉnh cho Form Tạo khóa học mới */
    .create-form-container {
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

    .btn-create-primary {
        background: #007bff; /* Màu xanh dương nổi bật */
        border: none;
        transition: all 0.3s ease;
        padding: 10px 25px;
        font-weight: 600;
    }
    
    .btn-create-primary:hover {
        background: #0056b3;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.4);
        color: white;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="create-form-container">
                
                <div class="form-header-gradient">
                    <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tạo khóa học mới</h4>
                </div>
                
                <div class="card-body px-4 pb-4">
                    <form action="index.php?controller=instructor&action=create" 
                          method="POST" 
                          enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên khóa học</label>
                            <input type="text" name="title" class="form-control" placeholder="Ví dụ: Lập trình PHP cơ bản" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Danh mục</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="" disabled selected>-- Chọn danh mục --</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>">
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Trình độ</label>
                                <select name="level" class="form-select" required>
                                    <option value="Beginner">Cơ bản (Beginner)</option>
                                    <option value="Intermediate">Trung cấp (Intermediate)</option>
                                    <option value="Advanced">Nâng cao (Advanced)</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Thời lượng (Tuần)</label>
                                <input type="number" name="duration_weeks" class="form-control" value="4" min="1" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Giá bán (VNĐ)</label>
                            <input type="number" name="price" class="form-control" value="0" min="0" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Ảnh đại diện</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Mô tả chi tiết</label>
                            <textarea name="description" class="form-control" rows="6" placeholder="Mô tả tóm tắt nội dung khóa học..." required></textarea>
                        </div>

                        <div class="d-flex justify-content-end pt-3 border-top">
                            <a href="index.php?controller=instructor&action=dashboard" class="btn btn-secondary me-2">Hủy</a>
                            <button type="submit" class="btn btn-create-primary">
                                <i class="fas fa-save me-2"></i>Lưu khóa học
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>