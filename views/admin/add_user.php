<?php 
// Kiểm tra quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 2) {
    header('Location: index.php?controller=auth&action=login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tài Khoản - Admin</title>
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
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }

        .main-content {
            padding: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h2 {
            color: #333;
            font-weight: 700;
            margin: 0;
        }

        .form-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .form-control, .form-select {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 5px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-cancel {
            background-color: #f0f0f0;
            color: #333;
        }

        .btn-cancel:hover {
            background-color: #e0e0e0;
            color: #333;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 20px;
        }

        .error-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .error-list li {
            padding: 5px 0;
        }

        .error-list li:before {
            content: "✕ ";
            color: #721c24;
            font-weight: bold;
            margin-right: 8px;
        }

        @media (max-width: 576px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row" style="min-height: 100vh;">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <h5 class="text-white px-3 mb-4">
                    <i class="fas fa-graduation-cap"></i> Online Course Admin
                </h5>
                <nav class="nav flex-column">
                    <a class="nav-link" href="index.php?controller=admin&action=dashboard">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                    <a class="nav-link active" href="index.php?controller=admin&action=users">
                        <i class="fas fa-users"></i> Quản Lý Tài Khoản
                    </a>
                    <a class="nav-link" href="index.php?controller=admin&action=categories">
                        <i class="fas fa-list"></i> Danh Mục Khóa Học
                    </a>
                    <a class="nav-link" href="index.php?controller=admin&action=courses">
                        <i class="fas fa-book"></i> Phê Duyệt Khóa Học
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 main-content">
                <div class="page-header">
                    <h2><i class="fas fa-user-plus"></i> Thêm Tài Khoản Mới</h2>
                </div>

                <div class="form-container">
                    <?php
                    // Hiển thị thông báo lỗi
                    if (!empty($errors)) {
                        echo '<div class="error-message">';
                        echo '<ul class="error-list">';
                        foreach ($errors as $error) {
                            echo '<li>' . htmlspecialchars($error) . '</li>';
                        }
                        echo '</ul>';
                        echo '</div>';
                    }
                    ?>

                    <form method="POST" action="index.php?controller=admin&action=addUserPost">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fullname"><i class="fas fa-user"></i> Họ Tên</label>
                                <input type="text" id="fullname" name="fullname" class="form-control" 
                                       placeholder="Nhập họ và tên" 
                                       value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="role"><i class="fas fa-shield-alt"></i> Quyền</label>
                                <select id="role" name="role" class="form-select" required>
                                    <option value="0" <?php echo (isset($_POST['role']) && $_POST['role'] == 0) ? 'selected' : ''; ?>>Học Viên</option>
                                    <option value="1" <?php echo (isset($_POST['role']) && $_POST['role'] == 1) ? 'selected' : ''; ?>>Giảng Viên</option>
                                    <option value="2" <?php echo (isset($_POST['role']) && $_POST['role'] == 2) ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username"><i class="fas fa-at"></i> Tên Đăng Nhập</label>
                            <input type="text" id="username" name="username" class="form-control" autocomplete="off"
                                   placeholder="Nhập tên đăng nhập (tối thiểu 3 ký tự)" 
                                   value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" id="email" name="email" class="form-control" 
                                   placeholder="Nhập địa chỉ email" 
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="password"><i class="fas fa-lock"></i> Mật Khẩu</label>
                                <input type="password" id="password" name="password" class="form-control" autocomplete="new-password"
                                       placeholder="Tối thiểu 6 ký tự" required>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password"><i class="fas fa-lock"></i> Xác Nhận Mật Khẩu</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" 
                                       placeholder="Nhập lại mật khẩu" required>
                            </div>
                        </div>

                        <div class="btn-group">
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-plus"></i> Thêm Tài Khoản
                            </button>
                            <a href="index.php?controller=admin&action=dashboard&tab=users" class="btn btn-cancel">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
