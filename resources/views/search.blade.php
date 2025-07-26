<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kết quả tìm kiếm: "{{ $query }}" - SpiderClone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', Arial, sans-serif; background: #f6f7fb; margin: 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .search-header { background: #fff; border-radius: 12px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .search-form { display: flex; gap: 12px; margin-bottom: 16px; }
        .search-input { flex: 1; padding: 12px 16px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; }
        .search-btn { padding: 12px 24px; background: #007bff; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 500; }
        .search-results { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .result-count { color: #666; margin-bottom: 20px; }
        .post-card { border-bottom: 1px solid #eee; padding: 20px 0; }
        .post-card:last-child { border-bottom: none; }
        .post-title { font-size: 1.3rem; font-weight: 600; margin-bottom: 8px; }
        .post-title a { color: #222; text-decoration: none; }
        .post-title a:hover { color: #007bff; }
        .post-excerpt { color: #666; margin-bottom: 12px; line-height: 1.5; }
        .post-meta { display: flex; align-items: center; gap: 16px; font-size: 0.9rem; color: #888; }
        .post-meta a { color: inherit; text-decoration: none; }
        .like-btn { background: none; border: none; cursor: pointer; color: #ccc; }
        .like-btn.liked { color: #e74c3c; }
        .back-link { display: inline-block; margin-bottom: 18px; color: #007bff; text-decoration: underline; }
        .search-filter {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 0.97rem;
            margin-right: 8px;
            background: #fff;
            color: #222;
        }
        .search-filter:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0,123,255,0.10);
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('home') }}" class="back-link"><i class="fas fa-arrow-left"></i> Về trang chủ</a>
        
        <div class="search-tabs" style="display:flex;gap:12px;margin-bottom:16px;">
            <a href="{{ route('search', ['type' => 'post', 'q' => $query]) }}" class="{{ ($type ?? 'post') == 'post' ? 'active' : '' }}" style="padding:8px 20px;border-radius:8px;text-decoration:none;{{ ($type ?? 'post') == 'post' ? 'background:#007bff;color:#fff;' : 'background:#f3f3f3;color:#222;' }}">Bài viết</a>
            <a href="{{ route('search', ['type' => 'user', 'q' => $query]) }}" class="{{ ($type ?? '') == 'user' ? 'active' : '' }}" style="padding:8px 20px;border-radius:8px;text-decoration:none;{{ ($type ?? '') == 'user' ? 'background:#007bff;color:#fff;' : 'background:#f3f3f3;color:#222;' }}">Bạn bè</a>
        </div>
        
        @if(($type ?? 'post') == 'user')
            <div class="search-header">
                <form class="search-form" method="GET" action="{{ route('search') }}">
                    <input type="hidden" name="type" value="user">
                    <input type="text" name="q" value="{{ $query }}" placeholder="Nhập tên, username hoặc email..." class="search-input" required>
                    <button type="submit" class="search-btn"><i class="fas fa-search"></i> Tìm kiếm</button>
                </form>
            </div>
            <div class="search-results">
                @if(isset($users) && count($users) > 0)
                    <ul class="user-list" style="list-style:none;padding:0;margin:0;">
                        @foreach($users as $u)
                        <li class="user-item" style="display:flex;align-items:center;justify-content:space-between;gap:16px;padding:24px 32px;border-bottom:1px solid #f3f3f3;min-height:72px;">
                            <a href="{{ route('user.profile', $u->id_user) }}" style="display:flex;align-items:center;gap:16px;text-decoration:none;color:inherit;flex:1;">
                                <div class="avatar" style="width:48px;height:48px;border-radius:50%;background:#f0f0f0;overflow:hidden;display:flex;align-items:center;justify-content:center;">
                                    @if($u->hinhanh)
                                        <img src="data:image/jpeg;base64,{{ base64_encode($u->hinhanh) }}" alt="avatar" style="width:100%;height:100%;object-fit:cover;" />
                                    @else
                                        <i class="fas fa-user-circle" style="font-size:2rem;color:#ccc;"></i>
                                    @endif
                                </div>
                                <div class="user-info" style="flex:1;min-width:0;">
                                    <div class="user-name" style="font-weight:600;font-size:1.1rem;">{{ $u->hoten ?? $u->username }}</div>
                                    <div class="user-meta" style="color:#888;font-size:0.95rem;">{{ $u->email }}</div>
                                </div>
                            </a>
                            <div style="display:flex;align-items:center;gap:12px;">
                                @if(isset($currentUser) && $currentUser && $u->id_user != $currentUser->id_user)
                                    @php
                                        $isFriend = \App\Models\DanhSachBanBe::where(function($q) use ($currentUser, $u) {
                                            $q->where('user_id_1', $currentUser->id_user)->where('user_id_2', $u->id_user);
                                        })->orWhere(function($q) use ($currentUser, $u) {
                                            $q->where('user_id_2', $currentUser->id_user)->where('user_id_1', $u->id_user);
                                        })->exists();
                                    @endphp
                                    @if($isFriend)
                                        <a href="{{ route('friends.chat', $u->id_user) }}" class="action-btn message" style="background:#28a745;color:#fff;padding:8px 20px;border-radius:18px;text-decoration:none;"><i class="fas fa-comments"></i> Nhắn tin</a>
                                    @else
                                        <button class="action-btn add-friend-btn" data-id="{{ $u->id_user }}" style="background:#007bff;color:#fff;padding:8px 20px;border-radius:18px;border:none;font-weight:500;cursor:pointer;"><i class="fas fa-user-plus"></i> Kết bạn</button>
                                    @endif
                                    <!-- Nút cài đặt -->
                                    <div class="user-settings-dropdown" style="position:relative;display:inline-block;margin-left:8px;">
                                        <button class="settings-btn" style="background:none;border:none;cursor:pointer;padding:6px 10px;border-radius:50%;font-size:1.2rem;"><i class="fas fa-ellipsis-v"></i></button>
                                        <div class="settings-menu" style="display:none;position:absolute;right:0;top:120%;background:#fff;border:1px solid #eee;border-radius:12px;box-shadow:0 6px 24px rgba(0,0,0,0.18);min-width:180px;z-index:10;padding:10px 0;">
                                            <button class="settings-action" style="width:100%;padding:14px 24px;border:none;background:none;text-align:left;cursor:pointer;display:flex;align-items:center;gap:10px;font-size:1rem;">
                                                <i class="fas fa-eye-slash" style="width:18px;"></i> Ẩn
                                            </button>
                                            <button class="settings-action" style="width:100%;padding:14px 24px;border:none;background:none;text-align:left;cursor:pointer;display:flex;align-items:center;gap:10px;font-size:1rem;">
                                                <i class="fas fa-user-times" style="width:18px;"></i> Xóa bạn
                                            </button>
                                            <button class="settings-action" style="width:100%;padding:14px 24px;border:none;background:none;text-align:left;cursor:pointer;display:flex;align-items:center;gap:10px;font-size:1rem;color:#e74c3c;">
                                                <i class="fas fa-ban" style="width:18px;"></i> Chặn
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @elseif(isset($query) && $query)
                    <div style="text-align:center;color:#888;margin-top:32px;">Không tìm thấy người dùng phù hợp.</div>
                @endif
            </div>
            <script>
            document.querySelectorAll('.add-friend-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const friendId = this.dataset.id;
                    const button = this;
                    button.disabled = true;
                    button.textContent = 'Đang gửi...';
                    fetch("{{ route('friends.add') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ friend_id: friendId })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            button.textContent = 'Đã gửi kết bạn';
                            button.disabled = true;
                        } else {
                            button.textContent = 'Lỗi';
                            button.disabled = false;
                        }
                    })
                    .catch(() => {
                        button.textContent = 'Lỗi';
                        button.disabled = false;
                    });
                });
            });
            </script>
        @else
            <div class="search-header">
                <form class="search-form" method="GET" action="{{ route('search') }}">
                    <input type="hidden" name="type" value="post">
                    <input type="text" name="q" value="{{ $query }}" placeholder="Tìm kiếm bài viết, tác giả..." class="search-input" required>
                    <select name="filter" class="search-filter">
                        <option value="all" {{ ($filter ?? 'all') == 'all' ? 'selected' : '' }}>Tất cả</option>
                        <option value="title" {{ ($filter ?? '') == 'title' ? 'selected' : '' }}>Tên bài viết</option>
                        <option value="user" {{ ($filter ?? '') == 'user' ? 'selected' : '' }}>Tên người dùng</option>
                    </select>
                    @if(isset($user) && $user)
                    <select name="liked" class="search-filter">
                        <option value="">Tất cả lượt thích</option>
                        <option value="liked" {{ ($liked ?? '') == 'liked' ? 'selected' : '' }}>Đã thích</option>
                        <option value="not_liked" {{ ($liked ?? '') == 'not_liked' ? 'selected' : '' }}>Chưa thích</option>
                    </select>
                    <select name="commented" class="search-filter">
                        <option value="">Tất cả bình luận</option>
                        <option value="commented" {{ ($commented ?? '') == 'commented' ? 'selected' : '' }}>Đã bình luận</option>
                        <option value="not_commented" {{ ($commented ?? '') == 'not_commented' ? 'selected' : '' }}>Chưa bình luận</option>
                    </select>
                    <label style="display:flex;align-items:center;gap:4px;font-size:0.97rem;">
                        <input type="checkbox" name="friend_posts" value="1" {{ ($friendPosts ?? '') == '1' ? 'checked' : '' }} style="margin-right:4px;"> Bài viết của bạn bè
                    </label>
                    @endif
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </form>
            </div>
            <div class="search-results">
                <div class="result-count">
                    Tìm thấy {{ count($baiviets) }} kết quả cho "{{ $query }}"
                </div>
                @if(count($baiviets) > 0)
                    @foreach($baiviets as $post)
                        <div class="post-card">
                            <div class="post-title">
                                <a href="{{ route('post.show', $post->id_baiviet) }}">{{ $post->tieude }}</a>
                            </div>
                            <div class="post-excerpt">
                                {{ Str::limit($post->mota ?? $post->noidung ?? 'Nội dung bài viết...', 200) }}
                            </div>
                            <div class="post-meta">
                                <span><i class="fas fa-user"></i> <a href="{{ route('user.profile', $post->user->id_user) }}">{{ $post->user->hoten ?? $post->user->username ?? 'Tác giả' }}</a></span>
                                <span><i class="fas fa-calendar"></i> {{ $post->thoigiandang ? $post->thoigiandang->format('d/m/Y') : 'N/A' }}</span>
                                <span><i class="fas fa-heart"></i> {{ $post->soluotlike ?? 0 }}</span>
                                @if(isset($user) && $user)
                                    <button class="like-btn {{ in_array($post->id_baiviet, $userLikedPosts) ? 'liked' : '' }}" data-post-id="{{ $post->id_baiviet }}" data-liked="{{ in_array($post->id_baiviet, $userLikedPosts) ? 'true' : 'false' }}">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 16px; color: #ccc;"></i>
                        <p>Không tìm thấy kết quả nào cho "{{ $query }}"</p>
                        <p>Thử tìm kiếm với từ khóa khác</p>
                    </div>
                @endif
            </div>
            @if(isset($user) && $user)
            <script>
                document.querySelectorAll('.like-btn').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        const postId = this.dataset.postId;
                        const isLiked = this.dataset.liked === 'true';
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
                                this.classList.toggle('liked', data.isLiked);
                                const likeCount = this.previousElementSibling;
                                likeCount.innerHTML = `<i class='fas fa-heart'></i> ${data.likeCount}`;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Có lỗi xảy ra khi like bài viết');
                        });
                    });
                });
            </script>
            @endif
        @endif
    </div>
    <script>
