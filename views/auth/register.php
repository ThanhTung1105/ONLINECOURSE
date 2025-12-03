<?php
// Nếu đã đăng nhập, chuyển hướng về dashboard
if(isset($_SESSION['user_id'])) {
    if($_SESSION['role'] == 0) {
        header("Location: index.php?controller=student&action=dashboard");
    } elseif($_SESSION['role'] == 1) {
        header("Location: index.php?controller=instructor&action=dashboard");
    } elseif($_SESSION['role'] == 2) {
        header("Location: index.php?controller=admin&action=dashboard");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tài Khoản - Online Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 450px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-header h2 {
            color: #667eea;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .register-header p {
            color: #999;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-register {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 14px;
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

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .password-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .password-section .form-group {
            margin-bottom: 0;
        }

        @media (max-width: 576px) {
            .register-container {
                padding: 25px;
                margin: 10px;
            }

            .password-section {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .password-section .form-group {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h2><i class="fas fa-user-plus"></i> Đăng Ký Tài Khoản</h2>
            <p>Tạo tài khoản mới để bắt đầu học tập</p>
        </div>

        <?php
        // Hiển thị thông báo lỗi
        if(!empty($errors)) {
            echo '<div class="error-message">';
            echo '<ul class="error-list">';
            foreach($errors as $error) {
                echo '<li>' . htmlspecialchars($error) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }

        // Hiển thị thông báo thành công
        if(!empty($success)) {
            echo '<div class="success-message">';
            echo '<i class="fas fa-check-circle"></i> ' . htmlspecialchars($success);
            echo '</div>';
        }
        ?>

        <form method="POST" action="index.php?controller=auth&action=registerPost">
            <div class="form-group">
                <label for="fullname"><i class="fas fa-user"></i> Họ và Tên</label>
                <input type="text" id="fullname" name="fullname" class="form-control" 
                       placeholder="Nhập họ và tên" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="username"><i class="fas fa-at"></i> Tên Đăng Nhập</label>
                <input type="text" id="username" name="username" class="form-control" 
                       placeholder="Nhập tên đăng nhập (tối thiểu 3 ký tự)" 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                       placeholder="Nhập địa chỉ email" 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>

            <div class="password-section">
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Mật Khẩu</label>
                    <input type="password" id="password" name="password" class="form-control" 
                           placeholder="Tối thiểu 6 ký tự" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password"><i class="fas fa-lock"></i> Xác Nhận Mật Khẩu</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" 
                           placeholder="Nhập lại mật khẩu" required>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> Đăng Ký
            </button>
        </form>

        <div class="login-link">
            Đã có tài khoản? <a href="index.php?controller=auth&action=login">Đăng nhập tại đây</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
