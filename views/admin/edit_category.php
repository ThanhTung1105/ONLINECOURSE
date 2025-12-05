<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Danh Mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Chỉnh Sửa Danh Mục</h4>
                    </div>
                    <div class="card-body">
                        <form action="index.php?controller=admin&action=editCategoryPost" method="POST">
                            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">Tên danh mục</label>
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mô tả</label>
                                <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($category['description']); ?></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="index.php?controller=admin&action=dashboard&tab=categories" class="btn btn-secondary">Quay lại</a>
                                <button type="submit" class="btn btn-warning">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>