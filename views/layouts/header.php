<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Khóa học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/onlinecourse/assets/css/style.css">
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="fas fa-graduation-cap"></i> Online Course
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=home&action=index">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=course&action=index">Danh sách Khóa học</a>
                    </li>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'instructor'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=instructor&action=dashboard">Bảng điều khiển Giảng viên</a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=admin&action=dashboard">Bảng điều khiển Admin</a>
                        </li>
                    <?php endif; ?>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>Xin chào, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php if ($_SESSION['role'] === 'student'): ?>
                                    <li><a class="dropdown-item" href="index.php?controller=student&action=dashboard"><i class="fas fa-book me-2"></i>Khóa học của tôi</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php elseif ($_SESSION['role'] === 'instructor'): ?>
                                    <li><a class="dropdown-item" href="index.php?controller=instructor&action=dashboard"><i class="fas fa-chalkboard-teacher me-2"></i>Bảng điều khiển</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php elseif ($_SESSION['role'] === 'admin'): ?>
                                    <li><a class="dropdown-item" href="index.php?controller=admin&action=dashboard"><i class="fas fa-shield-alt me-2"></i>Bảng điều khiển Admin</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                
                                <li><a class="dropdown-item text-danger" href="index.php?controller=auth&action=logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=auth&action=login">Đăng nhập</a>
                        </li>
                        
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container main-content py-4">