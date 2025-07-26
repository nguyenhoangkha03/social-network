<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TinNhan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TinNhanController extends Controller
{
    // Gửi tin nhắn
    public function send(Request $request)
    {
        var_dump(111111111111111111111111); // Debugging line to check request data
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'noidung' => 'nullable|string',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        $messageContent = $request->input('noidung');
        $imagePath = null;

        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            try {
                $file->move(public_path('uploads/messages'), $fileName);
                $imagePath = 'uploads/messages/' . $fileName;
            } catch (\Exception $e) {
                return response()->json(['error' => 'Không thể lưu ảnh: ' . $e->getMessage()], 500);
            }
        }

        $tinNhan = TinNhan::create([
            'user_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'noidung' => $messageContent,
            'hinhanh' => $imagePath,
            'thoigiantao' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã gửi tin nhắn thành công',
            'data' => [
                'id' => $tinNhan->id,
                'me' => true,
                'noidung' => $tinNhan->noidung,
                'hinhanh' => $tinNhan->hinhanh,
                'thoigiantao' => $tinNhan->thoigiantao,
                'receiver_id' => $tinNhan->receiver_id
            ]
        ]);
    }

    // Lấy lịch sử tin nhắn giữa user hiện tại và bạn bè
    public function getMessages($friendId)
    {
        $myId = Auth::id();

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
                    'id' => $msg->id,
                    'me' => $msg->user_id == $myId,
                    'noidung' => $msg->noidung,
                    'hinhanh' => $msg->hinhanh,
                    'thoigiantao' => $msg->thoigiantao,
                ];
            });

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }
}
