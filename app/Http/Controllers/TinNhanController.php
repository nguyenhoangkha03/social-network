<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TinNhan;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class TinNhanController extends Controller
{
    // Gửi tin nhắn
    public function sendMessage(Request $request)
    {
        if (!Session::has('user_id')) {
            return response()->json(['error' => 'Vui lòng đăng nhập'], 401);
        }

        $request->validate([
            'receiver_id' => 'required|exists:users,user_id',
            'noidung' => 'required|string|min:1',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);


        $senderId = Session::get('user_id');
        $messageContent = $request->input('noidung');
        $imagePath = null;

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/messages');

            // Tạo thư mục nếu chưa tồn tại
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            try {
                $file->move($uploadPath, $fileName);
                $imagePath = 'uploads/messages/' . $fileName;
            } catch (\Exception $e) {
                return response()->json(['error' => 'Không thể lưu ảnh: ' . $e->getMessage()], 500);
            }
        }

        // Tạo tin nhắn mới
        $tinNhan = TinNhan::create([
            'user_id' => $senderId,
            'receiver_id' => $request->receiver_id,
            'noidung' => $messageContent,
            'image_path' => $imagePath,
            'thoigiantao' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã gửi tin nhắn thành công',
            'msg' => $tinNhan
        ]);
    }

    // Lấy lịch sử tin nhắn giữa user hiện tại và bạn bè
    public function getMessages($friendId)
    {
        if (!Session::has('user_id')) {
            return response()->json(['error' => 'Vui lòng đăng nhập'], 401);
        }

        $myId = Session::get('user_id');

        $messages = TinNhan::where(function ($query) use ($myId, $friendId) {
            $query->where('user_id', $myId)->where('receiver_id', $friendId);
        })
            ->orWhere(function ($query) use ($myId, $friendId) {
                $query->where('user_id', $friendId)->where('receiver_id', $myId);
            })
            ->orderBy('thoigiantao', 'asc')
            ->get()
            ->map(function ($msg) use ($myId) {
                return [
                    'id' => $msg->id_tinnhan,
                    'me' => $msg->user_id == $myId,
                    'user_id' => $msg->user_id,
                    'noidung' => $msg->noidung,
                    'image_path' => $msg->image_path,
                    'thoigiantao' => $msg->thoigiantao,
                ];
            });

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    // API cho chat sidebar - lấy danh sách users để chat
    public function apiChatUsers()
    {
        if (!Session::has('user_id')) {
            return response()->json(['error' => 'Chưa đăng nhập'], 401);
        }

        $currentUserId = Session::get('user_id');

        // Lấy danh sách bạn bè hoặc users đã từng nhắn tin
        $users = User::whereHas('sentMessages', function ($query) use ($currentUserId) {
            $query->where('receiver_id', $currentUserId);
        })
            ->orWhereHas('receivedMessages', function ($query) use ($currentUserId) {
                $query->where('user_id', $currentUserId);
            })
            ->where('user_id', '!=', $currentUserId)
            ->get();

        return response()->json(['users' => $users]);
    }

    // API cho group chat - để sau này phát triển
    public function apiChatGroups()
    {
        return response()->json(['groups' => []]);
    }

    // API lấy tin nhắn với user cụ thể
    public function apiMessages($userId)
    {
        return $this->getMessages($userId);
    }

    // API lấy tin nhắn group - để sau này phát triển  
    public function apiGroupMessages($groupId)
    {
        return response()->json(['messages' => []]);
    }
}
