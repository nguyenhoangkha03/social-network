<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($editPost) ? 'Chỉnh sửa bài viết' : 'Tạo bài viết mới' }} - ChatPost</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Quill Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Modern CSS -->
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
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
            --space-16: 4rem;
            --space-20: 5rem;
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
            max-width: 1200px;
            margin: 0 auto;
            padding: var(--space-6);
        }

        .post-editor {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: var(--space-8);
            min-height: calc(100vh - var(--space-12));
        }

        .main-editor {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-8);
            height: fit-content;
        }

        .editor-header {
            text-align: center;
            margin-bottom: var(--space-8);
            border-bottom: 1px solid var(--border-light);
            padding-bottom: var(--space-6);
        }

        .editor-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: var(--space-2);
        }

        .editor-header p {
            color: var(--text-secondary);
            font-size: 1.125rem;
        }

        .form-group {
            margin-bottom: var(--space-6);
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: var(--space-3);
            font-size: 0.95rem;
        }

        .form-label i {
            color: var(--primary);
            width: 16px;
        }

        .form-input,
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

        .char-counter {
            text-align: right;
            color: var(--text-tertiary);
            font-size: 0.875rem;
            margin-top: var(--space-1);
        }

        .file-upload-zone {
            border: 2px dashed var(--border);
            border-radius: var(--radius-xl);
            padding: var(--space-8);
            text-align: center;
            background: var(--surface-secondary);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .file-upload-zone:hover {
            border-color: var(--primary);
            background: var(--surface);
        }

        .file-upload-zone.dragover {
            border-color: var(--primary);
            background: rgb(37 99 235 / 0.05);
        }

        .upload-icon {
            width: 64px;
            height: 64px;
            background: var(--primary);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto var(--space-4);
            color: white;
            font-size: 1.5rem;
        }

        .upload-text {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: var(--space-2);
        }

        .upload-hint {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .image-preview {
            margin-top: var(--space-4);
            border-radius: var(--radius-lg);
            overflow: hidden;
            position: relative;
        }

        .image-preview img {
            width: 100%;
            height: auto;
            max-height: 300px;
            object-fit: cover;
        }

        .remove-image {
            position: absolute;
            top: var(--space-2);
            right: var(--space-2);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: var(--radius-md);
            width: 32px;
            height: 32px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s ease;
        }

        .remove-image:hover {
            background: var(--error);
        }

        .form-actions {
            display: flex;
            gap: var(--space-3);
            justify-content: flex-end;
            padding-top: var(--space-6);
            border-top: 1px solid var(--border-light);
            margin-top: var(--space-8);
        }

        .btn {
            padding: var(--space-3) var(--space-6);
            border-radius: var(--radius-lg);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.95rem;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
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

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .sidebar {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            padding: var(--space-6);
            height: fit-content;
            position: sticky;
            top: var(--space-6);
        }

        .sidebar-section {
            margin-bottom: var(--space-6);
        }

        .sidebar-title {
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: var(--space-4);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .sidebar-title i {
            color: var(--primary);
        }

        .post-list {
            list-style: none;
        }

        .post-item {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3);
            border-radius: var(--radius-lg);
            margin-bottom: var(--space-2);
            background: var(--surface-secondary);
            transition: all 0.2s ease;
        }

        .post-item:hover {
            background: var(--surface-tertiary);
        }

        .post-link {
            flex: 1;
            text-decoration: none;
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.875rem;
            line-height: 1.4;
        }

        .post-link:hover {
            color: var(--primary);
        }

        .delete-btn {
            background: none;
            border: none;
            color: var(--error);
            cursor: pointer;
            padding: var(--space-1);
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
        }

        .delete-btn:hover {
            background: var(--error);
            color: white;
        }

        .alert {
            padding: var(--space-4);
            border-radius: var(--radius-lg);
            margin-bottom: var(--space-6);
            border-left: 4px solid;
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

        .preview-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .preview-content {
            background: var(--surface);
            border-radius: var(--radius-2xl);
            padding: var(--space-8);
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
            margin: var(--space-4);
            position: relative;
        }

        .close-preview {
            position: absolute;
            top: var(--space-4);
            right: var(--space-4);
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-secondary);
            cursor: pointer;
        }

        .quill-editor {
            height: 300px;
            margin-bottom: var(--space-4);
        }

        .ql-toolbar {
            border-top: 2px solid var(--border);
            border-left: 2px solid var(--border);
            border-right: 2px solid var(--border);
            border-bottom: none;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        .ql-container {
            border-bottom: 2px solid var(--border);
            border-left: 2px solid var(--border);
            border-right: 2px solid var(--border);
            border-top: none;
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        }

        .ql-editor {
            font-size: 1rem;
            line-height: 1.6;
        }

        .ql-editor:focus {
            outline: none;
        }

        @media (max-width: 1024px) {
            .post-editor {
                grid-template-columns: 1fr;
                gap: var(--space-6);
            }

            .sidebar {
                position: static;
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: var(--space-4);
            }

            .main-editor {
                padding: var(--space-6);
            }

            .editor-header h1 {
                font-size: 2rem;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="post-editor">
            <!-- Main Editor -->
            <div class="main-editor">
                <div class="editor-header">
                    <h1>
                        <i class="fas fa-{{ isset($editPost) ? 'edit' : 'plus-circle' }}"></i>
                        {{ isset($editPost) ? 'Chỉnh sửa bài viết' : 'Tạo bài viết mới' }}
                    </h1>
                    <p>{{ isset($editPost) ? 'Cập nhật nội dung bài viết của bạn' : 'Chia sẻ kiến thức và kết nối với cộng đồng' }}</p>
                </div>
                @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Có lỗi xảy ra:</strong>
                    <ul style="margin: var(--space-2) 0 0 0; padding-left: var(--space-4);">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="postForm" method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($editPost))
                    <input type="hidden" name="edit_id" value="{{ $editPost->id_baiviet }}">
                    @endif

                    <!-- Tiêu đề -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-heading"></i>
                            Tiêu đề bài viết
                        </label>
                        <input
                            type="text"
                            id="tieude"
                            name="tieude"
                            class="form-input"
                            value="{{ old('tieude', isset($editPost) ? $editPost->tieude : '') }}"
                            placeholder="Nhập tiêu đề hấp dẫn cho bài viết của bạn..."
                            maxlength="255"
                            required>
                        <div class="char-counter">
                            <span id="tieude-counter">{{ strlen(old('tieude', isset($editPost) ? $editPost->tieude : '')) }}</span>/255 ký tự
                        </div>
                    </div>

                    <!-- Mô tả -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-align-left"></i>
                            Mô tả ngắn
                        </label>
                        <textarea
                            id="mota"
                            name="mota"
                            class="form-textarea"
                            placeholder="Viết mô tả ngắn gọn để thu hút người đọc..."
                            maxlength="500">{{ old('mota', isset($editPost) ? $editPost->mota : '') }}</textarea>
                        <div class="char-counter">
                            <span id="mota-counter">{{ strlen(old('mota', isset($editPost) ? $editPost->mota : '')) }}</span>/500 ký tự
                        </div>
                    </div>

                    <!-- Nội dung -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-file-alt"></i>
                            Nội dung bài viết
                        </label>
                        <div class="quill-editor" id="editor"></div>
                        <textarea id="noidung" name="noidung" style="display: none;">{{ old('noidung', isset($editPost) ? $editPost->noidung : '') }}</textarea>
                        <div class="char-counter">
                            <span id="noidung-counter">{{ strlen(old('noidung', isset($editPost) ? $editPost->noidung : '')) }}</span> ký tự
                        </div>
                    </div>

                    <!-- Ảnh bìa -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-image"></i>
                            Ảnh bìa bài viết
                        </label>
                        <div class="file-upload-zone" id="uploadZone">
                            <input type="file" id="anh_bia" name="anh_bia" accept="image/*" style="display: none;">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="upload-text">Kéo thả ảnh vào đây hoặc nhấn để chọn</div>
                            <div class="upload-hint">Hỗ trợ: JPG, PNG, GIF, WebP (Tối đa 5MB)</div>
                        </div>
                        <div class="image-preview" id="imagePreview" style="display: {{ isset($editPost) && $editPost->anh_bia ? 'block' : 'none' }};">
                            <img id="previewImg" src="{{ isset($editPost) && $editPost->anh_bia ? asset($editPost->anh_bia) : '' }}" alt="Preview">
                            <button type="button" class="remove-image" onclick="removeImage()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Từ khóa -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-tags"></i>
                            Thẻ tag (tùy chọn)
                        </label>
                        <input
                            type="text"
                            id="dinhkhem"
                            name="dinhkhem"
                            class="form-input"
                            value="{{ old('dinhkhem', isset($editPost) ? $editPost->dinhkhem : '') }}"
                            placeholder="công nghệ, lập trình, tutorial...">
                        <div style="font-size: 0.875rem; color: var(--text-secondary); margin-top: var(--space-2);">
                            <i class="fas fa-info-circle"></i> Phân cách các tag bằng dấu phẩy
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="form-actions">
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Quay lại
                        </a>

                        <button type="button" id="previewBtn" class="btn btn-warning">
                            <i class="fas fa-eye"></i>
                            Xem trước
                        </button>

                        <button type="submit" name="save_draft" value="1" class="btn btn-secondary">
                            <i class="fas fa-save"></i>
                            Lưu nháp
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-{{ isset($editPost) ? 'save' : 'paper-plane' }}"></i>
                            {{ isset($editPost) ? 'Cập nhật' : 'Đăng bài viết' }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Drafts Section -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-save"></i>
                        Bản nháp ({{ count($drafts ?? []) }})
                    </h3>
                    @if(isset($drafts) && count($drafts) > 0)
                    <ul class="post-list">
                        @foreach($drafts as $draft)
                        <li class="post-item">
                            <a href="{{ route('post.create', ['edit' => $draft->id_baiviet]) }}" class="post-link">
                                {{ Str::limit($draft->tieude ?? 'Bản nháp chưa có tiêu đề', 30) }}
                            </a>
                            <form method="POST" action="{{ route('post.deleteDraft', $draft->id_baiviet) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" title="Xóa bản nháp" onclick="return confirm('Bạn có chắc muốn xóa bản nháp này?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div style="text-align: center; color: var(--text-tertiary); padding: var(--space-4);">
                        <i class="fas fa-file-alt" style="font-size: 2rem; margin-bottom: var(--space-2); display: block;"></i>
                        Chưa có bản nháp nào
                    </div>
                    @endif
                </div>

                <!-- Published Posts Section -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-check-circle"></i>
                        Đã đăng ({{ count($published ?? []) }})
                    </h3>
                    @if(isset($published) && count($published) > 0)
                    <ul class="post-list">
                        @foreach($published->take(5) as $post)
                        <li class="post-item">
                            <a href="{{ route('post.show', $post->id_baiviet) }}" class="post-link" target="_blank">
                                {{ Str::limit($post->tieude ?? 'Bài viết không có tiêu đề', 30) }}
                            </a>
                            <a href="{{ route('post.create', ['edit' => $post->id_baiviet]) }}" title="Chỉnh sửa" style="color: var(--primary); margin-right: var(--space-2);">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('post.delete', $post->id_baiviet) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" title="Xóa bài viết" onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                    @if(count($published) > 5)
                    <div style="text-align: center; margin-top: var(--space-3);">
                        <a href="{{ route('user.profile', auth()->user()->user_id ?? session('user_id')) }}" class="btn btn-secondary" style="font-size: 0.875rem; padding: var(--space-2) var(--space-4);">
                            Xem tất cả
                        </a>
                    </div>
                    @endif
                    @else
                    <div style="text-align: center; color: var(--text-tertiary); padding: var(--space-4);">
                        <i class="fas fa-newspaper" style="font-size: 2rem; margin-bottom: var(--space-2); display: block;"></i>
                        Chưa có bài viết nào
                    </div>
                    @endif
                </div>

                <!-- Tips Section -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">
                        <i class="fas fa-lightbulb"></i>
                        Mẹo viết bài hay
                    </h3>
                    <div style="background: var(--surface-secondary); padding: var(--space-4); border-radius: var(--radius-lg); font-size: 0.875rem; line-height: 1.6;">
                        <ul style="margin: 0; padding-left: var(--space-4); color: var(--text-secondary);">
                            <li style="margin-bottom: var(--space-2);">Tiêu đề ngắn gọn, hấp dẫn</li>
                            <li style="margin-bottom: var(--space-2);">Sử dụng ảnh chất lượng cao</li>
                            <li style="margin-bottom: var(--space-2);">Chia đoạn văn rõ ràng</li>
                            <li style="margin-bottom: var(--space-2);">Thêm tag phù hợp</li>
                            <li>Kiểm tra chính tả trước khi đăng</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="preview-modal" style="display: none;">
        <div class="preview-content">
            <button class="close-preview" onclick="closePreview()">
                <i class="fas fa-times"></i>
            </button>
            <div style="margin-bottom: var(--space-6);">
                <h2 style="color: var(--primary); margin-bottom: var(--space-2);">
                    <i class="fas fa-eye"></i> Xem trước bài viết
                </h2>
                <div style="display: flex; gap: var(--space-2);">
                    <button onclick="changeFontSize(1)" class="btn btn-secondary" style="padding: var(--space-2); font-size: 0.875rem;">
                        <i class="fas fa-plus"></i> A
                    </button>
                    <button onclick="changeFontSize(-1)" class="btn btn-secondary" style="padding: var(--space-2); font-size: 0.875rem;">
                        <i class="fas fa-minus"></i> A
                    </button>
                </div>
            </div>
            <div id="previewContent" style="border-top: 1px solid var(--border); padding-top: var(--space-6);"></div>
        </div>
    </div>

    <!-- Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        // Reset form sau khi submit thành công
        if (window.sessionStorage.getItem('post_submitted')) {
            document.querySelector('.post-form').reset();
            // Reset preview ảnh nếu có
            if (document.getElementById('imagePreview')) {
                document.getElementById('imagePreview').style.display = 'none';
                document.getElementById('uploadArea').style.display = 'block';
            }
            window.sessionStorage.removeItem('post_submitted');
        }
        // Khi submit thành công, set flag
        document.querySelector('.post-form').addEventListener('submit', function() {
            window.sessionStorage.setItem('post_submitted', '1');
        });

        // Sidebar toggle logic
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarPostList');
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar.style.left === '0px') {
                sidebar.style.left = '-350px';
                overlay.style.display = 'none';
            } else {
                sidebar.style.left = '0px';
                overlay.style.display = 'block';
            }
        }
        document.getElementById('toggleSidebarBtn').onclick = toggleSidebar;

        // Preview ảnh bìa khi chọn file
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');
            const img = document.getElementById('previewImg');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                img.src = '';
                preview.style.display = 'none';
            }
        }

        function removeImage() {
            document.getElementById('anh_bia').value = '';
            document.getElementById('previewImg').src = '';
            document.getElementById('imagePreview').style.display = 'none';
        }

        function formatText(command) {
            var textarea = document.getElementById('noidung');
            var start = textarea.selectionStart;
            var end = textarea.selectionEnd;
            var selected = textarea.value.substring(start, end);
            var before = textarea.value.substring(0, start);
            var after = textarea.value.substring(end);
            let openTag = '',
                closeTag = '';
            if (command === 'bold') {
                openTag = '<b>';
                closeTag = '</b>';
            } else if (command === 'italic') {
                openTag = '<i>';
                closeTag = '</i>';
            } else if (command === 'underline') {
                openTag = '<u>';
                closeTag = '</u>';
            }
            textarea.value = before + openTag + selected + closeTag + after;
            textarea.focus();
            // Đặt lại vùng chọn cho tiện thao tác tiếp
            textarea.selectionStart = start + openTag.length;
            textarea.selectionEnd = end + openTag.length;
        }

        function handleInsertImage(input) {
            if (input.files && input.files[0]) {
                var file = input.files[0];
                var formData = new FormData();
                formData.append('image', file);
                fetch('/upload-image', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.url) {
                            insertImageToTextarea(data.url);
                        } else {
                            alert('Upload ảnh thất bại!');
                        }
                    })
                    .catch(() => alert('Lỗi upload ảnh!'));
                input.value = '';
            }
        }

        function insertImageToTextarea(url) {
            var textarea = document.getElementById('noidung');
            var start = textarea.selectionStart;
            var end = textarea.selectionEnd;
            var before = textarea.value.substring(0, start);
            var after = textarea.value.substring(end);
            var imgTag = '<img src="' + url + '" alt="Ảnh" style="max-width:100%;"><br>';
            textarea.value = before + imgTag + after;
            textarea.focus();
            textarea.selectionStart = textarea.selectionEnd = start + imgTag.length;
        }

        // Preview bài viết
        function showPreview() {
            const tieude = document.getElementById('tieude').value;
            const mota = document.getElementById('mota').value;
            const noidung = document.getElementById('noidung').value;
            const anhBiaInput = document.getElementById('anh_bia');
            let anhBiaUrl = '';
            if (anhBiaInput && anhBiaInput.files && anhBiaInput.files[0]) {
                anhBiaUrl = URL.createObjectURL(anhBiaInput.files[0]);
            } else {
                const previewImg = document.getElementById('previewImg');
                if (previewImg && previewImg.src && !previewImg.src.includes('noimage') && previewImg.src !== window.location.href) {
                    anhBiaUrl = previewImg.src;
                }
            }
            let html = '';
            if (anhBiaUrl) {
                html += `<div style=\"text-align:center;margin-bottom:18px;\"><img src=\"${anhBiaUrl}\" alt=\"Ảnh bìa\" style=\"max-width:100%;max-height:320px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.08);\"></div>`;
            }
            html += `<h2 style=\"color:#222;\">${tieude ? tieude : '(Chưa có tiêu đề)'}<\/h2>`;
            if (mota) html += `<p style=\"color:#666;font-style:italic;\">${mota}<\/p>`;
            html += `<div id=\"previewMainContent\" style=\"margin-top:18px;font-size:1.08rem;line-height:1.7;\">${noidung.replace(/\n/g, '<br>')}<\/div>`;
            document.getElementById('previewContent').innerHTML = html;
            document.getElementById('postPreviewArea').style.display = 'block';
            window.scrollTo({
                top: document.getElementById('postPreviewArea').offsetTop - 40,
                behavior: 'smooth'
            });
            // Reset font size preview
            document.getElementById('previewMainContent').style.fontSize = '1.08rem';
        }

        function changeFontSize(delta) {
            const content = document.getElementById('previewMainContent');
            if (!content) return;
            let current = window.getComputedStyle(content).fontSize;
            let size = parseFloat(current);
            size += delta * 2;
            if (size < 12) size = 12;
            if (size > 48) size = 48;
            content.style.fontSize = size + 'px';
        }

        function hidePreview() {
            document.getElementById('postPreviewArea').style.display = 'none';
        }
    </script>
    <script>
        // Initialize Quill editor with custom image handler
        let quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        [{
                            'header': [1, 2, 3, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'align': []
                        }],
                        ['link', 'image', 'video'],
                        ['code-block'],
                        ['clean']
                    ],
                    handlers: {
                        image: imageHandler
                    }
                }
            },
            placeholder: 'Viết nội dung bài viết của bạn...',
        });

        // Custom image handler to upload to server instead of base64
        function imageHandler() {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();

            input.onchange = () => {
                const file = input.files[0];
                if (file) {
                    const formData = new FormData();
                    formData.append('image', file);

                    // Show loading indicator
                    const range = quill.getSelection();
                    quill.insertText(range.index, 'Đang tải ảnh...', 'user');

                    fetch('/upload-image', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.url) {
                                // Remove loading text
                                quill.deleteText(range.index, 'Đang tải ảnh...'.length);
                                // Insert image
                                quill.insertEmbed(range.index, 'image', data.url);
                                quill.setSelection(range.index + 1);
                            } else {
                                // Remove loading text
                                quill.deleteText(range.index, 'Đang tải ảnh...'.length);
                                alert('Upload ảnh thất bại: ' + (data.error || 'Lỗi không xác định'));
                            }
                        })
                        .catch(error => {
                            // Remove loading text
                            quill.deleteText(range.index, 'Đang tải ảnh...'.length);
                            alert('Lỗi upload ảnh: ' + error.message);
                        });
                }
            };
        }

        // Set initial content if editing
        const initialContent = document.getElementById('noidung').value;
        if (initialContent) {
            quill.root.innerHTML = initialContent;
        }

        // Sync Quill content with hidden textarea
        quill.on('text-change', function() {
            document.getElementById('noidung').value = quill.root.innerHTML;
            updateCharCounter('noidung', quill.getText().length);
        });

        // Character counters
        function updateCharCounter(fieldId, length) {
            const counter = document.getElementById(fieldId + '-counter');
            if (counter) {
                counter.textContent = length;
            }
        }

        // Initialize character counters
        document.getElementById('tieude').addEventListener('input', function() {
            updateCharCounter('tieude', this.value.length);
        });

        document.getElementById('mota').addEventListener('input', function() {
            updateCharCounter('mota', this.value.length);
        });

        // File upload handling
        const uploadZone = document.getElementById('uploadZone');
        const fileInput = document.getElementById('anh_bia');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        // Click to upload
        uploadZone.addEventListener('click', function() {
            fileInput.click();
        });

        // Drag and drop
        uploadZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadZone.classList.add('dragover');
        });

        uploadZone.addEventListener('dragleave', function() {
            uploadZone.classList.remove('dragover');
        });

        uploadZone.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileUpload(files[0]);
            }
        });

        // File input change
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                handleFileUpload(this.files[0]);
            }
        });

        // Handle file upload
        function handleFileUpload(file) {
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Chỉ chấp nhận file ảnh: JPG, PNG, GIF, WebP');
                return;
            }

            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('File quá lớn! Vui lòng chọn file nhỏ hơn 5MB');
                return;
            }

            // Preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
                uploadZone.style.display = 'none';
            };
            reader.readAsDataURL(file);

            // Set file to input
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
        }

        // Remove image
        function removeImage() {
            fileInput.value = '';
            previewImg.src = '';
            imagePreview.style.display = 'none';
            uploadZone.style.display = 'block';
        }

        // Preview functionality
        document.getElementById('previewBtn').addEventListener('click', function() {
            showPreview();
        });

        function showPreview() {
            const title = document.getElementById('tieude').value;
            const description = document.getElementById('mota').value;
            const content = quill.root.innerHTML;
            const coverImage = previewImg.src;

            let html = '';

            // Cover image
            if (coverImage && !coverImage.includes('data:,')) {
                html += `
                    <div style="text-align: center; margin-bottom: var(--space-6);">
                        <img src="${coverImage}" alt="Ảnh bìa" style="max-width: 100%; max-height: 400px; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg);">
                    </div>
                `;
            }

            // Title
            html += `<h1 style="font-size: 2.5rem; font-weight: 800; color: var(--text-primary); margin-bottom: var(--space-4); line-height: 1.2;">${title || '(Chưa có tiêu đề)'}</h1>`;

            // Description
            if (description) {
                html += `<p style="font-size: 1.25rem; color: var(--text-secondary); font-style: italic; margin-bottom: var(--space-6); line-height: 1.6;">${description}</p>`;
            }

            // Content
            html += `<div id="previewMainContent" style="font-size: 1.125rem; line-height: 1.8; color: var(--text-primary);">${content}</div>`;

            document.getElementById('previewContent').innerHTML = html;
            document.getElementById('previewModal').style.display = 'flex';
        }

        function closePreview() {
            document.getElementById('previewModal').style.display = 'none';
        }

        function changeFontSize(delta) {
            const content = document.getElementById('previewMainContent');
            if (!content) return;

            let currentSize = parseFloat(window.getComputedStyle(content).fontSize);
            let newSize = currentSize + (delta * 2);

            if (newSize < 12) newSize = 12;
            if (newSize > 32) newSize = 32;

            content.style.fontSize = newSize + 'px';
        }

        // Form submission handling
        document.getElementById('postForm').addEventListener('submit', function(e) {
            // Transfer Quill content to hidden textarea before validation
            document.getElementById('noidung').value = quill.root.innerHTML;

            // Validate required fields
            const title = document.getElementById('tieude').value.trim();
            const content = quill.getText().trim();

            if (!title) {
                e.preventDefault();
                alert('Vui lòng nhập tiêu đề bài viết');
                document.getElementById('tieude').focus();
                return;
            }

            if (content.length < 10) {
                e.preventDefault();
                alert('Nội dung bài viết phải có ít nhất 10 ký tự');
                quill.focus();
                return;
            }

            // Show loading state
            const submitButtons = this.querySelectorAll('button[type="submit"]');
            submitButtons.forEach(btn => {
                btn.disabled = true;
                const icon = btn.querySelector('i');
                if (icon) {
                    icon.className = 'fas fa-spinner fa-spin';
                }
            });
        });

        // Close preview on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePreview();
            }
        });

        // Initialize character counters on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCharCounter('tieude', document.getElementById('tieude').value.length);
            updateCharCounter('mota', document.getElementById('mota').value.length);
            updateCharCounter('noidung', quill.getText().length);
        });
    </script>
</body>

</html>