<?php include 'views/layouts/header.php'; ?>
<div class="container mt-5">
    <h2 class="mb-4">Tạo khóa học mới</h2>
    <form action="index.php?controller=instructor&action=create" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Tên khóa học</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-select">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Trình độ</label>
                <select name="level" class="form-select">
                    <option value="Beginner">Người mới (Beginner)</option>
                    <option value="Intermediate">Trung bình (Intermediate)</option>
                    <option value="Advanced">Nâng cao (Advanced)</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá (VNĐ)</label>
            <input type="number" name="price" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh đại diện</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả chi tiết</label>
            <textarea name="description" class="form-control" rows="5"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Lưu khóa học</button>
        <a href="index.php?controller=instructor&action=dashboard" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<?php include 'views/layouts/footer.php'; ?>