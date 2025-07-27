// Lấy danh sách bạn bè
async function fetchFriends() {
    const res = await fetch("/api/friends");
    if (!res.ok) return [];
    const data = await res.json();
    return data.friends || [];
}

// Lấy lịch sử tin nhắn với bạn bè
async function fetchMessages(friendId) {
    const res = await fetch(`/api/chat/messages/${friendId}`);
    if (!res.ok) return [];
    const data = await res.json();
    return data.messages || [];
}

// Gửi tin nhắn (có thể kèm ảnh)
async function sendMessage(friendId, text, imageFile) {
    const formData = new FormData();
    formData.append("receiver_id", friendId);
    formData.append("noidung", text);
    if (imageFile) {
        formData.append("hinhanh", imageFile);
        console.log(`1111`);
    } // <-- key chính xác là "hinhanh"
    formData.append(
        "_token",
        document.querySelector('meta[name="csrf-token"]').content
    );
    const res = await fetch("/api/chat/send", {
        method: "POST",
        body: formData,
    });
    return res.ok;
}

const friendList = document.getElementById("friendList");
const chatHeader = document.getElementById("chatHeader");
const chatMessages = document.getElementById("chatMessages");
const chatForm = document.getElementById("chatForm");
const chatInput = document.getElementById("chatInput");
const chatImage = document.getElementById("chatImage");

let selectedFriend = null;
let friends = [];

function renderFriendList() {
    friendList.innerHTML = "";
    friends.forEach((f) => {
        const li = document.createElement("li");
        li.className =
            "friend-item" +
            (selectedFriend && f.id_user === selectedFriend.id_user
                ? " selected"
                : "");
        li.innerHTML = `
            <img src="${
                f.avatar ||
                "https://ui-avatars.com/api/?name=" +
                    encodeURIComponent(f.hoten)
            }" class="friend-avatar" alt="avatar">
            <span>${f.hoten}</span>
        `;
        li.onclick = () => selectFriend(f);
        friendList.appendChild(li);
    });
}

function renderMessages(messages) {
    chatMessages.innerHTML = "";
    messages.forEach((msg) => {
        const row = document.createElement("div");
        row.className =
            "chat-message-row" +
            (msg.me ? " chat-message me" : " chat-message");
        const bubble = document.createElement("div");
        bubble.className = "chat-message-bubble";

        const isImage =
            msg.noidung && msg.noidung.startsWith("uploads/messages/");
        if (isImage) {
            const img = document.createElement("img");
            img.src = "/" + msg.noidung;
            img.alt = "Ảnh gửi trong chat";
            img.style.maxWidth = "200px";
            img.style.display = "block";
            bubble.appendChild(img);
        } else if (msg.noidung) {
            bubble.textContent = msg.noidung;
        }

        row.appendChild(bubble);
        chatMessages.appendChild(row);
    });
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

async function selectFriend(f) {
    selectedFriend = f;
    chatHeader.textContent = f.hoten;
    renderFriendList();
    chatMessages.innerHTML = "<div>Đang tải tin nhắn...</div>";
    const messages = await fetchMessages(f.id_user);
    renderMessages(messages);
}

chatForm.addEventListener("submit", async function (e) {
    e.preventDefault();
    const text = chatInput.value.trim();
    const imageInput = document.getElementById("chatImage");
    const imageFile =
        imageInput && imageInput.files.length > 0 ? imageInput.files[0] : null;
    if (!text && !imageFile) return;
    if (!selectedFriend) return;
    chatInput.value = "";
    if (imageInput) imageInput.value = "";
    const ok = await sendMessage(selectedFriend.id_user, text, imageFile);
    if (!ok) {
        alert("Không gửi được tin nhắn. Vui lòng thử lại!");
        return;
    }
    const messages = await fetchMessages(selectedFriend.id_user);
    renderMessages(messages);
});

// === EMOJI PICKER ===
const emojiBtn = document.getElementById("emojiBtn");
const emojiPicker = document.getElementById("emojiPicker");
const emojiList = [
    "😀",
    "😁",
    "😂",
    "🤣",
    "😃",
    "😄",
    "😅",
    "😆",
    "😉",
    "😊",
    "😋",
    "😎",
    "😍",
    "😘",
    "🥰",
    "😗",
    "😙",
    "😚",
    "🙂",
    "🤗",
    "🤩",
    "🤔",
    "🤨",
    "😐",
    "😑",
    "😶",
    "🙄",
    "😏",
    "😣",
    "😥",
    "😮",
    "🤐",
    "😯",
    "😪",
    "😫",
    "🥱",
    "😴",
    "😌",
    "😛",
    "😜",
    "😝",
    "🤤",
    "😒",
    "😓",
    "😔",
    "😕",
    "🙃",
    "🤑",
    "😲",
    "☹️",
    "🙁",
    "😖",
    "😞",
    "😟",
    "😤",
    "😢",
    "😭",
    "😦",
    "😧",
    "😨",
    "😩",
    "🤯",
    "😬",
    "😰",
    "😱",
    "🥵",
    "🥶",
    "😳",
    "🤪",
    "😵",
    "😡",
    "😠",
    "🤬",
    "😷",
    "🤒",
    "🤕",
    "🤢",
    "🤮",
    "🥴",
    "😇",
    "🥳",
    "🥺",
    "🤠",
    "🤡",
    "🤥",
    "🤫",
    "🤭",
    "🧐",
    "🤓",
    "😈",
    "👿",
    "👹",
    "👺",
    "💀",
    "👻",
    "👽",
    "🤖",
    "💩",
    "😺",
    "😸",
    "😹",
    "😻",
    "😼",
    "😽",
    "🙀",
    "😿",
    "😾",
];

emojiBtn.addEventListener("click", function (e) {
    e.preventDefault();
    if (emojiPicker.style.display === "block") {
        emojiPicker.style.display = "none";
        return;
    }
    emojiPicker.innerHTML = "";
    emojiList.forEach((emoji) => {
        const btn = document.createElement("button");
        btn.type = "button";
        btn.textContent = emoji;
        btn.style.fontSize = "1.3rem";
        btn.style.margin = "2px";
        btn.style.background = "none";
        btn.style.border = "none";
        btn.style.cursor = "pointer";
        btn.onclick = () => {
            chatInput.value += emoji;
            chatInput.focus();
        };
        emojiPicker.appendChild(btn);
    });
    const rect = emojiBtn.getBoundingClientRect();
    emojiPicker.style.left = rect.left + "px";
    emojiPicker.style.top = rect.top - 200 + "px";
    emojiPicker.style.display = "block";
});

document.addEventListener("click", function (e) {
    if (!emojiPicker.contains(e.target) && e.target !== emojiBtn) {
        emojiPicker.style.display = "none";
    }
});

// Khởi tạo giao diện
(async function init() {
    friends = await fetchFriends();
    renderFriendList();
    if (friends.length > 0) {
        selectFriend(friends[0]);
    }
})();
