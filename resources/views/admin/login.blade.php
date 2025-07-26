<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
<div class="admin-container" style="max-width:400px;">
    <h2>Đăng nhập quản trị</h2>
    @if(session('error'))
        <div style="color:#e53935;margin-bottom:12px;">{{ session('error') }}</div>
    @endif
    <form method="POST" action="/admin-login">
        @csrf
        <input type="text" name="username" placeholder="Tên đăng nhập" required style="width:100%;margin-bottom:12px;padding:10px 14px;border-radius:8px;border:1.5px solid #e0e3eb;">
        <input type="password" name="password" placeholder="Mật khẩu" required style="width:100%;margin-bottom:12px;padding:10px 14px;border-radius:8px;border:1.5px solid #e0e3eb;">
        <button type="submit" class="admin-btn" style="width:100%;">Đăng nhập</button>
    </form>
</div>
</body>
</html> 