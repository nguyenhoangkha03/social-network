<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - ChatPost</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/register.css'])
</head>

<body>
    <div class="auth-background">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="logo">
                        <i class="fas fa-comments"></i>
                        <span>ChatPost</span>
                    </div>
                    <h1 class="form-title">Tạo tài khoản mới</h1>
                    <p class="form-subtitle">Tham gia cộng đồng chia sẻ tri thức</p>
                </div>

                @if ($errors->any())
                <div class="alert error">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form class="auth-form" method="POST" action="{{ url('/register') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="username">Tên đăng nhập</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Nhập tên đăng nhập" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hoten">Họ và tên</label>
                        <div class="input-wrapper">
                            <i class="fas fa-id-card input-icon"></i>
                            <input type="text" id="hoten" name="hoten" value="{{ old('hoten') }}" placeholder="Nhập họ và tên của bạn">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Nhập địa chỉ email của bạn">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="password-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="password-strength-bar" id="passwordStrength"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Xác nhận mật khẩu</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye" id="password_confirmation-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="diachi">Địa chỉ</label>
                            <div class="input-wrapper">
                                <i class="fas fa-map-marker-alt input-icon"></i>
                                <input type="text" id="diachi" name="diachi" value="{{ old('diachi') }}" placeholder="Nhập địa chỉ">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sodienthoai">Số điện thoại</label>
                            <div class="input-wrapper">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="text" id="sodienthoai" name="sodienthoai" value="{{ old('sodienthoai') }}" placeholder="Nhập số điện thoại">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gioitinh">Giới tính</label>
                        <div class="select-wrapper">
                            <i class="fas fa-venus-mars input-icon"></i>
                            <select id="gioitinh" name="gioitinh">
                                <option value="">Chọn giới tính</option>
                                <option value="0" @if(old('gioitinh')==='0' ) selected @endif>Nữ</option>
                                <option value="1" @if(old('gioitinh')==='1' ) selected @endif>Nam</option>
                            </select>
                            <i class="fas fa-chevron-down select-arrow"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hinhanh">Ảnh đại diện</label>
                        <div class="avatar-upload">
                            <div class="avatar-preview" id="avatarPreview">
                                <i class="fas fa-user-circle"></i>
                                <img id="avatarImg" src="#" alt="Preview" style="display:none;" />
                            </div>
                            <div class="upload-btn">
                                <input type="file" hidden id="hinhanh" name="hinhanh" accept="image/*" onchange="previewAvatar(event)">
                                <label for="hinhanh" class="upload-label">
                                    <i class="fas fa-camera"></i>
                                    <span>Chọn ảnh</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-user-plus"></i>
                        <span>Tạo tài khoản</span>
                    </button>
                </form>

                <div class="auth-footer">
                    <p class="form-link">Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Preview avatar function
        function previewAvatar(event) {
            const input = event.target;
            const preview = document.getElementById('avatarPreview');
            const img = document.getElementById('avatarImg');
            const icon = preview.querySelector('i');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                    icon.style.display = 'none';
                    preview.classList.add('has-image');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                img.src = '#';
                img.style.display = 'none';
                icon.style.display = 'block';
                preview.classList.remove('has-image');
            }
        }

        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eye = document.getElementById(fieldId + '-eye');

            if (field.type === 'password') {
                field.type = 'text';
                eye.classList.remove('fa-eye');
                eye.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                eye.classList.remove('fa-eye-slash');
                eye.classList.add('fa-eye');
            }
        }

        // Password strength checker
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            const strengthBar = document.getElementById('passwordStrength');

            if (passwordField && strengthBar) {
                passwordField.addEventListener('input', function() {
                    const password = this.value;
                    let strength = 0;

                    // Check password criteria
                    if (password.length >= 8) strength++;
                    if (/[a-z]/.test(password)) strength++;
                    if (/[A-Z]/.test(password)) strength++;
                    if (/[0-9]/.test(password)) strength++;
                    if (/[^a-zA-Z0-9]/.test(password)) strength++;

                    // Update strength bar
                    strengthBar.className = 'password-strength-bar';
                    if (strength <= 2) {
                        strengthBar.classList.add('weak');
                    } else if (strength <= 3) {
                        strengthBar.classList.add('medium');
                    } else {
                        strengthBar.classList.add('strong');
                    }
                });
            }

            // Form submission loading state
            const form = document.querySelector('.auth-form');
            if (form) {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('.btn-submit');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Đang tạo tài khoản...</span>';
                        submitBtn.disabled = true;
                        document.body.classList.add('loading');
                    }
                });
            }
        });
    </script>
</body>

</html>