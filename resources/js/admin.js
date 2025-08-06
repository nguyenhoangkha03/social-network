// Xem trước ảnh nền
const bgInput = document.getElementById('bgInput');
const bgPreview = document.getElementById('bgPreview');
bgInput.addEventListener('change', function() {
    bgPreview.innerHTML = '';
    if (bgInput.files && bgInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            bgPreview.appendChild(img);
        };
        reader.readAsDataURL(bgInput.files[0]);
    }
});

document.getElementById('bgForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const file = bgInput.files[0];
    if (!file) {
        alert('Vui lòng chọn ảnh!');
        return;
    }
    const formData = new FormData();
    formData.append('bg', file);
    const res = await fetch('/admin/upload-bg', {
        method: 'POST',
        body: formData
    });
    const data = await res.json();
    if (data.success) {
        alert('Đã đổi ảnh nền thành công!');
    } else {
        alert('Lỗi: ' + (data.error || 'Không thể đổi ảnh nền'));
    }
});

document.getElementById('noticeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const notice = document.getElementById('noticeInput').value.trim();
    if (!notice) {
        document.getElementById('noticeResult').textContent = 'Vui lòng nhập thông báo!';
        return;
    }
    document.getElementById('noticeResult').textContent = 'Đã đăng thông báo: ' + notice;
    document.getElementById('noticeInput').value = '';
});

const maintenanceToggle = document.getElementById('maintenanceToggle');
const maintenanceStatus = document.getElementById('maintenanceStatus');
maintenanceToggle.addEventListener('change', function() {
    if (maintenanceToggle.checked) {
        maintenanceStatus.textContent = 'Bảo trì (người dùng không thể truy cập)';
        maintenanceStatus.style.color = '#e53935';
    } else {
        maintenanceStatus.textContent = 'Đang hoạt động';
        maintenanceStatus.style.color = '#388e3c';
    }
});

// Render báo cáo mẫu
document.addEventListener('DOMContentLoaded', function() {
    const reports = [
        {id: 1, user: 'Nguyễn Văn A', content: 'Spam tin nhắn', time: '2024-07-22 10:15'},
        {id: 2, user: 'Trần Thị B', content: 'Nội dung không phù hợp', time: '2024-07-22 11:02'},
        {id: 3, user: 'Lê Văn C', content: 'Báo cáo lỗi hệ thống', time: '2024-07-22 12:30'}
    ];
    const tbody = document.querySelector('#reportsTable tbody');
    tbody.innerHTML = '';
    reports.forEach(r => {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${r.id}</td><td>${r.user}</td><td>${r.content}</td><td>${r.time}</td>`;
        tbody.appendChild(tr);
    });
}); 