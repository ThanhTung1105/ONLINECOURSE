<?php include 'views/layouts/header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php if ($current_lesson): ?>
                        <h3 class="mb-3"><?= htmlspecialchars($current_lesson['title']) ?></h3>
                        
                       <?php if (isset($embed_url)): ?>
    <style>
        .video-responsive {
            position: relative;
            padding-bottom: 56.25%; /* Tỷ lệ 16:9 */
            height: 0;
            overflow: hidden;
            max-width: 100%;
            background: #000;
        }
        .video-responsive iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
    
    <div class="video-responsive mb-4">
        <iframe src="<?= htmlspecialchars($embed_url) ?>"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
        </iframe>
    </div>
<?php else: ?>
    <div class="alert alert-danger mb-4">Bài học này chưa có Video hoặc URL không hợp lệ.</div>
<?php endif; ?>

                        <div class="mt-4">
                            <h5>Nội dung bài học:</h5>
                            <hr class="my-4">

<div class="card bg-light border-0">
    <div class="card-body">
        <h5 class="card-title"><i class="fas fa-folder-open me-2 text-warning"></i>Tài liệu đính kèm</h5>
        
        <?php if (count($materials) > 0): ?>
            <div class="list-group mt-3">
                <?php foreach ($materials as $file): ?>
                    <?php 
                        $icon = 'fa-file';
                        if ($file['file_type'] == 'pdf') $icon = 'fa-file-pdf text-danger';
                        elseif ($file['file_type'] == 'zip') $icon = 'fa-file-archive text-warning';
                        elseif (strpos($file['file_type'], 'doc') !== false) $icon = 'fa-file-word text-primary';
                    ?>
                    
                    <a href="upload/materials/<?= $file['file_path'] ?>" download class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas <?= $icon ?> me-2"></i>
                            <?= htmlspecialchars($file['filename']) ?>
                        </div>
                        <span class="badge bg-secondary rounded-pill">
                            <i class="fas fa-download me-1"></i> Tải về
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted small mt-2">Bài học này không có tài liệu đính kèm.</p>
        <?php endif; ?>
    </div>
</div>
                            <p><?= nl2br(htmlspecialchars($current_lesson['content'])) ?></p>
                        </div>

                        <form action="index.php?controller=lesson&action=complete" method="POST" class="mt-4 text-end">
                            <input type="hidden" name="course_id" value="<?= $course_id ?>">
                            <input type="hidden" name="lesson_id" value="<?= $current_lesson['id'] ?>">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle me-2"></i>Hoàn thành bài học
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning">Khóa học này chưa có bài học nào.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white fw-bold">
                    Nội dung khóa học
                </div>
                <div class="list-group list-group-flush">
                    <?php foreach ($lessons as $lesson): ?>
                        <?php 
                            $isActive = ($current_lesson && $lesson['id'] == $current_lesson['id']) ? 'active' : ''; 
                        ?>
                        <a href="index.php?controller=lesson&action=learn&course_id=<?= $course_id ?>&lesson_id=<?= $lesson['id'] ?>" 
                           class="list-group-item list-group-item-action <?= $isActive ?>">
                            <div class="d-flex w-100 justify-content-between">
                                <span class="mb-1">
                                    <i class="fas fa-play-circle me-2 small"></i><?= htmlspecialchars($lesson['title']) ?>
                                </span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="mt-3 text-center">
                <a href="index.php?controller=student&action=dashboard" class="text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>