<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $category->name }} - SpiderClone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/home.css'])
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --primary-dark: #3730a3;
            --secondary: #10b981;
            --error: #ef4444;
            --warning: #f59e0b;
            --surface-primary: #ffffff;
            --surface-secondary: #f8fafc;
            --surface-tertiary: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-tertiary: #94a3b8;
            --text-inverse: #ffffff;
            --border-primary: #e2e8f0;
            --border-secondary: #cbd5e1;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-tertiary: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --radius-sm: 0.125rem;
            --radius-md: 0.375rem;
            --radius-lg: 0.5rem;
            --radius-xl: 0.75rem;
            --radius-2xl: 1rem;
            --radius-full: 9999px;
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
            --text-xs: 0.75rem;
            --text-sm: 0.875rem;
            --text-base: 1rem;
            --text-lg: 1.125rem;
            --text-xl: 1.25rem;
            --text-2xl: 1.5rem;
            --text-3xl: 1.875rem;
            --text-4xl: 2.25rem;
            --font-light: 300;
            --font-normal: 400;
            --font-medium: 500;
            --font-semibold: 600;
            --font-bold: 700;
            --font-extrabold: 800;
            --font-black: 900;
            --leading-tight: 1.25;
            --leading-relaxed: 1.625;
            --container-2xl: 1400px;
            --duration-200: 200ms;
            --duration-300: 300ms;
            --duration-500: 500ms;
            --ease-out: cubic-bezier(0.4, 0, 0.2, 1);
            --ease-back: cubic-bezier(0.68, -0.55, 0.265, 1.55);
            --z-50: 50;
        }

        .dark-theme {
            --surface-primary: #1e293b;
            --surface-secondary: #334155;
            --surface-tertiary: #475569;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-tertiary: #94a3b8;
            --border-primary: #475569;
            --border-secondary: #64748b;
        }

        .category-hero {
            background: linear-gradient(135deg, {{ $category->color }}AA 0%, {{ $category->color }} 100%);
            color: var(--text-inverse);
            padding: var(--space-20) var(--space-6) var(--space-12);
            text-align: center;
            margin-top: 70px;
        }

        .category-icon-large {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-2xl);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--text-4xl);
            margin: 0 auto var(--space-6);
            backdrop-filter: blur(10px);
        }

        .category-container {
            max-width: var(--container-2xl);
            margin: 0 auto;
            padding: var(--space-16) var(--space-6);
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: var(--space-12);
            align-items: start;
        }

        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: var(--space-6);
            margin-bottom: var(--space-8);
        }

        .modern-post-card {
            background: var(--surface-primary);
            border-radius: var(--radius-2xl);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all var(--duration-300) var(--ease-out);
            border: 1px solid var(--border-primary);
            position: relative;
        }

        .modern-post-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .post-image {
            height: 180px;
            overflow: hidden;
            position: relative;
        }

        .post-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--duration-500) var(--ease-out);
        }

        .modern-post-card:hover .post-image img {
            transform: scale(1.05);
        }

        .post-content {
            padding: var(--space-5);
        }

        .post-title {
            font-size: var(--text-lg);
            font-weight: var(--font-bold);
            line-height: var(--leading-tight);
            margin-bottom: var(--space-3);
            color: var(--text-primary);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-excerpt {
            color: var(--text-secondary);
            line-height: var(--leading-relaxed);
            margin-bottom: var(--space-4);
            font-size: var(--text-sm);
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .author-avatar {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-full);
            background: var(--gradient-tertiary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-inverse);
            font-weight: var(--font-bold);
            font-size: var(--text-xs);
        }

        .sidebar {
            position: sticky;
            top: 120px;
            height: fit-content;
        }

        .widget {
            background: var(--surface-primary);
            border: 1px solid var(--border-primary);
            border-radius: var(--radius-2xl);
            padding: var(--space-6);
            margin-bottom: var(--space-6);
            box-shadow: var(--shadow-sm);
        }

        .widget-title {
            font-size: var(--text-xl);
            font-weight: var(--font-bold);
            color: var(--text-primary);
            margin-bottom: var(--space-4);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-3) var(--space-6);
            background: var(--surface-primary);
            color: var(--text-primary);
            text-decoration: none;
            border-radius: var(--radius-xl);
            font-weight: var(--font-semibold);
            box-shadow: var(--shadow-md);
            transition: all var(--duration-200) var(--ease-out);
            margin-bottom: var(--space-8);
        }

        .back-button:hover {
            background: var(--primary);
            color: var(--text-inverse);
            transform: translateY(-2px);
        }

        .category-link {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3);
            background: var(--surface-secondary);
            border-radius: var(--radius-lg);
            text-decoration: none;
            color: var(--text-secondary);
            font-size: var(--text-sm);
            font-weight: var(--font-medium);
            transition: all var(--duration-200) var(--ease-out);
            margin-bottom: var(--space-2);
        }

        .category-link:hover {
            background: var(--primary);
            color: var(--text-inverse);
            transform: translateX(4px);
        }

        .category-mini-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-inverse);
            font-size: var(--text-sm);
        }

        .no-posts {
            grid-column: 1/-1;
            text-align: center;
            padding: var(--space-16);
            background: var(--surface-secondary);
            border-radius: var(--radius-2xl);
            border: 2px dashed var(--border-secondary);
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: var(--space-8);
        }

        .like-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-tertiary);
            padding: var(--space-1);
            border-radius: var(--radius-md);
            transition: all var(--duration-200) var(--ease-out);
        }

        .like-btn:hover {
            color: var(--error);
            transform: scale(1.1);
        }

        .like-btn[data-liked="true"] {
            color: var(--error);
        }
    </style>
