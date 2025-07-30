<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kết quả tìm kiếm: "{{ $query }}" - ChatPost</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #6366f1;
            --primary-dark: #3730a3;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --surface-primary: #ffffff;
            --surface-secondary: #f8fafc;
            --surface-tertiary: #f1f5f9;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-tertiary: #94a3b8;
            --border-primary: #e2e8f0;
            --border-secondary: #cbd5e1;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-xl: 16px;
            --radius-2xl: 24px;
            --radius-full: 9999px;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--surface-secondary);
            color: var(--text-primary);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .back-link:hover {
            color: var(--primary-dark);
            transform: translateX(-2px);
        }

        .search-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            background: var(--surface-primary);
            padding: 8px;
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-sm);
        }

        .search-tabs a {
            padding: 12px 24px;
            border-radius: var(--radius-lg);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
            flex: 1;
            text-align: center;
        }

        .search-tabs a:not(.active) {
            background: transparent;
            color: var(--text-secondary);
        }

        .search-tabs a.active {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .search-header {
            background: var(--surface-primary);
            border-radius: var(--radius-2xl);
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-primary);
        }

        .search-form {
            display: flex;
            gap: 16px;
            margin-bottom: 0;
            flex-wrap: wrap;
            align-items: center;
        }

        .search-input {
            flex: 1;
            min-width: 300px;
            padding: 16px 20px;
            border: 2px solid var(--border-primary);
            border-radius: var(--radius-xl);
            font-size: 16px;
            font-weight: 500;
            background: var(--surface-secondary);
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background: var(--surface-primary);
        }

        .search-btn {
            padding: 16px 32px;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: var(--radius-xl);
            cursor: pointer;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-md);
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .search-results {
            background: var(--surface-primary);
            border-radius: var(--radius-2xl);
            padding: 0;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-primary);
            overflow: hidden;
        }

        .result-count {
            color: var(--text-secondary);
            margin-bottom: 0;
            padding: 32px 32px 0;
            font-weight: 600;
        }

        .user-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .user-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 24px 32px;
            border-bottom: 1px solid var(--border-primary);
            transition: all 0.2s ease;
        }

        .user-item:hover {
            background: var(--surface-secondary);
        }

        .user-item:last-child {
            border-bottom: none;
        }

        .user-item a {
            display: flex;
            align-items: center;
            gap: 20px;
            text-decoration: none;
            color: inherit;
            flex: 1;
        }

        .avatar {
            width: 56px;
            height: 56px;
            border-radius: var(--radius-full);
            background: var(--surface-tertiary);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--border-primary);
            transition: all 0.2s ease;
        }

        .user-item:hover .avatar {
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar i {
            font-size: 24px;
            color: var(--text-tertiary);
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-weight: 700;
            font-size: 18px;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .user-meta {
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .action-btn {
            padding: 12px 24px;
            border-radius: var(--radius-full);
            border: 2px solid;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .action-btn.follow {
            background: var(--gradient-primary);
            color: white;
            border-color: transparent;
        }

        .action-btn.follow:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .action-btn.message {
            background: var(--success);
            color: white;
            border-color: transparent;
        }

        .action-btn.message:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .action-btn.call-voice {
            background: var(--primary);
            color: white;
            border-color: transparent;
            padding: 12px;
            width: 48px;
            height: 48px;
            justify-content: center;
        }

        .action-btn.call-voice:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .action-btn.call-video {
            background: var(--warning);
            color: white;
            border-color: transparent;
            padding: 12px;
            width: 48px;
            height: 48px;
            justify-content: center;
        }

        .action-btn.call-video:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .settings-dropdown {
            position: relative;
            display: inline-block;
        }

        .settings-btn {
            background: var(--surface-secondary);
            border: 2px solid var(--border-primary);
            cursor: pointer;
            padding: 12px;
            border-radius: var(--radius-full);
            font-size: 16px;
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }

        .settings-btn:hover {
            background: var(--surface-tertiary);
            border-color: var(--border-secondary);
            color: var(--text-primary);
        }

        .settings-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 120%;
            background: var(--surface-primary);
            border: 1px solid var(--border-primary);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-xl);
            min-width: 200px;
            z-index: 10;
            padding: 8px 0;
            overflow: hidden;
        }

        .settings-action {
            width: 100%;
            padding: 16px 24px;
            border: none;
            background: none;
            text-align: left;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
            transition: all 0.2s ease;
        }

        .settings-action:hover {
            background: var(--surface-secondary);
        }

        .settings-action.danger {
            color: var(--error);
        }

        .settings-action.danger:hover {
            background: rgba(239, 68, 68, 0.1);
        }

        .no-results {
            text-align: center;
            color: var(--text-secondary);
            padding: 64px 32px;
        }

        .no-results i {
            font-size: 48px;
            color: var(--text-tertiary);
            margin-bottom: 16px;
            display: block;
        }

        .no-results h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .no-results p {
            font-size: 16px;
            margin-bottom: 0;
        }

        /* Filter inputs styling */
        .search-filter {
            padding: 12px 16px;
            border-radius: var(--radius-lg);
            border: 2px solid var(--border-primary);
            font-size: 14px;
            font-weight: 500;
            background: var(--surface-secondary);
            color: var(--text-primary);
            transition: all 0.2s ease;
            min-width: 140px;
        }

        .search-filter:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background: var(--surface-primary);
        }

        .filter-checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: var(--surface-secondary);
            border: 2px solid var(--border-primary);
            border-radius: var(--radius-lg);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .filter-checkbox-wrapper:has(input:checked) {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .filter-checkbox-wrapper input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: white;
        }

        /* Post search results styling */
        .post-card {
            border-bottom: 1px solid var(--border-primary);
            padding: 32px 0;
            transition: all 0.2s ease;
        }

        .post-card:hover {
            padding-left: 16px;
            border-left: 4px solid var(--primary);
        }

        .post-card:last-child {
            border-bottom: none;
        }

        .post-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .post-title a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .post-title a:hover {
            color: var(--primary);
        }

        .post-excerpt {
            color: var(--text-secondary);
            margin-bottom: 16px;
            line-height: 1.6;
            font-size: 16px;
        }

        .post-meta {
            display: flex;
            align-items: center;
            gap: 24px;
            font-size: 14px;
            color: var(--text-tertiary);
            font-weight: 500;
        }

        .post-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .post-meta i {
            color: var(--primary);
        }

        .post-meta a {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .post-meta a:hover {
            color: var(--primary);
        }

        .like-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-tertiary);
            padding: 6px;
            border-radius: var(--radius-md);
            transition: all 0.2s ease;
        }

        .like-btn:hover {
            background: var(--surface-secondary);
            color: var(--error);
        }

        .like-btn.liked {
            color: var(--error);
            background: rgba(239, 68, 68, 0.1);
        }

        .no-posts {
            text-align: center;
            padding: 64px 32px;
            color: var(--text-secondary);
        }

        .no-posts i {
            font-size: 48px;
            color: var(--text-tertiary);
            margin-bottom: 16px;
            display: block;
        }

        .no-posts h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .no-posts p {
            font-size: 16px;
            margin-bottom: 16px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px 16px;
            }

            .search-header {
                padding: 24px 20px;
            }

            .search-form {
                flex-direction: column;
                align-items: stretch;
            }

            .search-input {
                min-width: unset;
            }

            .search-filter {
                min-width: unset;
            }

            .user-item {
                padding: 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .user-actions {
                width: 100%;
                justify-content: flex-end;
            }

            .post-meta {
                flex-wrap: wrap;
                gap: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="{{ route('home') }}" class="back-link"><i class="fas fa-arrow-left"></i> Về trang chủ</a>

        <div class="search-tabs">
            <a href="{{ route('search', ['type' => 'post', 'q' => $query]) }}" class="{{ ($type ?? 'post') == 'post' ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Bài viết
            </a>
            <a href="{{ route('search', ['type' => 'user', 'q' => $query]) }}" class="{{ ($type ?? '') == 'user' ? 'active' : '' }}">
                <i class="fas fa-users"></i> Người dùng
            </a>
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
            <div class="result-count">
                Tìm thấy {{ count($users) }} người dùng cho "{{ $query }}"
            </div>
            <ul class="user-list">
                @foreach($users as $u)
                <li class="user-item">
                    <a href="{{ route('user.profile', $u->user_id) }}">
                        <div class="avatar">
                            @if($u->hinhanh)
                            <img src="data:image/jpeg;base64,{{ base64_encode($u->hinhanh) }}" alt="avatar" />
                            @else
                            <i class="fas fa-user-circle"></i>
                            @endif
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ $u->hoten ?? $u->username }}</div>
                            <div class="user-meta">{{ $u->email }}</div>
                        </div>
                    </a>
                    <div class="user-actions">
                        @if(isset($currentUser) && $currentUser && $u->user_id != $currentUser->user_id)
                        @php
                        $isFriend = \App\Models\DanhSachBanBe::where(function($q) use ($currentUser, $u) {
                        $q->where('user_id_1', $currentUser->user_id)->where('user_id_2', $u->user_id);
                        })->orWhere(function($q) use ($currentUser, $u) {
                        $q->where('user_id_2', $currentUser->user_id)->where('user_id_1', $u->user_id);
                        })->exists();
                        @endphp
                        @if($isFriend)
                        <button class="action-btn call-voice" data-id="{{ $u->user_id }}" onclick="initiateCall({{ $u->user_id }}, 'voice')">
                            <i class="fas fa-phone"></i>
                        </button>
                        <button class="action-btn call-video" data-id="{{ $u->user_id }}" onclick="initiateCall({{ $u->user_id }}, 'video')">
                            <i class="fas fa-video"></i>
                        </button>
                        <a href="{{ route('friends.chat', $u->user_id) }}" class="action-btn message">
                            <i class="fas fa-comments"></i>
                        </a>
                        @else
                        <button class="action-btn follow follow-btn" data-id="{{ $u->user_id }}">
                            <i class="fas fa-plus"></i> Follow
                        </button>
                        @endif
                        <!-- Settings dropdown -->
                        <div class="settings-dropdown">
                            <button class="settings-btn">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="settings-menu">
                                <button class="settings-action">
                                    <i class="fas fa-eye-slash"></i> Ẩn
                                </button>
                                <button class="settings-action">
                                    <i class="fas fa-user-times"></i> Hủy theo dõi
                                </button>
                                <button class="settings-action danger">
                                    <i class="fas fa-ban"></i> Chặn
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
            @elseif(isset($query) && $query)
            <div class="no-results">
                <i class="fas fa-search"></i>
                <h3>Không tìm thấy người dùng</h3>
                <p>Không có kết quả nào cho "{{ $query }}". Thử tìm kiếm với từ khóa khác.</p>
            </div>
            @endif
        </div>
        <script>
            document.querySelectorAll('.follow-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const userId = this.dataset.id;
                    const button = this;
                    const originalContent = button.innerHTML;

                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang follow...';

                    fetch("{{ route('friends.add') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                friend_id: userId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                button.innerHTML = '<i class="fas fa-check"></i> Đã follow';
                                button.classList.remove('follow');
                                button.style.background = 'var(--success)';
                                button.disabled = true;
                            } else {
                                button.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Lỗi';
                                button.style.background = 'var(--error)';
                                setTimeout(() => {
                                    button.innerHTML = originalContent;
                                    button.style.background = '';
                                    button.disabled = false;
                                }, 2000);
                            }
                        })
                        .catch(() => {
                            button.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Lỗi';
                            button.style.background = 'var(--error)';
                            setTimeout(() => {
                                button.innerHTML = originalContent;
                                button.style.background = '';
                                button.disabled = false;
                            }, 2000);
                        });
                });
            });

            // Settings dropdown functionality
            document.querySelectorAll('.settings-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    // Close all other dropdowns
                    document.querySelectorAll('.settings-menu').forEach(menu => {
                        if (menu !== this.nextElementSibling) {
                            menu.style.display = 'none';
                        }
                    });
                    // Toggle current dropdown
                    const menu = this.nextElementSibling;
                    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                document.querySelectorAll('.settings-menu').forEach(menu => {
                    menu.style.display = 'none';
                });
            });
        </script>

        <script>
            // Initialize incoming call polling when page loads
            document.addEventListener('DOMContentLoaded', function() {
                startIncomingCallPolling();
            });

            // Call functionality
            function initiateCall(receiverId, callType) {
                // Show loading state
                const btn = event.target.closest('.action-btn');
                const originalContent = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                btn.disabled = true;

                fetch('/call/initiate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            receiver_id: receiverId,
                            call_type: callType
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Redirect to call page
                            window.location.href = `/call/${data.call_id}`;
                        } else {
                            alert(data.error || 'Không thể khởi tạo cuộc gọi');
                            btn.innerHTML = originalContent;
                            btn.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error initiating call:', error);
                        alert('Có lỗi xảy ra khi khởi tạo cuộc gọi');
                        btn.innerHTML = originalContent;
                        btn.disabled = false;
                    });
            }

            // Incoming call polling - copy from chat page
            function startIncomingCallPolling() {
                setInterval(async () => {
                    try {
                        const response = await fetch('/api/incoming-calls');
                        const data = await response.json();
                        
                        if (data.calls && data.calls.length > 0) {
                            for (const call of data.calls) {
                                showIncomingCallNotification(call);
                            }
                        }
                    } catch (error) {
                        console.error('Error checking incoming calls:', error);
                    }
                }, 2000); // Check every 2 seconds
            }

            function showIncomingCallNotification(call) {
                // Check if notification already exists
                if (document.getElementById(`call-notification-${call.call_id}`)) {
                    return;
                }

                // Create notification element
                const notification = document.createElement('div');
                notification.id = `call-notification-${call.call_id}`;
                notification.className = 'incoming-call-notification';
                notification.innerHTML = `
                    <div class="call-notification-content">
                        <div class="call-avatar">
                            ${call.caller_avatar ? 
                                `<img src="data:image/jpeg;base64,${call.caller_avatar}" alt="Avatar">` : 
                                '<i class="fas fa-user"></i>'
                            }
                        </div>
                        <div class="call-info">
                            <div class="caller-name">${call.caller_name}</div>
                            <div class="call-type">
                                <i class="fas fa-${call.call_type === 'video' ? 'video' : 'phone'}"></i>
                                ${call.call_type === 'video' ? 'Video call' : 'Voice call'} đến
                            </div>
                        </div>
                        <div class="call-actions">
                            <button class="answer-btn" onclick="answerIncomingCall('${call.call_id}')">
                                <i class="fas fa-phone"></i>
                            </button>
                            <button class="decline-btn" onclick="declineIncomingCall('${call.call_id}')">
                                <i class="fas fa-phone-slash"></i>
                            </button>
                        </div>
                    </div>
                `;

                // Add styles if not exists
                if (!document.getElementById('incoming-call-styles')) {
                    const styles = document.createElement('style');
                    styles.id = 'incoming-call-styles';
                    styles.textContent = `
                        .incoming-call-notification {
                            position: fixed;
                            top: 20px;
                            right: 20px;
                            background: white;
                            border-radius: 12px;
                            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                            padding: 16px;
                            z-index: 10000;
                            animation: slideIn 0.3s ease-out;
                            border-left: 4px solid #10b981;
                        }
                        
                        .call-notification-content {
                            display: flex;
                            align-items: center;
                            gap: 12px;
                        }
                        
                        .call-avatar {
                            width: 48px;
                            height: 48px;
                            border-radius: 50%;
                            overflow: hidden;
                            background: #f3f4f6;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }
                        
                        .call-avatar img {
                            width: 100%;
                            height: 100%;
                            object-fit: cover;
                        }
                        
                        .call-avatar i {
                            font-size: 20px;
                            color: #9ca3af;
                        }
                        
                        .call-info {
                            flex: 1;
                        }
                        
                        .caller-name {
                            font-weight: 600;
                            color: #111827;
                            margin-bottom: 4px;
                        }
                        
                        .call-type {
                            color: #6b7280;
                            font-size: 14px;
                            display: flex;
                            align-items: center;
                            gap: 6px;
                        }
                        
                        .call-actions {
                            display: flex;
                            gap: 8px;
                        }
                        
                        .answer-btn, .decline-btn {
                            width: 40px;
                            height: 40px;
                            border-radius: 50%;
                            border: none;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            cursor: pointer;
                            transition: all 0.2s;
                        }
                        
                        .answer-btn {
                            background: #10b981;
                            color: white;
                        }
                        
                        .answer-btn:hover {
                            background: #059669;
                            transform: scale(1.05);
                        }
                        
                        .decline-btn {
                            background: #ef4444;
                            color: white;
                        }
                        
                        .decline-btn:hover {
                            background: #dc2626;
                            transform: scale(1.05);
                        }
                        
                        @keyframes slideIn {
                            from {
                                transform: translateX(100%);
                                opacity: 0;
                            }
                            to {
                                transform: translateX(0);
                                opacity: 1;
                            }
                        }
                    `;
                    document.head.appendChild(styles);
                }

                document.body.appendChild(notification);

                // Auto remove after 30 seconds
                setTimeout(() => {
                    if (document.getElementById(`call-notification-${call.call_id}`)) {
                        notification.remove();
                    }
                }, 30000);
            }

            function answerIncomingCall(callId) {
                // Remove notification
                const notification = document.getElementById(`call-notification-${callId}`);
                if (notification) notification.remove();
                
                // Redirect to call page
                window.location.href = `/call/${callId}`;
            }

            function declineIncomingCall(callId) {
                // Remove notification
                const notification = document.getElementById(`call-notification-${callId}`);
                if (notification) notification.remove();
                
                // Send decline request
                fetch('/call/answer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        call_id: callId,
                        action: 'decline'
                    })
                }).catch(error => console.error('Error declining call:', error));
            }
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
                <label class="filter-checkbox-wrapper">
                    <input type="checkbox" name="friend_posts" value="1" {{ ($friendPosts ?? '') == '1' ? 'checked' : '' }}>
                    Bài viết của bạn bè
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
                    <span><i class="fas fa-user"></i> <a href="{{ route('user.profile', $post->user->user_id) }}">{{ $post->user->hoten ?? $post->user->username ?? 'Tác giả' }}</a></span>
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
            <div class="no-posts">
                <i class="fas fa-search"></i>
                <h3>Không tìm thấy bài viết</h3>
                <p>Không có kết quả nào cho "{{ $query }}"</p>
                <p>Thử tìm kiếm với từ khóa khác hoặc điều chỉnh bộ lọc</p>
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
</body>

</html>