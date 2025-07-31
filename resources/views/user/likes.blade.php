<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài viết {{ $user->hoten ?? $user->username }} đã thích</title>
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
            padding: var(--space-6);
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
            margin-bottom: var(--space-4);
            transition: all 0.2s ease;
        }

        .back-btn:hover {
            color: var(--primary-dark);
            transform: translateX(-2px);
        }

        .user-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-4);
            margin-bottom: var(--space-4);
        }

        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--surface-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            background: var(--primary);
        }

        .title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .likes-container {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-8);
        }

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
            position: relative;
        }

        .post-card:hover {
            background: var(--surface);
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        .liked-indicator {
            position: absolute;
            top: var(--space-4);
            right: var(--space-4);
            color: var(--error);
            font-size: 1.25rem;
        }

        .post-header {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            margin-bottom: var(--space-4);
        }

        .author-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--surface-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            background: var(--secondary);
        }

        .post-meta {
            flex: 1;
        }

        .author-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .post-date {
            color: var(--text-tertiary);
            font-size: 0.75rem;
        }

        .post-title {
            font-size: 1.125rem;
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

        .post-stat.liked {
            color: var(--error);
        }

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

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: var(--space-8);
            gap: var(--space-2);
        }

        .pagination a, .pagination span {
            padding: var(--space-2) var(--space-4);
            border-radius: var(--radius-md);
            text-decoration: none;
            color: var(--text-secondary);
            border: 1px solid var(--border);
        }

        .pagination a:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .pagination .current {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('user.profile', $user->user_id) }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Quay lại hồ sơ
            </a>
            
            <div class="user-info">
                @if($user->hinhanh)
                    <img src="data:image/jpeg;base64,{{ base64_encode($user->hinhanh) }}" alt="Avatar" class="avatar">
                @else
                    <div class="avatar">
                        {{ strtoupper(substr($user->hoten ?? $user->username ?? 'U', 0, 1)) }}
                    </div>
                @endif
                <h1 class="title">Bài viết {{ $user->hoten ?? $user->username }} đã thích</h1>
            </div>
        </div>

        <div class="likes-container">
            @if($likedPosts->count() > 0)
                <div class="posts-grid">
                    @foreach($likedPosts as $post)
                        <article class="post-card">
                            <div class="liked-indicator">
                                <i class="fas fa-heart"></i>
                            </div>
                            
                            <div class="post-header">
                                @if($post->user->hinhanh)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($post->user->hinhanh) }}" alt="Avatar" class="author-avatar">
                                @else
                                    <div class="author-avatar">
                                        {{ strtoupper(substr($post->user->hoten ?? $post->user->username ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                                
                                <div class="post-meta">
                                    <div class="author-name">{{ $post->user->hoten ?? $post->user->username }}</div>
                                    <div class="post-date">
                                        {{ $post->thoigiandang ? $post->thoigiandang->format('d/m/Y H:i') : 'N/A' }}
                                    </div>
                                </div>
                            </div>

                            <h3 class="post-title">
                                <a href="{{ route('post.show', $post->id_baiviet) }}">
                                    {{ $post->tieude }}
                                </a>
                            </h3>

                            @if($post->mota)
                                <p class="post-excerpt">{{ Str::limit($post->mota, 150) }}</p>
                            @endif

                            <div class="post-stats">
                                <span class="post-stat liked">
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

                <!-- Pagination -->
                <div class="pagination">
                    {{ $likedPosts->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-heart"></i>
                    <h3>Chưa thích bài viết nào</h3>
                    <p>{{ $user->hoten ?? $user->username }} chưa thích bài viết nào.</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>