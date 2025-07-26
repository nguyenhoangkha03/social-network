<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - ChatPost</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/login.css'])
</head>
<body>
    <div class="auth-background">
        <div class="auth-container">
            <div class="auth-card" id="user-login-form">
                <div class="auth-header">
                    <div class="logo">
                        <i class="fas fa-comments"></i>
                        <span>ChatPost</span>
                    </div>
                    <h2 class="form-title">Chào mừng trở lại</h2>
                    <p class="form-subtitle">Đăng nhập để tiếp tục</p>
                </div>
                <form class="auth-form" method="POST" action="{{ url('/login') }}">
                @if(session('success'))
                    <div class="alert success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @csrf
                    <div class="form-group">
                        <label for="login">Email hoặc Username</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" id="login" name="login" value="{{ old('login') }}" placeholder="Nhập email hoặc username" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">
                        <span>Đăng nhập</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
                <div class="auth-footer">
                    <p class="form-link">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
                </div>
                <div class="admin-toggle">
                    <button type="button" id="show-admin-login" class="toggle-btn">
                        <i class="fas fa-shield-alt"></i>
                        Đăng nhập quản trị
                    </button>
                </div>
            </div>
            <div class="auth-card" id="admin-login-form" style="display:none;">
                <div class="auth-header">
                    <div class="logo admin">
                        <i class="fas fa-shield-alt"></i>
                        <span>Admin Panel</span>
                    </div>
                    <h2 class="form-title">Đăng nhập quản trị</h2>
                    <p class="form-subtitle">Khu vực dành cho quản trị viên</p>
                </div>
                <form class="auth-form" method="POST" action="/admin-login" enctype="multipart/form-data">
                @if(session('error'))
                    <div class="alert error">{{ session('error') }}</div>
                @endif
                @csrf
                    <div class="form-group">
                        <label for="admin-username">Tên đăng nhập</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user-shield input-icon"></i>
                            <input type="text" id="admin-username" name="username" placeholder="Tên đăng nhập admin" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="admin-password">Mật khẩu</label>
                        <div class="input-wrapper">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" id="admin-password" name="password" placeholder="Mật khẩu admin" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('admin-password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="admin-key">File xác thực (.key)</label>
                        <div class="file-input-wrapper">
                            <input type="file" id="admin-key" name="admin_key" accept=".key" required>
                            <div class="file-input-display">
                                <i class="fas fa-upload"></i>
                                <span>Chọn file .key</span>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit admin">
                        <span>Đăng nhập Admin</span>
                        <i class="fas fa-shield-alt"></i>
                    </button>
                </form>
                <div class="auth-footer">
                    <div class="admin-toggle">
                        <button type="button" id="show-user-login" class="toggle-btn">
                            <i class="fas fa-arrow-left"></i>
                            Quay lại đăng nhập người dùng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    // Toggle between user and admin login
    document.getElementById('show-admin-login').onclick = function() {
        document.getElementById('user-login-form').classList.add('slide-out');
        setTimeout(() => {
            document.getElementById('user-login-form').style.display = 'none';
            document.getElementById('admin-login-form').style.display = 'block';
            document.getElementById('admin-login-form').classList.add('slide-in');
        }, 300);
    };
    
    document.getElementById('show-user-login').onclick = function() {
        document.getElementById('admin-login-form').classList.add('slide-out');
        setTimeout(() => {
            document.getElementById('admin-login-form').style.display = 'none';
            document.getElementById('user-login-form').style.display = 'block';
            document.getElementById('user-login-form').classList.add('slide-in');
        }, 300);
    };
    
    // Password toggle function
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const button = input.parentNode.querySelector('.password-toggle i');
        
        if (input.type === 'password') {
            input.type = 'text';
            button.classList.remove('fa-eye');
            button.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            button.classList.remove('fa-eye-slash');
            button.classList.add('fa-eye');
        }
    }
    
    // File input display
    document.getElementById('admin-key').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Chọn file .key';
        const display = e.target.parentNode.querySelector('.file-input-display span');
        display.textContent = fileName;
    });
    </script>
</body>
</html> 