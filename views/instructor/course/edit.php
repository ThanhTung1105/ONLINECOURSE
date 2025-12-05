<?php include 'views/layouts/header.php'; ?>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Chỉnh sửa khóa học</h4>
                </div>
                <div class="card-body">
                    <form action="index.php?controller=instructor&action=edit&id=<?php echo $course['id']; ?>" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên khóa học</label>
                            <input type="text" name="title" class="form-control" required value="<?php echo htmlspecialchars($course['title']); ?>">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Danh mục</label>
                                <select name="category_id" class="form-select">
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $course['category_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Trình độ</label>
                                <select name="level" class="form-select">
                                    <option value="Beginner" <?php echo ($course['level'] == 'Beginner') ? 'selected' : ''; ?>>Người mới (Beginner)</option>
                                    <option value="Intermediate" <?php echo ($course['level'] == 'Intermediate') ? 'selected' : ''; ?>>Trung bình (Intermediate)</option>
                                    <option value="Advanced" <?php echo ($course['level'] == 'Advanced') ? 'selected' : ''; ?>>Nâng cao (Advanced)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Giá bán (VNĐ)</label>
                            <input type="number" name="price" class="form-control" value="<?php echo $course['price']; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Ảnh đại diện (Để trống nếu không đổi)</label>
                            <input type="file" name="image" class="form-control">
                            <?php if (!empty($course['image'])): ?>
                                <div class="mt-2">
                                    <small class="text-muted">Ảnh hiện tại:</small><br>
                                    <img src="assets/uploads/courses/<?php echo $course['image']; ?>" alt="Current Image" style="height: 100px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả chi tiết</label>
                            <textarea name="description" class="form-control" rows="6"><?php echo htmlspecialchars($course['description']); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?controller=instructor&action=dashboard" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-warning fw-bold">
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