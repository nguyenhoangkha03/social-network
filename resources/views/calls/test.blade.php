<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Call Features</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .test-section {
            margin: 20px 0;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        button:hover {
            background: #0056b3;
        }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Test Call Features</h1>
    
    <div class="test-section">
        <h2>WebRTC Support Test</h2>
        <button onclick="testWebRTCSupport()">Test WebRTC Support</button>
        <div id="webrtcResult"></div>
    </div>
    
    <div class="test-section">
        <h2>Media Access Test</h2>
        <button onclick="testCameraAccess()">Test Camera</button>
        <button onclick="testMicrophoneAccess()">Test Microphone</button>
        <div id="mediaResult"></div>
        <video id="testVideo" width="320" height="240" autoplay muted style="display:none; margin-top: 10px;"></video>
    </div>
    
    <div class="test-section">
        <h2>Call API Test</h2>
        <p>Test with user ID: <input type="number" id="testUserId" placeholder="Enter user ID" value="1"></p>
        <button onclick="testVoiceCall()">Test Voice Call</button>
        <button onclick="testVideoCall()">Test Video Call</button>
        <div id="apiResult"></div>
    </div>
    
    <div class="test-section">
        <h2>Signaling Test</h2>
        <p>Call ID: <input type="text" id="testCallId" placeholder="Enter call ID"></p>
        <button onclick="testSignalingSend()">Send Test Signal</button>
        <button onclick="testSignalingReceive()">Receive Signals</button>
        <div id="signalingResult"></div>
    </div>
    
    <div class="test-section">
        <h2>Debug Info</h2>
        <button onclick="showDebugInfo()">Show System Info</button>
        <div id="debugInfo"></div>
    </div>

    <script>
        function testWebRTCSupport() {
            const result = document.getElementById('webrtcResult');
            
            if (typeof RTCPeerConnection !== 'undefined') {
                result.innerHTML = '<p class="success">✓ WebRTC is supported</p>';
                
                // Test STUN server connectivity
                const pc = new RTCPeerConnection({
                    iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
                });
                
                pc.onicecandidate = function(event) {
                    if (event.candidate) {
                        result.innerHTML += '<p class="success">✓ STUN server connectivity OK</p>';
                        pc.close();
                    }
                };
                
                // Create a dummy data channel to trigger ICE gathering
                pc.createDataChannel('test');
                pc.createOffer().then(offer => pc.setLocalDescription(offer));
                
            } else {
                result.innerHTML = '<p class="error">✗ WebRTC is not supported</p>';
            }
        }
        
        function testCameraAccess() {
            const result = document.getElementById('mediaResult');
            const video = document.getElementById('testVideo');
            
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    result.innerHTML = '<p class="success">✓ Camera access granted</p>';
                    video.srcObject = stream;
                    video.style.display = 'block';
                    
                    // Stop stream after 5 seconds
                    setTimeout(() => {
                        stream.getTracks().forEach(track => track.stop());
                        video.style.display = 'none';
                        result.innerHTML += '<p>Camera test completed</p>';
                    }, 5000);
                })
                .catch(error => {
                    result.innerHTML = '<p class="error">✗ Camera access denied: ' + error.message + '</p>';
                });
        }
        
        function testMicrophoneAccess() {
            const result = document.getElementById('mediaResult');
            
            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {
                    result.innerHTML = '<p class="success">✓ Microphone access granted</p>';
                    
                    // Stop stream immediately
                    stream.getTracks().forEach(track => track.stop());
                })
                .catch(error => {
                    result.innerHTML = '<p class="error">✗ Microphone access denied: ' + error.message + '</p>';
                });
        }
        
        function testVoiceCall() {
            testCallAPI('voice');
        }
        
        function testVideoCall() {
            testCallAPI('video');
        }
        
        function testCallAPI(callType) {
            const result = document.getElementById('apiResult');
            const userId = document.getElementById('testUserId').value;
            
            if (!userId) {
                result.innerHTML = '<p class="error">Please enter a user ID</p>';
                return;
            }
            
            result.innerHTML = '<p>Testing ' + callType + ' call API...</p>';
            
            fetch('/call/initiate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 'test'
                },
                body: JSON.stringify({
                    receiver_id: parseInt(userId),
                    call_type: callType
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    result.innerHTML = '<p class="success">✓ Call API working! Call ID: ' + data.call_id + '</p>';
                    result.innerHTML += '<p><a href="/call/' + data.call_id + '" target="_blank">Open Call Page</a></p>';
                } else {
                    result.innerHTML = '<p class="error">✗ Call API error: ' + (data.error || 'Unknown error') + '</p>';
                }
            })
            .catch(error => {
                result.innerHTML = '<p class="error">✗ Network error: ' + error.message + '</p>';
            });
        }
        
        function testSignalingSend() {
            const result = document.getElementById('signalingResult');
            const callId = document.getElementById('testCallId').value || 'test_call_123';
            
            result.innerHTML = '<p>Testing signaling send...</p>';
            
            fetch('/signaling/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 'test'
                },
                body: JSON.stringify({
                    call_id: callId,
                    signal_type: 'test',
                    signal_data: { message: 'Test signal from browser', timestamp: Date.now() }
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    result.innerHTML = '<p class="success">✓ Signaling send successful</p>';
                } else {
                    result.innerHTML = '<p class="error">✗ Signaling send failed</p>';
                }
            })
            .catch(error => {
                result.innerHTML = '<p class="error">✗ Signaling error: ' + error.message + '</p>';
            });
        }
        
        function testSignalingReceive() {
            const result = document.getElementById('signalingResult');
            const callId = document.getElementById('testCallId').value || 'test_call_123';
            
            result.innerHTML = '<p>Testing signaling receive...</p>';
            
            fetch(`/signaling/get/${callId}`)
            .then(response => response.json())
            .then(data => {
                if (data.signals && data.signals.length > 0) {
                    result.innerHTML = '<p class="success">✓ Received ' + data.signals.length + ' signal(s)</p>';
                    data.signals.forEach((signal, index) => {
                        result.innerHTML += '<p>Signal ' + (index + 1) + ': ' + JSON.stringify(signal.data) + '</p>';
                    });
                } else {
                    result.innerHTML = '<p>No signals received</p>';
                }
            })
            .catch(error => {
                result.innerHTML = '<p class="error">✗ Receive error: ' + error.message + '</p>';
            });
        }
        
        function showDebugInfo() {
            const result = document.getElementById('debugInfo');
            
            const info = {
                userAgent: navigator.userAgent,
                platform: navigator.platform,
                language: navigator.language,
                cookieEnabled: navigator.cookieEnabled,
                onLine: navigator.onLine,
                webRTCSupported: typeof RTCPeerConnection !== 'undefined',
                mediaDevicesSupported: navigator.mediaDevices && navigator.mediaDevices.getUserMedia,
                currentURL: window.location.href,
                timestamp: new Date().toISOString()
            };
            
            result.innerHTML = '<pre>' + JSON.stringify(info, null, 2) + '</pre>';
        }
    </script>
</body>
</html>