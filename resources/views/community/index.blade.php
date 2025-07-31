<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cộng đồng - ChatPost</title>
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

        .header {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-8);
            margin-bottom: var(--space-8);
            text-align: center;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: var(--space-6);
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

        .page-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: var(--space-4);
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-6);
            margin-bottom: var(--space-12);
        }

        .stat-card {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-6);
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid var(--border-light);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto var(--space-4);
            font-size: 1.5rem;
        }

        .stat-icon.users {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }

        .stat-icon.posts {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .stat-icon.likes {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .stat-icon.active {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: var(--space-2);
        }

        .stat-label {
            color: var(--text-secondary);
            font-weight: 600;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: var(--space-8);
        }

        .main-content {
            display: flex;
            flex-direction: column;
            gap: var(--space-8);
        }

        .section {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-8);
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

        .top-writers-grid {
            display: grid;
            gap: var(--space-4);
        }

        .writer-item {
            display: flex;
            align-items: center;
            gap: var(--space-4);
            padding: var(--space-4);
            background: var(--surface-secondary);
            border-radius: var(--radius-xl);
            transition: all 0.2s ease;
            border: 1px solid var(--border-light);
        }

        .writer-item:hover {
            background: var(--surface);
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        .writer-rank {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
        }

        .writer-rank.gold {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
        }

        .writer-rank.silver {
            background: linear-gradient(135deg, #94a3b8, #64748b);
        }

        .writer-rank.bronze {
            background: linear-gradient(135deg, #f97316, #ea580c);
        }

        .writer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .writer-info {
            flex: 1;
        }

        .writer-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: var(--space-1);
        }

        .writer-stats {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .recent-posts {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }

        .post-item {
            padding: var(--space-4);
            background: var(--surface-secondary);
            border-radius: var(--radius-lg);
            transition: all 0.2s ease;
            border: 1px solid var(--border-light);
        }

        .post-item:hover {
            background: var(--surface);
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        .post-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: var(--space-2);
            line-height: 1.4;
        }

        .post-title a {
            text-decoration: none;
            color: inherit;
        }

        .post-title a:hover {
            color: var(--primary);
        }

        .post-meta {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: var(--space-6);
        }

        .new-members {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: var(--space-3);
        }

        .member-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-4);
            background: var(--surface-secondary);
            border-radius: var(--radius-lg);
            transition: all 0.2s ease;
            border: 1px solid var(--border-light);
            text-decoration: none;
            color: inherit;
        }

        .member-item:hover {
            background: var(--surface);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .member-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .member-name {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.875rem;
            text-align: center;
        }

        .join-cta {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-8);
            text-align: center;
            margin-top: var(--space-8);
        }

        .cta-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: var(--space-4);
        }

        .cta-text {
            color: var(--text-secondary);
            margin-bottom: var(--space-6);
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

        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: var(--space-6);
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .new-members {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: var(--space-4);
            }

            .page-title {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .new-members {
                grid-template-columns: repeat(2, 1fr);
            }

            .section {
                padding: var(--space-6);
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
            
            <h1 class="page-title">Cộng Đồng ChatPost</h1>
            <p class="page-subtitle">
                Kết nối với hàng nghìn người dùng đam mê chia sẻ kiến thức và trải nghiệm
            </p>
        </div>

        <!-- Community Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ number_format($totalUsers) }}</div>
                <div class="stat-label">Thành viên</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon posts">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="stat-number">{{ number_format($totalPosts) }}</div>
                <div class="stat-label">Bài viết</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon likes">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="stat-number">{{ number_format($totalLikes) }}</div>
                <div class="stat-label">Lượt thích</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon active">
                    <i class="fas fa-bolt"></i>
                </div>
                <div class="stat-number">{{ number_format($activeUsersToday) }}</div>
                <div class="stat-label">Hoạt động hôm nay</div>
            </div>
        </div>

        <div class="content-grid">
            <div class="main-content">
                <!-- Top Writers -->
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-crown"></i>
                        Tác giả nổi bật
                    </h2>

                    @if($topWriters->count() > 0)
                        <div class="top-writers-grid">
                            @foreach($topWriters as $index => $writer)
                                <div class="writer-item">
                                    <div class="writer-rank {{ $index === 0 ? 'gold' : ($index === 1 ? 'silver' : ($index === 2 ? 'bronze' : '')) }}">
                                        {{ $index + 1 }}
                                    </div>
                                    
                                    @if($writer->hinhanh)
                                        <img src="data:image/jpeg;base64,{{ base64_encode($writer->hinhanh) }}" alt="Avatar" class="writer-avatar">
                                    @else
                                        <div class="writer-avatar">
                                            {{ strtoupper(substr($writer->hoten ?? $writer->username ?? 'U', 0, 1)) }}
                                        </div>
                                    @endif
                                    
                                    <div class="writer-info">
                                        <div class="writer-name">{{ $writer->hoten ?? $writer->username }}</div>
                                        <div class="writer-stats">{{ $writer->baiviets_count }} bài viết</div>
                                    </div>
                                    
                                    <a href="{{ route('user.profile', $writer->user_id) }}" class="btn btn-primary" style="font-size: 0.75rem; padding: var(--space-2) var(--space-3);">
                                        Xem hồ sơ
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: var(--space-8); color: var(--text-tertiary);">
                            <i class="fas fa-users" style="font-size: 3rem; margin-bottom: var(--space-4);"></i>
                            <p>Chưa có tác giả nào đăng bài viết</p>
                        </div>
                    @endif
                </div>

                <!-- Recent Posts -->
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-clock"></i>
                        Bài viết mới nhất
                    </h2>

                    @if($recentPosts->count() > 0)
                        <div class="recent-posts">
                            @foreach($recentPosts as $post)
                                <div class="post-item">
                                    <div class="post-title">
                                        <a href="{{ route('post.show', $post->id_baiviet) }}">
                                            {{ $post->tieude }}
                                        </a>
                                    </div>
                                    <div class="post-meta">
                                        <span>
                                            <i class="fas fa-user"></i>
                                            {{ $post->user->hoten ?? $post->user->username }}
                                        </span>
                                        <span>
                                            <i class="fas fa-calendar"></i>
                                            {{ $post->thoigiandang ? $post->thoigiandang->format('d/m/Y') : 'N/A' }}
                                        </span>
                                        <span>
                                            <i class="fas fa-heart"></i>
                                            {{ $post->soluotlike ?? 0 }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: var(--space-8); color: var(--text-tertiary);">
                            <i class="fas fa-newspaper" style="font-size: 3rem; margin-bottom: var(--space-4);"></i>
                            <p>Chưa có bài viết nào</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="sidebar">
                <!-- New Members -->
                <div class="section">
                    <h2 class="section-title">
                        <i class="fas fa-user-plus"></i>
                        Thành viên mới
                    </h2>

                    @if($newMembers->count() > 0)
                        <div class="new-members">
                            @foreach($newMembers as $member)
                                <a href="{{ route('user.profile', $member->user_id) }}" class="member-item">
                                    @if($member->hinhanh)
                                        <img src="data:image/jpeg;base64,{{ base64_encode($member->hinhanh) }}" alt="Avatar" class="member-avatar">
                                    @else
                                        <div class="member-avatar">
                                            {{ strtoupper(substr($member->hoten ?? $member->username ?? 'U', 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="member-name">{{ Str::limit($member->hoten ?? $member->username, 12) }}</div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: var(--space-6); color: var(--text-tertiary);">
                            <i class="fas fa-user-plus" style="font-size: 2rem; margin-bottom: var(--space-2);"></i>
                            <p>Chưa có thành viên mới</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Join CTA -->
        @if(!$user)
        <div class="join-cta">
            <h2 class="cta-title">Tham gia cộng đồng ngay hôm nay!</h2>
            <p class="cta-text">
                Kết nối với hàng nghìn người dùng, chia sẻ kiến thức và học hỏi từ những trải nghiệm thú vị.
            </p>
            <div style="display: flex; gap: var(--space-4); justify-content: center;">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Đăng ký ngay
                </a>
                <a href="{{ route('login') }}" class="btn" style="background: var(--surface-secondary); color: var(--text-primary); border: 1px solid var(--border);">
                    <i class="fas fa-sign-in-alt"></i>
                    Đăng nhập
                </a>
            </div>
        </div>
        @endif
    </div>
</body>
</html>