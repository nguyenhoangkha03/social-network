<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trang Chủ - SpiderClone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/home.css'])
    <style>
        /* ... các style cũ ... */
        .dark-theme {
            background: #181a1b !important;
            color: #f1f1f1 !important;
        }

        .dark-theme body,
        .dark-theme .container,
        .dark-theme .content-wrapper,
        .dark-theme .main-content,
        .dark-theme .sidebar,
        .dark-theme .top-bar,
        .dark-theme .nav-actions,
        .dark-theme .main-nav,
        .dark-theme .logo {
            background: #181a1b !important;
            color: #f1f1f1 !important;
        }

        .dark-theme .hero,
        .dark-theme .profile-banner {
            background: linear-gradient(90deg, #23272b 0%, #181a1b 100%) !important;
            color: #f1f1f1 !important;
        }

        .dark-theme .featured-posts,
        .dark-theme .latest-posts,
        .dark-theme .featured-grid,
        .dark-theme .posts-grid,
        .dark-theme .no-posts,
        .dark-theme .post-card,
        .dark-theme .featured-post,
        .dark-theme .sidebar,
        .dark-theme .stat-card {
            background: #23272b !important;
            color: #f1f1f1 !important;
            border: 1px solid #333 !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.18) !important;
        }

        .dark-theme .stat-label,
        .dark-theme .post-excerpt,
        .dark-theme .author,
        .dark-theme .date,
        .dark-theme .views,
        .dark-theme .user-meta,
        .dark-theme .post-meta,
        .dark-theme .sidebar .desc {
            color: #bbb !important;
        }

        .dark-theme .username,
        .dark-theme .fullname,
        .dark-theme .bio,
        .dark-theme h1,
        .dark-theme h2,
        .dark-theme h3,
        .dark-theme h4,
        .dark-theme h5,
        .dark-theme h6 {
            color: #f1f1f1 !important;
        }

        .dark-theme .user-meta i,
        .dark-theme .section-title,
        .dark-theme .stat-number,
        .dark-theme .cta-button {
            color: #4dc3ff !important;
        }

        .dark-theme .action-btn,
        .dark-theme .action-btn.edit,
        .dark-theme .cta-button,
        .dark-theme .logout-btn {
            background: #23272b !important;
            color: #4dc3ff !important;
            border-color: #4dc3ff !important;
        }

        .dark-theme .action-btn.edit:hover,
        .dark-theme .cta-button:hover,
        .dark-theme .logout-btn:hover {
            background: #4dc3ff !important;
            color: #23272b !important;
        }

        .dark-theme .action-btn:not(.edit) {
            background: #23272b !important;
            color: #fff !important;
        }

        .dark-theme .dropdown-item {
            background: #23272b !important;
            color: #f1f1f1 !important;
        }

        .dark-theme .avatar,
        .dark-theme .user-avatar {
            background: #23272b !important;
            border-color: #bbb !important;
        }

        .dark-theme .avatar i,
        .dark-theme .user-avatar i {
            color: #bbb !important;
        }

        .dark-theme .post-item,
        .dark-theme .featured-post,
        .dark-theme .post-card {
            border-bottom: 1px solid #333 !important;
        }

        .dark-theme .post-title a,
        .dark-theme .featured-post h3,
        .dark-theme .post-card h3 {
            color: #f1f1f1 !important;
        }

        .dark-theme .back-link {
            color: #4dc3ff !important;
        }

        .dark-theme input,
        .dark-theme textarea,
        .dark-theme select {
            background: #23272b !important;
            color: #f1f1f1 !important;
            border: 1px solid #444 !important;
        }

        .dark-theme input::placeholder,
        .dark-theme textarea::placeholder {
            color: #bbb !important;
        }

        .dark-theme .main-nav a,
        .dark-theme .logo a,
        .dark-theme .nav-actions a {
            color: #f1f1f1 !important;
        }

        .dark-theme .logout-btn {
            background: #23272b !important;
            color: #4dc3ff !important;
            border: 1px solid #4dc3ff !important;
        }

        .dark-theme .logout-btn:hover {
            background: #4dc3ff !important;
            color: #23272b !important;
        }

        .dark-theme .featured-posts h2,
        .dark-theme .latest-posts h2 {
            color: #4dc3ff !important;
        }

        .dark-theme .no-posts {
            border: 1px dashed #444 !important;
            color: #bbb !important;
        }

        .dark-theme .sidebar .box {
            background: #23272b !important;
            color: #f1f1f1 !important;
            border: 1px solid #333 !important;
        }

        .dark-theme .sidebar .box .desc {
            color: #bbb !important;
        }

        .dark-theme .like-btn {
            color: #4dc3ff !important;
        }

        .dark-theme .like-btn[data-liked="true"] {
            color: #e74c3c !important;
        }

        .dark-theme .fa-search {
            color: #4dc3ff !important;
        }

        .dark-theme .container,
        .dark-theme .main-content,
        .dark-theme .sidebar,
        .dark-theme .hero,
        .dark-theme .post-card,
        .dark-theme .featured-post,
        .dark-theme .category-card,
        .dark-theme .footer,
        .dark-theme .top-bar,
        .dark-theme .nav-actions,
        .dark-theme .main-nav,
        .dark-theme .logo,
        .dark-theme .no-posts,
        .dark-theme .featured-grid,
        .dark-theme .posts-grid {
            background: #23272b !important;
            color: #f1f1f1 !important;
            border-color: #333 !important;
        }

        .dark-theme .post-content,
        .dark-theme .post-meta,
        .dark-theme .post-excerpt,
        .dark-theme .author,
        .dark-theme .date,
        .dark-theme .views,
        .dark-theme .sidebar .desc {
            color: #bbb !important;
        }

        .dark-theme h1,
        .dark-theme h2,
        .dark-theme h3,
        .dark-theme h4,
        .dark-theme h5,
        .dark-theme h6,
        .dark-theme .username,
        .dark-theme .fullname,
        .dark-theme .bio {
            color: #f1f1f1 !important;
        }

        .dark-theme .user-meta i,
        .dark-theme .section-title,
        .dark-theme .stat-number,
        .dark-theme .cta-button {
            color: #4dc3ff !important;
        }

        .dark-theme .action-btn,
        .dark-theme .action-btn.edit,
        .dark-theme .cta-button,
        .dark-theme .logout-btn {
            background: #23272b !important;
            color: #4dc3ff !important;
            border-color: #4dc3ff !important;
        }

        .dark-theme .action-btn.edit:hover,
        .dark-theme .cta-button:hover,
        .dark-theme .logout-btn:hover {
            background: #4dc3ff !important;
            color: #23272b !important;
        }

        .dark-theme .action-btn:not(.edit) {
            background: #23272b !important;
            color: #fff !important;
        }

        .dark-theme .dropdown-item {
            background: #23272b !important;
            color: #f1f1f1 !important;
        }

        .dark-theme .avatar,
        .dark-theme .user-avatar {
            background: #23272b !important;
            border-color: #bbb !important;
        }

        .dark-theme .avatar i,
        .dark-theme .user-avatar i {
            color: #bbb !important;
        }

        .dark-theme .post-item,
        .dark-theme .featured-post,
        .dark-theme .post-card {
            border-bottom: 1px solid #333 !important;
        }

        .dark-theme .post-title a,
        .dark-theme .featured-post h3,
        .dark-theme .post-card h3 {
            color: #f1f1f1 !important;
        }

        .dark-theme .back-link {
            color: #4dc3ff !important;
        }

        .dark-theme input,
        .dark-theme textarea,
        .dark-theme select {
            background: #23272b !important;
            color: #f1f1f1 !important;
            border: 1px solid #444 !important;
        }

        .dark-theme input::placeholder,
        .dark-theme textarea::placeholder {
            color: #bbb !important;
        }

        .dark-theme .main-nav a,
        .dark-theme .logo a,
        .dark-theme .nav-actions a {
            color: #f1f1f1 !important;
        }

        .dark-theme .logout-btn {
            background: #23272b !important;
            color: #4dc3ff !important;
            border: 1px solid #4dc3ff !important;
        }

        .dark-theme .logout-btn:hover {
            background: #4dc3ff !important;
            color: #23272b !important;
        }

        .dark-theme .featured-posts h2,
        .dark-theme .latest-posts h2 {
            color: #4dc3ff !important;
        }

        .dark-theme .no-posts {
            border: 1px dashed #444 !important;
            color: #bbb !important;
        }

        .dark-theme .sidebar .widget,
        .dark-theme .sidebar .box {
            background: #23272b !important;
            color: #f1f1f1 !important;
            border: 1px solid #333 !important;
        }

        .dark-theme .sidebar .box .desc {
            color: #bbb !important;
        }

        .dark-theme .like-btn {
            color: #4dc3ff !important;
        }

        .dark-theme .like-btn[data-liked="true"] {
            color: #e74c3c !important;
        }

        .dark-theme .fa-search {
            color: #4dc3ff !important;
        }

        /* Header Styles */
        .modern-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-primary);
            transition: all 0.3s ease;
        }

        .header-container {
            max-width: var(--container-2xl);
            margin: 0 auto;
            padding: 0 var(--space-6);
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .modern-logo {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            text-decoration: none;
            color: var(--text-primary);
            font-weight: var(--font-bold);
            font-size: var(--text-xl);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-primary);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: var(--text-lg);
        }

        .header-nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: var(--space-8);
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: var(--font-medium);
            transition: color 0.2s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .search-toggle,
        .notification-bell,
        .user-menu-toggle {
            width: 44px;
            height: 44px;
            border: none;
            background: var(--surface-secondary);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .search-toggle:hover,
        .notification-bell:hover,
        .user-menu-toggle:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .notification-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: var(--error);
            border-radius: var(--radius-full);
            border: 2px solid white;
        }

        .cta-secondary,
        .cta-primary {
            padding: var(--space-2) var(--space-6);
            border-radius: var(--radius-xl);
            text-decoration: none;
            font-weight: var(--font-semibold);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
        }

        .cta-secondary {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-primary);
        }

        .cta-secondary:hover {
            background: var(--surface-secondary);
            color: var(--primary);
        }

        .cta-primary {
            background: var(--gradient-primary);
            color: white;
        }

        .cta-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Dark theme for header */
        .dark-theme .modern-header {
            background: rgba(24, 26, 27, 0.8) !important;
            border-bottom-color: #333 !important;
        }

        .dark-theme .search-toggle,
        .dark-theme .notification-bell,
        .dark-theme .user-menu-toggle {
            background: #23272b !important;
            color: #f1f1f1 !important;
        }

        .dark-theme .search-toggle:hover,
        .dark-theme .notification-bell:hover,
        .dark-theme .user-menu-toggle:hover {
            background: var(--primary) !important;
            color: white !important;
        }
    </style>
