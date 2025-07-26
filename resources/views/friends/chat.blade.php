<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chat 1-1</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/chat.css">
</head>
<body>
<div class="chat-container">
    <div class="chat-sidebar">
        <a href="/" class="back-to-home" style="display:block;padding:12px 18px 8px 18px;font-weight:600;font-size:1rem;color:#007bff;text-decoration:none;"><i class="fas fa-arrow-left"></i> Quay lại trang chủ</a>
        <div class="sidebar-title">Bạn bè</div>
        <ul class="friend-list" id="friendList"></ul>
    </div>
    <div class="chat-main">
        <div class="chat-header" id="chatHeader">Chọn bạn để bắt đầu trò chuyện</div>
        <div class="chat-messages" id="chatMessages"></div>
        <form class="chat-input-area" id="chatForm" autocomplete="off" enctype="multipart/form-data" style="display:flex;align-items:center;gap:8px;">
            <button type="button" id="emojiBtn" class="chat-emoji-btn" title="Chèn emoji" style="font-size:1.5rem;background:none;border:none;cursor:pointer;">😊</button>
            <input type="text" id="chatInput" class="chat-input" placeholder="Nhập tin nhắn..." />
            <label for="chatImage" style="margin:0;cursor:pointer;display:flex;align-items:center;">
                <img src="/images/sendimg.png" alt="Gửi ảnh" style="height:28px;width:28px;object-fit:contain;vertical-align:middle;margin-right:2px;" title="Gửi ảnh" />
                <input type="file" id="chatImage" name="chatImage" accept="image/*" style="display:none;">
            </label>
            <button type="submit" class="chat-send-btn animated-send-btn" style="padding:0 16px;background:none;border:none;">
                <svg width="32" height="32" viewBox="0 0 32 32"><circle cx="16" cy="16" r="16" fill="#0099ff"/><polygon points="12,8 24,16 12,24" fill="#fff"/></svg>
            </button>
        </form>
        <div id="emojiPicker" style="display:none;position:absolute;z-index:1000;background:#fff;border:1px solid #ccc;padding:8px;max-width:220px;max-height:180px;overflow:auto;"></div>
    </div>
</div>
<script src="/js/chat.js"></script>
<script>
// Hiển thị tên file đã chọn (nếu muốn)
document.getElementById('chatImage').addEventListener('change', function(e) {
    if(e.target.files && e.target.files[0]) {
        console.log(e.target.files[0].name);
        this.previousElementSibling.title = e.target.files[0].name;
    }
});
</script>
</body>
</html>
