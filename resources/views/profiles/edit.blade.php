<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chỉnh sửa hồ sơ cá nhân</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #dbeafe;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --surface: #ffffff;
            --surface-secondary: #f8fafc;
            --surface-tertiary: #f1f5f9;
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
            line-height: 1.5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: var(--space-6);
        }

        .edit-card {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
        }

        .edit-header {
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            padding: var(--space-8);
            text-align: center;
            color: white;
            position: relative;
        }

        .edit-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        }

        .edit-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: var(--space-2);
            position: relative;
            z-index: 1;
        }

        .edit-subtitle {
            font-size: 1.125rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .edit-form {
            padding: var(--space-8);
        }

        .form-section {
            margin-bottom: var(--space-8);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: var(--space-6);
            display: flex;
            align-items: center;
            gap: var(--space-2);
            padding-bottom: var(--space-3);
            border-bottom: 2px solid var(--border-light);
        }

        .section-title i {
            color: var(--primary);
        }

        /* Avatar Section */
        .avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--space-4);
            padding: var(--space-6);
            background: var(--surface-secondary);
            border-radius: var(--radius-xl);
            margin-bottom: var(--space-6);
        }

        .avatar-container {
            position: relative;
        }

        .avatar-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid var(--surface);
            object-fit: cover;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            font-weight: 700;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-upload {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 3px solid var(--surface);
        }

        .avatar-upload:hover {
            background: var(--primary-dark);
            transform: scale(1.1);
        }

        .avatar-upload input {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--space-6);
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .form-label i {
            color: var(--primary);
            width: 16px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: var(--space-4);
            border: 2px solid var(--border);
            border-radius: var(--radius-lg);
            font-size: 1rem;
            transition: all 0.2s ease;
            background: var(--surface);
            color: var(--text-primary);
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgb(37 99 235 / 0.1);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
            font-family: inherit;
        }

        .form-hint {
            font-size: 0.875rem;
            color: var(--text-tertiary);
            margin-top: var(--space-1);
        }

        /* Gender Select */
        .gender-options {
            display: flex;
            gap: var(--space-3);
        }

        .gender-option {
            flex: 1;
            position: relative;
        }

        .gender-option input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .gender-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-4);
            border: 2px solid var(--border);
            border-radius: var(--radius-lg);
            cursor: pointer;
            transition: all 0.2s ease;
            background: var(--surface);
            text-align: center;
        }

        .gender-option input:checked+label {
            border-color: var(--primary);
            background: var(--primary-light);
            color: var(--primary);
        }

        .gender-option i {
            font-size: 1.5rem;
            color: var(--text-tertiary);
        }

        .gender-option input:checked+label i {
            color: var(--primary);
        }

        /* Alert Messages */
        .alert {
            padding: var(--space-4);
            border-radius: var(--radius-lg);
            margin-bottom: var(--space-6);
            border-left: 4px solid;
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .alert-error {
            background: rgb(254 242 242);
            border-color: var(--error);
            color: #991b1b;
        }

        .alert-success {
            background: rgb(240 253 244);
            border-color: var(--success);
            color: #166534;
        }

        .alert ul {
            margin: 0;
            padding-left: var(--space-4);
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: var(--space-4);
            justify-content: flex-end;
            padding-top: var(--space-6);
            border-top: 1px solid var(--border-light);
            margin-top: var(--space-8);
        }

        .btn {
            padding: var(--space-3) var(--space-8);
            border-radius: var(--radius-lg);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 1rem;
            text-decoration: none;
            min-width: 120px;
            justify-content: center;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover:not(:disabled) {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: var(--surface-secondary);
            color: var(--text-secondary);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--surface-tertiary);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid var(--border);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: var(--space-4);
            }

            .edit-form {
                padding: var(--space-6);
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: var(--space-4);
            }

            .form-actions {
                flex-direction: column;
            }

            .gender-options {
                flex-direction: column;
            }
        }

        /* Success Animation */
        .success-check {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--success);
            color: white;
            text-align: center;
            line-height: 20px;
            font-size: 12px;
            animation: successPulse 0.6s ease-out;
        }

        @keyframes successPulse {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="edit-card">
            <!-- Header -->
            <div class="edit-header">
                <h1 class="edit-title">
                    <i class="fas fa-user-edit"></i>
                    Chỉnh sửa hồ sơ
                </h1>
                <p class="edit-subtitle">Cập nhật thông tin cá nhân của bạn</p>
            </div>

            <!-- Form -->
            <div class="edit-form">
                <!-- Success/Error Messages -->
                @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Có lỗi xảy ra:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <form id="profileForm" action="{{ route('profile.update', $user->user_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Avatar Section -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="fas fa-camera"></i>
                            Ảnh đại diện
                        </h2>

                        <div class="avatar-section">
                            <div class="avatar-container">
                                <div class="avatar-preview" id="avatarPreview">
                                    @if($user->hinhanh)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($user->hinhanh) }}" alt="Avatar">
                                    @else
                                    {{ strtoupper(substr($user->hoten ?? $user->username ?? 'U', 0, 1)) }}
                                    @endif
                                </div>
                                <div class="avatar-upload">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" name="hinhanh" accept="image/*" onchange="previewAvatar(event)">
                                </div>
                            </div>
                            <p class="form-hint">Click vào biểu tượng camera để thay đổi ảnh đại diện</p>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="fas fa-user"></i>
                            Thông tin cá nhân
                        </h2>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label" for="hoten">
                                    <i class="fas fa-signature"></i>
                                    Họ và tên
                                </label>
                                <input type="text" id="hoten" name="hoten" class="form-input"
                                    value="{{ old('hoten', $user->hoten) }}"
                                    placeholder="Nhập họ và tên đầy đủ" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="username">
                                    <i class="fas fa-at"></i>
                                    Tên người dùng
                                </label>
                                <input type="text" id="username" name="username" class="form-input"
                                    value="{{ old('username', $user->username) }}"
                                    placeholder="Tên người dùng duy nhất" required>
                                <p class="form-hint">Tên này sẽ hiển thị trong URL hồ sơ của bạn</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="email">
                                    <i class="fas fa-envelope"></i>
                                    Email
                                </label>
                                <input type="email" id="email" name="email" class="form-input"
                                    value="{{ old('email', $user->email) }}"
                                    placeholder="email@example.com" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="sodienthoai">
                                    <i class="fas fa-phone"></i>
                                    Số điện thoại
                                </label>
                                <input type="tel" id="sodienthoai" name="sodienthoai" class="form-input"
                                    value="{{ old('sodienthoai', $user->sodienthoai) }}"
                                    placeholder="0123456789">
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label" for="diachi">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Địa chỉ
                                </label>
                                <textarea id="diachi" name="diachi" class="form-textarea"
                                    placeholder="Nhập địa chỉ của bạn">{{ old('diachi', $user->diachi) }}</textarea>
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label">
                                    <i class="fas fa-venus-mars"></i>
                                    Giới tính
                                </label>
                                <div class="gender-options">
                                    <div class="gender-option">
                                        <input type="radio" name="gioitinh" value="1" id="male"
                                            {{ old('gioitinh', $user->gioitinh) == '1' ? 'checked' : '' }}>
                                        <label for="male">
                                            <i class="fas fa-mars"></i>
                                            <span>Nam</span>
                                        </label>
                                    </div>
                                    <div class="gender-option">
                                        <input type="radio" name="gioitinh" value="0" id="female"
                                            {{ old('gioitinh', $user->gioitinh) == '0' ? 'checked' : '' }}>
                                        <label for="female">
                                            <i class="fas fa-venus"></i>
                                            <span>Nữ</span>
                                        </label>
                                    </div>
                                    <div class="gender-option">
                                        <input type="radio" name="gioitinh" value="2" id="other"
                                            {{ old('gioitinh', $user->gioitinh) == '2' ? 'checked' : '' }}>
                                        <label for="other">
                                            <i class="fas fa-genderless"></i>
                                            <span>Khác</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('user.profile', $user->user_id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Hủy bỏ
                        </a>
                        <button type="submit" class="btn btn-primary" id="saveBtn">
                            <i class="fas fa-save"></i>
                            <span id="saveText">Lưu thay đổi</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Avatar preview functionality
        function previewAvatar(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('avatarPreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Avatar">`;
                };
                reader.readAsDataURL(file);
            }
        }

        // Form submission handling
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            const saveBtn = document.getElementById('saveBtn');
            const saveText = document.getElementById('saveText');

            // Show loading state
            saveBtn.disabled = true;
            saveText.innerHTML = '<div class="loading"></div> Đang lưu...';
        });

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide success message after 5 seconds
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.remove(), 300);
                }, 5000);
            }

            // Form validation
            const form = document.getElementById('profileForm');
            const inputs = form.querySelectorAll('input[required]');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        this.style.borderColor = 'var(--error)';
                    } else {
                        this.style.borderColor = 'var(--border)';
                    }
                });

                input.addEventListener('input', function() {
                    if (this.style.borderColor === 'rgb(239, 68, 68)') {
                        this.style.borderColor = 'var(--border)';
                    }
                });
            });
        });
    </script>
</body>

</html>