</head>

<body @if(isset($user) && $user->theme === 'dark') class="dark-theme" @endif>
    <!-- Modern Header -->
    <header class="modern-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="modern-logo">
                <div class="logo-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <span class="logo-text">ChatPost</span>
            </a>

            <nav class="header-nav">
                <ul class="nav-links">
                    <li><a href="{{ route('home') }}" class="nav-link">Trang chủ</a></li>
                    <li><a href="{{ route('categories.index') }}" class="nav-link">Chủ đề</a></li>
                    <li><a href="#" class="nav-link">Cộng đồng</a></li>
                    <li><a href="#" class="nav-link">Về chúng tôi</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                <!-- Search Toggle -->
                <button class="search-toggle" id="searchToggle">
                    <i class="fas fa-search"></i>
                </button>

                <!-- Search Modal -->
                <div class="search-modal" id="searchModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000; backdrop-filter: blur(4px);">
                    <div style="display: flex; align-items: flex-start; justify-content: center; padding-top: 100px;">
                        <div style="background: var(--surface-primary); border-radius: var(--radius-2xl); padding: var(--space-6); width: 90%; max-width: 600px; box-shadow: var(--shadow-2xl);">
                            <div style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-4);">
                                <i class="fas fa-search" style="color: var(--primary); font-size: var(--text-lg);"></i>
                                <input type="text" id="searchInput" placeholder="Tìm kiếm bài viết, người dùng..." style="flex: 1; border: none; outline: none; font-size: var(--text-lg); background: transparent; color: var(--text-primary);" autofocus>
                                <button id="closeSearch" style="background: none; border: none; color: var(--text-tertiary); font-size: var(--text-xl); cursor: pointer; padding: var(--space-2);">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div style="border-top: 1px solid var(--border-primary); padding-top: var(--space-4);">
                                <div style="display: flex; gap: var(--space-2); margin-bottom: var(--space-4);">
                                    <button class="search-tab active" data-type="post" style="padding: var(--space-2) var(--space-4); border: 1px solid var(--primary); background: var(--primary); color: white; border-radius: var(--radius-lg); font-weight: var(--font-medium); cursor: pointer;">Bài viết</button>
                                    <button class="search-tab" data-type="user" style="padding: var(--space-2) var(--space-4); border: 1px solid var(--border-primary); background: transparent; color: var(--text-secondary); border-radius: var(--radius-lg); font-weight: var(--font-medium); cursor: pointer;">Người dùng</button>
                                </div>
                                <div id="searchResults" style="max-height: 400px; overflow-y: auto;">
                                    <div style="text-align: center; color: var(--text-tertiary); padding: var(--space-8);">
                                        <i class="fas fa-search" style="font-size: var(--text-2xl); margin-bottom: var(--space-2);"></i>
                                        <p>Nhập từ khóa để tìm kiếm</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($user) && $user)
                <!-- Notification Bell Container -->
                <div style="position: relative;">
                    <button class="notification-bell" id="notificationBell">
                        <i class="fas fa-bell"></i>
                        @if($user->myNotifications()->where('is_read', false)->count() > 0)
                        <span class="notification-badge"></span>
                        @endif
                    </button>

                    <!-- Notification Dropdown -->
                    <div class="notification-dropdown" id="notificationDropdown" style="display: none; position: absolute; top: 60px; right: 0; width: 350px; background: var(--surface-primary); border: 1px solid var(--border-primary); border-radius: var(--radius-2xl); box-shadow: var(--shadow-xl); z-index: 1000; max-height: 400px; overflow-y: auto;">
                        <div style="padding: var(--space-4); border-bottom: 1px solid var(--border-primary); display: flex; align-items: center; justify-content: space-between;">
                            <h3 style="font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--text-primary); margin: 0;">Thông báo</h3>
                            <button id="markAllRead" style="background: none; border: none; color: var(--primary); font-size: var(--text-sm); cursor: pointer; font-weight: var(--font-medium);">Đánh dấu tất cả</button>
                        </div>
                        <div id="notificationList" style="padding: var(--space-2);">
                            <div style="text-align: center; color: var(--text-tertiary); padding: var(--space-8);">
                                <i class="fas fa-bell" style="font-size: var(--text-2xl); margin-bottom: var(--space-2);"></i>
                                <p>Đang tải thông báo...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                <button class="user-menu-toggle" id="userMenuToggle">
                    @if($user->hinhanh)
                    <img src="data:image/jpeg;base64,{{ base64_encode($user->hinhanh) }}" alt="Avatar" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                    @else
                    <i class="fas fa-user"></i>
                    @endif
                </button>

                <!-- User Dropdown Menu -->
                <div class="user-dropdown" id="userDropdown" style="display: none;">
                    <a href="{{ route('user.profile', $user->user_id) }}">
                        <i class="fas fa-user" style="margin-right: var(--space-2);"></i>
                        Hồ sơ của tôi
                    </a>
                    <a href="{{ route('post.create') }}">
                        <i class="fas fa-plus" style="margin-right: var(--space-2);"></i>
                        Viết bài mới
                    </a>
                    <a href="/chat">
                        <i class="fas fa-comments" style="margin-right: var(--space-2);"></i>
                        Tin nhắn
                    </a>
                    <a href="#">
                        <i class="fas fa-cog" style="margin-right: var(--space-2);"></i>
                        Cài đặt
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit">
                            <i class="fas fa-sign-out-alt" style="margin-right: var(--space-2);"></i>
                            Đăng xuất
                        </button>
                    </form>
                </div>
                @else
                <a href="{{ route('login') }}" class="cta-secondary">Đăng nhập</a>
                <a href="{{ route('register') }}" class="cta-primary">Đăng ký</a>
                @endif
            </div>
        </div>
    </header>

    <!-- Modern Hero Section -->
    <section class="modern-hero">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-text">
                    <div class="hero-badge">
                        <i class="fas fa-sparkles"></i>
                        <span>Nền tảng chia sẻ hiện đại</span>
                    </div>
                    <h1 class="hero-title">Góc nhìn đa chiều của thế hệ trẻ Việt Nam</h1>
                    <p class="hero-subtitle">
                        Kết nối - Chia sẻ - Sáng tạo với cộng đồng tri thức hàng đầu.
                        Nơi mọi ý tưởng đều có giá trị và được tôn trọng.
                    </p>
                    <div class="hero-actions">
                        @if(isset($user) && $user)
                        <a href="{{ route('post.create') }}" class="cta-primary">
                            <i class="fas fa-plus"></i>
                            <span>Tạo bài viết</span>
                        </a>
                        <a href="#featured" class="cta-secondary">
                            <i class="fas fa-compass"></i>
                            <span>Khám phá ngay</span>
                        </a>
                        @else
                        <a href="{{ route('register') }}" class="cta-primary">
                            <i class="fas fa-user-plus"></i>
                            <span>Tham gia ngay</span>
                        </a>
                        <a href="{{ route('login') }}" class="cta-secondary">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Đăng nhập</span>
                        </a>
                        @endif
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="hero-image-grid">
                        <div class="hero-card">
                            <div class="card-header">
                                <div class="card-avatar">T</div>
                                <div class="card-info">
                                    <h4>Trần Minh An</h4>
                                    <p>Tech Blogger</p>
                                </div>
                            </div>
                            <div class="card-content">
                                "Nơi tôi có thể chia sẻ những kiến thức công nghệ mới nhất và kết nối với cộng đồng developer Việt Nam."
                            </div>
                            <div class="card-stats">
                                <span><i class="fas fa-heart"></i> 1.2k</span>
                                <span><i class="fas fa-comment"></i> 45</span>
                                <span><i class="fas fa-share"></i> 120</span>
                            </div>
                        </div>

                        <div class="hero-card">
                            <div class="card-header">
                                <div class="card-avatar">L</div>
                                <div class="card-info">
                                    <h4>Lê Thị Mai</h4>
                                    <p>Content Creator</p>
                                </div>
                            </div>
                            <div class="card-content">
                                "Một community tuyệt vời để học hỏi và phát triển bản thân. Mình đã tìm được rất nhiều cảm hứng ở đây!"
                            </div>
                            <div class="card-stats">
                                <span><i class="fas fa-heart"></i> 856</span>
                                <span><i class="fas fa-comment"></i> 32</span>
                                <span><i class="fas fa-share"></i> 78</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content" style="padding-top: 100px;"> <!-- Offset for fixed header -->
        <div class="container" style="max-width: var(--container-2xl); margin: 0 auto; padding: var(--space-6);">
            <div class="content-wrapper" style="display: grid; grid-template-columns: 1fr 300px; gap: var(--space-12); align-items: start;">

                <!-- Featured Posts Section -->
                <section class="featured-posts" id="featured" style="margin-bottom: var(--space-16);">
                    <div style="text-align: center; margin-bottom: var(--space-12);">
                        <h2 style="font-size: var(--text-4xl); font-weight: var(--font-black); color: var(--text-primary); margin-bottom: var(--space-4);">Bài Viết Nổi Bật</h2>
                        <p style="font-size: var(--text-lg); color: var(--text-secondary); max-width: 600px; margin: 0 auto;">Khám phá những bài viết được yêu thích nhất từ cộng đồng</p>
                    </div>

                    <div class="featured-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: var(--space-8);">
                        @if(isset($featuredPosts) && count($featuredPosts) > 0)
                        @foreach($featuredPosts as $post)
                        <article class="modern-post-card" style="background: var(--surface-primary); border-radius: var(--radius-2xl); overflow: hidden; box-shadow: var(--shadow-lg); transition: all var(--duration-300) var(--ease-out); border: 1px solid var(--border-primary);">
                            <a href="{{ route('post.show', $post->id_baiviet) }}" style="text-decoration: none; color: inherit; display: block;">
                                <div class="post-image" style="height: 200px; overflow: hidden; position: relative;">
                                    @if($post->anh_bia)
                                    <img src="{{ asset($post->anh_bia) }}" alt="{{ $post->tieude ?? 'Featured Post' }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform var(--duration-500) var(--ease-out);">
                                    @else
                                    <div style="width: 100%; height: 100%; background: var(--gradient-primary); display: flex; align-items: center; justify-content: center; color: var(--text-inverse); font-size: var(--text-2xl); font-weight: var(--font-bold);">{{ substr($post->tieude ?? 'Post', 0, 1) }}</div>
                                    @endif
                                    <div style="position: absolute; top: var(--space-4); right: var(--space-4); background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); padding: var(--space-2) var(--space-3); border-radius: var(--radius-full); font-size: var(--text-sm); font-weight: var(--font-medium); color: var(--primary);">
                                        <i class="fas fa-star" style="margin-right: var(--space-1);"></i>Nổi bật
                                    </div>
                                </div>
                                <div class="post-content" style="padding: var(--space-6);">
                                    <h3 style="font-size: var(--text-xl); font-weight: var(--font-bold); line-height: var(--leading-tight); margin-bottom: var(--space-3); color: var(--text-primary);">{{ Str::limit($post->tieude ?? 'Tiêu đề bài viết', 60) }}</h3>
                                    <p class="post-excerpt" style="color: var(--text-secondary); line-height: var(--leading-relaxed); margin-bottom: var(--space-4);">{{ Str::limit($post->mota ?? $post->noidung ?? 'Nội dung bài viết...', 120) }}</p>
                                    <div class="post-meta" style="display: flex; align-items: center; justify-content: space-between;">
                                        <div style="display: flex; align-items: center; gap: var(--space-3);">
                                            <div style="width: 32px; height: 32px; border-radius: var(--radius-full); background: var(--gradient-secondary); display: flex; align-items: center; justify-content: center; color: var(--text-inverse); font-weight: var(--font-bold); font-size: var(--text-sm);">{{ substr($post->user->hoten ?? $post->user->username ?? 'U', 0, 1) }}</div>
                                            <div>
                                                <div style="font-weight: var(--font-medium); color: var(--text-primary); font-size: var(--text-sm);">{{ $post->user->hoten ?? $post->user->username ?? 'Tác giả' }}</div>
                                                <div style="color: var(--text-tertiary); font-size: var(--text-xs);">{{ $post->thoigiandang ? $post->thoigiandang->format('d/m/Y') : 'N/A' }}</div>
                                            </div>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: var(--space-3); color: var(--text-tertiary); font-size: var(--text-sm);">
                                            <span><i class="fas fa-heart" style="color: var(--error); margin-right: var(--space-1);"></i>{{ $post->soluotlike ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </article>
                        @endforeach
                        @else
                        <div class="no-posts" style="grid-column: 1/-1; text-align: center; padding: var(--space-16); background: var(--surface-secondary); border-radius: var(--radius-2xl); border: 2px dashed var(--border-secondary);">
                            <i class="fas fa-newspaper" style="font-size: var(--text-4xl); color: var(--text-tertiary); margin-bottom: var(--space-4);"></i>
                            <h3 style="font-size: var(--text-xl); font-weight: var(--font-semibold); color: var(--text-primary); margin-bottom: var(--space-2);">Chưa có bài viết nổi bật</h3>
                            <p style="color: var(--text-secondary); margin-bottom: var(--space-6);">Hãy là người đầu tiên chia sẻ nội dung chất lượng!</p>
                            @if(isset($user) && $user)
                            <a href="{{ route('post.create') }}" class="cta-primary" style="display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-3) var(--space-6); background: var(--gradient-primary); color: var(--text-inverse); text-decoration: none; border-radius: var(--radius-xl); font-weight: var(--font-semibold); transition: all var(--duration-200) var(--ease-out);">
                                <i class="fas fa-plus"></i>Tạo bài viết đầu tiên
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </section>

                <!-- Latest Posts Section -->
                <section class="latest-posts" style="margin-bottom: var(--space-16);">
                    <div style="text-align: center; margin-bottom: var(--space-12);">
                        <h2 style="font-size: var(--text-4xl); font-weight: var(--font-black); color: var(--text-primary); margin-bottom: var(--space-4);">Bài Viết Mới Nhất</h2>
                        <p style="font-size: var(--text-lg); color: var(--text-secondary); max-width: 600px; margin: 0 auto;">Cập nhật những chia sẻ mới nhất từ cộng đồng</p>
                    </div>

                    <div class="posts-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: var(--space-6);">
                        @if(isset($baiviets) && count($baiviets) > 0)
                        @foreach($baiviets as $post)
                        <article class="modern-post-card" style="background: var(--surface-primary); border-radius: var(--radius-2xl); overflow: hidden; box-shadow: var(--shadow-md); transition: all var(--duration-300) var(--ease-out); border: 1px solid var(--border-primary); position: relative;">
                            <a href="{{ route('post.show', $post->id_baiviet) }}" style="text-decoration: none; color: inherit; display: block;">
                                <div class="post-image" style="height: 180px; overflow: hidden; position: relative;">
                                    @if($post->anh_bia)
                                    <img src="{{ asset($post->anh_bia) }}" alt="{{ $post->tieude ?? 'Latest Post' }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform var(--duration-500) var(--ease-out);">
                                    @else
                                    <div style="width: 100%; height: 100%; background: var(--gradient-secondary); display: flex; align-items: center; justify-content: center; color: var(--text-inverse); font-size: var(--text-xl); font-weight: var(--font-bold);">{{ substr($post->tieude ?? 'Post', 0, 1) }}</div>
                                    @endif
                                    <div style="position: absolute; top: var(--space-3); left: var(--space-3); background: rgba(0,0,0,0.7); backdrop-filter: blur(10px); padding: var(--space-1) var(--space-2); border-radius: var(--radius-md); font-size: var(--text-xs); font-weight: var(--font-medium); color: var(--text-inverse);">
                                        <i class="fas fa-clock" style="margin-right: var(--space-1);"></i>Mới
                                    </div>
                                </div>
                                <div class="post-content" style="padding: var(--space-5);">
                                    <h3 style="font-size: var(--text-lg); font-weight: var(--font-bold); line-height: var(--leading-tight); margin-bottom: var(--space-3); color: var(--text-primary); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $post->tieude ?? 'Tiêu đề bài viết' }}</h3>
                                    <p class="post-excerpt" style="color: var(--text-secondary); line-height: var(--leading-relaxed); margin-bottom: var(--space-4); font-size: var(--text-sm); display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">{{ Str::limit($post->mota ?? $post->noidung ?? 'Nội dung bài viết...', 100) }}</p>
                                    <div class="post-meta" style="display: flex; align-items: center; justify-content: space-between;">
                                        <div style="display: flex; align-items: center; gap: var(--space-2);">
                                            <div style="width: 28px; height: 28px; border-radius: var(--radius-full); background: var(--gradient-tertiary); display: flex; align-items: center; justify-content: center; color: var(--text-inverse); font-weight: var(--font-bold); font-size: var(--text-xs);">{{ substr($post->user->hoten ?? $post->user->username ?? 'U', 0, 1) }}</div>
                                            <div>
                                                <div style="font-weight: var(--font-medium); color: var(--text-primary); font-size: var(--text-xs);">{{ Str::limit($post->user->hoten ?? $post->user->username ?? 'Tác giả', 15) }}</div>
                                                <div style="color: var(--text-tertiary); font-size: var(--text-xs);">{{ $post->thoigiandang ? $post->thoigiandang->format('d/m') : 'N/A' }}</div>
                                            </div>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: var(--space-2);">
                                            <span style="color: var(--text-tertiary); font-size: var(--text-xs); display: flex; align-items: center;"><i class="fas fa-heart" style="color: var(--error); margin-right: 4px;"></i>{{ $post->soluotlike ?? 0 }}</span>
                                            @if(isset($user) && $user)
                                            <button class="like-btn" data-post-id="{{ $post->id_baiviet }}" data-liked="{{ in_array($post->id_baiviet, $userLikedPosts ?? []) ? 'true' : 'false' }}" style="background: none; border: none; cursor: pointer; color: {{ in_array($post->id_baiviet, $userLikedPosts ?? []) ? 'var(--error)' : 'var(--text-tertiary)' }}; padding: var(--space-1); border-radius: var(--radius-md); transition: all var(--duration-200) var(--ease-out);" onclick="event.preventDefault(); event.stopPropagation();">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </article>
                        @endforeach
                        @else
                        <div class="no-posts" style="grid-column: 1/-1; text-align: center; padding: var(--space-12); background: var(--surface-secondary); border-radius: var(--radius-2xl); border: 2px dashed var(--border-secondary);">
                            <i class="fas fa-edit" style="font-size: var(--text-3xl); color: var(--text-tertiary); margin-bottom: var(--space-4);"></i>
                            <h3 style="font-size: var(--text-xl); font-weight: var(--font-semibold); color: var(--text-primary); margin-bottom: var(--space-2);">Chưa có bài viết nào</h3>
                            <p style="color: var(--text-secondary); margin-bottom: var(--space-6);">Hãy là người đầu tiên chia sẻ câu chuyện của bạn!</p>
                            @if(isset($user) && $user)
                            <a href="{{ route('post.create') }}" class="cta-primary" style="display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-3) var(--space-6); background: var(--gradient-primary); color: var(--text-inverse); text-decoration: none; border-radius: var(--radius-xl); font-weight: var(--font-semibold);">
                                <i class="fas fa-plus"></i>Đăng bài viết đầu tiên
                            </a>
                            @else
                            <a href="{{ route('login') }}" class="cta-primary" style="display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-3) var(--space-6); background: var(--gradient-primary); color: var(--text-inverse); text-decoration: none; border-radius: var(--radius-xl); font-weight: var(--font-semibold);">
                                <i class="fas fa-sign-in-alt"></i>Đăng nhập để đăng bài viết
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </section>

                <!-- Categories Section -->
                <section class="categories" style="margin-bottom: var(--space-16);">
                    <div style="text-align: center; margin-bottom: var(--space-10);">
                        <h2 style="font-size: var(--text-3xl); font-weight: var(--font-black); color: var(--text-primary); margin-bottom: var(--space-3);">Khám Phá Chủ Đề</h2>
                        <p style="font-size: var(--text-base); color: var(--text-secondary);">Tìm hiểu các lĩnh vực bạn quan tâm</p>
                    </div>

                    <div class="categories-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: var(--space-6);">
                        @if(isset($categories) && count($categories) > 0)
                        @foreach($categories->take(8) as $category)
                        <a href="{{ route('category.show', $category->slug) }}" class="category-card" style="background: var(--surface-primary); border: 1px solid var(--border-primary); border-radius: var(--radius-2xl); padding: var(--space-6); text-align: center; text-decoration: none; transition: all var(--duration-300) var(--ease-back); box-shadow: var(--shadow-sm); position: relative; overflow: hidden;">
                            <div style="width: 60px; height: 60px; background: {{ $category->color }}; border-radius: var(--radius-2xl); display: flex; align-items: center; justify-content: center; color: var(--text-inverse); font-size: var(--text-2xl); margin: 0 auto var(--space-4);">
                                <i class="{{ $category->icon }}"></i>
                            </div>
                            <h3 style="font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--text-primary); margin-bottom: var(--space-2);">{{ $category->name }}</h3>
                            <p style="font-size: var(--text-sm); color: var(--text-secondary); line-height: var(--leading-relaxed); margin-bottom: var(--space-3);">{{ $category->description }}</p>
                            <div style="display: flex; justify-content: center; align-items: center; gap: var(--space-1); color: var(--text-tertiary); font-size: var(--text-xs);">
                                <i class="fas fa-file-alt"></i>
                                <span>{{ $category->posts_count }} bài viết</span>
                            </div>
                        </a>
                        @endforeach
                        @else
                        <a href="#" class="category-card" style="background: var(--surface-primary); border: 1px solid var(--border-primary); border-radius: var(--radius-2xl); padding: var(--space-6); text-align: center; text-decoration: none; transition: all var(--duration-300) var(--ease-back); box-shadow: var(--shadow-sm); position: relative; overflow: hidden;">
                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: var(--radius-2xl); display: flex; align-items: center; justify-content: center; color: var(--text-inverse); font-size: var(--text-2xl); margin: 0 auto var(--space-4);">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <h3 style="font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--text-primary); margin-bottom: var(--space-2);">Công Nghệ</h3>
                            <p style="font-size: var(--text-sm); color: var(--text-secondary); line-height: var(--leading-relaxed);">Khám phá xu hướng công nghệ mới</p>
                        </a>
                        @endif
                        
                        @if(isset($categories) && count($categories) > 4)
                        <a href="{{ route('categories.index') }}" class="category-card" style="background: var(--gradient-primary); color: var(--text-inverse); border: 1px solid var(--border-primary); border-radius: var(--radius-2xl); padding: var(--space-6); text-align: center; text-decoration: none; transition: all var(--duration-300) var(--ease-back); box-shadow: var(--shadow-sm); position: relative; overflow: hidden;">
                            <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: var(--radius-2xl); display: flex; align-items: center; justify-content: center; color: var(--text-inverse); font-size: var(--text-2xl); margin: 0 auto var(--space-4);">
                                <i class="fas fa-plus"></i>
                            </div>
                            <h3 style="font-size: var(--text-lg); font-weight: var(--font-bold); margin-bottom: var(--space-2);">Xem tất cả</h3>
                            <p style="font-size: var(--text-sm); line-height: var(--leading-relaxed); opacity: 0.9;">Khám phá thêm nhiều chủ đề khác</p>
                        </a>
                        @endif
                    </div>
                </section>
            </div>

            <!-- Modern Sidebar -->
            <aside class="sidebar" style="position: sticky; top: 120px; height: fit-content;">
                <!-- Trending Topics Widget -->
                <div class="widget trending-topics" style="background: var(--surface-primary); border: 1px solid var(--border-primary); border-radius: var(--radius-2xl); padding: var(--space-6); margin-bottom: var(--space-6); box-shadow: var(--shadow-sm);">
                    <h3 style="font-size: var(--text-xl); font-weight: var(--font-bold); color: var(--text-primary); margin-bottom: var(--space-4); display: flex; align-items: center; gap: var(--space-2);">
                        <i class="fas fa-fire" style="color: var(--error);"></i>
                        Chủ Đề Hot
                    </h3>
                    <ul style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: var(--space-2);">
                        @if(isset($trendingTopics) && count($trendingTopics) > 0)
                        @foreach($trendingTopics as $topic)
                        <li>
                            <a href="#" style="display: flex; align-items: center; gap: var(--space-2); padding: var(--space-2) var(--space-3); background: var(--surface-secondary); border-radius: var(--radius-lg); text-decoration: none; color: var(--text-secondary); font-size: var(--text-sm); font-weight: var(--font-medium); transition: all var(--duration-200) var(--ease-out);">
                                <i class="fas fa-hashtag" style="color: var(--primary);"></i>
                                {{ $topic }}
                            </a>
                        </li>
                        @endforeach
                        @else
                        <li style="text-align: center; padding: var(--space-4); color: var(--text-tertiary); font-size: var(--text-sm);">
                            <i class="fas fa-search" style="font-size: var(--text-lg); margin-bottom: var(--space-2); display: block;"></i>
                            Chưa có chủ đề hot
                        </li>
                        @endif
                    </ul>
                </div>

                <!-- Top Writers Widget -->
                <div class="widget top-writers" style="background: var(--surface-primary); border: 1px solid var(--border-primary); border-radius: var(--radius-2xl); padding: var(--space-6); box-shadow: var(--shadow-sm);">
                    <h3 style="font-size: var(--text-xl); font-weight: var(--font-bold); color: var(--text-primary); margin-bottom: var(--space-4); display: flex; align-items: center; gap: var(--space-2);">
                        <i class="fas fa-crown" style="color: var(--warning);"></i>
                        Tác Giả Nổi Bật
                    </h3>
                    <ul style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: var(--space-3);">
                        @if(isset($topWriters) && count($topWriters) > 0)
                        @foreach($topWriters as $writer)
                        <li style="display: flex; align-items: center; gap: var(--space-3); padding: var(--space-3); background: var(--surface-secondary); border-radius: var(--radius-xl); transition: all var(--duration-200) var(--ease-out);">
                            <div style="width: 44px; height: 44px; border-radius: var(--radius-full); background: var(--gradient-primary); display: flex; align-items: center; justify-content: center; color: var(--text-inverse); font-weight: var(--font-bold); font-size: var(--text-base); box-shadow: var(--shadow-md);">
                                {{ substr($writer->hoten ?? $writer->username ?? 'A', 0, 1) }}
                            </div>
                            <div class="writer-info" style="flex: 1; min-width: 0;">
                                <div style="font-weight: var(--font-semibold); color: var(--text-primary); font-size: var(--text-sm); margin-bottom: var(--space-1); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Str::limit($writer->hoten ?? $writer->username ?? 'Tác giả', 20) }}</div>
                                <div style="color: var(--text-tertiary); font-size: var(--text-xs);">{{ $writer->posts_count ?? 0 }} bài viết</div>
                            </div>
                        </li>
                        @endforeach
                        @else
                        <li style="text-align: center; padding: var(--space-6); color: var(--text-tertiary); font-size: var(--text-sm);">
                            <i class="fas fa-users" style="font-size: var(--text-lg); margin-bottom: var(--space-2); display: block;"></i>
                            Chưa có tác giả nổi bật
                        </li>
                        @endif
                    </ul>
                </div>
            </aside>
        </div>
    </main>

    <!-- Scroll Progress Bar -->
    <div class="scroll-progress" id="scrollProgress"></div>

    <!-- Floating Chat Button -->
    @if(isset($user) && $user)
    <div class="floating-chat-btn" id="floatingChatBtn" style="position: fixed; bottom: var(--space-6); right: var(--space-6); z-index: var(--z-50);">
        <a href="/chat" style="width: 60px; height: 60px; background: var(--gradient-primary); border-radius: var(--radius-full); display: flex; align-items: center; justify-content: center; color: var(--text-inverse); text-decoration: none; box-shadow: var(--shadow-xl); transition: all var(--duration-300) var(--ease-back); animation: floatChat 3s ease-in-out infinite;">
            <i class="fas fa-comments" style="font-size: var(--text-xl);"></i>
        </a>
        <div style="position: absolute; top: -2px; right: -2px; width: 16px; height: 16px; background: var(--error); border-radius: var(--radius-full); border: 2px solid var(--surface-primary); display: none;" id="chatNotification"></div>
    </div>
    @endif

    <script>
        // Modern interactive features
        document.addEventListener('DOMContentLoaded', function() {
            // Scroll progress bar
            const scrollProgress = document.getElementById('scrollProgress');
            if (scrollProgress) {
                window.addEventListener('scroll', () => {
                    const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
                    scrollProgress.style.width = Math.min(scrolled, 100) + '%';
                });
            }

            // Header scroll effect
            const header = document.querySelector('.modern-header');
            if (header) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 50) {
                        header.style.background = 'rgba(255, 255, 255, 0.95)';
                        header.style.boxShadow = 'var(--shadow-lg)';
                    } else {
                        header.style.background = 'rgba(255, 255, 255, 0.8)';
                        header.style.boxShadow = 'none';
                    }
                });
            }

            // Post card hover effects
            document.querySelectorAll('.modern-post-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                    this.style.boxShadow = 'var(--shadow-2xl)';
                    const img = this.querySelector('.post-image img');
                    if (img) img.style.transform = 'scale(1.05)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'var(--shadow-lg)';
                    const img = this.querySelector('.post-image img');
                    if (img) img.style.transform = 'scale(1)';
                });
            });

            // Category card hover effects
            document.querySelectorAll('.category-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px) scale(1.02)';
                    this.style.boxShadow = 'var(--shadow-xl)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = 'var(--shadow-sm)';
                });
            });

            // Search functionality
            const searchToggle = document.getElementById('searchToggle');
            const searchModal = document.getElementById('searchModal');
            const searchInput = document.getElementById('searchInput');
            const closeSearch = document.getElementById('closeSearch');
            const searchResults = document.getElementById('searchResults');
            const searchTabs = document.querySelectorAll('.search-tab');

            if (searchToggle && searchModal) {
                searchToggle.addEventListener('click', function() {
                    searchModal.style.display = 'block';
                    searchInput.focus();
                });

                closeSearch.addEventListener('click', function() {
                    searchModal.style.display = 'none';
                    searchInput.value = '';
                    searchResults.innerHTML = '<div style="text-align: center; color: var(--text-tertiary); padding: var(--space-8);"><i class="fas fa-search" style="font-size: var(--text-2xl); margin-bottom: var(--space-2);"></i><p>Nhập từ khóa để tìm kiếm</p></div>';
                });

                searchModal.addEventListener('click', function(e) {
                    if (e.target === searchModal) {
                        searchModal.style.display = 'none';
                        searchInput.value = '';
                        searchResults.innerHTML = '<div style="text-align: center; color: var(--text-tertiary); padding: var(--space-8);"><i class="fas fa-search" style="font-size: var(--text-2xl); margin-bottom: var(--space-2);"></i><p>Nhập từ khóa để tìm kiếm</p></div>';
                    }
                });

                // Search tabs
                searchTabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        searchTabs.forEach(t => {
                            t.style.background = 'transparent';
                            t.style.color = 'var(--text-secondary)';
                            t.classList.remove('active');
                        });
                        this.style.background = 'var(--primary)';
                        this.style.color = 'white';
                        this.classList.add('active');

                        if (searchInput.value.trim()) {
                            performSearch(searchInput.value.trim(), this.dataset.type);
                        }
                    });
                });

                // Search input handler
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();
                    clearTimeout(searchTimeout);

                    if (query.length === 0) {
                        searchResults.innerHTML = '<div style="text-align: center; color: var(--text-tertiary); padding: var(--space-8);"><i class="fas fa-search" style="font-size: var(--text-2xl); margin-bottom: var(--space-2);"></i><p>Nhập từ khóa để tìm kiếm</p></div>';
                        return;
                    }

                    if (query.length < 2) return;

                    searchTimeout = setTimeout(() => {
                        const activeTab = document.querySelector('.search-tab.active');
                        performSearch(query, activeTab.dataset.type);
                    }, 300);
                });

                // Enter key to go to search page
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter' && this.value.trim()) {
                        const activeTab = document.querySelector('.search-tab.active');
                        window.location.href = `/search?q=${encodeURIComponent(this.value.trim())}&type=${activeTab.dataset.type}`;
                    }
                });
            }

            function performSearch(query, type) {
                searchResults.innerHTML = '<div style="text-align: center; padding: var(--space-8);"><i class="fas fa-spinner fa-spin" style="font-size: var(--text-2xl); color: var(--primary);"></i><p style="margin-top: var(--space-2); color: var(--text-secondary);">Đang tìm kiếm...</p></div>';

                fetch(`/search?q=${encodeURIComponent(query)}&type=${type}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (type === 'user') {
                            return response.json();
                        } else {
                            return response.text();
                        }
                    })
                    .then(data => {
                        if (type === 'post') {
                            // Handle HTML response for posts
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(data, 'text/html');
                            const posts = doc.querySelectorAll('.post-card, .modern-post-card');

                            if (posts.length > 0) {
                                let resultsHtml = '';
                                posts.forEach((post, index) => {
                                    if (index < 5) { // Show only first 5 results
                                        const title = post.querySelector('h3')?.textContent?.trim() || 'Không có tiêu đề';
                                        const link = post.querySelector('a')?.href || '#';
                                        const author = post.querySelector('.author, .post-meta')?.textContent?.trim() || 'Tác giả không xác định';

                                        resultsHtml += `
                    <div style="padding: var(--space-3); border-bottom: 1px solid var(--border-primary); cursor: pointer;" onclick="window.location.href='${link}'">
                      <h4 style="font-size: var(--text-base); font-weight: var(--font-semibold); color: var(--text-primary); margin-bottom: var(--space-1);">${title}</h4>
                      <p style="font-size: var(--text-sm); color: var(--text-secondary);">${author}</p>
                    </div>`;
                                    }
                                });

                                resultsHtml += `<div style="text-align: center; padding: var(--space-3);"><a href="/search?q=${encodeURIComponent(query)}&type=post" style="color: var(--primary); font-weight: var(--font-medium); text-decoration: none;">Xem tất cả kết quả</a></div>`;
                                searchResults.innerHTML = resultsHtml;
                            } else {
                                searchResults.innerHTML = '<div style="text-align: center; color: var(--text-tertiary); padding: var(--space-8);"><i class="fas fa-search" style="font-size: var(--text-2xl); margin-bottom: var(--space-2);"></i><p>Không tìm thấy bài viết nào</p></div>';
                            }
                        } else if (type === 'user') {
                            // Handle JSON response for users
                            console.log('User search response:', data);
                            const users = data.users || [];

                            if (users.length > 0) {
                                let resultsHtml = '';
                                users.forEach((user, index) => {
                                    if (index < 5) { // Show only first 5 results
                                        const name = user.hoten || user.username || 'Người dùng';
                                        const email = user.email || '';
                                        const profileUrl = `/user/${user.user_id}/profile`;

                                        resultsHtml += `
                    <div style="padding: var(--space-3); border-bottom: 1px solid var(--border-primary); cursor: pointer;" onclick="window.location.href='${profileUrl}'">
                      <div style="display: flex; align-items: center; gap: var(--space-3);">
                        <div style="width: 32px; height: 32px; border-radius: var(--radius-full); background: var(--gradient-primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: var(--font-bold); font-size: var(--text-sm);">
                          ${name.charAt(0).toUpperCase()}
                        </div>
                        <div>
                          <h4 style="font-size: var(--text-base); font-weight: var(--font-semibold); color: var(--text-primary); margin: 0;">${name}</h4>
                          ${email ? `<p style="font-size: var(--text-sm); color: var(--text-secondary); margin: 0;">${email}</p>` : ''}
                        </div>
                      </div>
                    </div>`;
                                    }
                                });

                                resultsHtml += `<div style="text-align: center; padding: var(--space-3);"><a href="/search?q=${encodeURIComponent(query)}&type=user" style="color: var(--primary); font-weight: var(--font-medium); text-decoration: none;">Xem tất cả kết quả</a></div>`;
                                searchResults.innerHTML = resultsHtml;
                            } else {
                                searchResults.innerHTML = '<div style="text-align: center; color: var(--text-tertiary); padding: var(--space-8);"><i class="fas fa-search" style="font-size: var(--text-2xl); margin-bottom: var(--space-2);"></i><p>Không tìm thấy người dùng nào</p></div>';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                        searchResults.innerHTML = '<div style="text-align: center; color: var(--error); padding: var(--space-8);"><i class="fas fa-exclamation-triangle" style="font-size: var(--text-2xl); margin-bottom: var(--space-2);"></i><p>Có lỗi xảy ra khi tìm kiếm</p></div>';
                    });
            }

            // Notification functionality
            const notificationBell = document.getElementById('notificationBell');
            const notificationDropdown = document.getElementById('notificationDropdown');
            const notificationList = document.getElementById('notificationList');
            const markAllRead = document.getElementById('markAllRead');

            if (notificationBell && notificationDropdown) {
                notificationBell.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isVisible = notificationDropdown.style.display === 'block';
                    notificationDropdown.style.display = isVisible ? 'none' : 'block';

                    if (!isVisible) {
                        loadNotifications();
                    }
                });

                document.addEventListener('click', function() {
                    notificationDropdown.style.display = 'none';
                });

                notificationDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });

                if (markAllRead) {
                    markAllRead.addEventListener('click', function() {
                        fetch('/notifications/mark-read', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    document.querySelector('.notification-badge')?.remove();
                                    loadNotifications();
                                }
                            })
                            .catch(error => console.error('Error marking notifications as read:', error));
                    });
                }
            }

            function loadNotifications() {
                @if(isset($user) && $user)
                const notifications = @json($user->myNotifications()->orderBy('created_at', 'desc')->limit(10)->get());

                if (notifications.length > 0) {
                    let notificationsHtml = '';
                    notifications.forEach(notification => {
                        const isRead = notification.is_read;
                        notificationsHtml += `
                <div style="padding: var(--space-3); border-bottom: 1px solid var(--border-primary); ${!isRead ? 'background: var(--primary-50);' : ''}" data-id="${notification.id}">
                  <div style="display: flex; align-items: flex-start; gap: var(--space-3);">
                    <div style="width: 8px; height: 8px; border-radius: var(--radius-full); background: ${!isRead ? 'var(--primary)' : 'transparent'}; margin-top: var(--space-2); flex-shrink: 0;"></div>
                    <div style="flex: 1;">
                      <p style="font-size: var(--text-sm); color: var(--text-primary); margin-bottom: var(--space-1); font-weight: ${!isRead ? 'var(--font-semibold)' : 'var(--font-normal)'};">${notification.data || notification.content || 'Bạn có thông báo mới'}</p>
                      <p style="font-size: var(--text-xs); color: var(--text-tertiary);">${new Date(notification.created_at).toLocaleString('vi-VN')}</p>
                    </div>
                  </div>
                </div>`;
                    });
                    notificationList.innerHTML = notificationsHtml;
                } else {
                    notificationList.innerHTML = '<div style="text-align: center; color: var(--text-tertiary); padding: var(--space-8);"><i class="fas fa-bell" style="font-size: var(--text-2xl); margin-bottom: var(--space-2);"></i><p>Chưa có thông báo nào</p></div>';
                }
                @else
                notificationList.innerHTML = '<div style="text-align: center; color: var(--text-tertiary); padding: var(--space-8);"><i class="fas fa-sign-in-alt" style="font-size: var(--text-2xl); margin-bottom: var(--space-2);"></i><p>Đăng nhập để xem thông báo</p></div>';
                @endif
            }

            // User dropdown toggle
            const userMenuToggle = document.getElementById('userMenuToggle');
            const userDropdown = document.getElementById('userDropdown');
            if (userMenuToggle && userDropdown) {
                userMenuToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.style.display = userDropdown.style.display === 'none' ? 'block' : 'none';
                });

                document.addEventListener('click', function() {
                    userDropdown.style.display = 'none';
                });
            }

            // Like button functionality
            document.querySelectorAll('.like-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const postId = this.dataset.postId;
                    const isLiked = this.dataset.liked === 'true';

                    // Immediate visual feedback
                    this.style.transform = 'scale(1.2)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);

                    fetch(`/post/${postId}/like`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                this.dataset.liked = data.isLiked.toString();
                                this.style.color = data.isLiked ? 'var(--error)' : 'var(--text-tertiary)';

                                // Update like count
                                const likeCount = this.parentElement.querySelector('span');
                                if (likeCount) {
                                    likeCount.innerHTML = `<i class="fas fa-heart" style="color: var(--error); margin-right: 4px;"></i>${data.likeCount}`;
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Floating chat button effects
            const floatingChatBtn = document.getElementById('floatingChatBtn');
            if (floatingChatBtn) {
                // Pulse animation when new messages (demo)
                setTimeout(() => {
                    const notification = document.getElementById('chatNotification');
                    if (notification && Math.random() > 0.7) { // Random demo notification
                        notification.style.display = 'block';
                        notification.style.animation = 'pulse 2s infinite';
                    }
                }, 5000);

                // Hide on scroll down, show on scroll up
                let lastScrollTop = 0;
                window.addEventListener('scroll', () => {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    if (scrollTop > lastScrollTop && scrollTop > 200) {
                        // Scrolling down
                        floatingChatBtn.style.transform = 'translateY(100px)';
                        floatingChatBtn.style.opacity = '0';
                    } else {
                        // Scrolling up
                        floatingChatBtn.style.transform = 'translateY(0)';
                        floatingChatBtn.style.opacity = '1';
                    }
                    lastScrollTop = scrollTop;
                });
            }
        });
    </script>

    <!-- Modern Footer -->
    <footer style="background: var(--surface-primary); border-top: 1px solid var(--border-primary); margin-top: var(--space-20);">
        <div style="max-width: var(--container-2xl); margin: 0 auto; padding: var(--space-12) var(--space-6) var(--space-6);">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--space-8); margin-bottom: var(--space-8);">
                <div>
                    <div style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-4);">
                        <div style="width: 40px; height: 40px; background: var(--gradient-primary); border-radius: var(--radius-xl); display: flex; align-items: center; justify-content: center; color: var(--text-inverse); font-size: var(--text-lg); font-weight: var(--font-bold);">
                            <i class="fas fa-comments"></i>
                        </div>
                        <span style="font-size: var(--text-xl); font-weight: var(--font-extrabold); background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">ChatPost</span>
                    </div>
                    <p style="color: var(--text-secondary); line-height: var(--leading-relaxed); margin-bottom: var(--space-4);">Nền tảng chia sẻ kiến thức và kết nối cộng đồng hiện đại. Nơi mọi ý tưởng đều có giá trị.</p>
                    <div style="display: flex; gap: var(--space-3);">
                        <a href="#" style="width: 40px; height: 40px; background: var(--surface-secondary); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); text-decoration: none; transition: all var(--duration-200) var(--ease-out);">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" style="width: 40px; height: 40px; background: var(--surface-secondary); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); text-decoration: none; transition: all var(--duration-200) var(--ease-out);">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" style="width: 40px; height: 40px; background: var(--surface-secondary); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); text-decoration: none; transition: all var(--duration-200) var(--ease-out);">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 style="font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--text-primary); margin-bottom: var(--space-4);">Liên Kết Nhanh</h4>
                    <ul style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: var(--space-2);">
                        <li><a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: var(--text-sm); transition: color var(--duration-200) var(--ease-out);">Điều Khoản Sử Dụng</a></li>
                        <li><a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: var(--text-sm); transition: color var(--duration-200) var(--ease-out);">Chính Sách Bảo Mật</a></li>
                        <li><a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: var(--text-sm); transition: color var(--duration-200) var(--ease-out);">Liên Hệ Hỗ Trợ</a></li>
                        <li><a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: var(--text-sm); transition: color var(--duration-200) var(--ease-out);">Hướng Dẫn Sử Dụng</a></li>
                    </ul>
                </div>

                <div>
                    <h4 style="font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--text-primary); margin-bottom: var(--space-4);">Cộng Đồng</h4>
                    <ul style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: var(--space-2);">
                        <li><a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: var(--text-sm); transition: color var(--duration-200) var(--ease-out);">Thảo Luận</a></li>
                        <li><a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: var(--text-sm); transition: color var(--duration-200) var(--ease-out);">Sự Kiện</a></li>
                        <li><a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: var(--text-sm); transition: color var(--duration-200) var(--ease-out);">Blog</a></li>
                        <li><a href="#" style="color: var(--text-secondary); text-decoration: none; font-size: var(--text-sm); transition: color var(--duration-200) var(--ease-out);">Newsletter</a></li>
                    </ul>
                </div>

                <div>
                    <h4 style="font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--text-primary); margin-bottom: var(--space-4);">Theo Dõi Cập Nhật</h4>
                    <p style="color: var(--text-secondary); font-size: var(--text-sm); margin-bottom: var(--space-3);">Nhận thông báo về bài viết mới và sự kiện hấp dẫn</p>
                    <div style="display: flex; gap: var(--space-2);">
                        <input type="email" placeholder="Email của bạn" style="flex: 1; padding: var(--space-2) var(--space-3); border: 1px solid var(--border-primary); border-radius: var(--radius-lg); background: var(--surface-secondary); color: var(--text-primary); font-size: var(--text-sm);">
                        <button style="padding: var(--space-2) var(--space-4); background: var(--gradient-primary); color: var(--text-inverse); border: none; border-radius: var(--radius-lg); font-weight: var(--font-semibold); cursor: pointer; font-size: var(--text-sm);">Gửi</button>
                    </div>
                </div>
            </div>

            <div style="border-top: 1px solid var(--border-primary); padding-top: var(--space-6); text-align: center;">
                <p style="color: var(--text-tertiary); font-size: var(--text-sm);">&copy; 2025 ChatPost. Tất cả quyền được bảo lưu. Made with <i class="fas fa-heart" style="color: var(--error);"></i> in Vietnam</p>
            </div>
        </div>
    </footer>

</body>
<script>
    // Dropdown hiệu ứng cho nút tài khoản
    const accountDropdown = document.querySelector('.account-dropdown');
    const dropdownToggle = document.querySelector('.account-dropdown .dropdown-toggle');
    dropdownToggle.addEventListener('click', function(e) {
        e.preventDefault();
        accountDropdown.classList.toggle('active');
    });
    document.addEventListener('click', function(e) {
        if (!accountDropdown.contains(e.target)) {
            accountDropdown.classList.remove('active');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        @if(isset($user) && $user->theme)
        // Ưu tiên theme cá nhân, không dùng localStorage nữa
        if ('{{ $user->theme }}' === 'dark') document.body.classList.add('dark-theme');
        else document.body.classList.remove('dark-theme');
        window.toggleTheme = function() {
            // Không cho phép đổi theme bằng JS khi đã có theme cá nhân
            alert('Bạn hãy đổi theme trong hồ sơ cá nhân!');
        }
        @else
        // Nếu chưa đăng nhập, cho phép dùng localStorage để đổi theme
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-theme');
        } else {
            document.body.classList.remove('dark-theme');
        }
        window.toggleTheme = function() {
            if (document.body.classList.contains('dark-theme')) {
                document.body.classList.remove('dark-theme');
                localStorage.setItem('theme', 'light');
            } else {
                document.body.classList.add('dark-theme');
                localStorage.setItem('theme', 'dark');
            }
        }
        @endif
    });
</script>

</html>