<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản trị hệ thống - Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background: linear-gradient(120deg, #e0e7ff 0%, #f6f8fa 100%); }
        .admin-header {
            background: linear-gradient(90deg, #007bff 0%, #8f5eff 100%);
            color: #fff;
            padding: 28px 0 18px 0;
            text-align: center;
            border-radius: 0 0 24px 24px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            margin-bottom: 32px;
        }
        .admin-header h1 { font-size: 2.3rem; font-weight: 900; letter-spacing: 1px; margin: 0; }
        .admin-layout { display: flex; gap: 32px; max-width: 1200px; margin: 0 auto; }
        .admin-sidebar {
            min-width: 210px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            padding: 28px 0 18px 0;
            display: flex;
            flex-direction: column;
            gap: 18px;
            align-items: center;
            height: fit-content;
        }
        .admin-sidebar .menu-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 28px;
            border-radius: 8px;
            color: #333;
            font-weight: 600;
            font-size: 1.08rem;
            cursor: pointer;
            transition: background 0.18s, color 0.18s;
        }
        .admin-sidebar .menu-item.active, .admin-sidebar .menu-item:hover {
            background: linear-gradient(90deg, #007bff 0%, #8f5eff 100%);
            color: #fff;
        }
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 32px;
        }
        .admin-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            padding: 32px 36px 28px 36px;
            margin-bottom: 0;
        }
        .admin-card h2 {
            margin-top: 0;
            color: #5a3cff;
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin-bottom: 18px;
        }
        .admin-btn {
            background: linear-gradient(90deg, #007bff 0%, #8f5eff 100%);
            color: #fff;
            border: none;
            border-radius: 22px;
            padding: 10px 32px;
            font-size: 1.08rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 12px;
            transition: background 0.2s, transform 0.15s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .admin-btn:hover {
            background: linear-gradient(90deg, #8f5eff 0%, #007bff 100%);
            transform: scale(1.04);
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            background: #f9f9fb;
            border-radius: 12px;
            overflow: hidden;
            margin-top: 10px;
        }
        .admin-table th, .admin-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e0e3eb;
            text-align: left;
        }
        .admin-table th {
            background: #f1f3fa;
            color: #333;
            font-weight: 700;
        }
        .admin-table tr:last-child td { border-bottom: none; }
        .switch { position: relative; display: inline-block; width: 48px; height: 28px; margin-right: 12px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: #ccc; border-radius: 28px; transition: .3s; }
        .slider:before { position: absolute; content: ""; height: 22px; width: 22px; left: 3px; bottom: 3px; background: #fff; border-radius: 50%; transition: .3s; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .switch input:checked + .slider { background: #4caf50; }
        .switch input:checked + .slider:before { transform: translateX(20px); }
        @media (max-width: 900px) {
            .admin-layout { flex-direction: column; gap: 0; }
            .admin-sidebar { flex-direction: row; min-width: 0; border-radius: 16px 16px 0 0; padding: 18px 0; }
            .admin-main { padding: 0 2vw; }
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1><i class="fas fa-crown"></i> Trang quản trị hệ thống</h1>
    </div>
    <div id="toast-bg-success" style="display:none;position:fixed;top:32px;right:32px;z-index:9999;background:linear-gradient(90deg,#007bff,#8f5eff);color:#fff;padding:18px 32px;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,0.13);font-size:1.15rem;font-weight:600;align-items:center;gap:12px;"><i class='fas fa-check-circle' style='margin-right:10px;'></i> Đã đổi ảnh nền!</div>
    <div class="admin-layout">
        <nav class="admin-sidebar">
            <div class="admin-menu-item active" data-section="bg-section"><i class="fas fa-image"></i> Đổi ảnh top banner</div>
            <div class="admin-menu-item" data-section="color-section"><i class="fas fa-palette"></i> Đổi màu nền</div>
            <div class="admin-menu-item" data-section="notice-section"><i class="fas fa-bullhorn"></i> Thông báo chung</div>
            <div class="admin-menu-item" data-section="maintenance-section"><i class="fas fa-tools"></i> Bảo trì hệ thống</div>
            <div class="admin-menu-item" data-section="reports-section"><i class="fas fa-flag"></i> Báo cáo người dùng</div>
        </nav>
        <main class="admin-main">
            <section class="admin-card" id="bg-section" style="display:block;">
                <h2>Đổi album ảnh top banner trang chủ</h2>
                <form id="banner-form" enctype="multipart/form-data">
                    <input type="file" name="banners[]" accept="image/*" multiple required>
                    <button type="submit" class="btn-submit">Thêm ảnh banner</button>
                    <div style="font-size:0.95rem;color:#888;margin-top:6px;">Tối đa 5 ảnh. Nếu chỉ có 1 ảnh sẽ hiển thị như cũ, từ 2 ảnh trở lên sẽ tự động chuyển ảnh.</div>
                </form>
                <div id="banner-album-list" style="margin-top:18px;display:flex;gap:18px;flex-wrap:wrap;"></div>
            </section>
            <section class="admin-card" id="color-section" style="display:none;">
                <h2>Đổi màu nền background</h2>
                <form id="bgcolor-form">
                    <input type="color" name="bgcolor" id="bgcolor-picker" value="#e0e7ff">
                    <button type="submit" class="btn-submit">Lưu màu nền</button>
                    <button type="button" id="reset-bgcolor" style="margin-left:10px;">Màu mặc định</button>
                </form>
            </section>
            <section class="admin-card" id="notice-section" style="display:none;">
                <h2><i class="fas fa-bullhorn"></i> Đăng thông báo chung</h2>
                <form id="noticeForm">
                    <textarea id="noticeInput" rows="3" placeholder="Nhập thông báo..."></textarea>
                    <button type="submit" class="admin-btn"><i class="fas fa-paper-plane"></i> Đăng thông báo</button>
                </form>
                <div id="noticeResult"></div>
            </section>
            <section class="admin-card" id="maintenance-section" style="display:none;">
                <h2><i class="fas fa-tools"></i> Trạng thái bảo trì</h2>
                <label class="switch">
                    <input type="checkbox" id="maintenanceToggle">
                    <span class="slider"></span>
                </label>
                <span id="maintenanceStatus">Đang hoạt động</span>
            </section>
            <section class="admin-card" id="reports-section" style="display:none;">
                <h2><i class="fas fa-flag"></i> Báo cáo từ người dùng</h2>
                <table class="admin-table" id="reportsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Người báo cáo</th>
                            <th>Nội dung</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dữ liệu báo cáo sẽ được JS render ở đây -->
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <script src="/js/admin.js"></script>
    <script>
    // Tab chuyển đổi chức năng admin
    document.querySelectorAll('.admin-menu-item').forEach(item => {
        item.onclick = function() {
            document.querySelectorAll('.admin-menu-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.admin-card').forEach(card => card.style.display = 'none');
            const section = document.getElementById(this.dataset.section);
            if(section) section.style.display = 'block';
        }
    });
    // Toast thông báo đổi ảnh nền thành công
    function showBgSuccessToast(msg) {
        const toast = document.getElementById('toast-bg-success');
        toast.innerHTML = `<i class='fas fa-check-circle' style='margin-right:10px;'></i> ${msg}`;
        toast.style.display = 'flex';
        setTimeout(() => { toast.style.display = 'none'; }, 2200);
    }
    // Hiển thị album ảnh đã upload
    function loadBannerAlbum() {
        fetch('/admin-banner-album-list').then(r=>r.json()).then(data => {
            const list = document.getElementById('banner-album-list');
            list.innerHTML = '';
            (data.album||[]).forEach((img, idx) => {
                const div = document.createElement('div');
                div.style.position = 'relative';
                div.innerHTML = `<img src="/images/topbanner/${img}" style="width:180px;height:90px;object-fit:cover;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);"><button data-fn="${img}" style="position:absolute;top:4px;right:4px;background:#e74c3c;color:#fff;border:none;border-radius:50%;width:28px;height:28px;cursor:pointer;font-size:1.1rem;"><i class='fas fa-times'></i></button>`;
                div.querySelector('button').onclick = function() {
                    if(confirm('Xóa ảnh này khỏi album?')) {
                        fetch('/admin-delete-banner', {method:'POST',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,'Content-Type':'application/json'},body:JSON.stringify({file:img})}).then(r=>r.json()).then(data=>{if(data.success) loadBannerAlbum();});
                    }
                };
                list.appendChild(div);
            });
        });
    }
    loadBannerAlbum();
    // Xử lý upload nhiều ảnh banner
    const bannerForm = document.getElementById('banner-form');
    bannerForm && bannerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(bannerForm);
        fetch('/admin-upload-banner-album', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData
        }).then(r=>r.json()).then(data=>{
            if(data.success) showBgSuccessToast('Đã thêm ảnh banner!');
            loadBannerAlbum();
        });
    });
    // Xử lý đổi màu nền
    const bgcolorForm = document.getElementById('bgcolor-form');
    bgcolorForm && bgcolorForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const color = document.getElementById('bgcolor-picker').value;
        fetch('/admin-set-bgcolor', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({color})
        }).then(r=>r.json()).then(data=>{
            if(data.success) showBgSuccessToast('Đã đổi màu nền!');
        });
    });
    document.getElementById('reset-bgcolor')?.addEventListener('click', function() {
        const picker = document.getElementById('bgcolor-picker');
        picker.value = '#e0e7ff';
        // Tự động submit form để lưu màu mặc định
        document.getElementById('bgcolor-form').dispatchEvent(new Event('submit', {cancelable:true, bubbles:true}));
    });
    </script>
</body>
</html> 