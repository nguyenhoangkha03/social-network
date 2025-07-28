<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $callData['call_type'] === 'video' ? 'Video Call' : 'Voice Call' }} - ChatPost</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --success: #10b981;
            --error: #ef4444;
            --warning: #f59e0b;
            --surface-primary: #ffffff;
            --surface-dark: #1f2937;
            --text-primary: #0f172a;
            --text-inverse: #ffffff;
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .call-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-inverse);
        }

        .video-container {
            position: relative;
            width: 100%;
            height: 100%;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .local-video, .remote-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            background: #1f2937;
        }

        .local-video-small {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 200px;
            height: 150px;
            border-radius: 12px;
            border: 3px solid var(--surface-primary);
            z-index: 10;
            object-fit: cover;
            box-shadow: var(--shadow-xl);
        }

        .voice-call-ui {
            text-align: center;
            padding: 40px;
        }

        .user-avatar {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 6px solid var(--surface-primary);
            margin: 0 auto 30px;
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            animation: pulse 2s infinite;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-avatar.no-image {
            background: var(--surface-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
            color: var(--text-inverse);
        }

        .user-name {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .call-status {
            font-size: 18px;
            opacity: 0.8;
            margin-bottom: 40px;
        }

        .call-controls {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 20px;
            z-index: 100;
        }

        .control-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-xl);
        }

        .control-btn.mute {
            background: var(--surface-dark);
            color: var(--text-inverse);
        }

        .control-btn.mute.active {
            background: var(--error);
        }

        .control-btn.camera {
            background: var(--surface-dark);
            color: var(--text-inverse);
        }

        .control-btn.camera.active {
            background: var(--error);
        }

        .control-btn.end-call {
            background: var(--error);
            color: var(--text-inverse);
            width: 70px;
            height: 70px;
            font-size: 28px;
        }

        .control-btn.answer {
            background: var(--success);
            color: var(--text-inverse);
            width: 70px;
            height: 70px;
            font-size: 28px;
        }

        .control-btn:hover {
            transform: scale(1.1);
        }

        .incoming-call {
            text-align: center;
        }

        .incoming-call .user-name {
            margin-bottom: 20px;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .call-timer {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 18px;
            font-weight: 600;
            z-index: 10;
        }

        .call-info {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px;
            z-index: 10;
        }

        .connection-status {
            position: absolute;
            top: 70px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.7);
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 14px;
            z-index: 10;
        }

        .no-video-placeholder {
            width: 100%;
            height: 100%;
            background: var(--surface-dark);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-inverse);
        }

        .no-video-placeholder i {
            font-size: 100px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .local-video-small {
                width: 120px;
                height: 90px;
                top: 10px;
                right: 10px;
            }

            .control-btn {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }

            .control-btn.end-call,
            .control-btn.answer {
                width: 60px;
                height: 60px;
                font-size: 24px;
            }

            .user-avatar {
                width: 150px;
                height: 150px;
            }

            .user-name {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="call-container">
        <!-- Call Timer (hiển thị khi đã kết nối) -->
        <div class="call-timer" id="callTimer" style="display: none;">
            <span id="timerDisplay">00:00</span>
        </div>

        <!-- Call Info -->
        <div class="call-info" id="callInfo">
            {{ $callData['call_type'] === 'video' ? 'Video Call' : 'Voice Call' }}
        </div>

        <!-- Connection Status -->
        <div class="connection-status" id="connectionStatus">
            Đang kết nối...
        </div>

        <!-- Video Call UI -->
        @if($callData['call_type'] === 'video')
            <div class="video-container" id="videoContainer">
                <!-- Remote Video -->
                <video id="remoteVideo" class="remote-video" autoplay playsinline></video>
                
                <!-- Local Video (small) -->
                <video id="localVideo" class="local-video-small" autoplay muted playsinline></video>
                
                <!-- No Video Placeholder -->
                <div class="no-video-placeholder" id="noVideoPlaceholder">
                    <i class="fas fa-video-slash"></i>
                    <p>Camera chưa được bật</p>
                </div>
            </div>
        @endif

        <!-- Voice Call UI -->
        @if($callData['call_type'] === 'voice')
            <div class="voice-call-ui" id="voiceCallUI">
                <div class="user-avatar {{ (!$call->caller->hinhanh && !$call->receiver->hinhanh) ? 'no-image' : '' }}">
                    @php
                        $otherUser = ($currentUserId == $callData['caller_id']) ? $call->receiver : $call->caller;
                    @endphp
                    @if($otherUser->hinhanh)
                        <img src="data:image/jpeg;base64,{{ base64_encode($otherUser->hinhanh) }}" alt="Avatar">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                </div>
                <div class="user-name">{{ $otherUser->hoten ?? $otherUser->username }}</div>
                <div class="call-status" id="callStatus">
                    @if($currentUserId == $callData['caller_id'])
                        Đang gọi...
                    @else
                        Cuộc gọi đến
                    @endif
                </div>
            </div>
        @endif

        <!-- Call Controls -->
        <div class="call-controls">
            @if($currentUserId != $callData['caller_id'] && $callData['status'] === 'initiating')
                <!-- Incoming call - show answer/decline -->
                <button class="control-btn answer" id="answerBtn" onclick="answerCall()">
                    <i class="fas fa-phone"></i>
                </button>
                <button class="control-btn end-call" id="declineBtn" onclick="declineCall()">
                    <i class="fas fa-phone-slash"></i>
                </button>
            @else
                <!-- Regular call controls -->
                <button class="control-btn mute" id="muteBtn" onclick="toggleMute()">
                    <i class="fas fa-microphone"></i>
                </button>
                
                @if($callData['call_type'] === 'video')
                    <button class="control-btn camera" id="cameraBtn" onclick="toggleCamera()">
                        <i class="fas fa-video"></i>
                    </button>
                @endif
                
                <button class="control-btn end-call" id="endCallBtn" onclick="endCall()">
                    <i class="fas fa-phone-slash"></i>
                </button>
            @endif
        </div>
    </div>

    <script>
        const callId = '{{ $callId }}';
        const currentUserId = {{ $currentUserId }};
        const callType = '{{ $callData['call_type'] }}';
        const isCaller = {{ $currentUserId == $callData['caller_id'] ? 'true' : 'false' }};
        
        let localStream = null;
        let remoteStream = null;
        let peerConnection = null;
        let isMuted = false;
        let isCameraOff = false;
        let callStartTime = null;
        let timerInterval = null;

        // WebRTC Configuration
        const rtcConfig = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' }
            ]
        };

        // Initialize call
        document.addEventListener('DOMContentLoaded', function() {
            initializeCall();
            setupEventListeners();
            startSignalingPoll();
        });

        async function initializeCall() {
            try {
                // Get user media
                const constraints = {
                    audio: true,
                    video: callType === 'video'
                };

                localStream = await navigator.mediaDevices.getUserMedia(constraints);
                
                if (callType === 'video') {
                    document.getElementById('localVideo').srcObject = localStream;
                    document.getElementById('noVideoPlaceholder').style.display = 'none';
                }

                // Setup WebRTC
                setupWebRTC();
                
                // If caller, create offer
                if (isCaller) {
                    createOffer();
                }

            } catch (error) {
                console.error('Error accessing media devices:', error);
                alert('Không thể truy cập camera/microphone. Vui lòng kiểm tra quyền truy cập.');
            }
        }

        function setupWebRTC() {
            peerConnection = new RTCPeerConnection(rtcConfig);

            // Add local stream
            localStream.getTracks().forEach(track => {
                peerConnection.addTrack(track, localStream);
            });

            // Handle remote stream
            peerConnection.ontrack = function(event) {
                remoteStream = event.streams[0];
                if (callType === 'video') {
                    document.getElementById('remoteVideo').srcObject = remoteStream;
                }
            };

            // Handle ICE candidates
            peerConnection.onicecandidate = function(event) {
                if (event.candidate) {
                    // Send ICE candidate to other peer (implement signaling)
                    sendSignalingMessage({
                        type: 'ice-candidate',
                        candidate: event.candidate
                    });
                }
            };

            // Connection state changes
            peerConnection.onconnectionstatechange = function() {
                updateConnectionStatus(peerConnection.connectionState);
            };
        }

        async function createOffer() {
            try {
                const offer = await peerConnection.createOffer();
                await peerConnection.setLocalDescription(offer);
                
                // Send offer to other peer
                sendSignalingMessage({
                    type: 'offer',
                    offer: offer
                });
            } catch (error) {
                console.error('Error creating offer:', error);
            }
        }

        async function handleOffer(offer) {
            try {
                await peerConnection.setRemoteDescription(offer);
                const answer = await peerConnection.createAnswer();
                await peerConnection.setLocalDescription(answer);
                
                // Send answer back
                sendSignalingMessage({
                    type: 'answer',
                    answer: answer
                });
            } catch (error) {
                console.error('Error handling offer:', error);
            }
        }

        async function handleAnswer(answer) {
            try {
                await peerConnection.setRemoteDescription(answer);
            } catch (error) {
                console.error('Error handling answer:', error);
            }
        }

        async function handleIceCandidate(candidate) {
            try {
                await peerConnection.addIceCandidate(candidate);
            } catch (error) {
                console.error('Error adding ICE candidate:', error);
            }
        }

        function sendSignalingMessage(message) {
            fetch('/signaling/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    call_id: callId,
                    signal_type: message.type,
                    signal_data: message
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error('Failed to send signaling message');
                }
            })
            .catch(error => console.error('Signaling error:', error));
        }

        // Start polling for signaling messages
        function startSignalingPoll() {
            setInterval(async () => {
                try {
                    const response = await fetch(`/signaling/get/${callId}`);
                    const data = await response.json();
                    
                    if (data.signals && data.signals.length > 0) {
                        for (const signal of data.signals) {
                            await handleSignalingMessage(signal.data);
                        }
                    }
                } catch (error) {
                    console.error('Error polling signaling:', error);
                }
            }, 1000); // Poll every second
        }

        async function handleSignalingMessage(message) {
            try {
                switch (message.type) {
                    case 'offer':
                        await handleOffer(message.offer);
                        break;
                    case 'answer':
                        await handleAnswer(message.answer);
                        break;
                    case 'ice-candidate':
                        await handleIceCandidate(message.candidate);
                        break;
                }
            } catch (error) {
                console.error('Error handling signaling message:', error);
            }
        }

        function toggleMute() {
            isMuted = !isMuted;
            const audioTrack = localStream.getAudioTracks()[0];
            if (audioTrack) {
                audioTrack.enabled = !isMuted;
            }
            
            const muteBtn = document.getElementById('muteBtn');
            const icon = muteBtn.querySelector('i');
            
            if (isMuted) {
                muteBtn.classList.add('active');
                icon.className = 'fas fa-microphone-slash';
            } else {
                muteBtn.classList.remove('active');
                icon.className = 'fas fa-microphone';
            }
        }

        function toggleCamera() {
            if (callType !== 'video') return;
            
            isCameraOff = !isCameraOff;
            const videoTrack = localStream.getVideoTracks()[0];
            if (videoTrack) {
                videoTrack.enabled = !isCameraOff;
            }
            
            const cameraBtn = document.getElementById('cameraBtn');
            const icon = cameraBtn.querySelector('i');
            const placeholder = document.getElementById('noVideoPlaceholder');
            
            if (isCameraOff) {
                cameraBtn.classList.add('active');
                icon.className = 'fas fa-video-slash';
                placeholder.style.display = 'flex';
            } else {
                cameraBtn.classList.remove('active');
                icon.className = 'fas fa-video';
                placeholder.style.display = 'none';
            }
        }

        function answerCall() {
            fetch('/call/answer', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    call_id: callId,
                    action: 'accept'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    startCall();
                    // Start creating answer for the received offer
                    setTimeout(() => {
                        if (!isCaller) {
                            console.log('Ready to receive offer as callee');
                        }
                    }, 1000);
                }
            })
            .catch(error => console.error('Error answering call:', error));
        }

        function declineCall() {
            fetch('/call/answer', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    call_id: callId,
                    action: 'decline'
                })
            })
            .then(() => {
                window.location.href = '/chat';
            })
            .catch(error => console.error('Error declining call:', error));
        }

        function endCall() {
            fetch('/call/end', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    call_id: callId
                })
            })
            .then(() => {
                cleanup();
                window.location.href = '/chat';
            })
            .catch(error => console.error('Error ending call:', error));
        }

        function startCall() {
            callStartTime = Date.now();
            startTimer();
            
            // Hide answer/decline buttons
            const answerBtn = document.getElementById('answerBtn');
            const declineBtn = document.getElementById('declineBtn');
            if (answerBtn) answerBtn.style.display = 'none';
            if (declineBtn) declineBtn.style.display = 'none';
            
            // Update status
            const callStatus = document.getElementById('callStatus');
            if (callStatus) callStatus.textContent = 'Đang kết nối...';
            
            document.getElementById('connectionStatus').textContent = 'Đang thiết lập kết nối...';
            document.getElementById('callTimer').style.display = 'block';
            
            // Show regular call controls
            const muteBtn = document.getElementById('muteBtn');
            const endCallBtn = document.getElementById('endCallBtn');
            if (muteBtn) muteBtn.style.display = 'block';
            if (endCallBtn) endCallBtn.style.display = 'block';
            
            if (callType === 'video') {
                const cameraBtn = document.getElementById('cameraBtn');
                if (cameraBtn) cameraBtn.style.display = 'block';
            }
        }

        function startTimer() {
            timerInterval = setInterval(() => {
                const elapsed = Date.now() - callStartTime;
                const minutes = Math.floor(elapsed / 60000);
                const seconds = Math.floor((elapsed % 60000) / 1000);
                document.getElementById('timerDisplay').textContent = 
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }

        function updateConnectionStatus(state) {
            const statusElement = document.getElementById('connectionStatus');
            console.log('Connection state changed:', state);
            
            switch (state) {
                case 'connecting':
                    statusElement.textContent = 'Đang kết nối...';
                    break;
                case 'connected':
                    statusElement.textContent = 'Đã kết nối - Cuộc gọi đang hoạt động';
                    const callStatus = document.getElementById('callStatus');
                    if (callStatus) callStatus.textContent = 'Đã kết nối';
                    
                    if (!callStartTime) {
                        startCall();
                    }
                    break;
                case 'disconnected':
                    statusElement.textContent = 'Mất kết nối';
                    break;
                case 'failed':
                    statusElement.textContent = 'Kết nối thất bại - Kiểm tra mạng';
                    console.error('WebRTC connection failed');
                    break;
                case 'closed':
                    statusElement.textContent = 'Cuộc gọi đã kết thúc';
                    break;
            }
        }

        function cleanup() {
            if (localStream) {
                localStream.getTracks().forEach(track => track.stop());
            }
            if (peerConnection) {
                peerConnection.close();
            }
            if (timerInterval) {
                clearInterval(timerInterval);
            }
        }

        function setupEventListeners() {
            // Handle page unload
            window.addEventListener('beforeunload', function() {
                cleanup();
            });
        }

        // Poll for call status updates
        setInterval(() => {
            fetch(`/call/status/${callId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.call_data && data.call_data.status === 'declined') {
                        alert('Cuộc gọi đã bị từ chối');
                        window.location.href = '/chat';
                    }
                })
                .catch(error => console.error('Error checking call status:', error));
        }, 2000);
    </script>
</body>
</html>