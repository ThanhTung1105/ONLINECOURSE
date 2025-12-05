<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh Sửa Danh Mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* CSS Tùy chỉnh cho Form Admin */
        .category-form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); /* Đổ bóng mạnh hơn */
            overflow: hidden; 
        }

        .form-header-gradient {
            /* Sử dụng Gradient tím-xanh đồng bộ */
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white;
            padding: 25px 30px;
            margin-bottom: 30px;
        }
        
        .form-header-gradient h4 {
            margin: 0;
            font-weight: 600;
        }

        .btn-update-category {
            /* ĐỔI MÀU NÚT: Màu xanh dương mạnh mẽ hơn */
            background: #007bff; 
            border: none;
            transition: all 0.3s ease;
            padding: 10px 25px;
            font-weight: 600;
        }
        
        .btn-update-category:hover {
            background: #0056b3;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.4);
            color: white;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="category-form-container">
                    
                    <div class="form-header-gradient">
                        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Chỉnh Sửa Danh Mục</h4>
                    </div>
                    
                    <div class="card-body px-4 pb-4">
                        <form action="index.php?controller=admin&action=editCategoryPost" method="POST">
                            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tên danh mục</label>
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($category['name']); ?>" placeholder="Ví dụ: Thiết kế đồ họa" required>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Mô tả</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Mô tả chi tiết về loại khóa học này..."><?php echo htmlspecialchars($category['description']); ?></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-between pt-3 border-top">
                                <a href="index.php?controller=admin&action=dashboard&tab=categories" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                                </a>
                                <button type="submit" class="btn btn-update-category">
                                    <i class="fas fa-save me-2"></i>Cập nhật
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>