</head>

<body @if(isset($user) && $user->theme === 'dark') class="dark-theme" @endif>
    <!-- Header -->
    <header class="modern-header" style="position: fixed; top: 0; left: 0; right: 0; z-index: 100; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border-primary);">
        <div class="header-container" style="max-width: var(--container-2xl); margin: 0 auto; padding: 0 var(--space-6); display: flex; align-items: center; justify-content: space-between; height: 70px;">
            <a href="{{ route('home') }}" class="modern-logo" style="display: flex; align-items: center; gap: var(--space-3); text-decoration: none; color: var(--text-primary); font-weight: var(--font-bold); font-size: var(--text-xl);">
                <div class="logo-icon" style="width: 40px; height: 40px; background: var(--gradient-primary); border-radius: var(--radius-xl); display: flex; align-items: center; justify-content: center; color: white; font-size: var(--text-lg);">
                    <i class="fas fa-comments"></i>
                </div>
                <span class="logo-text">ChatPost</span>
            </a>

            <nav class="header-nav">
                <ul class="nav-links" style="display: flex; list-style: none; margin: 0; padding: 0; gap: var(--space-8);">
                    <li><a href="{{ route('home') }}" class="nav-link" style="text-decoration: none; color: var(--text-secondary); font-weight: var(--font-medium);">Trang chủ</a></li>
                    <li><a href="{{ route('categories.index') }}" class="nav-link" style="text-decoration: none; color: var(--text-secondary); font-weight: var(--font-medium);">Chủ đề</a></li>
                </ul>
            </nav>

            <div class="header-actions" style="display: flex; align-items: center; gap: var(--space-4);">
                @if(isset($user) && $user)
                <!-- User Menu -->
                <button class="user-menu-toggle" id="userMenuToggle" style="width: 44px; height: 44px; border: none; background: var(--surface-secondary); border-radius: var(--radius-xl); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); cursor: pointer;">
                    @if($user->hinhanh)
                    <img src="data:image/jpeg;base64,{{ base64_encode($user->hinhanh) }}" alt="Avatar" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                    @else
                    <i class="fas fa-user"></i>
                    @endif
                </button>

                <!-- User Dropdown Menu -->
                <div class="user-dropdown" id="userDropdown" style="display: none; position: absolute; top: 60px; right: 0; width: 200px; background: var(--surface-primary); border: 1px solid var(--border-primary); border-radius: var(--radius-2xl); box-shadow: var(--shadow-xl); z-index: 1000; overflow: hidden;">
                    <a href="{{ route('user.profile', $user->user_id) }}" style="display: block; padding: var(--space-3) var(--space-4); color: var(--text-primary); text-decoration: none; transition: background var(--duration-200); border-bottom: 1px solid var(--border-primary);">
                        <i class="fas fa-user" style="margin-right: var(--space-2);"></i>
                        Hồ sơ của tôi
                    </a>
                    <a href="{{ route('post.create') }}" style="display: block; padding: var(--space-3) var(--space-4); color: var(--text-primary); text-decoration: none; transition: background var(--duration-200); border-bottom: 1px solid var(--border-primary);">
                        <i class="fas fa-plus" style="margin-right: var(--space-2);"></i>
                        Viết bài mới
                    </a>
                    <a href="/chat" style="display: block; padding: var(--space-3) var(--space-4); color: var(--text-primary); text-decoration: none; transition: background var(--duration-200); border-bottom: 1px solid var(--border-primary);">
                        <i class="fas fa-comments" style="margin-right: var(--space-2);"></i>
                        Tin nhắn
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" style="width: 100%; text-align: left; padding: var(--space-3) var(--space-4); background: none; border: none; color: var(--text-primary); cursor: pointer; transition: background var(--duration-200);">
                            <i class="fas fa-sign-out-alt" style="margin-right: var(--space-2);"></i>
                            Đăng xuất
                        </button>
                    </form>
                </div>
                @else
                <a href="{{ route('login') }}" class="cta-secondary" style="padding: var(--space-2) var(--space-4); border-radius: var(--radius-xl); text-decoration: none; font-weight: var(--font-medium); background: transparent; color: var(--text-secondary); border: 1px solid var(--border-primary);">Đăng nhập</a>
                <a href="{{ route('register') }}" class="cta-primary" style="padding: var(--space-2) var(--space-6); border-radius: var(--radius-xl); text-decoration: none; font-weight: var(--font-semibold); background: var(--gradient-primary); color: var(--text-inverse);">Đăng ký</a>
                @endif
            </div>
        </div>
    </header>

    <!-- Category Hero -->
    <section class="category-hero">
        <div class="category-icon-large" style="color: {{ $category->color }};">
            <i class="{{ $category->icon }}"></i>
        </div>
        <h1 style="font-size: var(--text-4xl); font-weight: var(--font-black); margin-bottom: var(--space-4);">{{ $category->name }}</h1>
        <p style="font-size: var(--text-xl); opacity: 0.9; max-width: 600px; margin: 0 auto var(--space-6);">{{ $category->description }}</p>
        <div style="display: flex; justify-content: center; align-items: center; gap: var(--space-4); font-size: var(--text-lg); opacity: 0.8;">
            <span><i class="fas fa-file-alt" style="margin-right: var(--space-2);"></i>{{ $baiviets->total() }} bài viết</span>
        </div>
    </section>

    <!-- Main Content -->
    <div class="category-container">
        <main>
            <a href="{{ route('categories.index') }}" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Tất cả chủ đề
            </a>

            @if($featuredPosts->count() > 0)
            <section style="margin-bottom: var(--space-12);">
                <h2 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--text-primary); margin-bottom: var(--space-6); display: flex; align-items: center; gap: var(--space-2);">
                    <i class="fas fa-star" style="color: var(--warning);"></i>
                    Bài viết nổi bật
                </h2>
                
                <div class="posts-grid">
                    @foreach($featuredPosts as $post)
                    <article class="modern-post-card">
                        <a href="{{ route('post.show', $post->id_baiviet) }}" style="text-decoration: none; color: inherit; display: block;">
                            <div class="post-image">
                                @if($post->anh_bia)
                                <img src="{{ asset($post->anh_bia) }}" alt="{{ $post->tieude }}">
                                @else
                                <div style="width: 100%; height: 100%; background: var(--gradient-secondary); display: flex; align-items: center; justify-content: center; color: var(--text-inverse); font-size: var(--text-xl); font-weight: var(--font-bold);">{{ substr($post->tieude ?? 'Post', 0, 1) }}</div>
                                @endif
                                <div style="position: absolute; top: var(--space-3); right: var(--space-3); background: rgba(255,165,0,0.9); backdrop-filter: blur(10px); padding: var(--space-1) var(--space-2); border-radius: var(--radius-md); font-size: var(--text-xs); font-weight: var(--font-medium); color: white;">
                                    <i class="fas fa-star" style="margin-right: var(--space-1);"></i>Nổi bật
                                </div>
                            </div>
                            <div class="post-content">
                                <h3 class="post-title">{{ $post->tieude ?? 'Tiêu đề bài viết' }}</h3>
                                <p class="post-excerpt">{{ Str::limit($post->mota ?? $post->noidung ?? 'Nội dung bài viết...', 100) }}</p>
                                <div class="post-meta">
                                    <div class="author-info">
                                        <div class="author-avatar">{{ substr($post->user->hoten ?? $post->user->username ?? 'U', 0, 1) }}</div>
                                        <div>
                                            <div style="font-weight: var(--font-medium); color: var(--text-primary); font-size: var(--text-xs);">{{ Str::limit($post->user->hoten ?? $post->user->username ?? 'Tác giả', 15) }}</div>
                                            <div style="color: var(--text-tertiary); font-size: var(--text-xs);">{{ $post->thoigiandang ? $post->thoigiandang->format('d/m') : 'N/A' }}</div>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: var(--space-2);">
                                        <span style="color: var(--text-tertiary); font-size: var(--text-xs);"><i class="fas fa-heart" style="color: var(--error); margin-right: 4px;"></i>{{ $post->soluotlike ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </article>
                    @endforeach
                </div>
            </section>
            @endif

            <section>
                <h2 style="font-size: var(--text-2xl); font-weight: var(--font-bold); color: var(--text-primary); margin-bottom: var(--space-6); display: flex; align-items: center; gap: var(--space-2);">
                    <i class="fas fa-clock" style="color: var(--primary);"></i>
                    Bài viết mới nhất
                </h2>

                @if($baiviets->count() > 0)
                <div class="posts-grid">
                    @foreach($baiviets as $post)
                    <article class="modern-post-card">
                        <a href="{{ route('post.show', $post->id_baiviet) }}" style="text-decoration: none; color: inherit; display: block;">
                            <div class="post-image">
                                @if($post->anh_bia)
                                <img src="{{ asset($post->anh_bia) }}" alt="{{ $post->tieude }}">
                                @else
                                <div style="width: 100%; height: 100%; background: var(--gradient-tertiary); display: flex; align-items: center; justify-content: center; color: var(--text-inverse); font-size: var(--text-xl); font-weight: var(--font-bold);">{{ substr($post->tieude ?? 'Post', 0, 1) }}</div>
                                @endif
                            </div>
                            <div class="post-content">
                                <h3 class="post-title">{{ $post->tieude ?? 'Tiêu đề bài viết' }}</h3>
                                <p class="post-excerpt">{{ Str::limit($post->mota ?? $post->noidung ?? 'Nội dung bài viết...', 100) }}</p>
                                <div class="post-meta">
                                    <div class="author-info">
                                        <div class="author-avatar">{{ substr($post->user->hoten ?? $post->user->username ?? 'U', 0, 1) }}</div>
                                        <div>
                                            <div style="font-weight: var(--font-medium); color: var(--text-primary); font-size: var(--text-xs);">{{ Str::limit($post->user->hoten ?? $post->user->username ?? 'Tác giả', 15) }}</div>
                                            <div style="color: var(--text-tertiary); font-size: var(--text-xs);">{{ $post->thoigiandang ? $post->thoigiandang->format('d/m') : 'N/A' }}</div>
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: var(--space-2);">
                                        <span style="color: var(--text-tertiary); font-size: var(--text-xs);"><i class="fas fa-heart" style="color: var(--error); margin-right: 4px;"></i>{{ $post->soluotlike ?? 0 }}</span>
                                        @if(isset($user) && $user)
                                        <button class="like-btn" data-post-id="{{ $post->id_baiviet }}" data-liked="{{ in_array($post->id_baiviet, $userLikedPosts ?? []) ? 'true' : 'false' }}" onclick="event.preventDefault(); event.stopPropagation();">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    {{ $baiviets->links() }}
                </div>
                @else
                <div class="no-posts">
                    <i class="fas fa-edit" style="font-size: var(--text-3xl); color: var(--text-tertiary); margin-bottom: var(--space-4);"></i>
                    <h3 style="font-size: var(--text-xl); font-weight: var(--font-semibold); color: var(--text-primary); margin-bottom: var(--space-2);">Chưa có bài viết nào</h3>
                    <p style="color: var(--text-secondary); margin-bottom: var(--space-6);">Hãy là người đầu tiên chia sẻ về {{ $category->name }}!</p>
                    @if(isset($user) && $user)
                    <a href="{{ route('post.create') }}" class="cta-primary" style="display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-3) var(--space-6); background: var(--gradient-primary); color: var(--text-inverse); text-decoration: none; border-radius: var(--radius-xl); font-weight: var(--font-semibold);">
                        <i class="fas fa-plus"></i>Đăng bài viết đầu tiên
                    </a>
                    @endif
                </div>
                @endif
            </section>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Other Categories Widget -->
            <div class="widget">
                <h3 class="widget-title">
                    <i class="fas fa-list" style="color: var(--primary);"></i>
                    Chủ đề khác
                </h3>
                @foreach($otherCategories as $otherCategory)
                <a href="{{ route('category.show', $otherCategory->slug) }}" class="category-link">
                    <div class="category-mini-icon" style="background: {{ $otherCategory->color }};">
                        <i class="{{ $otherCategory->icon }}"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: var(--font-semibold); margin-bottom: 2px;">{{ $otherCategory->name }}</div>
                        <div style="font-size: var(--text-xs); opacity: 0.7;">{{ $otherCategory->posts_count }} bài viết</div>
                    </div>
                </a>
                @endforeach
            </div>
        </aside>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Post card hover effects
            document.querySelectorAll('.modern-post-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                    this.style.boxShadow = 'var(--shadow-xl)';
                    const img = this.querySelector('.post-image img');
                    if (img) img.style.transform = 'scale(1.05)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'var(--shadow-md)';
                    const img = this.querySelector('.post-image img');
                    if (img) img.style.transform = 'scale(1)';
                });
            });

            // Like button functionality
            document.querySelectorAll('.like-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const postId = this.dataset.postId;
                    const isLiked = this.dataset.liked === 'true';

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

                userDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
</body>
</html>