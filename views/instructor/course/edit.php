<?php include 'views/layouts/header.php'; ?>

<style>
    /* CSS Tùy chỉnh cho Form Chỉnh sửa */
    .edit-form-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden; /* Quan trọng để header gradient không bị tràn */
    }

    .form-header-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); /* Gradient tím-xanh */
        color: white;
        padding: 25px 30px;
        margin-bottom: 30px;
    }
    
    .form-header-gradient h4 {
        margin: 0;
        font-weight: 600;
    }

    .current-image-preview {
        width: 150px;
        height: 100px;
        object-fit: cover;
        border: 2px solid #ddd;
        border-radius: 8px;
        margin-top: 10px;
    }

    .btn-update-success {
        background: #4CAF50; /* Màu xanh lá cây */
        border: none;
        transition: all 0.3s ease;
        padding: 10px 25px;
        font-weight: 600;
    }
    
    .btn-update-success:hover {
        background: #45a049;
        box-shadow: 0 4px 10px rgba(76, 175, 80, 0.4);
        color: white;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="edit-form-container">
                
                <div class="form-header-gradient">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Chỉnh sửa khóa học</h4>
                </div>
                
                <div class="card-body px-4 pb-4">
                    <form action="index.php?controller=instructor&action=edit&id=<?php echo $course['id']; ?>" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên khóa học</label>
                            <input type="text" name="title" class="form-control" required value="<?php echo htmlspecialchars($course['title']); ?>">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Danh mục</label>
                                <select name="category_id" class="form-select">
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $course['category_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Trình độ</label>
                                <select name="level" class="form-select">
                                    <option value="Beginner" <?php echo ($course['level'] == 'Beginner') ? 'selected' : ''; ?>>Cơ bản (Beginner)</option>
                                    <option value="Intermediate" <?php echo ($course['level'] == 'Intermediate') ? 'selected' : ''; ?>>Trung cấp (Intermediate)</option>
                                    <option value="Advanced" <?php echo ($course['level'] == 'Advanced') ? 'selected' : ''; ?>>Nâng cao (Advanced)</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Thời lượng (Tuần)</label>
                                <input type="number" 
                                       name="duration_weeks" 
                                       class="form-control" 
                                       value="<?php echo htmlspecialchars($course['duration_weeks'] ?? 4); ?>" 
                                       min="1" 
                                       required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Giá bán (VNĐ)</label>
                            <input type="number" name="price" class="form-control" value="<?php echo $course['price']; ?>" min="0">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Ảnh đại diện mới (Chọn nếu muốn đổi)</label>
                            <input type="file" name="image" class="form-control">
                            <?php if (!empty($course['image'])): ?>
                                <div class="mt-2">
                                    <small class="text-muted">Ảnh hiện tại:</small><br>
                                    <img src="/onlinecourse/assets/uploads/courses/<?php echo $course['image']; ?>" 
                                         alt="Current Image" 
                                         class="current-image-preview">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Mô tả chi tiết</label>
                            <textarea name="description" class="form-control" rows="6"><?php echo htmlspecialchars($course['description']); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="index.php?controller=instructor&action=dashboard" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-update-success">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>