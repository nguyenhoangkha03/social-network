<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng bài viết - SpiderClone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    @vite(['resources/css/post.css'])
</head>
<body>
    <!-- Nút mở sidebar -->
    <button id="toggleSidebarBtn" style="position:fixed;top:32px;left:32px;z-index:1200;background:#fff;border-radius:8px;padding:10px 18px;box-shadow:0 2px 8px rgba(0,0,0,0.10);border:none;display:flex;align-items:center;gap:8px;cursor:pointer;font-weight:500;font-size:1rem;">
        <i class="fas fa-list"></i> Danh sách bài viết
    </button>
    <!-- Sidebar drafts/published (ẩn mặc định) -->
    <aside id="sidebarPostList" class="sidebar" style="width: 320px; background: #f8f9fa; border-radius: 10px; padding: 18px 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); height: 100vh; position:fixed; top:0; left:-350px; z-index:1300; transition:left 0.3s; overflow-y:auto;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
            <h3 style="font-size: 1.1rem; color: #333; margin:0;">Bản nháp của bạn</h3>
            <button onclick="toggleSidebar()" style="background:none;border:none;font-size:1.3rem;color:#888;cursor:pointer;"><i class="fas fa-times"></i></button>
        </div>
        @if(isset($drafts) && count($drafts) > 0)
            <ul style="list-style: none; padding: 0; margin-bottom: 18px;">
                @foreach($drafts as $draft)
                <li style="margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                    <span style="flex:1; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        <a href="{{ route('post.create', ['edit' => $draft->id_baiviet]) }}" style="color:#007bff; text-decoration:underline;">{{ $draft->tieude ?? '(Chưa có tiêu đề)' }}</a>
                    </span>
                    <form method="POST" action="{{ route('post.deleteDraft', $draft->id_baiviet) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:#dc3545; cursor:pointer;" title="Xóa bản nháp"><i class="fas fa-trash"></i></button>
                    </form>
                </li>
                @endforeach
            </ul>
        @else
            <div style="color:#888; font-size:0.97rem; margin-bottom:18px;">Chưa có bản nháp nào.</div>
        @endif
        <h3 style="margin-bottom: 10px; font-size: 1.1rem; color: #333;">Bài đã đăng</h3>
        @if(isset($published) && count($published) > 0)
            <ul style="list-style: none; padding: 0;">
                @foreach($published as $post)
                <li style="margin-bottom: 10px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; display:flex; align-items:center; gap:8px;">
                    <a href="{{ route('post.create', ['edit' => $post->id_baiviet]) }}" style="color:#28a745; text-decoration:underline; flex:1;">{{ $post->tieude ?? '(Chưa có tiêu đề)' }}</a>
                    <form method="POST" action="{{ route('post.delete', $post->id_baiviet) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:#dc3545; cursor:pointer;" title="Gỡ bài"><i class="fas fa-trash"></i></button>
                    </form>
                </li>
                @endforeach
            </ul>
        @else
            <div style="color:#888; font-size:0.97rem;">Chưa có bài đã đăng.</div>
        @endif
    </aside>
    <!-- Overlay khi sidebar mở -->
    <div id="sidebarOverlay" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.18);z-index:1299;" onclick="toggleSidebar()"></div>
    <!-- Form soạn bài rộng hơn -->
    <div class="post-container" style="max-width:900px;margin:48px auto 0 auto;box-shadow:0 2px 16px rgba(0,0,0,0.07);border-radius:16px;padding:40px 48px 32px 48px;background:#fff;">
        <div class="post-header">
                <h1><i class="fas fa-edit"></i> Đăng bài viết mới</h1>
                <p>Chia sẻ kiến thức và kết nối với cộng đồng</p>
            </div>

            <form class="post-form" method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div class="alert error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="tieude">
                        <i class="fas fa-heading"></i> Tiêu đề bài viết
                    </label>
                    <input type="text" id="tieude" name="tieude" value="{{ old('tieude', isset($editPost) ? $editPost->tieude : '') }}" required placeholder="Nhập tiêu đề bài viết...">
                    <div class="char-counter">
                        <span id="tieude-counter">0</span>/255
                    </div>
                </div>

                <div class="form-group">
                    <label for="mota">
                        <i class="fas fa-align-left"></i> Mô tả ngắn
                    </label>
                    <textarea id="mota" name="mota" placeholder="Mô tả ngắn gọn về bài viết...">{{ old('mota', isset($editPost) ? $editPost->mota : '') }}</textarea>
                    <div class="char-counter">
                        <span id="mota-counter">0</span> ký tự
                    </div>
                </div>

                <div class="form-group">
                    <label for="noidung">
                        <i class="fas fa-file-alt"></i> Nội dung bài viết
                    </label>
                    <div style="margin-bottom: 10px;">
                        <button type="button" onclick="formatText('bold')" title="In đậm" style="font-weight:bold;padding:4px 10px;">B</button>
                        <button type="button" onclick="formatText('italic')" title="In nghiêng" style="font-style:italic;padding:4px 10px;">I</button>
                        <button type="button" onclick="formatText('underline')" title="Gạch chân" style="text-decoration:underline;padding:4px 10px;">U</button>
                        <button type="button" onclick="document.getElementById('insertImageInput').click()" title="Chèn ảnh" style="padding:4px 10px;">🖼️ Chèn ảnh</button>
                        <input type="file" id="insertImageInput" accept="image/*" style="display:none" onchange="handleInsertImage(this)">
                    </div>
                    <textarea id="noidung" name="noidung" required placeholder="Viết nội dung bài viết của bạn..." style="min-height: 320px; height: 420px; resize: vertical;">{{ old('noidung', isset($editPost) ? $editPost->noidung : '') }}</textarea>
                    <div class="char-counter">
                        <span id="noidung-counter">0</span> ký tự
                    </div>
                </div>

                <div class="form-group">
                    <label for="anh_bia">
                        <i class="fas fa-image"></i> Ảnh bìa bài viết
                    </label>
                    <div class="file-upload-area" id="uploadArea">
                        <input type="file" id="anh_bia" name="anh_bia" accept="image/*" onchange="previewImage(event)">
                        <div class="upload-content">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Kéo thả ảnh vào đây hoặc click để chọn</p>
                            <span>Hỗ trợ: JPG, PNG, GIF (Tối đa 5MB)</span>
                        </div>
                    </div>
                    <div class="image-preview" id="imagePreview" style="display: {{ isset($editPost) && $editPost->anh_bia ? 'block' : 'none' }}; margin-top:10px;">
                        <img id="previewImg" src="{{ isset($editPost) && $editPost->anh_bia ? asset($editPost->anh_bia) : '' }}" alt="Preview" style="max-width:100%;max-height:220px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                        <button type="button" class="remove-image" onclick="removeImage()" style="margin-top:6px;background:#fff;border:1px solid #ccc;padding:4px 12px;border-radius:6px;cursor:pointer;color:#dc3545;">
                            <i class="fas fa-times"></i> Xóa ảnh
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="dinhkhem">
                        <i class="fas fa-tags"></i> Từ khóa (tùy chọn)
                    </label>
                    <input type="text" id="dinhkhem" name="dinhkhem" value="{{ old('dinhkhem', isset($editPost) ? $editPost->dinhkhem : '') }}" placeholder="Nhập từ khóa, phân cách bằng dấu phẩy...">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="window.location.href='{{ route('home') }}'">
                        <i class="fas fa-home"></i> Về Trang Chủ
                    </button>
                    <button type="submit" class="btn-draft" name="save_draft" value="1">
                        <i class="fas fa-save"></i> Lưu nháp
                    </button>
                    <button type="button" class="btn-preview" onclick="showPreview()" style="background:#ffc107;color:#333;margin-right:8px;">
                        <i class="fas fa-eye"></i> Xem trước
                    </button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-paper-plane"></i> Đăng bài viết
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview Area -->
    <div id="postPreviewArea" style="display:none;max-width:900px;margin:32px auto 0 auto;background:#f9f9f9;border-radius:14px;box-shadow:0 2px 12px rgba(0,0,0,0.06);padding:32px 40px;">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <h2 style="margin:0;color:#007bff;"><i class="fas fa-eye"></i> Xem trước bài viết</h2>
            <div>
                <button onclick="changeFontSize(1)" style="background:#e0e0e0;border:none;border-radius:6px;padding:6px 14px;margin-right:6px;cursor:pointer;font-size:1.1rem;">A+</button>
                <button onclick="changeFontSize(-1)" style="background:#e0e0e0;border:none;border-radius:6px;padding:6px 14px;cursor:pointer;font-size:1.1rem;">A-</button>
                <button onclick="hidePreview()" style="background:none;border:none;font-size:1.5rem;color:#888;cursor:pointer;margin-left:10px;"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <hr style="margin:18px 0;">
        <div id="previewContent"></div>
    </div>

    @vite(['resources/js/post.js'])
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
            let openTag = '', closeTag = '';
            if (command === 'bold') {
                openTag = '<b>'; closeTag = '</b>';
            } else if (command === 'italic') {
                openTag = '<i>'; closeTag = '</i>';
            } else if (command === 'underline') {
                openTag = '<u>'; closeTag = '</u>';
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
            window.scrollTo({top: document.getElementById('postPreviewArea').offsetTop - 40, behavior: 'smooth'});
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
</body>
</html> 