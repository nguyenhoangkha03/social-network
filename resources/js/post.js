document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo các tính năng
    initCharCounters();
    initDragAndDrop();
    initFormValidation();
    initAutoSave();
});

// Đếm ký tự cho các trường input
function initCharCounters() {
    const tieudeInput = document.getElementById('tieude');
    const motaTextarea = document.getElementById('mota');
    const noidungTextarea = document.getElementById('noidung');
    
    const tieudeCounter = document.getElementById('tieude-counter');
    const motaCounter = document.getElementById('mota-counter');
    const noidungCounter = document.getElementById('noidung-counter');
    
    // Đếm ký tự cho tiêu đề
    tieudeInput.addEventListener('input', function() {
        const count = this.value.length;
        tieudeCounter.textContent = count;
        
        if (count > 240) {
            tieudeCounter.style.color = '#ff4757';
        } else if (count > 200) {
            tieudeCounter.style.color = '#ffa502';
        } else {
            tieudeCounter.style.color = '#666';
        }
    });
    
    // Đếm ký tự cho mô tả
    motaTextarea.addEventListener('input', function() {
        const count = this.value.length;
        motaCounter.textContent = count;
        
        if (count > 500) {
            motaCounter.style.color = '#ff4757';
        } else if (count > 400) {
            motaCounter.style.color = '#ffa502';
        } else {
            motaCounter.style.color = '#666';
        }
    });
    
    // Đếm ký tự cho nội dung
    noidungTextarea.addEventListener('input', function() {
        const count = this.value.length;
        noidungCounter.textContent = count;
        
        if (count > 5000) {
            noidungCounter.style.color = '#ff4757';
        } else if (count > 4000) {
            noidungCounter.style.color = '#ffa502';
        } else {
            noidungCounter.style.color = '#666';
        }
    });
}

// Khởi tạo drag and drop cho upload ảnh
function initDragAndDrop() {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('anh_bia');
    
    // Ngăn chặn hành vi mặc định của trình duyệt
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    // Highlight vùng drop
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    // Xử lý file được drop
    uploadArea.addEventListener('drop', handleDrop, false);
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight(e) {
        uploadArea.classList.add('drag-over');
    }
    
    function unhighlight(e) {
        uploadArea.classList.remove('drag-over');
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            previewImage({ target: fileInput });
        }
    }
}

// Preview ảnh được chọn
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const uploadArea = document.getElementById('uploadArea');
    
    if (file) {
        // Kiểm tra kích thước file (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('File ảnh quá lớn. Vui lòng chọn file nhỏ hơn 5MB.');
            return;
        }
        
        // Kiểm tra loại file
        if (!file.type.startsWith('image/')) {
            alert('Vui lòng chọn file ảnh hợp lệ.');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
            uploadArea.style.display = 'none';
            
            // Hiệu ứng fade in
            preview.style.opacity = '0';
            preview.style.transform = 'scale(0.9)';
            setTimeout(() => {
                preview.style.transition = 'all 0.3s ease';
                preview.style.opacity = '1';
                preview.style.transform = 'scale(1)';
            }, 10);
        };
        reader.readAsDataURL(file);
    }
}

// Xóa ảnh preview
function removeImage() {
    const preview = document.getElementById('imagePreview');
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('anh_bia');
    
    // Hiệu ứng fade out
    preview.style.transition = 'all 0.3s ease';
    preview.style.opacity = '0';
    preview.style.transform = 'scale(0.9)';
    
    setTimeout(() => {
        preview.style.display = 'none';
        uploadArea.style.display = 'block';
        fileInput.value = '';
        
        // Reset hiệu ứng
        preview.style.opacity = '1';
        preview.style.transform = 'scale(1)';
    }, 300);
}

// Validation form
function initFormValidation() {
    const form = document.querySelector('.post-form');
    
    form.addEventListener('submit', function(e) {
        const tieude = document.getElementById('tieude').value.trim();
        const noidung = document.getElementById('noidung').value.trim();
        
        let isValid = true;
        let errorMessage = '';
        
        // Kiểm tra tiêu đề
        if (tieude.length < 10) {
            errorMessage += 'Tiêu đề phải có ít nhất 10 ký tự.\n';
            isValid = false;
        }
        
        if (tieude.length > 255) {
            errorMessage += 'Tiêu đề không được vượt quá 255 ký tự.\n';
            isValid = false;
        }
        
        // Kiểm tra nội dung
        if (noidung.length < 50) {
            errorMessage += 'Nội dung phải có ít nhất 50 ký tự.\n';
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Vui lòng kiểm tra lại:\n' + errorMessage);
        }
    });
}

// Auto save draft
function initAutoSave() {
    const tieude = document.getElementById('tieude');
    const mota = document.getElementById('mota');
    const noidung = document.getElementById('noidung');
    const dinhkhem = document.getElementById('dinhkhem');
    
    const fields = [tieude, mota, noidung, dinhkhem];
    
    fields.forEach(field => {
        field.addEventListener('input', function() {
            // Lưu vào localStorage
            const draft = {
                tieude: tieude.value,
                mota: mota.value,
                noidung: noidung.value,
                dinhkhem: dinhkhem.value,
                timestamp: Date.now()
            };
            
            localStorage.setItem('post_draft', JSON.stringify(draft));
            
            // Hiển thị thông báo auto save
            showAutoSaveNotification();
        });
    });
    
    // Khôi phục draft khi load trang
    const savedDraft = localStorage.getItem('post_draft');
    if (savedDraft) {
        const draft = JSON.parse(savedDraft);
        
        // Chỉ khôi phục nếu draft không quá cũ (24 giờ)
        if (Date.now() - draft.timestamp < 24 * 60 * 60 * 1000) {
            tieude.value = draft.tieude || '';
            mota.value = draft.mota || '';
            noidung.value = draft.noidung || '';
            dinhkhem.value = draft.dinhkhem || '';
            
            // Cập nhật counter
            tieude.dispatchEvent(new Event('input'));
            mota.dispatchEvent(new Event('input'));
            noidung.dispatchEvent(new Event('input'));
        }
    }
}

// Hiển thị thông báo auto save
function showAutoSaveNotification() {
    // Tạo notification element nếu chưa có
    let notification = document.getElementById('auto-save-notification');
    if (!notification) {
        notification = document.createElement('div');
        notification.id = 'auto-save-notification';
        notification.innerHTML = '<i class="fas fa-save"></i> Đã lưu bản nháp';
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2ed573;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 0.9rem;
            z-index: 1000;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        `;
        document.body.appendChild(notification);
    }
    
    // Hiển thị notification
    notification.style.opacity = '1';
    notification.style.transform = 'translateX(0)';
    
    // Ẩn sau 2 giây
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100%)';
    }, 2000);
}

// Xóa draft khi submit form thành công
document.querySelector('.post-form').addEventListener('submit', function() {
    localStorage.removeItem('post_draft');
});

// Thêm CSS cho drag over effect
const style = document.createElement('style');
style.textContent = `
    .file-upload-area.drag-over {
        border-color: #2ed573 !important;
        background: #f0fff4 !important;
        transform: scale(1.02) !important;
    }
    
    .file-upload-area.drag-over .upload-content i {
        color: #2ed573 !important;
        animation: bounce 0.5s infinite !important;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
`;
document.head.appendChild(style); 