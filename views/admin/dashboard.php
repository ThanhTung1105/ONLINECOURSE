<?php 
// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header('Location: index.php?controller=auth&action=login');
    exit;
}

// Lấy tab hiện tại
$currentTab = isset($_GET['tab']) ? $_GET['tab'] : 'overview';

// Nếu là tab users, lấy dữ liệu user
if ($currentTab == 'users') {
    $database = new Database();
    $db = $database->connect();
    $userModel = new User($db);
    $allUsers = $userModel->getAll();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng Điều Khiển Admin - Online Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh;
            padding: 20px 0;
            position: fixed;
            width: 250px;
            left: 0;
            top: 0;
            overflow-y: auto;
        }

        .sidebar h5 {
            padding: 0 20px;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h2 {
            color: #333;
            font-weight: 700;
            margin: 0;
        }

        .tabs-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .nav-tabs {
            border-bottom: 2px solid #f0f0f0;
            padding: 0 20px;
            background-color: #f8f9fa;
        }

        .nav-tabs .nav-link {
            color: #666;
            border: none;
            border-bottom: 3px solid transparent;
            padding: 15px 0;
            margin: 0 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            color: #667eea;
            border-bottom-color: #667eea;
        }

        .nav-tabs .nav-link.active {
            color: #667eea;
            border-bottom-color: #667eea;
            background-color: transparent;
        }

        .tab-content {
            padding: 20px;
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .stats-card i {
            font-size: 32px;
            margin-bottom: 10px;
            color: #667eea;
        }

        .stats-card h3 {
            font-size: 28px;
            font-weight: 700;
            margin: 10px 0;
            color: #333;
        }

        .stats-card p {
            color: #999;
            margin: 0;
            font-size: 14px;
        }

        /* Table Styling */
        .table-wrapper {
            overflow: auto;
        }

        table {
            margin-bottom: 0;
        }

        table thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        table th {
            font-weight: 600;
            color: #333;
            padding: 15px;
            vertical-align: middle;
        }

        table td {
            padding: 15px;
            vertical-align: middle;
        }

        table tbody tr {
            border-bottom: 1px solid #dee2e6;
            transition: background-color 0.3s ease;
        }

        table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .role-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .role-student {
            background-color: #e7f3ff;
            color: #0066cc;
        }

        .role-instructor {
            background-color: #fff4e6;
            color: #ff9800;
        }

        .role-admin {
            background-color: #ffe7e7;
            color: #cc0000;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-edit {
            background-color: #0066cc;
            color: white;
        }

        .btn-edit:hover {
            background-color: #0052a3;
            color: white;
            text-decoration: none;
        }

        .btn-delete {
            background-color: #cc0000;
            color: white;
        }

        .btn-delete:hover {
            background-color: #990000;
            color: white;
            text-decoration: none;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 20px;
            color: #ddd;
        }

        .btn-add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .tab-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .tab-header h5 {
            margin: 0;
            color: #333;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                min-height: auto;
                position: relative;
                padding: 15px 0;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .nav-tabs {
                padding: 0 10px;
                overflow-x: auto;
                white-space: nowrap;
            }

            .nav-tabs .nav-link {
                margin: 0 10px;
                padding: 12px 0;
            }

            table {
                font-size: 13px;
            }

            table th, table td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h5>
                <i class="fas fa-graduation-cap"></i> Online Course Admin
            </h5>
            <nav class="nav flex-column">
                <a class="nav-link <?php echo $currentTab == 'overview' ? 'active' : ''; ?>" 
                   href="index.php?controller=admin&action=dashboard">
                    <i class="fas fa-chart-line"></i> Thống Kê
                </a>
                <a class="nav-link <?php echo $currentTab == 'users' ? 'active' : ''; ?>" 
                   href="index.php?controller=admin&action=dashboard&tab=users">
                    <i class="fas fa-users"></i> Quản Lý Tài Khoản
                </a>
                <a class="nav-link <?php echo $currentTab == 'categories' ? 'active' : ''; ?>" 
                   href="index.php?controller=admin&action=dashboard&tab=categories">
                    <i class="fas fa-list"></i> Danh Mục
                </a>
                <a class="nav-link <?php echo $currentTab == 'courses' ? 'active' : ''; ?>" 
                   href="index.php?controller=admin&action=dashboard&tab=courses">
                    <i class="fas fa-book"></i> Phê Duyệt Khóa Học
                </a>
                <hr style="border-color: rgba(255, 255, 255, 0.2); margin: 20px 0;">
                <a class="nav-link" href="index.php?controller=auth&action=logout">
                    <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <div class="page-header">
                <h2>
                    <?php 
                    $titles = [
                        'overview' => 'Tổng Quan',
                        'users' => 'Quản Lý Tài Khoản',
                        'categories' => 'Danh Mục Khóa Học',
                        'courses' => 'Phê Duyệt Khóa Học'
                    ];
                    echo isset($titles[$currentTab]) ? $titles[$currentTab] : 'Bảng Điều Khiển';
                    ?>
                </h2>
            </div>

            <div class="tabs-container">
                <!-- OVERVIEW TAB -->
                <?php if ($currentTab == 'overview'): ?>
                <div class="tab-content">
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <i class="fas fa-users" style="color: #667eea;"></i>
                                <h3><?php echo number_format($stats['totalUsers']); ?></h3>
                                <p>Tổng Người Dùng</p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <i class="fas fa-book" style="color: #28a745;"></i>
                                <h3><?php echo number_format($stats['totalCourses']); ?></h3>
                                <p>Khóa Học Đã Duyệt</p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <i class="fas fa-hourglass-half" style="color: #ffc107;"></i>
                                <h3><?php echo number_format($stats['pendingCourses']); ?></h3>
                                <p>Chờ Phê Duyệt</p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <i class="fas fa-chart-line" style="color: #dc3545;"></i>
                                <h3><?php echo number_format($stats['totalRevenue']); ?> đ</h3>
                                <p>Tổng Doanh Thu</p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <i class="fas fa-user-check" style="color: #17a2b8;"></i>
                                <h3><?php echo number_format($stats['totalEnrollments']); ?></h3>
                                <p>Tổng Lượt Đăng Ký</p>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                

                <!-- USERS TAB -->
                <?php elseif ($currentTab == 'users'): ?>
                <div class="tab-content">
                    <div class="tab-header">
                        <h5><i class="fas fa-users"></i> Danh Sách Tài Khoản</h5>
                        <a href="index.php?controller=admin&action=addUser" class="btn-add">
                            <i class="fas fa-plus"></i> Thêm Mới
                        </a>
                    </div>

                    <div class="table-wrapper">
                        <?php if (!empty($allUsers)): ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Họ Tên</th>
                                        <th>Email</th>
                                        <th>Tên Đăng Nhập</th>
                                        <th>Quyền</th>
                                        <th>Ngày Tạo</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    foreach ($allUsers as $user):
                                        $roleName = '';
                                        $roleBadgeClass = '';
                                        
                                        if ($user['role'] == 0) {
                                            $roleName = 'Học Viên';
                                            $roleBadgeClass = 'role-student';
                                        } elseif ($user['role'] == 1) {
                                            $roleName = 'Giảng Viên';
                                            $roleBadgeClass = 'role-instructor';
                                        } elseif ($user['role'] == 2) {
                                            $roleName = 'Admin';
                                            $roleBadgeClass = 'role-admin';
                                        }
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td>
                                            <span class="role-badge <?php echo $roleBadgeClass; ?>">
                                                <?php echo $roleName; ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="index.php?controller=admin&action=editUser&id=<?php echo $user['id']; ?>" 
                                                   class="btn-sm btn-edit">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                    <a href="index.php?controller=admin&action=deleteUser&id=<?php echo $user['id']; ?>" 
                                                       class="btn-sm btn-delete"
                                                       onclick="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <h5>Không có tài khoản nào</h5>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- CATEGORIES TAB -->
                <?php elseif ($currentTab == 'categories'): ?>
                <div class="tab-content">
                    <div class="tab-header">
                        <h5><i class="fas fa-list"></i> Danh Mục Khóa Học</h5>
                        <a href="index.php?controller=admin&action=addCategory" class="btn-add">
                            <i class="fas fa-plus"></i> Thêm Danh Mục
                        </a>
                    </div>

                    <div class="table-wrapper">
                        <?php if (!empty($allCategories)): ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="10%">ID</th>
                                        <th width="30%">Tên Danh Mục</th>
                                        <th width="40%">Mô Tả</th>
                                        <th width="20%">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($allCategories as $cat): ?>
                                    <tr>
                                        <td>#<?php echo $cat['id']; ?></td>
                                        <td class="fw-bold text-primary"><?php echo htmlspecialchars($cat['name']); ?></td>
                                        <td><?php echo htmlspecialchars($cat['description']); ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="index.php?controller=admin&action=editCategory&id=<?php echo $cat['id']; ?>" 
                                                   class="btn-sm btn-edit">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <a href="index.php?controller=admin&action=deleteCategory&id=<?php echo $cat['id']; ?>" 
                                                   class="btn-sm btn-delete"
                                                   onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-folder-open"></i>
                                <h5>Chưa có danh mục nào</h5>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- COURSES TAB -->
                <?php elseif ($currentTab == 'courses'): ?>
                <div class="tab-content">
                    <div class="tab-header">
                        <h5><i class="fas fa-check-circle"></i> Phê Duyệt Khóa Học</h5>
                        <span class="badge bg-warning text-dark">
                            <?php echo !empty($pendingCourses) ? count($pendingCourses) : 0; ?> chờ duyệt
                        </span>
                    </div>

                    <div class="table-wrapper">
                        <?php if (!empty($pendingCourses)): ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Khóa Học</th>
                                        <th>Giảng Viên</th>
                                        <th>Giá</th>
                                        <th>Ngày Tạo</th>
                                        <th width="20%">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pendingCourses as $course): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-primary"><?php echo htmlspecialchars($course['title']); ?></div>
                                            <small class="text-muted"><?php echo htmlspecialchars($course['category_name']); ?></small>
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?php echo htmlspecialchars($course['instructor_name']); ?></div>
                                        </td>
                                        <td><?php echo number_format($course['price']); ?> đ</td>
                                        <td><?php echo date('d/m/Y', strtotime($course['created_at'])); ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="index.php?controller=course&action=detail&id=<?php echo $course['id']; ?>" 
                                                   target="_blank" class="btn-sm btn-info text-white" title="Xem nội dung">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="index.php?controller=admin&action=approveCourse&id=<?php echo $course['id']; ?>" 
                                                   class="btn-sm btn-success" 
                                                   onclick="return confirm('Xác nhận duyệt khóa học này?');" title="Duyệt">
                                                    <i class="fas fa-check"></i>
                                                </a>

                                                <a href="index.php?controller=admin&action=rejectCourse&id=<?php echo $course['id']; ?>" 
                                                   class="btn-sm btn-delete" 
                                                   onclick="return confirm('Từ chối khóa học này?');" title="Từ chối">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="empty-state">
                                <i class="fas fa-check-double text-success"></i>
                                <h5>Tuyệt vời!</h5>
                                <p>Không có khóa học nào đang chờ duyệt.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
