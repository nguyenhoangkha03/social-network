<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chủ Đề - SpiderClone</title>
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

        .categories-hero {
            background: var(--gradient-primary);
            color: var(--text-inverse);
            padding: var(--space-20) var(--space-6) var(--space-16);
            text-align: center;
            margin-top: 70px;
        }

        .categories-container {
            max-width: var(--container-2xl);
            margin: 0 auto;
            padding: var(--space-16) var(--space-6);
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--space-8);
            margin-bottom: var(--space-16);
        }

        .category-card {
            background: var(--surface-primary);
            border: 1px solid var(--border-primary);
            border-radius: var(--radius-2xl);
            padding: var(--space-8);
            text-align: center;
            text-decoration: none;
            transition: all var(--duration-300) var(--ease-back);
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-2xl);
            border-color: var(--primary);
        }

        .category-icon {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-2xl);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-inverse);
            font-size: var(--text-3xl);
            margin: 0 auto var(--space-6);
            transition: all var(--duration-300) var(--ease-out);
        }

        .category-card:hover .category-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .category-title {
            font-size: var(--text-2xl);
            font-weight: var(--font-bold);
            color: var(--text-primary);
            margin-bottom: var(--space-3);
        }

        .category-description {
            font-size: var(--text-base);
            color: var(--text-secondary);
            line-height: var(--leading-relaxed);
            margin-bottom: var(--space-4);
        }

        .category-stats {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: var(--space-2);
            color: var(--text-tertiary);
            font-size: var(--text-sm);
            font-weight: var(--font-medium);
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
                    <li><a href="{{ route('categories.index') }}" class="nav-link" style="text-decoration: none; color: var(--primary); font-weight: var(--font-semibold);">Chủ đề</a></li>
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

    <!-- Hero Section -->
    <section class="categories-hero">
        <h1 style="font-size: var(--text-4xl); font-weight: var(--font-black); margin-bottom: var(--space-4);">Khám Phá Chủ Đề</h1>
        <p style="font-size: var(--text-xl); opacity: 0.9; max-width: 600px; margin: 0 auto;">Tìm hiểu các lĩnh vực bạn quan tâm và kết nối với cộng đồng</p>
    </section>

    <!-- Main Content -->
    <main class="categories-container">
        <a href="{{ route('home') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Về trang chủ
        </a>

        <div class="categories-grid">
            @foreach($categories as $category)
            <a href="{{ route('category.show', $category->slug) }}" class="category-card">
                <div class="category-icon" style="background: {{ $category->color }};">
                    <i class="{{ $category->icon }}"></i>
                </div>
                <h3 class="category-title">{{ $category->name }}</h3>
                <p class="category-description">{{ $category->description }}</p>
                <div class="category-stats">
                    <i class="fas fa-file-alt"></i>
                    <span>{{ $category->posts_count }} bài viết</span>
                </div>
            </a>
            @endforeach
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category card hover effects
            document.querySelectorAll('.category-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                    this.style.boxShadow = 'var(--shadow-2xl)';
                    this.style.borderColor = 'var(--primary)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = 'var(--shadow-md)';
                    this.style.borderColor = 'var(--border-primary)';
                });
            });

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