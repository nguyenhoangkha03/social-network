<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $post->tieude ?? 'Bài viết' }} - ChatPost</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Modern CSS -->
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --surface: #ffffff;
            --surface-secondary: #f8fafc;
            --surface-tertiary: #f1f5f9;
            --surface-hover: #e2e8f0;
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
            line-height: 1.6;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: var(--space-6);
        }

        .post-card {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            margin-bottom: var(--space-8);
        }

        .post-header {
            padding: var(--space-8);
            border-bottom: 1px solid var(--border-light);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            margin-bottom: var(--space-6);
            padding: var(--space-2) var(--space-4);
            border-radius: var(--radius-lg);
            transition: all 0.2s ease;
        }

        .back-link:hover {
            background: var(--surface-secondary);
            transform: translateX(-2px);
        }

        .post-title {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            color: var(--text-primary);
            margin-bottom: var(--space-4);
        }

        .post-meta {
            display: flex;
            align-items: center;
            gap: var(--space-4);
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: var(--space-6);
        }

        .post-meta a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .post-meta a:hover {
            text-decoration: underline;
        }

        .follow-btn {
            background: none;
            border: 2px solid var(--primary);
            color: var(--primary);
            padding: var(--space-2) var(--space-4);
            border-radius: var(--radius-xl);
            cursor: pointer;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .follow-btn:hover {
            background: var(--primary);
            color: white;
        }

        .follow-btn.following {
            background: var(--primary);
            color: white;
        }

        .post-cover {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: var(--radius-xl);
            margin-bottom: var(--space-6);
            box-shadow: var(--shadow-lg);
        }

        .post-content {
            padding: var(--space-8);
        }

        .content-text {
            font-size: 1.125rem;
            line-height: 1.8;
            color: var(--text-primary);
            margin-bottom: var(--space-6);
        }

        .content-text h1,
        .content-text h2,
        .content-text h3 {
            margin: var(--space-6) 0 var(--space-4) 0;
            color: var(--text-primary);
        }

        .content-text p {
            margin-bottom: var(--space-4);
        }

        .content-text img {
            max-width: 100%;
            height: auto;
            border-radius: var(--radius-lg);
            margin: var(--space-4) 0;
            box-shadow: var(--shadow-md);
        }

        .post-tags {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            margin-bottom: var(--space-6);
            color: var(--primary);
            font-weight: 500;
        }

        .font-controls {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            margin-bottom: var(--space-6);
            padding: var(--space-4);
            background: var(--surface-secondary);
            border-radius: var(--radius-lg);
        }

        .font-btn {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: var(--space-2) var(--space-3);
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .font-btn:hover {
            background: var(--surface-hover);
        }

        .post-actions {
            display: flex;
            align-items: center;
            gap: var(--space-6);
            padding: var(--space-6);
            border-top: 1px solid var(--border-light);
            background: var(--surface-secondary);
        }

        .like-section {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .like-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.5rem;
            padding: var(--space-2);
            border-radius: var(--radius-lg);
            transition: all 0.2s ease;
        }

        .like-btn:hover {
            background: var(--surface-hover);
            transform: scale(1.1);
        }

        .like-btn.liked {
            color: var(--error);
        }

        .like-count {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1.125rem;
        }

        .comments-section {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-8);
        }

        .comments-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: var(--space-6);
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .comment-form {
            display: flex;
            gap: var(--space-4);
            margin-bottom: var(--space-8);
            padding: var(--space-6);
            background: var(--surface-secondary);
            border-radius: var(--radius-xl);
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: var(--shadow-md);
        }

        .comment-input {
            flex: 1;
            padding: var(--space-4);
            border: 2px solid var(--border);
            border-radius: var(--radius-xl);
            resize: vertical;
            min-height: 60px;
            font-family: inherit;
            font-size: 1rem;
            background: var(--surface);
            transition: border-color 0.2s ease;
        }

        .comment-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .send-btn {
            padding: var(--space-4) var(--space-6);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            border-radius: var(--radius-xl);
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: var(--space-2);
            transition: all 0.2s ease;
        }

        .send-btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        .comment-item {
            background: var(--surface-secondary);
            border-radius: var(--radius-xl);
            padding: var(--space-6);
            margin-bottom: var(--space-6);
            border: 1px solid var(--border);
            transition: all 0.2s ease;
        }

        .comment-item:hover {
            box-shadow: var(--shadow-md);
        }

        .comment-item.pinned {
            background: linear-gradient(135deg, #dbeafe 0%, #e0f2fe 100%);
            border: 2px solid var(--primary);
            position: relative;
        }

        .pinned-badge {
            position: absolute;
            top: var(--space-4);
            right: var(--space-4);
            background: var(--primary);
            color: white;
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius-xl);
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: var(--space-1);
        }

        .comment-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--space-3);
        }

        .comment-author {
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .author-name {
            font-weight: 600;
            color: var(--text-primary);
        }

        .comment-time {
            color: var(--text-tertiary);
            font-size: 0.875rem;
        }

        .comment-content {
            color: var(--text-primary);
            line-height: 1.6;
            margin-bottom: var(--space-4);
        }

        .comment-actions {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .reply-btn {
            background: none;
            border: none;
            color: var(--primary);
            cursor: pointer;
            font-weight: 500;
            font-size: 0.875rem;
            padding: var(--space-2) var(--space-3);
            border-radius: var(--radius-md);
            transition: all 0.2s ease;
        }

        .reply-btn:hover {
            background: var(--surface-hover);
        }

        .more-btn {
            background: none;
            border: none;
            color: var(--text-tertiary);
            cursor: pointer;
            padding: var(--space-2);
            border-radius: var(--radius-md);
            font-size: 1.25rem;
            transition: all 0.2s ease;
        }

        .more-btn:hover {
            background: var(--surface-hover);
            color: var(--text-secondary);
        }

        .more-menu {
            position: absolute;
            right: 0;
            top: 100%;
            z-index: 50;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            min-width: 150px;
            overflow: hidden;
        }

        .menu-item {
            width: 100%;
            background: none;
            border: none;
            padding: var(--space-3) var(--space-4);
            text-align: left;
            cursor: pointer;
            font-size: 0.875rem;
            color: var(--text-primary);
            transition: background 0.2s ease;
        }

        .menu-item:hover {
            background: var(--surface-secondary);
        }

        .menu-item.danger {
            color: var(--error);
        }

        .menu-item.danger:hover {
            background: rgb(254 242 242);
        }

        .replies-list {
            margin-left: var(--space-12);
            margin-top: var(--space-6);
            border-left: 2px solid var(--border);
            padding-left: var(--space-6);
        }

        .reply-item {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: var(--space-4);
            margin-bottom: var(--space-4);
        }

        .reply-form {
            display: none;
            margin-top: var(--space-4);
            padding: var(--space-4);
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
        }

        .reply-form.active {
            display: flex;
            gap: var(--space-3);
            align-items: flex-start;
        }

        .reply-input {
            flex: 1;
            padding: var(--space-3);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            resize: vertical;
            min-height: 80px;
            font-family: inherit;
        }

        .reply-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        @media (max-width: 768px) {
            .container {
                padding: var(--space-4);
            }

            .post-header,
            .post-content,
            .comments-section {
                padding: var(--space-6);
            }

            .post-title {
                font-size: 2rem;
            }

            .replies-list {
                margin-left: var(--space-6);
                padding-left: var(--space-4);
            }

            .comment-form {
                flex-direction: column;
                gap: var(--space-3);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Post Card -->
        <article class="post-card">
            <!-- Post Header -->
            <header class="post-header">
                <a href="{{ route('home') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Về trang chủ
                </a>

                <h1 class="post-title">{{ $post->tieude }}</h1>

                <div class="post-meta">
                    <div style="display: flex; align-items: center; gap: var(--space-2);">
                        <i class="fas fa-user"></i>
                        <a href="{{ route('user.profile', $post->user->user_id) }}">{{ $post->user->hoten ?? $post->user->username ?? 'Tác giả' }}</a>
                    </div>

                    <div style="display: flex; align-items: center; gap: var(--space-2);">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $post->thoigiandang ? $post->thoigiandang->format('d/m/Y H:i') : '' }}</span>
                    </div>

                    @if(isset($user) && $user && $user->user_id != $post->user->user_id)
                    <button id="followBtn" class="follow-btn {{ $user->isFollowing($post->user->user_id) ? 'following' : '' }}" data-user-id="{{ $post->user->user_id }}" data-following="{{ $user->isFollowing($post->user->user_id) ? 'true' : 'false' }}">
                        <i class="fas fa-{{ $user->isFollowing($post->user->user_id) ? 'check' : 'plus' }}"></i>
                        {{ $user->isFollowing($post->user->user_id) ? 'Đang theo dõi' : 'Theo dõi' }}
                    </button>
                    @endif
                </div>

                @if($post->anh_bia)
                <img src="{{ asset($post->anh_bia) }}" alt="Ảnh bìa" class="post-cover">
                @endif
            </header>

            <!-- Post Content -->
            <div class="post-content">
                <div class="font-controls">
                    <span style="color: var(--text-secondary); font-weight: 500;">Kích thước chữ:</span>
                    <button class="font-btn" onclick="changeFontSize(2)">
                        <i class="fas fa-plus"></i> A
                    </button>
                    <button class="font-btn" onclick="changeFontSize(-2)">
                        <i class="fas fa-minus"></i> A
                    </button>
                    <button class="font-btn" onclick="resetFontSize()">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>

                <div class="content-text" id="postContent">{!! $post->noidung !!}</div>

                @if($post->dinhkhem)
                <div class="post-tags">
                    <i class="fas fa-tags"></i>
                    {{ $post->dinhkhem }}
                </div>
                @endif
            </div>

            <!-- Post Actions -->
            <div class="post-actions">
                <div class="like-section">
                    <span class="like-count">{{ $post->soluotlike ?? 0 }}</span>
                    @if(isset($user) && $user)
                    <button id="likeBtn" class="like-btn {{ $userLiked ? 'liked' : '' }}" data-post-id="{{ $post->id_baiviet }}" data-liked="{{ $userLiked ? 'true' : 'false' }}">
                        <i class="fas fa-heart"></i>
                    </button>
                    @else
                    <i class="fas fa-heart" style="color: var(--text-tertiary); font-size: 1.5rem;"></i>
                    @endif
                </div>

                <div style="display: flex; align-items: center; gap: var(--space-2); color: var(--text-secondary);">
                    <i class="fas fa-eye"></i>
                    <span>{{ number_format(rand(100, 5000)) }} lượt xem</span>
                </div>

                <div style="display: flex; align-items: center; gap: var(--space-2); color: var(--text-secondary);">
                    <i class="fas fa-share"></i>
                    <button style="background: none; border: none; color: inherit; cursor: pointer; font-weight: 500;" onclick="sharePost()">
                        Chia sẻ
                    </button>
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <section class="comments-section">
            <h2 class="comments-title">
                <i class="fas fa-comments"></i>
                Bình luận ({{ count($comments) }})
            </h2>
            @if(isset($user) && $user)
            <form class="comment-form" id="commentForm">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->hoten ?? $user->username ?? 'U') }}&background=2563eb&color=fff&size=48" alt="Avatar" class="avatar">
                <textarea id="commentContent" class="comment-input" placeholder="Viết bình luận của bạn..."></textarea>
                <button type="button" id="sendCommentBtn" class="send-btn">
                    <i class="fas fa-paper-plane"></i>
                    Gửi
                </button>
            </form>
            @else
            <div style="text-align: center; padding: var(--space-8); background: var(--surface-secondary); border-radius: var(--radius-xl); margin-bottom: var(--space-8);">
                <i class="fas fa-lock" style="font-size: 2rem; color: var(--text-tertiary); margin-bottom: var(--space-4);"></i>
                <p style="color: var(--text-secondary); margin-bottom: var(--space-4);">Bạn cần đăng nhập để tham gia bình luận</p>
                <a href="{{ route('login') }}" style="display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-3) var(--space-6); background: var(--primary); color: white; text-decoration: none; border-radius: var(--radius-xl); font-weight: 600; transition: all 0.2s ease;">
                    <i class="fas fa-sign-in-alt"></i>
                    Đăng nhập ngay
                </a>
            </div>
            @endif
            <div id="commentsList">
                {{-- Pinned Comment --}}
                @if($post->pinnedComment)
                <div class="comment-item pinned" data-comment-id="{{ $post->pinnedComment->id_binhluan }}">
                    <div class="pinned-badge">
                        <i class="fas fa-thumbtack"></i>
                        Được ghim
                    </div>

                    <div class="comment-header">
                        <div class="comment-author">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->pinnedComment->user->hoten ?? $post->pinnedComment->user->username ?? 'U') }}&background=2563eb&color=fff&size=40" alt="Avatar" class="avatar" style="width: 40px; height: 40px;">
                            <div>
                                <div class="author-name">{{ $post->pinnedComment->user->hoten ?? $post->pinnedComment->user->username ?? 'Tác giả' }}</div>
                                <div class="comment-time">{{ $post->pinnedComment->thoigiantao ? $post->pinnedComment->thoigiantao->diffForHumans() : '' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="comment-content">{{ $post->pinnedComment->noidung }}</div>
                </div>
                @endif
                @foreach($comments as $comment)
                <div class="comment-item" data-comment-id="{{ $comment->id_binhluan }}">
                    <div class="comment-header">
                        <div class="comment-author">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->hoten ?? $comment->user->username ?? 'U') }}&background=64748b&color=fff&size=40" alt="Avatar" class="avatar" style="width: 40px; height: 40px;">
                            <div>
                                <div class="author-name">{{ $comment->user->hoten ?? $comment->user->username ?? 'Tác giả' }}</div>
                                <div class="comment-time">{{ $comment->thoigiantao ? $comment->thoigiantao->diffForHumans() : '' }}</div>
                            </div>
                        </div>

                        <div style="position: relative;">
                            <button class="more-btn" data-comment-id="{{ $comment->id_binhluan }}">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="more-menu" id="menu-{{ $comment->id_binhluan }}" style="display: none;">
                                <button class="menu-item">Chỉnh sửa</button>
                                <button class="menu-item danger">Xóa</button>
                                <button class="menu-item">Ghim</button>
                            </div>
                        </div>
                    </div>

                    <div class="comment-content">{{ $comment->noidung }}</div>

                    <div class="comment-actions">
                        <button class="reply-btn" data-comment-id="{{ $comment->id_binhluan }}">
                            <i class="fas fa-reply"></i>
                            Trả lời
                        </button>
                    </div>
                    @if(isset($user) && $user)
                    <form class="reply-form" data-parent-id="{{ $comment->id_binhluan }}">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->hoten ?? $user->username ?? 'U') }}&background=2563eb&color=fff&size=32" alt="Avatar" style="width: 32px; height: 32px; border-radius: 50%;">
                        <textarea class="reply-input" placeholder="Trả lời bình luận này..."></textarea>
                        <button type="button" class="send-btn sendReplyBtn" data-parent-id="{{ $comment->id_binhluan }}" style="padding: var(--space-3) var(--space-4); font-size: 0.875rem;">
                            <i class="fas fa-paper-plane"></i>
                            Gửi
                        </button>
                    </form>
                    @endif
                    <!-- Replies -->
                    @if($comment->replies && $comment->replies->count())
                    <div class="replies-list">
                        @foreach($comment->replies as $reply)
                        <div class="reply-item" data-comment-id="{{ $reply->id_binhluan }}">
                            <div class="comment-header">
                                <div class="comment-author">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->hoten ?? $reply->user->username ?? 'U') }}&background=06b6d4&color=fff&size=36" alt="Avatar" style="width: 36px; height: 36px; border-radius: 50%;">
                                    <div>
                                        <div class="author-name">{{ $reply->user->hoten ?? $reply->user->username ?? 'Tác giả' }}</div>
                                        <div class="comment-time">{{ $reply->thoigiantao ? $reply->thoigiantao->diffForHumans() : '' }}</div>
                                    </div>
                                </div>

                                <div style="position: relative;">
                                    <button class="more-btn" data-comment-id="{{ $reply->id_binhluan }}">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="more-menu" id="menu-{{ $reply->id_binhluan }}" style="display: none;">
                                        <button class="menu-item">Chỉnh sửa</button>
                                        <button class="menu-item danger">Xóa</button>
                                    </div>
                                </div>
                            </div>

                            <div class="comment-content">{{ $reply->noidung }}</div>

                            <div class="comment-actions">
                                <button class="reply-btn" data-comment-id="{{ $comment->id_binhluan }}">
                                    <i class="fas fa-reply"></i>
                                    Trả lời
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
    </div>
    </div>
    @if(isset($user) && $user)
    <script>
        document.getElementById('likeBtn').addEventListener('click', function() {
            const postId = this.dataset.postId;
            const isLiked = this.dataset.liked === 'true';

            fetch(`/post/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cập nhật UI
                        this.dataset.liked = data.isLiked.toString();
                        this.style.color = data.isLiked ? '#e74c3c' : '#ccc';

                        // Cập nhật số lượt like
                        document.querySelector('.like-count').textContent = data.likeCount;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi like bài viết');
                });
        });

        // Gửi bình luận cha
        document.getElementById('sendCommentBtn').addEventListener('click', function() {
            const content = document.getElementById('commentContent').value.trim();
            if (!content) {
                alert('Vui lòng nhập nội dung bình luận');
                return;
            }
            fetch('/post/{{ $post->id_baiviet }}/comment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        noidung: content
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.error || 'Có lỗi xảy ra!');
                    }
                })
                .catch(() => alert('Có lỗi xảy ra!'));
        });

        // Gửi reply (bình luận con)
        document.querySelectorAll('.sendReplyBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                const parentId = this.dataset.parentId;
                const form = this.closest('.reply-form');
                const textarea = form.querySelector('textarea');
                const content = textarea.value.trim();
                if (!content) {
                    alert('Vui lòng nhập nội dung trả lời');
                    return;
                }
                fetch('/post/{{ $post->id_baiviet }}/comment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            noidung: content,
                            parent_id: parentId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.error || 'Có lỗi xảy ra!');
                        }
                    })
                    .catch(() => alert('Có lỗi xảy ra!'));
            });
        });

        // Hiện form trả lời khi bấm nút "Trả lời"
        document.querySelectorAll('.reply-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const commentId = this.dataset.commentId;
                const replyForm = document.querySelector('.reply-form[data-parent-id="' + commentId + '"]');
                if (replyForm) {
                    replyForm.style.display = replyForm.style.display === 'none' || replyForm.style.display === '' ? 'flex' : 'none';
                    replyForm.querySelector('textarea').focus();
                }
            });
        });
    </script>

    @if(isset($user) && $user && $user->user_id != $post->user->user_id)
    <script>
        document.getElementById('followBtn').addEventListener('click', function() {
            const userId = this.dataset.userId;
            const isFollowing = this.dataset.following === 'true';

            fetch(`/user/${userId}/follow`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cập nhật UI
                        this.dataset.following = data.isFollowing.toString();
                        this.textContent = data.isFollowing ? 'Đang theo dõi' : 'Theo dõi';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi thực hiện thao tác');
                });
        });
    </script>
    @endif
    @endif
    <!-- XÓA: <script> ... </script> liên quan đến comment/reply -->
    <script>
        // Xử lý hiện/ẩn menu 3 chấm
        document.querySelectorAll('.more-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const id = this.dataset.commentId;
                // Ẩn tất cả menu khác trước khi mở menu này
                document.querySelectorAll('.more-menu').forEach(m => m.style.display = 'none');
                const menu = document.getElementById('menu-' + id);
                if (menu) menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
            });
        });
        // Ẩn menu khi click ra ngoài
        document.addEventListener('click', function() {
            document.querySelectorAll('.more-menu').forEach(m => m.style.display = 'none');
        });

        // Xử lý xóa bình luận/reply
        document.querySelectorAll('.more-menu .menu-item:nth-child(2)').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const menu = this.closest('.more-menu');
                const commentId = menu.id.replace('menu-', '');
                if (confirm('Bạn có chắc muốn xóa bình luận này?')) {
                    fetch('/comment/' + commentId, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert(data.error || 'Có lỗi xảy ra!');
                            }
                        })
                        .catch(() => alert('Có lỗi xảy ra!'));
                }
            });
        });

        // Xử lý chỉnh sửa bình luận/reply
        document.querySelectorAll('.more-menu .menu-item:first-child').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const menu = this.closest('.more-menu');
                const commentId = menu.id.replace('menu-', '');
                const commentItem = document.querySelector('[data-comment-id="' + commentId + '"]') || document.getElementById('comment-' + commentId);
                if (!commentItem) return;
                // Tìm div nội dung
                const contentDiv = commentItem.querySelector('div[style*="line-height"]');
                if (!contentDiv) return;
                // Nếu đã có textarea thì không làm gì
                if (commentItem.querySelector('.edit-textarea')) return;
                const oldContent = contentDiv.textContent;
                // Tạo textarea và nút lưu/hủy
                const textarea = document.createElement('textarea');
                textarea.className = 'edit-textarea';
                textarea.style.width = '100%';
                textarea.style.minHeight = '48px';
                textarea.style.margin = '8px 0';
                textarea.style.padding = '10px 12px';
                textarea.style.border = '1.5px solid #e0e3eb';
                textarea.style.borderRadius = '10px';
                textarea.value = oldContent;
                const saveBtn = document.createElement('button');
                saveBtn.textContent = 'Lưu';
                saveBtn.style.marginRight = '8px';
                saveBtn.style.background = 'linear-gradient(90deg,#007bff,#00c6ff)';
                saveBtn.style.color = 'white';
                saveBtn.style.border = 'none';
                saveBtn.style.borderRadius = '8px';
                saveBtn.style.padding = '8px 18px';
                saveBtn.style.cursor = 'pointer';
                const cancelBtn = document.createElement('button');
                cancelBtn.textContent = 'Hủy';
                cancelBtn.style.background = '#eee';
                cancelBtn.style.color = '#222';
                cancelBtn.style.border = 'none';
                cancelBtn.style.borderRadius = '8px';
                cancelBtn.style.padding = '8px 18px';
                cancelBtn.style.cursor = 'pointer';
                // Ẩn nội dung cũ, chèn textarea và nút
                contentDiv.style.display = 'none';
                contentDiv.parentNode.insertBefore(textarea, contentDiv);
                contentDiv.parentNode.insertBefore(saveBtn, contentDiv);
                contentDiv.parentNode.insertBefore(cancelBtn, contentDiv);
                textarea.focus();
                // Lưu
                saveBtn.onclick = function() {
                    const newContent = textarea.value.trim();
                    if (!newContent) {
                        alert('Nội dung không được để trống!');
                        return;
                    }
                    fetch('/comment/' + commentId, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                noidung: newContent
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                contentDiv.textContent = data.noidung;
                                textarea.remove();
                                saveBtn.remove();
                                cancelBtn.remove();
                                contentDiv.style.display = '';
                            } else {
                                alert(data.error || 'Có lỗi xảy ra!');
                            }
                        })
                        .catch(() => alert('Có lỗi xảy ra!'));
                };
                // Hủy
                cancelBtn.onclick = function() {
                    textarea.remove();
                    saveBtn.remove();
                    cancelBtn.remove();
                    contentDiv.style.display = '';
                };
            });
        });

        // Xử lý ghim bình luận (chỉ chủ bài viết mới thao tác)
        document.querySelectorAll('.more-menu .menu-item:last-child').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const menu = this.closest('.more-menu');
                const commentId = menu.id.replace('menu-', '');
                // Chỉ cho phép ghim bình luận cha
                const commentItem = document.querySelector('[data-comment-id="' + commentId + '"]');
                if (commentItem && commentItem.closest('.replies-list')) {
                    alert('Chỉ có thể ghim bình luận cha!');
                    return;
                }
                // Kiểm tra quyền (chỉ chủ bài viết)
                @if(!isset($user) || $user->user_id != $post->user->user_id)
                alert('Chỉ chủ bài viết mới được ghim!');
                return;
                @endif
                fetch('/comment/' + commentId + '/pin', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.error || 'Có lỗi xảy ra!');
                        }
                    })
                    .catch(() => alert('Có lỗi xảy ra!'));
            });
        });
    </script>
</body>
<script>
    function changeFontSize(delta) {
        const content = document.querySelector('.post-content');
        if (!content) return;
        let current = window.getComputedStyle(content).fontSize;
        let size = parseFloat(current);
        size += delta * 2;
        if (size < 12) size = 12;
        if (size > 48) size = 48;
        content.style.fontSize = size + 'px';
    }
</script>

</html>