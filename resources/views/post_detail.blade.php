<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->tieude ?? 'Bài viết' }} - SpiderClone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', Arial, sans-serif; background: #f6f7fb; margin: 0; }
        .container { max-width: 800px; margin: 40px auto; background: #fff; border-radius: 14px; box-shadow: 0 2px 16px rgba(0,0,0,0.07); padding: 36px 40px; }
        .post-title { font-size: 2.1rem; font-weight: 700; margin-bottom: 12px; color: #222; }
        .post-meta { color: #888; font-size: 1rem; margin-bottom: 18px; }
        .post-cover { width: 100%; max-height: 340px; object-fit:cover; border-radius: 10px; margin-bottom: 18px; }
        .post-content { font-size: 1.15rem; color: #222; line-height: 1.7; margin-bottom: 24px; white-space: pre-line; }
        .post-tags { color: #007bff; font-size: 1rem; margin-bottom: 10px; }
        .back-link { display:inline-block; margin-bottom:18px; color:#007bff; text-decoration:underline; }
        .comment-item {
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 16px;
        }
        .replies-list {
            margin-left: 40px;   /* Thụt vào 40px */
            margin-top: 10px;
        }
        .reply-item {
            background: #f4f6fa;
            border-radius: 8px;
            margin-bottom: 12px;
            padding: 12px;
            border-left: 3px solid #007bff; /* Viền xanh nổi bật */
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('home') }}" class="back-link"><i class="fas fa-arrow-left"></i> Về trang chủ</a>
        <div class="post-title">{{ $post->tieude }}</div>
        <div class="post-meta">
            <span><i class="fas fa-user"></i> <a href="{{ route('user.profile', $post->user->id_user) }}" style="color: inherit; text-decoration: underline;">{{ $post->user->hoten ?? $post->user->username ?? 'Tác giả' }}</a></span>
            &nbsp;|&nbsp;
            <span><i class="fas fa-calendar"></i> {{ $post->thoigiandang ? $post->thoigiandang->format('d/m/Y H:i') : '' }}</span>
            @if(isset($user) && $user && $user->id_user != $post->user->id_user)
            &nbsp;|&nbsp;
            <button id="followBtn" class="follow-btn" data-user-id="{{ $post->user->id_user }}" data-following="{{ $user->isFollowing($post->user->id_user) ? 'true' : 'false' }}" style="background: none; border: 1px solid #007bff; color: #007bff; padding: 4px 12px; border-radius: 12px; cursor: pointer; font-size: 0.9rem;">
                {{ $user->isFollowing($post->user->id_user) ? 'Đang theo dõi' : 'Theo dõi' }}
            </button>
            @endif
        </div>
        @if($post->anh_bia)
            <img src="{{ asset($post->anh_bia) }}" alt="Ảnh bìa" class="post-cover">
        @endif
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
            <button onclick="changeFontSize(1)" style="background:#e0e0e0;border:none;border-radius:6px;padding:6px 14px;cursor:pointer;font-size:1.1rem;">A+</button>
            <button onclick="changeFontSize(-1)" style="background:#e0e0e0;border:none;border-radius:6px;padding:6px 14px;cursor:pointer;font-size:1.1rem;">A-</button>
        </div>
        <div class="post-content">{!! $post->noidung !!}</div>
        @if($post->dinhkhem)
            <div class="post-tags"><i class="fas fa-tags"></i> {{ $post->dinhkhem }}</div>
        @endif
        <div class="post-actions" style="margin-top: 20px; display: flex; align-items: center; gap: 16px;">
            <div class="like-section" style="display: flex; align-items: center; gap: 8px;">
                <span class="like-count" style="font-weight: 500; color: #333;">{{ $post->soluotlike ?? 0 }}</span>
                @if(isset($user) && $user)
                    <button id="likeBtn" data-post-id="{{ $post->id_baiviet }}" data-liked="{{ $userLiked ? 'true' : 'false' }}" style="background:none;border:none;cursor:pointer;color:{{ $userLiked ? '#e74c3c' : '#ccc' }};font-size:1.2rem;">
                        <i class="fas fa-heart"></i>
                    </button>
                @else
                    <i class="fas fa-heart" style="color:#ccc;font-size:1.2rem;"></i>
                @endif
            </div>
        </div>

        <!-- Phần comment mới đẹp, hỗ trợ lồng nhiều cấp -->
        <div class="comments-section" style="margin-top: 48px; border-top: 1px solid #eee; padding-top: 36px;">
            <h3 style="margin-bottom: 24px; font-size: 1.35rem; color: #222; font-weight: 700; letter-spacing: 0.5px;">
                <i class="fas fa-comments"></i> Bình luận
            </h3>
            @if(isset($user) && $user)
            <form id="commentForm" style="display: flex; gap: 14px; align-items: flex-start; margin-bottom: 32px;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->hoten ?? $user->username ?? 'U') }}&background=007bff&color=fff&size=48" alt="avatar" style="width:48px;height:48px;border-radius:50%;object-fit:cover;box-shadow:0 2px 8px rgba(0,0,0,0.07);">
                <textarea id="commentContent" name="noidung" placeholder="Viết bình luận của bạn..." style="flex: 1; padding: 14px 16px; border: 1.5px solid #e0e3eb; border-radius: 12px; resize: vertical; min-height: 56px; font-family: inherit; font-size: 1.05rem; background: #f8fafd;"></textarea>
                <button type="button" id="sendCommentBtn" style="padding: 14px 22px; background: linear-gradient(90deg,#007bff,#00c6ff); color: white; border: none; border-radius: 12px; cursor: pointer; font-weight: 600; font-size: 1.05rem; box-shadow:0 2px 8px rgba(0,123,255,0.08); transition: background 0.2s;">
                    <i class="fas fa-paper-plane"></i> Gửi
                </button>
            </form>
            @else
            <div style="margin-bottom: 32px; color: #888; font-size: 1.05rem;">Bạn cần <a href="{{ route('login') }}" style="color:#007bff;text-decoration:underline;">đăng nhập</a> để bình luận.</div>
            @endif
            <div id="commentsList">
                {{-- Hiển thị bình luận ghim nếu có --}}
                @if($post->pinnedComment)
                <div class="comment-item" data-comment-id="{{ $post->pinnedComment->id_binhluan }}" style="background:#eaf6ff;border:2px solid #007bff;position:relative;box-shadow:0 2px 8px rgba(0,123,255,0.08);margin-bottom:28px;">
                    <span style="position:absolute;top:10px;right:18px;color:#007bff;font-weight:700;font-size:1.1rem;"><i class="fas fa-thumbtack"></i> Được ghim</span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($post->pinnedComment->user->hoten ?? $post->pinnedComment->user->username ?? 'U') }}&background=007bff&color=fff&size=40" alt="avatar" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                    <div style="flex:1;display:inline-block;vertical-align:top;margin-left:12px;">
                        <div style="font-weight:600;color:#222;">{{ $post->pinnedComment->user->hoten ?? $post->pinnedComment->user->username ?? 'Tác giả' }} <span style="color:#888;font-size:0.95em;font-weight:400;margin-left:8px;">• {{ $post->pinnedComment->thoigiantao ? $post->pinnedComment->thoigiantao->diffForHumans() : '' }}</span></div>
                        <div style="color:#333;line-height:1.6;margin:6px 0 0 0;">{{ $post->pinnedComment->noidung }}</div>
                    </div>
                </div>
                @endif
                @foreach($comments as $comment)
                <div class="comment-item" data-comment-id="{{ $comment->id_binhluan }}" style="display:flex;gap:14px;align-items:flex-start;position:relative;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->hoten ?? $comment->user->username ?? 'U') }}&background=6c757d&color=fff&size=40" alt="avatar" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                    <div style="flex:1;">
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <div style="font-weight:600;color:#222;">{{ $comment->user->hoten ?? $comment->user->username ?? 'Tác giả' }} <span style="color:#888;font-size:0.95em;font-weight:400;margin-left:8px;">• {{ $comment->thoigiantao ? $comment->thoigiantao->diffForHumans() : '' }}</span></div>
                            <div class="comment-actions" style="position:relative;">
                                <button class="more-btn" data-comment-id="{{ $comment->id_binhluan }}" style="background:none;border:none;font-size:1.4rem;cursor:pointer;color:#888;padding:0 8px;">&#8230;</button>
                                <div class="more-menu" id="menu-{{ $comment->id_binhluan }}" style="display:none;position:absolute;right:0;top:28px;z-index:10;background:#fff;border:1px solid #eee;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);min-width:120px;">
                                    <button class="menu-item" style="width:100%;background:none;border:none;padding:10px 18px;text-align:left;cursor:pointer;font-size:1rem;color:#222;">Chỉnh sửa</button>
                                    <button class="menu-item" style="width:100%;background:none;border:none;padding:10px 18px;text-align:left;cursor:pointer;font-size:1rem;color:#e74c3c;">Xóa</button>
                                    <button class="menu-item" style="width:100%;background:none;border:none;padding:10px 18px;text-align:left;cursor:pointer;font-size:1rem;color:#007bff;">Ghim</button>
                                </div>
                            </div>
                        </div>
                        <div style="color:#333;line-height:1.6;margin:6px 0 0 0;">{{ $comment->noidung }}</div>
                        <button class="reply-btn" data-comment-id="{{ $comment->id_binhluan }}" style="margin-top:8px;background:none;border:none;color:#007bff;cursor:pointer;font-size:0.97rem;font-weight:500;">Trả lời</button>
                        <!-- Form trả lời inline, ẩn mặc định -->
                        <form class="reply-form" data-parent-id="{{ $comment->id_binhluan }}" style="display:none;gap:10px;align-items:flex-start;margin-top:10px;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->hoten ?? $user->username ?? 'U') }}&background=007bff&color=fff&size=32" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                            <textarea placeholder="Trả lời bình luận này..." style="flex:1;padding:10px 12px;border:1.5px solid #e0e3eb;border-radius:10px;resize:vertical;min-height:40px;font-family:inherit;font-size:1rem;background:#f8fafd;"></textarea>
                            <button type="button" class="sendReplyBtn" data-parent-id="{{ $comment->id_binhluan }}" style="padding:10px 18px;background:linear-gradient(90deg,#007bff,#00c6ff);color:white;border:none;border-radius:10px;cursor:pointer;font-weight:600;font-size:1rem;">Gửi</button>
                        </form>
                        <!-- Reply cấp 2 -->
                        @if($comment->replies && $comment->replies->count())
                        <div class="replies-list" style="margin-left:40px;margin-top:10px;">
                            @foreach($comment->replies as $reply)
                            <div class="comment-item" data-comment-id="{{ $reply->id_binhluan }}" style="display:flex;gap:14px;align-items:flex-start;background:#f4f6fa;position:relative;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($reply->user->hoten ?? $reply->user->username ?? 'U') }}&background=17a2b8&color=fff&size=36" alt="avatar" style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                                <div style="flex:1;">
                                    <div style="display:flex;align-items:center;justify-content:space-between;">
                                        <div style="font-weight:600;color:#222;">{{ $reply->user->hoten ?? $reply->user->username ?? 'Tác giả' }} <span style="color:#888;font-size:0.95em;font-weight:400;margin-left:8px;">• {{ $reply->thoigiantao ? $reply->thoigiantao->diffForHumans() : '' }}</span></div>
                                        <div class="comment-actions" style="position:relative;">
                                            <button class="more-btn" data-comment-id="{{ $reply->id_binhluan }}" style="background:none;border:none;font-size:1.4rem;cursor:pointer;color:#888;padding:0 8px;">&#8230;</button>
                                            <div class="more-menu" id="menu-{{ $reply->id_binhluan }}" style="display:none;position:absolute;right:0;top:28px;z-index:10;background:#fff;border:1px solid #eee;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);min-width:120px;">
                                                <button class="menu-item" style="width:100%;background:none;border:none;padding:10px 18px;text-align:left;cursor:pointer;font-size:1rem;color:#222;">Chỉnh sửa</button>
                                                <button class="menu-item" style="width:100%;background:none;border:none;padding:10px 18px;text-align:left;cursor:pointer;font-size:1rem;color:#e74c3c;">Xóa</button>
                                                <button class="menu-item" style="width:100%;background:none;border:none;padding:10px 18px;text-align:left;cursor:pointer;font-size:1rem;color:#007bff;">Ghim</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="color:#333;line-height:1.6;margin:6px 0 0 0;">{{ $reply->noidung }}</div>
                                    <button class="reply-btn" data-comment-id="{{ $comment->id_binhluan }}" style="margin-top:8px;background:none;border:none;color:#007bff;cursor:pointer;font-size:0.97rem;font-weight:500;">Trả lời</button>
                                    <!-- Form trả lời inline, ẩn mặc định -->
                                    <form class="reply-form" data-parent-id="{{ $comment->id_binhluan }}" style="display:none;gap:10px;align-items:flex-start;margin-top:10px;">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->hoten ?? $user->username ?? 'U') }}&background=007bff&color=fff&size=32" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                                        <textarea placeholder="Trả lời bình luận này..." style="flex:1;padding:10px 12px;border:1.5px solid #e0e3eb;border-radius:10px;resize:vertical;min-height:40px;font-family:inherit;font-size:1rem;background:#f8fafd;"></textarea>
                                        <button type="button" class="sendReplyBtn" data-parent-id="{{ $comment->id_binhluan }}" style="padding:10px 18px;background:linear-gradient(90deg,#007bff,#00c6ff);color:white;border:none;border-radius:10px;cursor:pointer;font-weight:600;font-size:1rem;">Gửi</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
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
                body: JSON.stringify({ noidung: content })
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
                    body: JSON.stringify({ noidung: content, parent_id: parentId })
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
   
    @if(isset($user) && $user && $user->id_user != $post->user->id_user)
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
                    if (!newContent) { alert('Nội dung không được để trống!'); return; }
                    fetch('/comment/' + commentId, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ noidung: newContent })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            contentDiv.textContent = data.noidung;
                            textarea.remove(); saveBtn.remove(); cancelBtn.remove();
                            contentDiv.style.display = '';
                        } else {
                            alert(data.error || 'Có lỗi xảy ra!');
                        }
                    })
                    .catch(() => alert('Có lỗi xảy ra!'));
                };
                // Hủy
                cancelBtn.onclick = function() {
                    textarea.remove(); saveBtn.remove(); cancelBtn.remove();
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
                @if(!isset($user) || $user->id_user != $post->user->id_user)
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