<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bạn bè</title>
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

        .friend-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .friend-item {
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

        .friend-info {
            flex: 1;
        }

        .friend-name {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .friend-meta {
            color: #888;
            font-size: 0.95rem;
        }

        .action-btn {
            padding: 8px 20px;
            border-radius: 18px;
            border: none;
            background: #28a745;
            color: #fff;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Danh sách bạn bè</h1>
        @if(isset($friends) && count($friends) > 0)
        <ul class="friend-list">
            @foreach($friends as $f)
            <li class="friend-item">
                <div class="avatar">
                    @if($f->hinhanh)
                    <img src="data:image/jpeg;base64,{{ base64_encode($f->hinhanh) }}" alt="avatar">
                    @else
                    <i class="fas fa-user-circle"></i>
                    @endif
                </div>
                <div class="friend-info">
                    <div class="friend-name">{{ $f->hoten ?? $f->username }}</div>
                    <div class="friend-meta">{{ $f->email }}</div>
                </div>
                @if(in_array($f->user_id, $friendIds))
                <span class="friend-status" style="color:#28a745;font-weight:600;">Bạn bè</span>
                @else
                <button class="action-btn add-friend-btn" data-id="{{ $f->user_id }}"><i class="fas fa-user-plus"></i> Kết bạn</button>
                @endif
            </li>
            @endforeach
        </ul>
        @else
        <div style="text-align:center;color:#888;margin-top:32px;">Không có người dùng nào khác.</div>
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