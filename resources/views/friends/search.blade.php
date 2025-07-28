<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm bạn bè</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background: #f6f7fb;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
            padding: 36px 40px;
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 32px;
        }

        .search-form {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
        }

        .search-input {
            flex: 1;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .search-btn {
            padding: 10px 28px;
            border-radius: 22px;
            border: none;
            background: #007bff;
            color: #fff;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
        }

        .user-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .user-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid #f3f3f3;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #f0f0f0;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar i {
            font-size: 2rem;
            color: #ccc;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .user-meta {
            color: #888;
            font-size: 0.95rem;
        }

        .action-btn {
            padding: 8px 20px;
            border-radius: 18px;
            border: none;
            background: #007bff;
            color: #fff;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .action-btn[disabled] {
            background: #ccc;
            cursor: not-allowed;
        }

        .action-btn.message {
            background: #28a745;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Tìm kiếm bạn bè</h1>
        <form class="search-form" method="GET" action="{{ route('friends.search') }}">
            <input type="text" name="q" class="search-input" placeholder="Nhập tên, username hoặc email..." value="{{ $query ?? '' }}" required />
            <button type="submit" class="search-btn"><i class="fas fa-search"></i> Tìm kiếm</button>
        </form>
        @if(isset($users) && count($users) > 0)
        <ul class="user-list">
            @foreach($users as $u)
            <li class="user-item">
                <div class="avatar">
                    @if($u->hinhanh)
                    <img src="data:image/jpeg;base64,{{ base64_encode($u->hinhanh) }}" alt="avatar">
                    @else
                    <i class="fas fa-user-circle"></i>
                    @endif
                </div>
                <div class="user-info">
                    <div class="user-name">{{ $u->hoten ?? $u->username }}</div>
                    <div class="user-meta">{{ $u->email }}</div>
                </div>
                @if($currentUser && $u->user_id != $currentUser->user_id)
                @php
                $isFriend = \App\Models\DanhSachBanBe::where(function($q) use ($currentUser, $u) {
                $q->where('user_id_1', $currentUser->user_id)->where('user_id_2', $u->user_id);
                })->orWhere(function($q) use ($currentUser, $u) {
                $q->where('user_id_2', $currentUser->user_id)->where('user_id_1', $u->user_id);
                })->exists();
                @endphp
                @if($isFriend)
                <a href="{{ route('friends.chat', $u->user_id) }}" class="action-btn message"><i class="fas fa-comments"></i> Nhắn tin</a>
                @else
                <button class="action-btn add-friend-btn" data-id="{{ $u->user_id }}"><i class="fas fa-user-plus"></i> Follow</button>
                @endif
                @endif
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
                        body: JSON.stringify({
                            friend_id: friendId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
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
</body>

</html>