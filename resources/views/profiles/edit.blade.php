<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa hồ sơ cá nhân</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', Arial, sans-serif; background: #f6f7fb; margin: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.07); padding: 36px 40px; }
        h1 { text-align: center; color: #007bff; margin-bottom: 32px; }
        form { display: flex; flex-direction: column; gap: 18px; }
        label { font-weight: 500; color: #333; margin-bottom: 4px; }
        input, select, textarea { padding: 10px 14px; border-radius: 8px; border: 1px solid #ccc; font-size: 1rem; }
        input[type="file"] { border: none; }
        .form-group { display: flex; flex-direction: column; }
        .avatar-preview { width: 90px; height: 90px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; overflow: hidden; margin-bottom: 8px; }
        .avatar-preview img { width: 100%; height: 100%; object-fit: cover; }
        .avatar-preview i { font-size: 2.5rem; color: #ccc; }
        .form-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 18px; }
        .btn { padding: 10px 28px; border-radius: 22px; border: none; cursor: pointer; font-weight: 600; font-size: 1rem; transition: background 0.2s; }
        .btn.save { background: #007bff; color: #fff; }
        .btn.save:hover { background: #0056b3; }
        .btn.cancel { background: #e9ecef; color: #6c757d; }
        @media (max-width: 700px) { .container { padding: 16px !important; } }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chỉnh sửa hồ sơ cá nhân</h1>
        <form action="{{ route('profile.update', $user->id_user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group" style="align-items:center;">
                <label>Ảnh đại diện</label>
                <div class="avatar-preview">
                    @if($user->hinhanh)
                        <img id="avatarImg" src="data:image/jpeg;base64,{{ base64_encode($user->hinhanh) }}" alt="avatar">
                    @else
                        <i class="fas fa-user-circle" id="avatarImg"></i>
                    @endif
                </div>
                <input type="file" name="hinhanh" accept="image/*" onchange="previewAvatar(event)">
            </div>
            <div class="form-group">
                <label for="hoten">Họ tên</label>
                <input type="text" name="hoten" id="hoten" value="{{ old('hoten', $user->hoten) }}" required>
            </div>
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group">
                <label for="sodienthoai">Số điện thoại</label>
                <input type="text" name="sodienthoai" id="sodienthoai" value="{{ old('sodienthoai', $user->sodienthoai) }}">
            </div>
            <div class="form-group">
                <label for="diachi">Địa chỉ</label>
                <input type="text" name="diachi" id="diachi" value="{{ old('diachi', $user->diachi) }}">
            </div>
            <div class="form-group">
                <label for="gioitinh">Giới tính</label>
                <select name="gioitinh" id="gioitinh">
                    <option value="" {{ $user->gioitinh === null ? 'selected' : '' }}>Không xác định</option>
                    <option value="1" {{ $user->gioitinh == 1 ? 'selected' : '' }}>Nam</option>
                    <option value="0" {{ $user->gioitinh == 0 ? 'selected' : '' }}>Nữ</option>
                    <option value="2" {{ $user->gioitinh == 2 ? 'selected' : '' }}>Khác</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn save"><i class="fas fa-save"></i> Lưu thay đổi</button>
                <a href="{{ route('user.profile', $user->id_user) }}" class="btn cancel">Huỷ</a>
            </div>
        </form>
    </div>
    <script>
        function previewAvatar(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const img = document.getElementById('avatarImg');
                if(img.tagName === 'IMG') img.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>