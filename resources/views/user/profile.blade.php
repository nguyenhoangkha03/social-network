<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $user->hoten ?? $user->username ?? 'User' }} - Hồ sơ cá nhân</title>

    <!-- Fonts & Icons -->
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
            max-width: 1200px;
            margin: 0 auto;
            padding: var(--space-6);
        }

        /* Profile Header */
        .profile-header {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            margin-bottom: var(--space-8);
        }

        .cover-image {
            height: 200px;
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            position: relative;
            overflow: hidden;
        }

        .cover-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        }

        .profile-info {
            padding: var(--space-8);
            position: relative;
            margin-top: -60px;
        }

        .avatar-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto var(--space-6);
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid var(--surface);
            object-fit: cover;
            background: var(--surface-secondary);
            box-shadow: var(--shadow-lg);
        }

        .online-status {
            position: absolute;
            bottom: 8px;
            right: 8px;
            width: 20px;
            height: 20px;
            background: var(--success);
            border: 3px solid var(--surface);
            border-radius: 50%;
            box-shadow: var(--shadow-md);
        }

        .user-info {
            text-align: center;
            margin-bottom: var(--space-6);
        }

        .user-name {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: var(--space-1);
        }

        .user-username {
            color: var(--text-secondary);
            font-size: 1.125rem;
            margin-bottom: var(--space-2);
        }

        .user-bio {
            color: var(--text-secondary);
            max-width: 500px;
            margin: 0 auto var(--space-4);
            line-height: 1.6;
        }

        .user-location {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-1);
            color: var(--text-tertiary);
            font-size: 0.875rem;
            margin-bottom: var(--space-6);
        }

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: var(--space-4);
            margin-bottom: var(--space-6);
        }

        .stat-item {
            text-align: center;
            padding: var(--space-4);
            background: var(--surface-secondary);
            border-radius: var(--radius-xl);
            transition: all 0.2s ease;
        }

        .stat-item:hover {
            background: var(--surface-tertiary);
            transform: translateY(-2px);
            cursor: pointer;
            box-shadow: var(--shadow-md);
        }

        .stat-item:hover .stat-number {
            color: var(--primary-dark);
        }

        .stat-item:hover .stat-label {
            color: var(--text-primary);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            display: block;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-top: var(--space-1);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: var(--space-3);
            justify-content: center;
        }

        .btn {
            padding: var(--space-3) var(--space-6);
            border-radius: var(--radius-lg);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.95rem;
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

        .btn-secondary {
            background: var(--surface-secondary);
            color: var(--text-secondary);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--surface-tertiary);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        /* Main Content */
        .main-content {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: var(--space-8);
        }

        .content-section {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-8);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: between;
            margin-bottom: var(--space-6);
            padding-bottom: var(--space-4);
            border-bottom: 1px solid var(--border-light);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .section-title i {
            color: var(--primary);
        }

        /* Tab Navigation */
        .tab-nav {
            display: flex;
            gap: var(--space-1);
            margin-bottom: var(--space-6);
            background: var(--surface-secondary);
            padding: var(--space-1);
            border-radius: var(--radius-xl);
        }

        .tab-btn {
            flex: 1;
            padding: var(--space-3) var(--space-4);
            border: none;
            background: transparent;
            border-radius: var(--radius-lg);
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .tab-btn.active {
            background: var(--surface);
            color: var(--primary);
            box-shadow: var(--shadow-sm);
        }

        /* Posts Grid */
        .posts-grid {
            display: grid;
            gap: var(--space-6);
        }

        .post-card {
            background: var(--surface-secondary);
            border-radius: var(--radius-xl);
            padding: var(--space-6);
            transition: all 0.2s ease;
            border: 1px solid var(--border-light);
        }

        .post-card:hover {
            background: var(--surface);
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        .post-header {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            margin-bottom: var(--space-4);
        }

        .post-date {
            color: var(--text-tertiary);
            font-size: 0.875rem;
        }

        .post-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: var(--space-2);
            line-height: 1.4;
        }

        .post-excerpt {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: var(--space-4);
        }

        .post-stats {
            display: flex;
            align-items: center;
            gap: var(--space-4);
            color: var(--text-tertiary);
            font-size: 0.875rem;
        }

        .post-stat {
            display: flex;
            align-items: center;
            gap: var(--space-1);
        }

        /* Sidebar */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: var(--space-6);
        }

        .sidebar-card {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-6);
        }

        .sidebar-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: var(--space-4);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .sidebar-title i {
            color: var(--primary);
        }

        /* Activity Timeline */
        .activity-item {
            display: flex;
            gap: var(--space-3);
            padding: var(--space-3) 0;
            border-bottom: 1px solid var(--border-light);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-icon i {
            color: var(--primary);
            font-size: 0.875rem;
        }

        .activity-content {
            flex: 1;
        }

        .activity-text {
            font-size: 0.875rem;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        .activity-time {
            font-size: 0.75rem;
            color: var(--text-tertiary);
            margin-top: var(--space-1);
        }

        /* Following/Followers List */
        .user-list {
            display: flex;
            flex-direction: column;
            gap: var(--space-3);
        }

        .user-item {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3);
            border-radius: var(--radius-lg);
            transition: all 0.2s ease;
        }

        .user-item:hover {
            background: var(--surface-secondary);
        }

        .user-item-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--surface-secondary);
        }

        .user-item-info {
            flex: 1;
        }

        .user-item-name {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .user-item-username {
            color: var(--text-tertiary);
            font-size: 0.75rem;
        }

        /* Achievement Badges */
        .badges-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--space-3);
        }

        .badge {
            text-align: center;
            padding: var(--space-3);
            border-radius: var(--radius-lg);
            background: var(--surface-secondary);
            transition: all 0.2s ease;
        }

        .badge:hover {
            background: var(--surface-tertiary);
            transform: translateY(-1px);
        }

        .badge-icon {
            font-size: 1.5rem;
            margin-bottom: var(--space-2);
            display: block;
        }

        .badge-name {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .badge.gold .badge-icon {
            color: #fbbf24;
        }

        .badge.silver .badge-icon {
            color: #94a3b8;
        }

        .badge.bronze .badge-icon {
            color: #f97316;
        }

        /* Back Button Style */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
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

        /* Empty States */
        .empty-state {
            text-align: center;
            padding: var(--space-12) var(--space-6);
            color: var(--text-tertiary);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: var(--space-4);
            display: block;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.125rem;
            margin-bottom: var(--space-2);
            color: var(--text-secondary);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: var(--space-6);
            }

            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: var(--space-4);
            }

            .profile-info {
                padding: var(--space-6);
            }

            .action-buttons {
                flex-direction: column;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }

            .content-section {
                padding: var(--space-6);
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid var(--border);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--surface-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-tertiary);
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Profile Header -->
        <div class="profile-header">
            <!-- Cover Image -->
            <div class="cover-image"></div>

            <!-- Profile Info -->
            <div class="profile-info">
                <!-- Back to Home Button -->
                <div style="text-align: left; margin-bottom: var(--space-4);">
                    <a href="{{ route('home') }}" class="back-btn">
                        <i class="fas fa-home"></i>
                        Quay lại trang chủ
                    </a>
                </div>
                
                <!-- Avatar -->
                <div class="avatar-container">
                    @if($user->hinhanh)
                    <img src="data:image/jpeg;base64,{{ base64_encode($user->hinhanh) }}" alt="Avatar" class="avatar">
                    @else
                    <div class="avatar" style="display: flex; align-items: center; justify-content: center; background: var(--primary); color: white; font-size: 2.5rem; font-weight: 700;">
                        {{ strtoupper(substr($user->hoten ?? $user->username ?? 'U', 0, 1)) }}
                    </div>
                    @endif
                    <div class="online-status" title="Đang hoạt động"></div>
                </div>

                <!-- User Info -->
                <div class="user-info">
                    <h1 class="user-name">{{ $user->hoten ?? $user->username ?? 'Người dùng' }}</h1>
                    <p class="user-username">{{ $user->username ?? 'username' }}</p>

                    @if($user->diachi)
                    <div class="user-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $user->diachi }}</span>
                    </div>
                    @endif
                </div>

                <!-- Stats Row -->
                <div class="stats-row">
                    <a href="{{ route('user.posts', $user->user_id) }}" class="stat-item" style="text-decoration: none; color: inherit;">
                        <span class="stat-number">{{ count($posts) }}</span>
                        <span class="stat-label">Bài viết</span>
                    </a>
                    <a href="{{ route('user.followers', $user->user_id) }}" class="stat-item" style="text-decoration: none; color: inherit;">
                        <span class="stat-number">{{ $followersCount }}</span>
                        <span class="stat-label">Người theo dõi</span>
                    </a>
                    <a href="{{ route('user.following', $user->user_id) }}" class="stat-item" style="text-decoration: none; color: inherit;">
                        <span class="stat-number">{{ $followingCount }}</span>
                        <span class="stat-label">Đang theo dõi</span>
                    </a>
                    <a href="{{ route('user.likes', $user->user_id) }}" class="stat-item" style="text-decoration: none; color: inherit;">
                        <span class="stat-number">{{ $posts->sum('soluotlike') }}</span>
                        <span class="stat-label">Lượt thích</span>
                    </a>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    @if($currentUser && $currentUser->user_id == $user->user_id)
                    <a href="{{ route('profile.edit', $user->user_id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i>
                        Chỉnh sửa hồ sơ
                    </a>
                    <a href="{{ route('post.create') }}" class="btn btn-secondary">
                        <i class="fas fa-plus"></i>
                        Tạo bài viết
                    </a>
                    @elseif($currentUser)
                    <button id="followBtn" class="btn {{ $isFollowing ? 'btn-success' : 'btn-primary' }}" onclick="toggleFollow({{ $user->user_id }})">
                        <i class="fas fa-{{ $isFollowing ? 'check' : 'user-plus' }}"></i>
                        <span id="followText">{{ $isFollowing ? 'Đang theo dõi' : 'Theo dõi' }}</span>
                    </button>
                    <a href="{{ route('friends.chat', $user->user_id) }}" class="btn btn-secondary">
                        <i class="fas fa-message"></i>
                        Nhắn tin
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Posts Section -->
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-newspaper"></i>
                        Bài viết của {{ $user->hoten ?? $user->username }}
                    </h2>
                </div>

                <!-- Tab Navigation -->
                <div class="tab-nav">
                    <button class="tab-btn active" onclick="showTab('posts')">
                        <i class="fas fa-newspaper"></i>
                        Bài viết ({{ count($posts) }})
                    </button>
                    <button class="tab-btn" onclick="showTab('liked')">
                        <i class="fas fa-heart"></i>
                        Đã thích
                    </button>
                    <button class="tab-btn" onclick="showTab('saved')">
                        <i class="fas fa-bookmark"></i>
                        Đã lưu
                    </button>
                </div>

                <!-- Posts Content -->
                <div id="posts-content" class="tab-content active">
                    @if(count($posts) > 0)
                    <div class="posts-grid">
                        @foreach($posts as $post)
                        <article class="post-card">
                            <div class="post-header">
                                <span class="post-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $post->thoigiandang ? $post->thoigiandang->format('d/m/Y') : 'N/A' }}
                                </span>
                            </div>

                            <h3 class="post-title">
                                <a href="{{ route('post.show', $post->id_baiviet) }}" style="text-decoration: none; color: inherit;">
                                    {{ $post->tieude }}
                                </a>
                            </h3>

                            @if($post->mota)
                            <p class="post-excerpt">{{ Str::limit($post->mota, 150) }}</p>
                            @endif

                            <div class="post-stats">
                                <span class="post-stat">
                                    <i class="fas fa-heart"></i>
                                    {{ $post->soluotlike ?? 0 }}
                                </span>
                                <span class="post-stat">
                                    <i class="fas fa-comment"></i>
                                    {{ $post->comments_count ?? 0 }}
                                </span>
                                <span class="post-stat">
                                    <i class="fas fa-eye"></i>
                                    {{ rand(10, 1000) }} lượt xem
                                </span>
                            </div>
                        </article>
                        @endforeach
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="fas fa-newspaper"></i>
                        <h3>Chưa có bài viết nào</h3>
                        <p>{{ $user->hoten ?? $user->username }} chưa đăng bài viết nào.</p>
                    </div>
                    @endif
                </div>

                <!-- Liked Posts Content -->
                <div id="liked-content" class="tab-content" style="display: none;">
                    <div class="empty-state">
                        <i class="fas fa-heart"></i>
                        <h3>Đang phát triển</h3>
                        <p>Tính năng này sẽ sớm được cập nhật.</p>
                    </div>
                </div>

                <!-- Saved Posts Content -->
                <div id="saved-content" class="tab-content" style="display: none;">
                    <div class="empty-state">
                        <i class="fas fa-bookmark"></i>
                        <h3>Đang phát triển</h3>
                        <p>Tính năng này sẽ sớm được cập nhật.</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Activity Timeline -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-clock"></i>
                        Hoạt động gần đây
                    </h3>
                    <div class="activity-timeline">
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-pen"></i>
                            </div>
                            <div class="activity-content">
                                <p class="activity-text">Đã đăng bài viết mới</p>
                                <span class="activity-time">2 giờ trước</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="activity-content">
                                <p class="activity-text">Đã thích 5 bài viết</p>
                                <span class="activity-time">1 ngày trước</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="activity-content">
                                <p class="activity-text">Theo dõi 3 người dùng mới</p>
                                <span class="activity-time">3 ngày trước</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Achievement Badges -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-trophy"></i>
                        Thành tích
                    </h3>
                    <div class="badges-grid">
                        <div class="badge gold">
                            <i class="fas fa-crown badge-icon"></i>
                            <span class="badge-name">Tác giả nổi bật</span>
                        </div>
                        <div class="badge silver">
                            <i class="fas fa-users badge-icon"></i>
                            <span class="badge-name">Người có ảnh hưởng</span>
                        </div>
                        <div class="badge bronze">
                            <i class="fas fa-fire badge-icon"></i>
                            <span class="badge-name">Hoạt động tích cực</span>
                        </div>
                    </div>
                </div>

                <!-- Following List -->
                @if(count($following) > 0)
                <div class="sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="fas fa-users"></i>
                        Đang theo dõi ({{ count($following) }})
                    </h3>
                    <div class="user-list">
                        @foreach($following->take(5) as $followedUser)
                        <div class="user-item">
                            @if($followedUser->hinhanh)
                            <img src="data:image/jpeg;base64,{{ base64_encode($followedUser->hinhanh) }}" alt="Avatar" class="user-item-avatar">
                            @else
                            <div class="user-item-avatar" style="display: flex; align-items: center; justify-content: center; background: var(--primary); color: white; font-weight: 600;">
                                {{ strtoupper(substr($followedUser->hoten ?? 'U', 0, 1)) }}
                            </div>
                            @endif
                            <div class="user-item-info">
                                <p class="user-item-name">{{ $followedUser->hoten ?? $followedUser->username }}</p>
                                <p class="user-item-username">@{{ $followedUser->username }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Follow/Unfollow functionality
        function toggleFollow(userId) {
            const btn = document.getElementById('followBtn');
            const text = document.getElementById('followText');
            const originalText = text.textContent;

            // Show loading
            text.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            fetch(`/user/${userId}/follow`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.isFollowing) {
                            btn.className = 'btn btn-success';
                            btn.innerHTML = '<i class="fas fa-check"></i><span id="followText">Đang theo dõi</span>';
                        } else {
                            btn.className = 'btn btn-primary';
                            btn.innerHTML = '<i class="fas fa-user-plus"></i><span id="followText">Theo dõi</span>';
                        }

                        // Update follower count
                        location.reload(); // Simple reload for now
                    } else {
                        alert(data.error || 'Có lỗi xảy ra');
                        text.textContent = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi thực hiện thao tác');
                    text.textContent = originalText;
                })
                .finally(() => {
                    btn.disabled = false;
                });
        }

        // Tab switching functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });

            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab content
            document.getElementById(tabName + '-content').style.display = 'block';

            // Add active class to clicked button
            event.target.classList.add('active');
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Add any initialization code here
            console.log('Profile page loaded');
        });
    </script>
</body>

</html>