<?php include 'views/layouts/header.php'; ?>

<div class="bg-primary py-4 mb-4">
    <div class="container text-white">
        <h1 class="fw-bold fs-2">Tất cả khóa học</h1>
        <p class="mb-0 opacity-75">Khám phá hàng trăm khóa học chất lượng cao</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-filter me-2"></i>Bộ lọc</h5>
                    
                    <form action="index.php" method="GET">
                        <input type="hidden" name="controller" value="course">
                        <input type="hidden" name="action" value="index">

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Từ khóa</label>
                            <input type="text" name="keyword" class="form-control" placeholder="Tìm tên khóa học..." 
                                   value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Danh mục</label>
                            <div class="d-grid gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category_id" value="" id="cat_all" 
                                           <?= (!isset($_GET['category_id']) || $_GET['category_id'] == '') ? 'checked' : '' ?> 
                                           onchange="this.form.submit()">
                                    <label class="form-check-label" for="cat_all">Tất cả</label>
                                </div>
                                <?php foreach ($categories as $cat): ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="category_id" value="<?= $cat['id'] ?>" id="cat_<?= $cat['id'] ?>"
                                               <?= (isset($_GET['category_id']) && $_GET['category_id'] == $cat['id']) ? 'checked' : '' ?>
                                               onchange="this.form.submit()">
                                        <label class="form-check-label" for="cat_<?= $cat['id'] ?>">
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Sắp xếp theo</label>
                            <select name="sort" class="form-select" onchange="this.form.submit()">
                                <option value="newest" <?= (isset($_GET['sort']) && $_GET['sort'] == 'newest') ? 'selected' : '' ?>>Mới nhất</option>
                                <option value="price_asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : '' ?>>Giá thấp đến cao</option>
                                <option value="price_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : '' ?>>Giá cao đến thấp</option>
                            </select>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search me-1"></i> Áp dụng</button>
                            <a href="index.php?controller=course&action=index" class="btn btn-link text-decoration-none mt-2">Xóa bộ lọc</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <?php if (count($courses) > 0): ?>
                <?php 
    // Kiểm tra xem người dùng có đang lọc hay không
    $is_filtering = !empty($_GET['keyword']) || !empty($_GET['category_id']);
?>

<?php if ($is_filtering): ?>
    <p class="text-muted mb-3">
        <i class="fas fa-search me-1"></i>
        Tìm thấy <strong><?= count($courses) ?></strong> kết quả phù hợp với bộ lọc:
    </p>
<?php else: ?>
    <p class="text-muted mb-3">
        <i class="fas fa-list me-1"></i>
        Hiện đang có tất cả <strong><?= count($courses) ?></strong> khóa học trên hệ thống:
    </p>
<?php endif; ?>
                
                <div class="row g-4">
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0 hover-card">
                                <div class="position-relative">
                                    <img src="<?= !empty($course['image']) ? 'upload/courses/' . $course['image'] : 'https://via.placeholder.com/400x250?text=Course' ?>" 
                                         class="card-img-top" alt="Course" style="height: 180px; object-fit: cover;">
                                    <span class="badge bg-info text-dark position-absolute top-0 start-0 m-2">
                                        <?= htmlspecialchars($course['category_name']) ?>
                                    </span>
                                </div>
                                
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title fw-bold" style="min-height: 40px;">
                                        <a href="index.php?controller=course&action=detail&id=<?= $course['id'] ?>" class="text-decoration-none text-dark stretched-link">
                                            <?= htmlspecialchars($course['title']) ?>
                                        </a>
                                    </h6>
                                    
                                    <div class="d-flex align-items-center mb-3 text-muted small">
                                        <img src="https://via.placeholder.com/20" class="rounded-circle me-1" alt="gv">
                                        <span><?= htmlspecialchars($course['instructor_name']) ?></span>
                                    </div>

                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-primary">
                                            <?= number_format($course['price'], 0, ',', '.') ?> đ
                                        </span>
                                        <small class="text-muted"><i class="fas fa-eye me-1"></i>Chi tiết</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" alt="Empty" style="width: 100px; opacity: 0.5;">
                    <h5 class="mt-3 text-muted">Không tìm thấy khóa học nào!</h5>
                    <p>Vui lòng thử lại với từ khóa khác.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>