document.querySelectorAll('.settings-btn').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        // Ẩn tất cả menu khác
        document.querySelectorAll('.settings-menu').forEach(function(menu) { menu.style.display = 'none'; });
        // Hiện menu của nút này
        btn.nextElementSibling.style.display = 'block';
    });
});
document.addEventListener('click', function() {
    document.querySelectorAll('.settings-menu').forEach(function(menu) { menu.style.display = 'none'; });
});

// Sự kiện Xóa bạn
// Lặp qua tất cả nút Xóa bạn
setTimeout(function() {
    document.querySelectorAll('.settings-action').forEach(function(actionBtn) {
        if(actionBtn.textContent.trim().includes('Xóa bạn')) {
            actionBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var userItem = actionBtn.closest('.user-item');
                actionBtn.closest('.settings-menu').style.display = 'none';
                var messageBtn = userItem.querySelector('.message');
                if(messageBtn) {
                    // Đổi thành nút Kết bạn
                    messageBtn.outerHTML = '<button class="action-btn add-friend-btn" style="background:#007bff;color:#fff;padding:8px 20px;border-radius:18px;border:none;font-weight:500;cursor:pointer;"><i class=\'fas fa-user-plus\'></i> Kết bạn</button>';
                }
                // Thêm sự kiện cho nút Kết bạn vừa tạo
                var newBtn = userItem.querySelector('.add-friend-btn');
                if(newBtn) {
                    newBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        newBtn.innerHTML = '<i class="fas fa-user-check"></i> Đã gửi lời mời';
                        newBtn.style.background = '#6c757d';
                        newBtn.disabled = true;
                    });
                }
            });
        }
    });
}, 300);
</script>
</body>
</html> 