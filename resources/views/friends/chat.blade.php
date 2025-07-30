<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tin nhắn - ChatPost</title>

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

        .chat-container {
            height: 100vh;
            display: grid;
            grid-template-columns: 350px 1fr;
            max-width: 1400px;
            margin: 0 auto;
            background: var(--surface);
            box-shadow: var(--shadow-xl);
        }

        /* Sidebar */
        .chat-sidebar {
            background: var(--surface-secondary);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: var(--space-6);
            border-bottom: 1px solid var(--border);
            background: var(--surface);
        }

        .sidebar-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: var(--space-2);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .sidebar-title i {
            color: var(--primary);
        }

        .back-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: var(--space-1);
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: var(--primary);
        }

        .search-box {
            padding: var(--space-4) var(--space-6);
            border-bottom: 1px solid var(--border);
        }

        .search-input {
            width: 100%;
            padding: var(--space-3) var(--space-4);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            background: var(--surface);
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgb(37 99 235 / 0.1);
        }

        .friends-list {
            flex: 1;
            overflow-y: auto;
            padding: var(--space-4);
        }

        .friend-item {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3);
            border-radius: var(--radius-lg);
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: var(--space-2);
        }

        .friend-item:hover {
            background: var(--surface);
        }

        .friend-item.active {
            background: var(--primary-light);
            color: var(--primary);
        }

        .friend-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            position: relative;
        }

        .friend-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .online-indicator {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            background: var(--success);
            border: 2px solid var(--surface);
            border-radius: 50%;
        }

        .friend-info {
            flex: 1;
            min-width: 0;
        }

        .friend-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: var(--space-1);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .friend-last-message {
            color: var(--text-tertiary);
            font-size: 0.875rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .message-time {
            color: var(--text-tertiary);
            font-size: 0.75rem;
            white-space: nowrap;
        }

        /* Main Chat Area */
        .chat-main {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .chat-header {
            padding: var(--space-6);
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .chat-user-info {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            flex: 1;
        }

        .chat-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .chat-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .chat-user-details h3 {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: var(--space-1);
        }

        .chat-user-status {
            color: var(--success);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: var(--space-1);
        }

        .chat-actions {
            display: flex;
            gap: var(--space-2);
        }

        .chat-action-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: var(--surface-secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--text-secondary);
        }

        .chat-action-btn:hover {
            background: var(--primary);
            color: white;
        }

        /* Messages Area */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: var(--space-6);
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }

        .message {
            display: flex;
            gap: var(--space-3);
            max-width: 70%;
        }

        .message.own {
            align-self: flex-end;
            flex-direction: row-reverse;
        }

        .message-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            margin-top: auto;
        }

        .message-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .message-content {
            flex: 1;
        }

        .message-bubble {
            padding: var(--space-3) var(--space-4);
            border-radius: var(--radius-xl);
            background: var(--surface-secondary);
            color: var(--text-primary);
            word-wrap: break-word;
            position: relative;
        }

        .message.own .message-bubble {
            background: var(--primary);
            color: white;
        }

        .message-image {
            max-width: 100%;
            border-radius: var(--radius-lg);
            margin-top: var(--space-2);
        }

        .message-time {
            font-size: 0.75rem;
            color: var(--text-tertiary);
            margin-top: var(--space-1);
            text-align: right;
        }

        .message.own .message-time {
            text-align: left;
        }

        /* Input Area */
        .chat-input-container {
            padding: var(--space-6);
            border-top: 1px solid var(--border);
            background: var(--surface);
        }

        .chat-input-form {
            display: flex;
            align-items: flex-end;
            gap: var(--space-3);
            background: var(--surface-secondary);
            border-radius: var(--radius-2xl);
            padding: var(--space-3);
        }

        .input-actions {
            display: flex;
            gap: var(--space-2);
        }

        .input-btn {
            width: 36px;
            height: 36px;
            border: none;
            background: transparent;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--text-secondary);
        }

        .input-btn:hover {
            background: var(--surface);
            color: var(--primary);
        }

        .message-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: var(--space-3) 0;
            font-size: 1rem;
            resize: none;
            outline: none;
            max-height: 120px;
            min-height: 24px;
        }

        .send-btn {
            width: 36px;
            height: 36px;
            border: none;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: white;
        }

        .send-btn:hover:not(:disabled) {
            background: var(--primary-dark);
            transform: scale(1.05);
        }

        .send-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Empty State */
        .empty-chat {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--text-tertiary);
            padding: var(--space-12);
        }

        .empty-chat i {
            font-size: 4rem;
            margin-bottom: var(--space-6);
            opacity: 0.5;
        }

        .empty-chat h3 {
            font-size: 1.5rem;
            margin-bottom: var(--space-3);
            color: var(--text-secondary);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .chat-container {
                grid-template-columns: 1fr;
                height: 100vh;
            }

            .chat-sidebar {
                position: fixed;
                left: -350px;
                width: 350px;
                height: 100vh;
                z-index: 1000;
                transition: left 0.3s ease;
            }

            .chat-sidebar.open {
                left: 0;
            }

            .mobile-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .mobile-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .mobile-menu-btn {
                display: block;
                width: 40px;
                height: 40px;
                border: none;
                background: var(--surface-secondary);
                border-radius: 50%;
                cursor: pointer;
                color: var(--text-secondary);
            }
        }

        @media (min-width: 769px) {
            .mobile-menu-btn {
                display: none;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--surface-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-tertiary);
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

        /* Typing Indicator */
        .typing-indicator {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-3) var(--space-4);
            background: var(--surface-secondary);
            border-radius: var(--radius-xl);
            margin: var(--space-2) 0;
        }

        .typing-dots {
            display: flex;
            gap: 2px;
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            background: var(--text-tertiary);
            border-radius: 50%;
            animation: typing 1.4s infinite;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {

            0%,
            60%,
            100% {
                transform: translateY(0);
            }

            30% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body>
    <div class="mobile-overlay" onclick="closeMobileSidebar()"></div>

    <div class="chat-container">
        <!-- Sidebar -->
        <div class="chat-sidebar" id="chatSidebar">
            <!-- Header -->
            <div class="sidebar-header">
                <h1 class="sidebar-title">
                    <i class="fas fa-comments"></i>
                    Tin nhắn
                </h1>
                <a href="{{ route('home') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Quay lại trang chủ
                </a>
            </div>

            <!-- Search -->
            <div class="search-box">
                <input type="text" class="search-input" placeholder="Tìm kiếm bạn bè..." id="searchInput">
            </div>

            <!-- Friends List -->
            <div class="friends-list" id="friendsList">
                <div class="loading-friends" style="text-align: center; padding: var(--space-8); color: var(--text-tertiary);">
                    <div class="loading"></div>
                    <p style="margin-top: var(--space-2);">Đang tải danh sách bạn bè...</p>
                </div>
            </div>
        </div>

        <!-- Main Chat -->
        <div class="chat-main">
            <!-- Chat Header -->
            <div class="chat-header" id="chatHeader" style="display: none;">
                <button class="mobile-menu-btn" onclick="openMobileSidebar()">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="chat-user-info">
                    <div class="chat-avatar" id="chatAvatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="chat-user-details">
                        <h3 id="chatUserName">Tên người dùng</h3>
                        <div class="chat-user-status">
                            <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                            Đang hoạt động
                        </div>
                    </div>
                </div>

                <div class="chat-actions">
                    <button class="chat-action-btn" title="Gọi điện" id="voiceCallBtn" onclick="initiateCallFromChat('voice')">
                        <i class="fas fa-phone"></i>
                    </button>
                    <button class="chat-action-btn" title="Video call" id="videoCallBtn" onclick="initiateCallFromChat('video')">
                        <i class="fas fa-video"></i>
                    </button>
                    <button class="chat-action-btn" title="Thông tin">
                        <i class="fas fa-info-circle"></i>
                    </button>
                </div>
            </div>

            <!-- Messages -->
            <div class="chat-messages" id="chatMessages">
                <div class="empty-chat">
                    <i class="fas fa-comments"></i>
                    <h3>Chọn một cuộc trò chuyện</h3>
                    <p>Chọn một người bạn từ danh sách bên trái để bắt đầu nhắn tin</p>
                </div>
            </div>

            <!-- Input Area -->
            <div class="chat-input-container" id="chatInputContainer" style="display: none;">
                <form class="chat-input-form" id="messageForm" enctype="multipart/form-data">
                    <div class="input-actions">
                        <button type="button" class="input-btn" title="Chọn ảnh">
                            <i class="fas fa-image"></i>
                            <input type="file" accept="image/*" style="display: none;" id="imageInput">
                        </button>
                        <button type="button" class="input-btn" title="Emoji">
                            <i class="fas fa-smile"></i>
                        </button>
                    </div>

                    <textarea class="message-input" id="messageInput" placeholder="Nhập tin nhắn..." rows="1"></textarea>

                    <button type="submit" class="send-btn" id="sendBtn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        let currentChatUser = null;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Initialize chat
        document.addEventListener('DOMContentLoaded', function() {
            loadFriends();
            setupEventListeners();
            startIncomingCallPolling(); // Add this line

            // Check if we have a specific friend to chat with
            const urlParams = new URLSearchParams(window.location.search);
            const friendId = urlParams.get('friend_id') || '{{ $friend->user_id ?? "" }}';
            if (friendId) {
                setTimeout(() => selectFriend(friendId), 1000);
            }
        });

        // Setup event listeners
        function setupEventListeners() {
            // Message form submission
            document.getElementById('messageForm').addEventListener('submit', function(e) {
                e.preventDefault();
                sendMessage();
            });

            // Auto-resize textarea
            const messageInput = document.getElementById('messageInput');
            messageInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });

            // Enter to send message
            messageInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            // Image upload
            document.querySelector('.input-btn').addEventListener('click', function() {
                document.getElementById('imageInput').click();
            });

            document.getElementById('imageInput').addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    sendImageMessage(e.target.files[0]);
                }
            });

            // Search friends
            document.getElementById('searchInput').addEventListener('input', function() {
                filterFriends(this.value);
            });
        }

        // Load friends list
        async function loadFriends() {
            try {
                const response = await fetch('/api/friends');
                const data = await response.json();

                if (data.friends) {
                    displayFriends(data.friends);
                } else {
                    showNoFriends();
                }
            } catch (error) {
                console.error('Error loading friends:', error);
                showNoFriends();
            }
        }

        // Display friends
        function displayFriends(friends) {
            const friendsList = document.getElementById('friendsList');

            if (friends.length === 0) {
                showNoFriends();
                return;
            }

            friendsList.innerHTML = friends.map(friend => `
                <div class="friend-item" onclick="selectFriend(${friend.user_id})" data-friend-id="${friend.user_id}">
                    <div class="friend-avatar">
                        ${friend.avatar ? 
                            `<img src="${friend.avatar}" alt="${friend.hoten}">` : 
                            `${friend.hoten.charAt(0).toUpperCase()}`
                        }
                        <div class="online-indicator"></div>
                    </div>
                    <div class="friend-info">
                        <div class="friend-name">${friend.hoten}</div>
                        <div class="friend-last-message">Nhấn để bắt đầu trò chuyện</div>
                    </div>
                    <div class="message-time">
                        <i class="fas fa-circle" style="font-size: 0.5rem; color: var(--success);"></i>
                    </div>
                </div>
            `).join('');
        }

        // Show no friends message
        function showNoFriends() {
            document.getElementById('friendsList').innerHTML = `
                <div style="text-align: center; padding: var(--space-8); color: var(--text-tertiary);">
                    <i class="fas fa-user-friends" style="font-size: 2rem; margin-bottom: var(--space-4); opacity: 0.5;"></i>
                    <p>Chưa có bạn bè nào</p>
                    <p style="font-size: 0.875rem; margin-top: var(--space-2);">Hãy kết bạn để bắt đầu trò chuyện</p>
                </div>
            `;
        }

        // Select friend to chat with
        async function selectFriend(friendId) {
            console.log(friendId);
            currentChatUser = friendId;

            // Update active state
            document.querySelectorAll('.friend-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector(`[data-friend-id="${friendId}"]`)?.classList.add('active');

            // Show chat header and input
            document.getElementById('chatHeader').style.display = 'flex';
            document.getElementById('chatInputContainer').style.display = 'block';

            // Load friend info and messages
            await loadChatData(friendId);

            // Close mobile sidebar
            closeMobileSidebar();
        }

        // Load chat data
        async function loadChatData(friendId) {
            try {
                // Set current chat user for call functionality
                currentChatUserId = friendId;

                // Load friend info (you might want to create an API endpoint for this)
                const friendElement = document.querySelector(`[data-friend-id="${friendId}"]`);
                if (friendElement) {
                    const friendName = friendElement.querySelector('.friend-name').textContent;
                    const friendAvatar = friendElement.querySelector('.friend-avatar img')?.src;

                    // Update chat header
                    document.getElementById('chatUserName').textContent = friendName;
                    const chatAvatar = document.getElementById('chatAvatar');
                    if (friendAvatar) {
                        chatAvatar.innerHTML = `<img src="${friendAvatar}" alt="${friendName}">`;
                    } else {
                        chatAvatar.innerHTML = friendName.charAt(0).toUpperCase();
                    }
                }

                // Load messages
                const response = await fetch(`/api/chat/messages/${friendId}`);
                const data = await response.json();

                if (data.messages) {
                    displayMessages(data.messages);

                    // Set last message time and start polling
                    if (data.messages.length > 0) {
                        const latestMessage = data.messages[data.messages.length - 1];
                        lastMessageTime = new Date(latestMessage.thoigiantao).getTime();
                    }
                    startMessagePolling();
                }
            } catch (error) {
                console.error('Error loading chat data:', error);
            }
        }

        // Display messages
        function displayMessages(messages) {
            const chatMessages = document.getElementById('chatMessages');

            if (messages.length === 0) {
                chatMessages.innerHTML = `
                    <div class="empty-chat">
                        <i class="fas fa-comment-dots"></i>
                        <h3>Chưa có tin nhắn</h3>
                        <p>Hãy gửi tin nhắn đầu tiên để bắt đầu cuộc trò chuyện</p>
                    </div>
                `;
                return;
            }

            chatMessages.innerHTML = messages.map(message => `
                <div class="message ${message.me ? 'own' : ''}">
                    <div class="message-avatar">
                        ${message.me ? 'Bạn'.charAt(0) : 'A'}
                    </div>
                    <div class="message-content">
                        <div class="message-bubble">
                            ${message.noidung}
                            ${message.hinhanh ? `<img src="/${message.hinhanh}" alt="Hình ảnh" class="message-image">` : ''}
                        </div>
                        <div class="message-time">
                            ${formatMessageTime(message.thoigiantao)}
                        </div>
                    </div>
                </div>
            `).join('');

            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Send message
        async function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();

            if (!message || !currentChatUser) return;

            const sendBtn = document.getElementById('sendBtn');
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<div class="loading"></div>';

            try {
                const response = await fetch('/api/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        receiver_id: currentChatUser,
                        noidung: message
                    })
                });


                const data = await response.json();

                if (data.success) {
                    messageInput.value = '';
                    messageInput.style.height = 'auto';

                    // Add message immediately to UI for instant feedback
                    const newMessage = {
                        id: Date.now(),
                        me: true,
                        noidung: message,
                        thoigiantao: new Date().toISOString()
                    };

                    // The polling will pick up the real message from server soon
                    setTimeout(() => {
                        if (currentChatUserId) {
                            // Force refresh messages to get the real message from server
                            fetch(`/api/chat/messages/${currentChatUserId}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.messages) {
                                        displayMessages(data.messages);
                                        const messagesContainer = document.getElementById('chatMessages');
                                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                                    }
                                });
                        }
                    }, 500);
                } else {
                    alert('Gửi tin nhắn thất bại: ' + (data.error || 'Lỗi không xác định'));
                }
            } catch (error) {
                console.error('Error sending message:', error);
                alert('Lỗi khi gửi tin nhắn');
            } finally {
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
            }
        }

        // Send image message
        async function sendImageMessage(file) {
            if (!currentChatUser) return;

            const formData = new FormData();
            formData.append('receiver_id', currentChatUser);
            formData.append('noidung', 'Đã gửi một hình ảnh');
            formData.append('hinhanh', file);

            try {
                const response = await fetch('/api/chat/send', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    loadChatData(currentChatUser); // Reload messages
                } else {
                    alert('Gửi ảnh thất bại: ' + (data.error || 'Lỗi không xác định'));
                }
            } catch (error) {
                console.error('Error sending image:', error);
                alert('Lỗi khi gửi ảnh');
            }
        }

        // Filter friends
        function filterFriends(query) {
            const friends = document.querySelectorAll('.friend-item');
            friends.forEach(friend => {
                const name = friend.querySelector('.friend-name').textContent.toLowerCase();
                if (name.includes(query.toLowerCase())) {
                    friend.style.display = 'flex';
                } else {
                    friend.style.display = 'none';
                }
            });
        }

        // Format message time
        function formatMessageTime(timestamp) {
            const date = new Date(timestamp);
            const now = new Date();
            const diffTime = Math.abs(now - date);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays === 1) {
                return 'Hôm nay ' + date.toLocaleTimeString('vi-VN', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            } else if (diffDays === 2) {
                return 'Hôm qua ' + date.toLocaleTimeString('vi-VN', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            } else {
                return date.toLocaleDateString('vi-VN') + ' ' + date.toLocaleTimeString('vi-VN', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
        }

        // Mobile sidebar functions
        function openMobileSidebar() {
            document.getElementById('chatSidebar').classList.add('open');
            document.querySelector('.mobile-overlay').classList.add('active');
        }

        function closeMobileSidebar() {
            document.getElementById('chatSidebar').classList.remove('open');
            document.querySelector('.mobile-overlay').classList.remove('active');
        }

        // Real-time messaging
        let messagePollingInterval = null;
        let lastMessageTime = null;

        function startMessagePolling() {
            if (messagePollingInterval) {
                clearInterval(messagePollingInterval);
            }

            messagePollingInterval = setInterval(async () => {
                if (currentChatUserId) {
                    try {
                        const response = await fetch(`/api/chat/messages/${currentChatUserId}`);
                        const data = await response.json();

                        if (data.messages && data.messages.length > 0) {
                            const latestMessage = data.messages[data.messages.length - 1];
                            const latestTime = new Date(latestMessage.thoigiantao).getTime();

                            // Only reload if there are new messages
                            if (!lastMessageTime || latestTime > lastMessageTime) {
                                displayMessages(data.messages);
                                lastMessageTime = latestTime;

                                // Scroll to bottom for new messages
                                const messagesContainer = document.getElementById('chatMessages');
                                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                            }
                        }
                    } catch (error) {
                        console.error('Error polling messages:', error);
                    }
                }
            }, 2000); // Poll every 2 seconds
        }

        function stopMessagePolling() {
            if (messagePollingInterval) {
                clearInterval(messagePollingInterval);
                messagePollingInterval = null;
            }
        }

        // Call functionality
        let currentChatUserId = null;

        function initiateCallFromChat(callType) {
            if (!currentChatUserId) {
                alert('Vui lòng chọn người để chat trước');
                return;
            }

            // Show loading state
            const btn = callType === 'voice' ? document.getElementById('voiceCallBtn') : document.getElementById('videoCallBtn');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;

            fetch('/call/initiate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        receiver_id: currentChatUserId,
                        call_type: callType
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Open call in new window or redirect
                        window.location.href = `/call/${data.call_id}`;
                    } else {
                        alert(data.error || 'Không thể khởi tạo cuộc gọi');
                        btn.innerHTML = originalContent;
                        btn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error initiating call:', error);
                    alert('Có lỗi xảy ra khi khởi tạo cuộc gọi');
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                });
        }

        // Incoming call polling
        function startIncomingCallPolling() {
            setInterval(async () => {
                try {
                    const response = await fetch('/api/incoming-calls');
                    const data = await response.json();
                    
                    if (data.calls && data.calls.length > 0) {
                        for (const call of data.calls) {
                            showIncomingCallNotification(call);
                        }
                    }
                } catch (error) {
                    console.error('Error checking incoming calls:', error);
                }
            }, 2000); // Check every 2 seconds
        }

        function showIncomingCallNotification(call) {
            // Check if notification already exists
            if (document.getElementById(`call-notification-${call.call_id}`)) {
                return;
            }

            // Create notification element
            const notification = document.createElement('div');
            notification.id = `call-notification-${call.call_id}`;
            notification.className = 'incoming-call-notification';
            notification.innerHTML = `
                <div class="call-notification-content">
                    <div class="call-avatar">
                        ${call.caller_avatar ? 
                            `<img src="data:image/jpeg;base64,${call.caller_avatar}" alt="Avatar">` : 
                            '<i class="fas fa-user"></i>'
                        }
                    </div>
                    <div class="call-info">
                        <div class="caller-name">${call.caller_name}</div>
                        <div class="call-type">
                            <i class="fas fa-${call.call_type === 'video' ? 'video' : 'phone'}"></i>
                            ${call.call_type === 'video' ? 'Video call' : 'Voice call'} đến
                        </div>
                    </div>
                    <div class="call-actions">
                        <button class="answer-btn" onclick="answerIncomingCall('${call.call_id}')">
                            <i class="fas fa-phone"></i>
                        </button>
                        <button class="decline-btn" onclick="declineIncomingCall('${call.call_id}')">
                            <i class="fas fa-phone-slash"></i>
                        </button>
                    </div>
                </div>
            `;

            // Add styles if not exists
            if (!document.getElementById('incoming-call-styles')) {
                const styles = document.createElement('style');
                styles.id = 'incoming-call-styles';
                styles.textContent = `
                    .incoming-call-notification {
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: white;
                        border-radius: 12px;
                        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
                        padding: 16px;
                        z-index: 10000;
                        animation: slideIn 0.3s ease-out;
                        border-left: 4px solid #10b981;
                    }
                    
                    .call-notification-content {
                        display: flex;
                        align-items: center;
                        gap: 12px;
                    }
                    
                    .call-avatar {
                        width: 48px;
                        height: 48px;
                        border-radius: 50%;
                        overflow: hidden;
                        background: #f3f4f6;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
                    
                    .call-avatar img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }
                    
                    .call-avatar i {
                        font-size: 20px;
                        color: #9ca3af;
                    }
                    
                    .call-info {
                        flex: 1;
                    }
                    
                    .caller-name {
                        font-weight: 600;
                        color: #111827;
                        margin-bottom: 4px;
                    }
                    
                    .call-type {
                        color: #6b7280;
                        font-size: 14px;
                        display: flex;
                        align-items: center;
                        gap: 6px;
                    }
                    
                    .call-actions {
                        display: flex;
                        gap: 8px;
                    }
                    
                    .answer-btn, .decline-btn {
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                        border: none;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        cursor: pointer;
                        transition: all 0.2s;
                    }
                    
                    .answer-btn {
                        background: #10b981;
                        color: white;
                    }
                    
                    .answer-btn:hover {
                        background: #059669;
                        transform: scale(1.05);
                    }
                    
                    .decline-btn {
                        background: #ef4444;
                        color: white;
                    }
                    
                    .decline-btn:hover {
                        background: #dc2626;
                        transform: scale(1.05);
                    }
                    
                    @keyframes slideIn {
                        from {
                            transform: translateX(100%);
                            opacity: 0;
                        }
                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }
                `;
                document.head.appendChild(styles);
            }

            document.body.appendChild(notification);

            // Auto remove after 30 seconds
            setTimeout(() => {
                if (document.getElementById(`call-notification-${call.call_id}`)) {
                    notification.remove();
                }
            }, 30000);
        }

        function answerIncomingCall(callId) {
            // Remove notification
            const notification = document.getElementById(`call-notification-${callId}`);
            if (notification) notification.remove();
            
            // Redirect to call page
            window.location.href = `/call/${callId}`;
        }

        function declineIncomingCall(callId) {
            // Remove notification
            const notification = document.getElementById(`call-notification-${callId}`);
            if (notification) notification.remove();
            
            // Send decline request
            fetch('/call/answer', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    call_id: callId,
                    action: 'decline'
                })
            }).catch(error => console.error('Error declining call:', error));
        }
    </script>
</body>

</html>