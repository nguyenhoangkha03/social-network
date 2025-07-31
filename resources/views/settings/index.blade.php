<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cài đặt - ChatPost</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #dbeafe;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --surface: #ffffff;
            --surface-secondary: #f8fafc;
            --surface-tertiary: #f1f5f9;
            --border: #e2e8f0;
            --border-light: #f1f5f9;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-tertiary: #94a3b8;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-10: 2.5rem;
            --space-12: 3rem;
            --space-16: 4rem;
            --space-20: 5rem;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--text-primary);
            line-height: 1.5;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: var(--space-6);
        }

        .header {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-6);
            margin-bottom: var(--space-8);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: var(--space-4);
            padding: var(--space-2) var(--space-4);
            background: var(--surface-secondary);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }

        .back-btn:hover {
            background: var(--primary-light);
            color: var(--primary-dark);
            transform: translateX(-2px);
            box-shadow: var(--shadow-sm);
        }

        .header-content {
            text-align: center;
        }

        .title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: var(--space-2);
        }

        .subtitle {
            color: var(--text-secondary);
            font-size: 1.125rem;
        }

        .settings-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: var(--space-8);
        }

        .sidebar {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-6);
            height: fit-content;
            position: sticky;
            top: var(--space-6);
        }

        .sidebar-nav {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) var(--space-4);
            text-decoration: none;
            color: var(--text-secondary);
            border-radius: var(--radius-lg);
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .sidebar-nav a:hover {
            background: var(--surface-secondary);
            color: var(--primary);
        }

        .sidebar-nav a.active {
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        .content {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-8);
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: var(--space-6);
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .section-title i {
            color: var(--primary);
        }

        .setting-group {
            margin-bottom: var(--space-8);
        }

        .setting-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: var(--space-4);
            background: var(--surface-secondary);
            border-radius: var(--radius-xl);
            margin-bottom: var(--space-4);
            border: 1px solid var(--border-light);
        }

        .setting-info {
            flex: 1;
        }

        .setting-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: var(--space-1);
        }

        .setting-desc {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .setting-control {
            margin-left: var(--space-4);
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 24px;
            background: var(--border);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-switch.active {
            background: var(--primary);
        }

        .toggle-slider {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .toggle-switch.active .toggle-slider {
            transform: translateX(26px);
        }

        .select-control {
            padding: var(--space-2) var(--space-4);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            background: var(--surface);
            color: var(--text-primary);
            font-size: 0.875rem;
            min-width: 120px;
        }

        .select-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .danger-zone {
            border: 1px solid var(--error);
            border-radius: var(--radius-xl);
            padding: var(--space-6);
            margin-top: var(--space-8);
        }

        .danger-title {
            color: var(--error);
            font-weight: 700;
            margin-bottom: var(--space-4);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .btn {
            padding: var(--space-3) var(--space-6);
            border-radius: var(--radius-lg);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        .btn-danger {
            background: var(--error);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        .notification {
            position: fixed;
            top: var(--space-6);
            right: var(--space-6);
            padding: var(--space-4) var(--space-6);
            background: var(--success);
            color: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            transform: translateX(400px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .notification.show {
            transform: translateX(0);
        }

        .user-info-card {
            background: var(--surface-secondary);
            border-radius: var(--radius-xl);
            padding: var(--space-6);
            margin-bottom: var(--space-8);
            border: 1px solid var(--border-light);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 700;
            margin: 0 auto var(--space-4);
        }

        .user-name {
            text-align: center;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: var(--space-1);
        }

        .user-email {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .settings-container {
                grid-template-columns: 1fr;
                gap: var(--space-6);
            }

            .sidebar {
                position: static;
            }

            .sidebar-nav {
                flex-direction: row;
                overflow-x: auto;
                gap: var(--space-1);
            }

            .sidebar-nav a {
                white-space: nowrap;
                min-width: fit-content;
                padding: var(--space-2) var(--space-3);
            }

            .setting-item {
                flex-direction: column;
                gap: var(--space-3);
                align-items: flex-start;
            }

            .setting-control {
                margin-left: 0;
                width: 100%;
                display: flex;
                justify-content: flex-end;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('home') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Quay lại trang chủ
            </a>
            
            <div class="header-content">
                <h1 class="title">Cài đặt</h1>
                <p class="subtitle">Tùy chỉnh trải nghiệm của bạn</p>
            </div>
        </div>

        <div class="settings-container">
            <!-- Sidebar Navigation -->
            <div class="sidebar">
                <ul class="sidebar-nav">
                    <li><a href="#general" class="nav-link active" data-section="general">
                        <i class="fas fa-user-cog"></i>
                        Chung
                    </a></li>
                    <li><a href="#appearance" class="nav-link" data-section="appearance">
                        <i class="fas fa-palette"></i>
                        Giao diện
                    </a></li>
                    <li><a href="#notifications" class="nav-link" data-section="notifications">
                        <i class="fas fa-bell"></i>
                        Thông báo
                    </a></li>
                    <li><a href="#privacy" class="nav-link" data-section="privacy">
                        <i class="fas fa-shield-alt"></i>
                        Riêng tư
                    </a></li>
                    <li><a href="#account" class="nav-link" data-section="account">
                        <i class="fas fa-user-circle"></i>
                        Tài khoản
                    </a></li>
                </ul>
            </div>

            <!-- Content Area -->
            <div class="content">
                <!-- General Settings -->
                <div id="general" class="section active">
                    <h2 class="section-title">
                        <i class="fas fa-user-cog"></i>
                        Cài đặt chung
                    </h2>

                    <div class="user-info-card">
                        @if($user->hinhanh)
                            <img src="data:image/jpeg;base64,{{ base64_encode($user->hinhanh) }}" alt="Avatar" class="user-avatar">
                        @else
                            <div class="user-avatar">
                                {{ strtoupper(substr($user->hoten ?? $user->username ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                        <div class="user-name">{{ $user->hoten ?? $user->username }}</div>
                        <div class="user-email">{{ $user->email }}</div>
                    </div>

                    <div class="setting-group">
                        <div class="setting-item">
                            <div class="setting-info">
                                <div class="setting-label">Ngôn ngữ</div>
                                <div class="setting-desc">Chọn ngôn ngữ hiển thị</div>
                            </div>
                            <div class="setting-control">
                                <select class="select-control" id="language">
                                    <option value="vi" {{ ($user->language ?? 'vi') === 'vi' ? 'selected' : '' }}>Tiếng Việt</option>
                                    <option value="en" {{ ($user->language ?? 'vi') === 'en' ? 'selected' : '' }}>English</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appearance Settings -->
                <div id="appearance" class="section">
                    <h2 class="section-title">
                        <i class="fas fa-palette"></i>
                        Giao diện
                    </h2>

                    <div class="setting-group">
                        <div class="setting-item">
                            <div class="setting-info">
                                <div class="setting-label">Chế độ tối</div>
                                <div class="setting-desc">Bật chế độ tối để bảo vệ mắt</div>
                            </div>
                            <div class="setting-control">
                                <div class="toggle-switch {{ ($user->theme ?? 'light') === 'dark' ? 'active' : '' }}" id="darkMode">
                                    <div class="toggle-slider"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div id="notifications" class="section">
                    <h2 class="section-title">
                        <i class="fas fa-bell"></i>
                        Thông báo
                    </h2>

                    <div class="setting-group">
                        <div class="setting-item">
                            <div class="setting-info">
                                <div class="setting-label">Thông báo trên web</div>
                                <div class="setting-desc">Nhận thông báo khi có hoạt động mới</div>
                            </div>
                            <div class="setting-control">
                                <div class="toggle-switch {{ ($user->notifications_enabled ?? true) ? 'active' : '' }}" id="webNotifications">
                                    <div class="toggle-slider"></div>
                                </div>
                            </div>
                        </div>

                        <div class="setting-item">
                            <div class="setting-info">
                                <div class="setting-label">Thông báo email</div>
                                <div class="setting-desc">Nhận thông báo qua email</div>
                            </div>
                            <div class="setting-control">
                                <div class="toggle-switch {{ ($user->email_notifications ?? true) ? 'active' : '' }}" id="emailNotifications">
                                    <div class="toggle-slider"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Privacy Settings -->
                <div id="privacy" class="section">
                    <h2 class="section-title">
                        <i class="fas fa-shield-alt"></i>
                        Riêng tư & Bảo mật
                    </h2>

                    <div class="setting-group">
                        <div class="setting-item">
                            <div class="setting-info">
                                <div class="setting-label">Chế độ riêng tư</div>
                                <div class="setting-desc">Ẩn hoạt động của bạn khỏi người khác</div>
                            </div>
                            <div class="setting-control">
                                <div class="toggle-switch {{ ($user->privacy_mode ?? false) ? 'active' : '' }}" id="privacyMode">
                                    <div class="toggle-slider"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Settings -->
                <div id="account" class="section">
                    <h2 class="section-title">
                        <i class="fas fa-user-circle"></i>
                        Tài khoản
                    </h2>

                    <div class="setting-group">
                        <div class="setting-item">
                            <div class="setting-info">
                                <div class="setting-label">Chỉnh sửa hồ sơ</div>
                                <div class="setting-desc">Cập nhật thông tin cá nhân</div>
                            </div>
                            <div class="setting-control">
                                <a href="{{ route('profile.edit', $user->user_id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                    Chỉnh sửa
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="danger-zone">
                        <h3 class="danger-title">
                            <i class="fas fa-exclamation-triangle"></i>
                            Vùng nguy hiểm
                        </h3>
                        <div class="setting-item">
                            <div class="setting-info">
                                <div class="setting-label">Xóa tài khoản</div>
                                <div class="setting-desc">Xóa vĩnh viễn tài khoản và tất cả dữ liệu</div>
                            </div>
                            <div class="setting-control">
                                <button class="btn btn-danger" onclick="confirmDeleteAccount()">
                                    <i class="fas fa-trash"></i>
                                    Xóa tài khoản
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Toast -->
    <div class="notification" id="notification">
        <i class="fas fa-check-circle" style="margin-right: var(--space-2);"></i>
        <span id="notificationText">Cài đặt đã được lưu!</span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navigation
            const navLinks = document.querySelectorAll('.nav-link');
            const sections = document.querySelectorAll('.section');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all links and sections
                    navLinks.forEach(l => l.classList.remove('active'));
                    sections.forEach(s => s.classList.remove('active'));
                    
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    // Show corresponding section
                    const sectionId = this.dataset.section;
                    document.getElementById(sectionId).classList.add('active');
                });
            });

            // Toggle switches
            const toggles = document.querySelectorAll('.toggle-switch');
            toggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    this.classList.toggle('active');
                    updateSetting();
                });
            });

            // Select controls
            const selects = document.querySelectorAll('.select-control');
            selects.forEach(select => {
                select.addEventListener('change', updateSetting);
            });

            function updateSetting() {
                const settings = {
                    theme: document.getElementById('darkMode').classList.contains('active') ? 'dark' : 'light',
                    language: document.getElementById('language').value,
                    notifications_enabled: document.getElementById('webNotifications').classList.contains('active'),
                    email_notifications: document.getElementById('emailNotifications').classList.contains('active'),
                    privacy_mode: document.getElementById('privacyMode').classList.contains('active')
                };

                fetch('{{ route("settings.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(settings)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message);
                        
                        // Apply theme immediately
                        if (settings.theme === 'dark') {
                            document.body.classList.add('dark-theme');
                        } else {
                            document.body.classList.remove('dark-theme');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Có lỗi xảy ra khi lưu cài đặt', 'error');
                });
            }

            function showNotification(message, type = 'success') {
                const notification = document.getElementById('notification');
                const notificationText = document.getElementById('notificationText');
                
                notificationText.textContent = message;
                notification.classList.add('show');
                
                if (type === 'error') {
                    notification.style.background = 'var(--error)';
                } else {
                    notification.style.background = 'var(--success)';
                }
                
                setTimeout(() => {
                    notification.classList.remove('show');
                }, 3000);
            }

            window.showNotification = showNotification;
        });

        function confirmDeleteAccount() {
            if (confirm('Bạn có chắc chắn muốn xóa tài khoản? Hành động này không thể hoàn tác!')) {
                if (confirm('Điều này sẽ xóa vĩnh viễn tất cả dữ liệu của bạn. Bạn có thực sự muốn tiếp tục?')) {
                    // TODO: Implement account deletion
                    alert('Tính năng xóa tài khoản sẽ được cập nhật trong tương lai.');
                }
            }
        }
    </script>
</body>
</html>