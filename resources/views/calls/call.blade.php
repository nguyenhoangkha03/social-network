<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $callData['call_type'] === 'video' ? 'Video Call' : 'Voice Call' }} - ChatPost</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
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
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .call-container {
            text-align: center;
            padding: 40px;
        }

        .user-avatar {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 6px solid white;
            margin: 0 auto 30px;
            overflow: hidden;
            box-shadow: 0 20px 25px rgba(0,0,0,0.3);
            animation: pulse 2s infinite;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-avatar.no-image {
            background: #1f2937;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
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
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 40px;
            position: relative;
            z-index: 100;
        }

        .control-btn {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .control-btn:hover {
            transform: scale(1.1);
        }

        .control-btn.answer {
            background: #10b981;
            color: white;
        }

        .control-btn.decline {
            background: #ef4444;
            color: white;
        }

        .control-btn.end-call {
            background: #ef4444;
            color: white;
        }

        .control-btn.mute {
            background: #374151;
            color: white;
        }

        .control-btn.mute.active {
            background: #ef4444;
        }

        .control-btn.camera {
            background: #374151;
            color: white;
        }

        .control-btn.camera.active {
            background: #ef4444;
        }

        .call-timer {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.5);
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 18px;
            font-weight: 600;
            display: none;
            z-index: 1000;
        }

        .connection-status {
            position: absolute;
            top: 70px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.7);
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 14px;
            z-index: 1000;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @media (max-width: 768px) {
            .control-btn {
                width: 60px;
                height: 60px;
                font-size: 20px;
            }
            .user-avatar {
                width: 150px;
                height: 150px;
            }
            .user-name {
                font-size: 24px;
            }
        }

        /* Video Call Styles */
        .video-call-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remote-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            background: #1f2937;
        }

        .local-video {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 200px;
            height: 150px;
            border-radius: 12px;
            border: 3px solid white;
            object-fit: cover;
            background: #1f2937;
            z-index: 10;
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
        }

        .no-video-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            z-index: 5;
        }

        .no-video-placeholder .user-avatar {
            margin-bottom: 20px;
        }

        /* Fixed positioning for video call controls */
        .video-call-container .call-controls {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
        }

        @media (max-width: 768px) {
            .local-video {
                width: 120px;
                height: 90px;
                top: 10px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="call-timer" id="callTimer">
        <span id="timerDisplay">00:00</span>
    </div>

    <div class="connection-status" id="connectionStatus">
        Đang kết nối...
    </div>

    <!-- Video Call Container -->
    @if($callData['call_type'] === 'video')
        <div class="video-call-container">
            <!-- Remote Video (full screen) -->
            <video id="remoteVideo" class="remote-video" autoplay playsinline></video>
            
            <!-- Local Video (small overlay) -->
            <video id="localVideo" class="local-video" autoplay muted playsinline></video>
            
            <!-- Video placeholder when no video -->
            <div class="no-video-placeholder" id="noVideoPlaceholder">
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
                        Video Call - Đang gọi...
                    @else
                        Video Call - Cuộc gọi đến
                    @endif
                </div>
            </div>

            <div class="call-controls">
                @if($currentUserId != $callData['caller_id'] && $callData['status'] === 'initiating')
                    <!-- Incoming call buttons -->
                    <button class="control-btn answer" id="answerBtn" onclick="answerCall()">
                        <i class="fas fa-phone"></i>
                    </button>
                    <button class="control-btn decline" id="declineBtn" onclick="declineCall()">
                        <i class="fas fa-phone-slash"></i>
                    </button>
                @else
                    <!-- In-call buttons -->
                    <button class="control-btn mute" id="muteBtn" onclick="toggleMute()" style="display: none;">
                        <i class="fas fa-microphone"></i>
                    </button>
                    <button class="control-btn camera" id="cameraBtn" onclick="toggleCamera()" style="display: none;">
                        <i class="fas fa-video"></i>
                    </button>
                    <button class="control-btn end-call" id="endCallBtn" onclick="endCall()" style="display: none;">
                        <i class="fas fa-phone-slash"></i>
                    </button>
                @endif
            </div>
        </div>
    @else
        <!-- Voice Call Container -->
        <div class="call-container">
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
                    Voice Call - Đang gọi...
                @else
                    Voice Call - Cuộc gọi đến
                @endif
            </div>

            <div class="call-controls">
                @if($currentUserId != $callData['caller_id'] && $callData['status'] === 'initiating')
                    <!-- Incoming call buttons -->
                    <button class="control-btn answer" id="answerBtn" onclick="answerCall()">
                        <i class="fas fa-phone"></i>
                    </button>
                    <button class="control-btn decline" id="declineBtn" onclick="declineCall()">
                        <i class="fas fa-phone-slash"></i>
                    </button>
                @else
                    <!-- In-call buttons -->
                    <button class="control-btn mute" id="muteBtn" onclick="toggleMute()" style="display: none;">
                        <i class="fas fa-microphone"></i>
                    </button>
                    <button class="control-btn end-call" id="endCallBtn" onclick="endCall()" style="display: none;">
                        <i class="fas fa-phone-slash"></i>
                    </button>
                @endif
            </div>
        </div>
    @endif

    <!-- Audio elements for call -->
    <audio id="localAudio" autoplay muted></audio>
    <audio id="remoteAudio" autoplay></audio>

    <script>
        // Call data
        const callId = '{{ $callId }}';
        const currentUserId = {{ $currentUserId }};
        const callType = '{{ $callData['call_type'] ?? 'voice' }}';
        const isCaller = {{ $currentUserId == $callData['caller_id'] ? 'true' : 'false' }};
        
        console.log('Call type:', callType);
        
        // Call state
        let localStream = null;
        let remoteStream = null;
        let peerConnection = null;
        let isMuted = false;
        let isVideoOff = false;
        let callStartTime = null;
        let timerInterval = null;
        let isCallConnected = false;

        // Improved WebRTC configuration for video
        const rtcConfig = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' },
                { urls: 'stun:stun2.l.google.com:19302' }
            ],
            iceCandidatePoolSize: 10,
            bundlePolicy: 'max-compat',
            rtcpMuxPolicy: 'require'
        };

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing call...', {callId, currentUserId, isCaller});
            initializeCall();
            startStatusPolling();
            startSignalingPolling();
        });

        async function initializeCall() {
            try {
                console.log('Initializing', callType, 'call...');
                
                // Enhanced media constraints for video
                const constraints = {
                    audio: {
                        echoCancellation: true,
                        noiseSuppression: true,
                        autoGainControl: true
                    },
                    video: callType === 'video' ? {
                        width: { ideal: 1280, max: 1920 },
                        height: { ideal: 720, max: 1080 },
                        frameRate: { ideal: 30, max: 60 }
                    } : false
                };
                
                localStream = await navigator.mediaDevices.getUserMedia(constraints);
                console.log('Media devices accessed successfully');
                
                if (callType === 'video') {
                    const localVideoElement = document.getElementById('localVideo');
                    if (localVideoElement) {
                        localVideoElement.srcObject = localStream;
                        console.log('Local video stream set');
                        
                        // Ensure video plays
                        localVideoElement.onloadedmetadata = () => {
                            localVideoElement.play().catch(e => console.log('Local video play error:', e));
                        };
                    }
                } else {
                    const localAudioElement = document.getElementById('localAudio');
                    if (localAudioElement) {
                        localAudioElement.srcObject = localStream;
                        console.log('Local audio stream set');
                    }
                }
                
                // Setup WebRTC if needed
                if (isCaller || isCallConnected) {
                    setupWebRTC();
                }
                
            } catch (error) {
                console.error('Error accessing media devices:', error);
                const errorMsg = callType === 'video' ? 
                    'Không thể truy cập camera/microphone' : 
                    'Không thể truy cập microphone';
                document.getElementById('connectionStatus').textContent = errorMsg;
            }
        }

        function setupWebRTC() {
            console.log('=== SETTING UP WEBRTC ===');
            console.log('Local stream available:', !!localStream);
            
            try {
                peerConnection = new RTCPeerConnection(rtcConfig);
                console.log('✅ PeerConnection created');

                // Add local stream
                if (localStream) {
                    localStream.getTracks().forEach(track => {
                        peerConnection.addTrack(track, localStream);
                        console.log('✅ Added local track:', track.kind, track.id);
                    });
                } else {
                    console.error('❌ No local stream available!');
                }

                // Handle remote stream
                peerConnection.ontrack = function(event) {
                    console.log('✅ Received remote track:', event.track.kind, 'from', event.streams.length, 'streams');
                    
                    if (event.streams && event.streams[0]) {
                        remoteStream = event.streams[0];
                        
                        if (callType === 'video') {
                            const remoteVideoElement = document.getElementById('remoteVideo');
                            if (remoteVideoElement) {
                                remoteVideoElement.srcObject = remoteStream;
                                console.log('✅ Set remote video source');
                                
                                // Ensure remote video plays and hide placeholder
                                remoteVideoElement.onloadedmetadata = () => {
                                    remoteVideoElement.play().then(() => {
                                        console.log('✅ Remote video playing');
                                        const placeholder = document.getElementById('noVideoPlaceholder');
                                        if (placeholder) {
                                            placeholder.style.display = 'none';
                                        }
                                    }).catch(e => console.log('Remote video play error:', e));
                                };
                            }
                        } else {
                            const remoteAudioElement = document.getElementById('remoteAudio');
                            if (remoteAudioElement) {
                                remoteAudioElement.srcObject = remoteStream;
                                console.log('✅ Set remote audio source');
                            }
                        }
                    }
                };

                // Handle ICE candidates
                peerConnection.onicecandidate = function(event) {
                    if (event.candidate) {
                        console.log('📡 Sending ICE candidate:', event.candidate.type);
                        sendSignal('ice-candidate', event.candidate);
                    } else {
                        console.log('✅ ICE gathering completed');
                    }
                };

                // Connection state changes
                peerConnection.onconnectionstatechange = function() {
                    console.log('🔄 Connection state changed:', peerConnection.connectionState);
                    updateConnectionStatus(peerConnection.connectionState);
                };
                
                // ICE connection state changes
                peerConnection.oniceconnectionstatechange = function() {
                    console.log('🧊 ICE connection state:', peerConnection.iceConnectionState);
                };

                console.log('✅ WebRTC setup complete');
            } catch (error) {
                console.error('❌ Error setting up WebRTC:', error);
                document.getElementById('connectionStatus').textContent = 'Lỗi thiết lập WebRTC';
            }
        }

        function answerCall() {
            console.log('=== ANSWERING CALL ===');
            console.log('Call ID:', callId);
            console.log('Current User ID:', currentUserId);
            console.log('Is Caller:', isCaller);
            
            // Update UI immediately
            document.getElementById('connectionStatus').textContent = 'Đang chấp nhận cuộc gọi...';
            
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
            .then(response => {
                console.log('Answer API response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Answer API response data:', data);
                if (data.success) {
                    console.log('✅ Call accepted successfully');
                    isCallConnected = true;
                    if (!peerConnection) {
                        setupWebRTC();
                    }
                    startCall();
                } else {
                    console.error('❌ Call accept failed:', data);
                    document.getElementById('connectionStatus').textContent = 'Lỗi chấp nhận cuộc gọi: ' + (data.message || 'Unknown error');
                }
            })
            .catch(error => {
                console.error('❌ Error answering call:', error);
                document.getElementById('connectionStatus').textContent = 'Lỗi kết nối API: ' + error.message;
            });
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
            
            isVideoOff = !isVideoOff;
            const videoTrack = localStream.getVideoTracks()[0];
            if (videoTrack) {
                videoTrack.enabled = !isVideoOff;
            }
            
            const cameraBtn = document.getElementById('cameraBtn');
            const icon = cameraBtn.querySelector('i');
            const placeholder = document.getElementById('noVideoPlaceholder');
            
            if (isVideoOff) {
                cameraBtn.classList.add('active');
                icon.className = 'fas fa-video-slash';
                // Don't show placeholder for local video off, just for remote
                console.log('📹 Camera turned off');
            } else {
                cameraBtn.classList.remove('active');
                icon.className = 'fas fa-video';
                console.log('📹 Camera turned on');
            }
        }

        function startCall() {
            console.log('=== STARTING CALL ===');
            
            // Hide answer/decline buttons
            const answerBtn = document.getElementById('answerBtn');
            const declineBtn = document.getElementById('declineBtn');
            if (answerBtn) {
                answerBtn.style.display = 'none';
                console.log('✅ Hidden answer button');
            }
            if (declineBtn) {
                declineBtn.style.display = 'none';
                console.log('✅ Hidden decline button');
            }
            
            // Show call controls
            const muteBtn = document.getElementById('muteBtn');
            const endCallBtn = document.getElementById('endCallBtn');
            const cameraBtn = document.getElementById('cameraBtn');
            
            if (muteBtn) {
                muteBtn.style.display = 'flex';
                console.log('✅ Showing mute button');
            }
            
            if (callType === 'video' && cameraBtn) {
                cameraBtn.style.display = 'flex';
                console.log('✅ Showing camera button');
            }
            
            if (endCallBtn) {
                endCallBtn.style.display = 'flex';
                console.log('✅ Showing end call button');
            }
            
            // Update status
            document.getElementById('callStatus').textContent = 'Đang kết nối...';
            document.getElementById('connectionStatus').textContent = 'Đang thiết lập kết nối...';
            console.log('✅ Updated UI status');
            
            // Start timer when actually connected
            if (!callStartTime) {
                callStartTime = Date.now();
                startTimer();
                document.getElementById('callTimer').style.display = 'block';
                console.log('✅ Started call timer');
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
                    statusElement.textContent = 'Đã kết nối';
                    document.getElementById('callStatus').textContent = 'Cuộc gọi đang hoạt động';
                    break;
                case 'disconnected':
                    statusElement.textContent = 'Mất kết nối';
                    break;
                case 'failed':
                    statusElement.textContent = 'Kết nối thất bại';
                    break;
                case 'closed':
                    statusElement.textContent = 'Cuộc gọi đã kết thúc';
                    break;
            }
        }

        function sendSignal(type, data) {
            fetch('/signaling/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    call_id: callId,
                    signal_type: type,
                    signal_data: {
                        type: type,
                        data: data
                    }
                })
            })
            .then(response => response.json())
            .then(result => {
                console.log('Signal sent:', type);
            })
            .catch(error => console.error('Error sending signal:', error));
        }

        function startStatusPolling() {
            setInterval(() => {
                fetch(`/call/status/${callId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('🔄 Call status poll:', data.call_data?.status);
                        if (data.call_data) {
                            if (data.call_data.status === 'declined') {
                                alert('Cuộc gọi đã bị từ chối');
                                window.location.href = '/chat';
                            } else if (data.call_data.status === 'connected' && !isCallConnected) {
                                console.log('✅ Call was accepted by receiver, starting WebRTC for caller...');
                                isCallConnected = true;
                                if (!peerConnection) {
                                    setupWebRTC();
                                }
                                startCall();
                                
                                // If caller, create offer after a delay
                                if (isCaller) {
                                    console.log('📡 Caller will create offer in 2 seconds...');
                                    setTimeout(createOffer, 2000);
                                }
                            } else if (data.call_data.status === 'ended') {
                                console.log('📞 Call ended by other party');
                                alert('Cuộc gọi đã kết thúc');
                                window.location.href = '/chat';
                            }
                            
                            // Debug: Show current call status
                            console.log('📊 Call debug info:', {
                                status: data.call_data.status,
                                caller_id: data.call_data.caller_id,
                                receiver_id: data.call_data.receiver_id,
                                currentUserId: currentUserId,
                                isCaller: isCaller,
                                isCallConnected: isCallConnected
                            });
                        }
                    })
                    .catch(error => console.error('❌ Error checking call status:', error));
            }, 2000);
        }

        function fixSDPFormat(sdp) {
            console.log('🔧 Fixing SDP format issues...');
            
            const lines = sdp.split('\n');
            const fixedLines = [];
            
            for (let line of lines) {
                line = line.trim();
                if (!line) continue;
                
                // Fix malformed SSRC lines
                if (line.startsWith('a=ssrc:')) {
                    const parts = line.split(' ');
                    if (parts.length >= 3) {
                        const ssrcId = parts[0].replace('a=ssrc:', '');
                        
                        // Check if it's a msid line without proper attribute
                        if (parts[1] && parts[1].includes('-') && parts[2] && parts[2].includes('-')) {
                            // This looks like "a=ssrc:123456 uuid1 uuid2" which should be "a=ssrc:123456 msid:uuid1 uuid2"
                            const fixedLine = `a=ssrc:${ssrcId} msid:${parts[1]} ${parts[2]}`;
                            fixedLines.push(fixedLine);
                            console.log('🔧 Fixed SSRC line:', line, '→', fixedLine);
                            continue;
                        }
                    }
                }
                
                // Keep other lines as-is
                fixedLines.push(line);
            }
            
            const result = fixedLines.join('\n') + '\n';
            console.log('✅ SDP format fixed');
            return result;
        }

        function logSDPDetails(sdp, label) {
            console.log(`📋 ${label} SDP Details:`);
            const lines = sdp.split('\n');
            
            for (let i = 0; i < lines.length; i++) {
                const line = lines[i].trim();
                if (line.startsWith('m=') || line.startsWith('a=rtpmap:') || 
                    line.startsWith('a=fmtp:') || line.startsWith('a=mid:') ||
                    line.startsWith('a=ssrc:')) {
                    console.log(`  ${i}: ${line}`);
                }
            }
        }

        function isValidSDP(sdp) {
            const lines = sdp.split('\n');
            let hasVersion = false;
            let hasOrigin = false;
            let hasSession = false;
            let hasTiming = false;
            
            for (let line of lines) {
                line = line.trim();
                if (line.startsWith('v=')) hasVersion = true;
                if (line.startsWith('o=')) hasOrigin = true;
                if (line.startsWith('s=')) hasSession = true;
                if (line.startsWith('t=')) hasTiming = true;
            }
            
            const isValid = hasVersion && hasOrigin && hasSession && hasTiming;
            console.log('📊 SDP Validation:', {hasVersion, hasOrigin, hasSession, hasTiming, isValid});
            return isValid;
        }

        async function createOffer() {
            console.log('=== CREATING OFFER ===');
            if (!peerConnection) {
                console.error('❌ PeerConnection not ready');
                return;
            }

            try {
                console.log('📡 Creating WebRTC offer...');
                const offer = await peerConnection.createOffer({
                    offerToReceiveAudio: true,
                    offerToReceiveVideo: callType === 'video'
                });

                await peerConnection.setLocalDescription(offer);
                console.log('✅ Offer set as local description');

                // Log original SDP for debugging
                logSDPDetails(offer.sdp, 'Original Offer');

                // Fix SDP format before sending
                const fixedSDP = fixSDPFormat(offer.sdp);
                const fixedOffer = {
                    type: offer.type,
                    sdp: fixedSDP
                };

                sendSignal('offer', fixedOffer);
                console.log('📡 Fixed offer sent via signaling');

            } catch (error) {
                console.error('❌ Error creating offer:', error);
                document.getElementById('connectionStatus').textContent = 'Lỗi tạo offer: ' + error.message;
            }
        }

        function startSignalingPolling() {
            setInterval(async () => {
                try {
                    const response = await fetch(`/signaling/get/${callId}`);
                    const data = await response.json();
                    
                    if (data.signals && data.signals.length > 0) {
                        console.log(`Received ${data.signals.length} signaling messages`);
                        for (const signal of data.signals) {
                            await handleSignalingMessage(signal.data);
                        }
                    }
                } catch (error) {
                    console.error('Error polling signaling:', error);
                }
            }, 1000);
        }

        async function handleSignalingMessage(message) {
            if (!peerConnection) {
                console.log('PeerConnection not ready, ignoring signal:', message.type);
                return;
            }

            try {
                console.log('Handling signaling message:', message.type);
                
                switch (message.type) {
                    case 'offer':
                        await handleOffer(message.data);
                        break;
                    case 'answer':
                        await handleAnswer(message.data);
                        break;
                    case 'ice-candidate':
                        await handleIceCandidate(message.data);
                        break;
                    default:
                        console.log('Unknown signal type:', message.type);
                }
            } catch (error) {
                console.error('Error handling signaling message:', error);
            }
        }

        async function handleOffer(offer) {
            console.log('=== HANDLING OFFER ===');
            try {
                console.log('📨 Received offer:', offer.type);
                
                // Log received SDP for debugging
                logSDPDetails(offer.sdp, 'Received Offer');
                
                // Fix SDP format issues
                const fixedSDP = fixSDPFormat(offer.sdp);
                
                // Validate SDP before using
                if (!isValidSDP(fixedSDP)) {
                    console.error('❌ Invalid SDP received');
                    document.getElementById('connectionStatus').textContent = 'SDP không hợp lệ';
                    return;
                }
                
                // Use the fixed SDP
                const fixedOffer = {
                    type: offer.type,
                    sdp: fixedSDP
                };
                
                await peerConnection.setRemoteDescription(fixedOffer);
                console.log('✅ Set remote description from offer');
                
                const answer = await peerConnection.createAnswer();
                console.log('✅ Answer created:', answer.type);
                
                await peerConnection.setLocalDescription(answer);
                console.log('✅ Answer set as local description');
                
                // Log answer SDP for debugging
                logSDPDetails(answer.sdp, 'Created Answer');
                
                // Fix answer SDP before sending
                const fixedAnswerSDP = fixSDPFormat(answer.sdp);
                const fixedAnswer = {
                    type: answer.type,
                    sdp: fixedAnswerSDP
                };
                
                sendSignal('answer', fixedAnswer);
                console.log('📡 Fixed answer sent via signaling');
            } catch (error) {
                console.error('❌ Error handling offer:', error);
                console.error('❌ Full error details:', error.name, error.message);
                
                // Try to provide more specific error info
                if (error.message.includes('codec')) {
                    document.getElementById('connectionStatus').textContent = 'Lỗi codec - trình duyệt không tương thích';
                } else if (error.message.includes('parse') || error.message.includes('Invalid SDP')) {
                    document.getElementById('connectionStatus').textContent = 'Lỗi định dạng SDP';
                } else {
                    document.getElementById('connectionStatus').textContent = 'Lỗi xử lý offer: ' + error.message;
                }
            }
        }

        async function handleAnswer(answer) {
            console.log('=== HANDLING ANSWER ===');
            try {
                console.log('📨 Received answer:', answer.type);
                
                // Log received SDP for debugging
                logSDPDetails(answer.sdp, 'Received Answer');
                
                // Fix SDP format issues
                const fixedSDP = fixSDPFormat(answer.sdp);
                
                // Validate SDP before using
                if (!isValidSDP(fixedSDP)) {
                    console.error('❌ Invalid SDP received');
                    document.getElementById('connectionStatus').textContent = 'SDP không hợp lệ';
                    return;
                }
                
                // Use the fixed SDP
                const fixedAnswer = {
                    type: answer.type,
                    sdp: fixedSDP
                };
                
                await peerConnection.setRemoteDescription(fixedAnswer);
                console.log('✅ Answer processed successfully - WebRTC negotiation complete!');
            } catch (error) {
                console.error('❌ Error handling answer:', error);
                console.error('❌ Full error details:', error.name, error.message);
                document.getElementById('connectionStatus').textContent = 'Lỗi xử lý answer: ' + error.message;
            }
        }

        async function handleIceCandidate(candidate) {
            try {
                if (!peerConnection || !peerConnection.remoteDescription) {
                    console.log('⏸️ Skipping ICE candidate - no remote description yet');
                    return;
                }
                
                console.log('🧊 Adding ICE candidate:', candidate.type || 'unknown');
                await peerConnection.addIceCandidate(candidate);
                console.log('✅ ICE candidate added successfully');
            } catch (error) {
                console.warn('⚠️ ICE candidate failed (this is usually OK):', error.message);
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

        // Handle page unload
        window.addEventListener('beforeunload', cleanup);
    </script>
</body>
</html>