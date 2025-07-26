<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->hoten ?? $user->username ?? 'User' }} - Hồ sơ cá nhân</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Roboto', Arial, sans-serif; 
            background:rgb(160, 178, 250); 
            margin: 0; }

        /* .profile-banner { width: 100%; 
            height: 240px; 
            background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%); 
            position: relative; 
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        } */

        .profile-banner {
            width: 100%;
            height: 240px;
            background: url('/images/beach.jpg') center center / cover no-repeat;
            position: relative;
            border-radius: 0 0 32px 32px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            }

        .dark-theme .profile-banner {
            background: url('/images/beach.jpg') center center / cover no-repeat !important;
            }

        .container { width: 90%; 
            max-width: 1400px; 
            margin: 10px auto 40px auto; 
            padding: 0 16px; 
            box-sizing: border-box;
        }

        .profile-card { background: #fff; 
            border-radius: 18px; 
            box-shadow: 0 2px 16px rgba(0,0,0,0.09); 
            padding: 36px 40px 24px 40px; 
            margin-bottom: 28px; 
            position: relative;
        }

        .profile-grid { display: grid; grid-template-columns: 180px 1fr; gap: 32px; align-items: center; }
        .avatar-wrap { display: flex; flex-direction: column; align-items: center; }
        .avatar { width: 160px; height: 160px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 7px solid #fff; box-shadow: 0 4px 16px rgba(0,0,0,0.13); position: relative; transition: box-shadow 0.2s; }
        .avatar:hover { box-shadow: 0 8px 32px rgba(0,123,255,0.18); }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        .avatar i { font-size: 5rem; color: #ccc; }
        .edit-avatar-btn { margin-top: 10px; color: #007bff; background: none; border: none; cursor: pointer; font-size: 1rem; display: none; }
        .avatar-wrap:hover .edit-avatar-btn { display: block; }
        .user-details { display: flex; flex-direction: column; gap: 8px; }
        .username { font-size: 2.3rem; font-weight: 900; color: #222; margin-bottom: 2px; font-family: 'Times New Roman', Times, serif; }
        .fullname { font-size: 1.2rem; color: #007bff; font-weight: 500; margin-bottom: 6px; }
        .bio { font-size: 1.05rem; color: #444; margin-bottom: 10px; font-style: italic; }
        .user-meta { display: flex; flex-wrap: wrap; gap: 18px; font-size: 1rem; color: #555; margin-bottom: 10px; }
        .user-meta i { margin-right: 6px; color: #007bff; }
        .profile-actions { margin-top: 10px; }
        .action-btn { padding: 10px 28px; border-radius: 22px; border: none; cursor: pointer; font-weight: 600; font-size: 1rem; margin-right: 10px; transition: background 0.2s, box-shadow 0.2s; box-shadow: 0 2px 8px rgba(0,123,255,0.08); }
        .action-btn.edit { background: #fff; color: #007bff; border: 2px solid #007bff; }
        .action-btn.edit:hover { background: #007bff; color: #fff; box-shadow: 0 4px 16px rgba(0,123,255,0.13); }
        .action-btn.following { background: #e9ecef; color: #6c757d; }
        .action-btn.not-following { background: #007bff; color: white; }
        .action-btn.not-following:hover { background: #0056b3; }
        .stats-row { display: flex; gap: 32px; margin: 18px 0 0 0; }
        .stat-card { background: #f6f7fb; border-radius: 12px; padding: 18px 28px; text-align: center; box-shadow: 0 1px 4px rgba(0,0,0,0.04); min-width: 110px; transition: box-shadow 0.2s; }
        .stat-card:hover { box-shadow: 0 4px 16px rgba(0,123,255,0.10); }
        .stat-number { font-size: 1.5rem; font-weight: 700; color: #007bff; }
        .stat-label { font-size: 0.95rem; color: #888; }
        .posts-section { background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.07); padding: 36px 40px; }
        .section-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 24px; color: #222; }
        .post-item { border-bottom: 1px solid #eee; padding: 20px 0; transition: background 0.15s; }
        .post-item:last-child { border-bottom: none; }
        .post-item:hover { background:rgb(97, 97, 97); border-radius: 8px;}
        .post-title { font-size: 1.2rem; font-weight: 600; margin-bottom: 8px; }
        .post-title a { color: #222; text-decoration: none; }
        .post-meta { font-size: 0.9rem; color: #888; }
        .back-link { display: inline-block; margin-bottom: 18px; color:rgb(255, 255, 255); text-decoration: none; font-size: 1.6rem; font-weight: 700; font-family: 'Times New Roman', Times, serif;}
        @media (max-width: 900px) {
            .container, .posts-section, .profile-card { padding: 16px !important; }
            .profile-grid { grid-template-columns: 1fr; gap: 18px; }
            .avatar { width: 110px; height: 110px; }
        }
        /* DARK THEME OVERRIDES */
        .dark-theme {
            background: #181a1b !important;
            color: #f1f1f1 !important;
        }
        .dark-theme .profile-card, .dark-theme .posts-section {
            background: #23272b !important;
            color: #f1f1f1 !important;
        }
        .dark-theme .username, .dark-theme .fullname, .dark-theme .bio {
            color: #f1f1f1 !important;
        }
        .dark-theme .user-meta, .dark-theme .post-meta {
            color: #bbb !important;
        }
        .dark-theme .user-meta i, .dark-theme .section-title, .dark-theme .stat-number {
            color: #4dc3ff !important;
        }
        .dark-theme .stat-card {
            background: #181a1b !important;
            color: #f1f1f1 !important;
            border: 1px solid #333 !important;
        }
        .dark-theme .stat-label {
            color: #bbb !important;
        }
        .dark-theme .action-btn, .dark-theme .action-btn.edit {
            background: #23272b !important;
            color: #4dc3ff !important;
            border-color: #4dc3ff !important;
        }
        .dark-theme .action-btn.edit:hover {
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
        /* .dark-theme .profile-banner {
            background: linear-gradient(90deg,rgb(111, 131, 153) 0%,rgb(51, 92, 112) 100%) !important;
        } */
        .dark-theme .avatar {
            background: #23272b !important;
            border-color: #bbb !important;
        }
        .dark-theme .avatar i {
            color: #bbb !important;
        }
        .dark-theme .post-item {
            border-bottom: 1px solid #333 !important;
        }
        .dark-theme .post-title a {
            color: #f1f1f1 !important;
        }
        .dark-theme .back-link {
            color: #4dc3ff !important;
        }
    </style>
</head>
<body>
    <div class="profile-banner"></div>
    <div class="container">
        <a href="{{ route('home') }}" class="back-link"><i class="fas fa-arrow-left"></i> Về trang chủ</a>
        <div class="profile-card">
            <div class="profile-grid">
                <div class="avatar-wrap">
                    <div class="avatar">
                        @if($user->hinhanh)
                            <img src="data:image/jpeg;base64,{{ base64_encode($user->hinhanh) }}" alt="avatar">
                        @else
                            <i class="fas fa-user-circle"></i>
                        @endif
                    </div>
                </div>
                <div class="user-details">
                    <div class="username">{{ $user->hoten ?? $user->username ?? 'User' }}</div>
                    <div class="fullname">{{ '@'.$user->username }}</div>
                    @if(isset($currentUser) && $currentUser && $currentUser->id_user != $user->id_user)
                        <button id="followBtn" class="action-btn {{ $isFollowing ? 'following' : 'not-following' }}" data-user-id="{{ $user->id_user }}" data-following="{{ $isFollowing ? 'true' : 'false' }}">
                            <span id="followBtnText">{{ $isFollowing ? 'Đang theo dõi' : 'Theo dõi' }}</span>
                        </button>
                    @endif
                    @if(isset($user->bio))
                        <div class="bio">{{ $user->bio }}</div>
                    @endif
                    <div class="user-meta">
                        <div><i class="fas fa-envelope"></i> {{ $user->email }}</div>
                        @if($user->sodienthoai)
                        <div><i class="fas fa-phone"></i> {{ $user->sodienthoai }}</div>
                        @endif
                        @if($user->diachi)
                        <div><i class="fas fa-map-marker-alt"></i> {{ $user->diachi }}</div>
                        @endif
                        @if($user->gioitinh !== null)
                        <div><i class="fas fa-venus-mars"></i> {{ $user->gioitinh == 1 ? 'Nam' : ($user->gioitinh == 0 ? 'Nữ' : 'Khác') }}</div>
                        @endif
                        <div><i class="fas fa-calendar-alt"></i> Tham gia: {{ $user->ngaytao ? date('d/m/Y', strtotime($user->ngaytao)) : '' }}</div>
                        <div><i class="fas fa-user-check"></i> Trạng thái: {{ $user->trangthai ? 'Hoạt động' : 'Khoá' }}</div>
                    </div>
                    @if(isset($currentUser) && $currentUser && $currentUser->id_user == $user->id_user)
                    <div class="profile-actions" style="margin:18px 0 10px 0;display:flex;gap:12px;flex-wrap:wrap;">
                        <a href="{{ route('profile.edit', $user->id_user) }}" class="action-btn edit"><i class="fas fa-edit"></i> Chỉnh sửa hồ sơ</a>
                        <a href="{{ route('post.create') }}" class="action-btn" style="background:#28a745;color:#fff;"><i class="fas fa-pen"></i> Viết bài</a>
                        <div class="action-btn" style="position:relative;display:inline-block;background:#f8f9fa;color:#007bff;min-width:120px;" id="settingsBtn">
                            <i class="fas fa-cog"></i> Cài đặt
                            <div id="settingsDropdown" style="display:none;position:absolute;top:110%;left:0;min-width:180px;background:#fff;border-radius:10px;box-shadow:0 2px 12px rgba(0,0,0,0.13);z-index:10;overflow:hidden;">
                                <a href="{{ route('logout') }}" class="dropdown-item" style="display:block;padding:12px 18px;color:#222;text-decoration:none;"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                                <button type="button" onclick="toggleTheme()" class="dropdown-item" style="width:100%;text-align:left;padding:12px 18px;border:none;background:none;color:#222;cursor:pointer;"><i class="fas fa-adjust"></i> Đổi theme sáng/tối</button>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="stats-row">
                        <div class="stat-card" style="cursor:pointer;" onclick="showModal('followersModal')">
                            <div class="stat-number" id="followersCount">{{ $followersCount }}</div>
                            <div class="stat-label">Followers</div>
                        </div>
                        <div class="stat-card" style="cursor:pointer;" onclick="showModal('followingModal')">
                            <div class="stat-number">{{ $followingCount }}</div>
                            <div class="stat-label">Following</div>
                        </div>
                        <div class="stat-card" style="cursor:pointer;" onclick="showModal('postsModal')">
                            <div class="stat-number">{{ count($posts) }}</div>
                            <div class="stat-label">Bài viết</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="posts-section">
            <h2 class="section-title">Bài viết của {{ $user->hoten ?? $user->username ?? 'User' }}</h2>
            @if(count($posts) > 0)
                @foreach($posts as $post)
                    <div class="post-item">
                        <div class="post-title">
                            <a href="{{ route('post.show', $post->id_baiviet) }}">{{ $post->tieude }}</a>
                        </div>
                        <div class="post-meta">
                            <i class="fas fa-calendar"></i> {{ $post->thoigiandang ? $post->thoigiandang->format('d/m/Y H:i') : '' }}
                            <i class="fas fa-heart" style="margin-left: 16px;"></i> {{ $post->soluotlike ?? 0 }}
                        </div>
                    </div>
                @endforeach
            @else
                <p style="color: #888; text-align: center;">Chưa có bài viết nào.</p>
            @endif
        </div>
    </div>
    <!-- Modal Followers -->
    <div id="followersModal" class="custom-modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"><b>Danh sách người theo dõi</b></span>
                <span class="modal-close" onclick="closeModal('followersModal')">&times;</span>
            </div>
            <div class="modal-body">
                @forelse($followers as $follower)
                    <div class="follower-row">
                        <img src="{{ $follower->hinhanh ? 'data:image/jpeg;base64,'.base64_encode($follower->hinhanh) : '/public/images/default-avatar.png' }}" class="avatar" style="width:40px;height:40px;border-radius:50%;margin-right:12px;">
                        <a href="{{ route('user.profile', $follower->id_user) }}" class="follower-name" style="color:#6c2eb7;text-decoration:underline;font-size:17px;">{{ $follower->hoten ?? $follower->username }}</a>
                    </div>
                @empty
                    <div style="color:#888;text-align:center;padding:16px;">Chưa có người theo dõi nào.</div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Modal Following -->
    <div id="followingModal" class="custom-modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"><b>Danh sách đang theo dõi</b></span>
                <span class="modal-close" onclick="closeModal('followingModal')">&times;</span>
            </div>
            <div class="modal-body">
                @forelse($following as $followed)
                    <div class="follower-row">
                        <img src="{{ $followed->hinhanh ? 'data:image/jpeg;base64,'.base64_encode($followed->hinhanh) : '/public/images/default-avatar.png' }}" class="avatar" style="width:40px;height:40px;border-radius:50%;margin-right:12px;">
                        <a href="{{ route('user.profile', $followed->id_user) }}" class="follower-name" style="color:#6c2eb7;text-decoration:underline;font-size:17px;">{{ $followed->hoten ?? $followed->username }}</a>
                    </div>
                @empty
                    <div style="color:#888;text-align:center;padding:16px;">Chưa theo dõi ai.</div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Modal Bài viết -->
    <div id="postsModal" class="custom-modal" style="display:none;">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title"><b>Danh sách bài viết</b></span>
                <span class="modal-close" onclick="closeModal('postsModal')">&times;</span>
            </div>
            <div class="modal-body">
                @forelse($posts as $post)
                    <div class="follower-row">
                        <a href="{{ route('post.show', $post->id_baiviet) }}" style="color:#007bff;text-decoration:underline;font-size:17px;">{{ $post->tieude }}</a>
                        <span style="color:#888;font-size:13px;margin-left:8px;">({{ $post->thoigiandang ? $post->thoigiandang->format('d/m/Y H:i') : '' }})</span>
                    </div>
                @empty
                    <div style="color:#888;text-align:center;padding:16px;">Chưa có bài viết nào.</div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
    .custom-modal {
        position: fixed;
        z-index: 9999;
        left: 0; top: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-content {
        background: #fff;
        border-radius: 16px;
        width: 400px;
        max-width: 90vw;
        box-shadow: 0 2px 16px rgba(0,0,0,0.2);
        padding: 0;
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px 8px 24px;
    }
    .modal-title { font-size: 20px; }
    .modal-close {
        font-size: 28px;
        cursor: pointer;
        color: #888;
    }
    .modal-body {
        padding: 0 24px 16px 24px;
    }
    .follower-row {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding: 12px 0;
    }
    </style>
    <script>
    function showModal(id) {
        document.getElementById('followersModal').style.display = 'none';
        document.getElementById('followingModal').style.display = 'none';
        document.getElementById('postsModal').style.display = 'none';
        document.getElementById(id).style.display = 'flex';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
    window.onclick = function(event) {
        ['followersModal','followingModal','postsModal'].forEach(function(mid){
            var modal = document.getElementById(mid);
            if(modal && event.target === modal) modal.style.display = 'none';
        });
    }
    </script>
    @if($currentUser && $currentUser->id_user != $user->id_user)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var followBtn = document.getElementById('followBtn');
            if(followBtn) {
                followBtn.addEventListener('click', function() {
                    var userId = this.dataset.userId;
                    var isFollowing = this.dataset.following === 'true';
                    var btn = this;
                    var btnText = document.getElementById('followBtnText');
                    btn.disabled = true;
                    btnText.textContent = 'Đang xử lý...';
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
                            btn.dataset.following = data.isFollowing ? 'true' : 'false';
                            btnText.textContent = data.isFollowing ? 'Đang theo dõi' : 'Theo dõi';
                            btn.className = `action-btn ${data.isFollowing ? 'following' : 'not-following'}`;
                            // Cập nhật số followers
                            var followersCount = document.getElementById('followersCount');
                            if(followersCount) {
                                var currentCount = parseInt(followersCount.textContent);
                                followersCount.textContent = data.isFollowing ? currentCount + 1 : currentCount - 1;
                            }
                        } else {
                            btnText.textContent = 'Thử lại';
                        }
                        btn.disabled = false;
                    })
                    .catch(error => {
                        btnText.textContent = 'Lỗi!';
                        btn.disabled = false;
                    });
                });
            }
            // Dropdown settings
            const settingsBtn = document.getElementById('settingsBtn');
            const settingsDropdown = document.getElementById('settingsDropdown');
            if(settingsBtn && settingsDropdown) {
                settingsBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    settingsDropdown.style.display = settingsDropdown.style.display === 'block' ? 'none' : 'block';
                });
                document.addEventListener('click', function(e) {
                    if (!settingsBtn.contains(e.target)) {
                        settingsDropdown.style.display = 'none';
                    }
                });
            }
            // Theme toggle
            window.toggleTheme = function() {
                if(document.body.classList.contains('dark-theme')) {
                    document.body.classList.remove('dark-theme');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.body.classList.add('dark-theme');
                    localStorage.setItem('theme', 'dark');
                }
            }
            if(localStorage.getItem('theme') === 'dark') {
                document.body.classList.add('dark-theme');
            }
        });
    </script>
    @endif
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dropdown settings cho nút cài đặt
        const settingsBtn = document.getElementById('settingsBtn');
        const settingsDropdown = document.getElementById('settingsDropdown');
        if(settingsBtn && settingsDropdown) {
            settingsBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                settingsDropdown.style.display = settingsDropdown.style.display === 'block' ? 'none' : 'block';
            });
            document.addEventListener('click', function(e) {
                if (!settingsBtn.contains(e.target)) {
                    settingsDropdown.style.display = 'none';
                }
            });
        }
        // Theme toggle
        window.toggleTheme = function() {
            if(document.body.classList.contains('dark-theme')) {
                document.body.classList.remove('dark-theme');
                localStorage.setItem('theme', 'light');
            } else {
                document.body.classList.add('dark-theme');
                localStorage.setItem('theme', 'dark');
            }
        }
        if(localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-theme');
        }
    });
    </script>
</body>
</html> 