<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\DanhSachBanBe;
use App\Models\Call;
use App\Models\CallSignal;

class CallController extends Controller
{
    public function initiateCall(Request $request)
    {
        if (!Session::has('user_id')) {
            return response()->json(['error' => 'Chưa đăng nhập'], 401);
        }

        $request->validate([
            'receiver_id' => 'required|integer|exists:users,user_id',
            'call_type' => 'required|in:voice,video'
        ]);

        $callerId = Session::get('user_id');
        $receiverId = $request->receiver_id;
        $callType = $request->call_type;

        // Kiểm tra xem có phải bạn bè không
        $isFriend = DanhSachBanBe::where(function ($q) use ($callerId, $receiverId) {
            $q->where('user_id_1', $callerId)->where('user_id_2', $receiverId);
        })->orWhere(function ($q) use ($callerId, $receiverId) {
            $q->where('user_id_2', $callerId)->where('user_id_1', $receiverId);
        })->exists();

        if (!$isFriend) {
            return response()->json(['error' => 'Chỉ có thể gọi cho bạn bè'], 403);
        }

        $caller = User::find($callerId);
        $receiver = User::find($receiverId);

        // Tạo call ID duy nhất
        $callId = uniqid('call_', true);

        // Lưu thông tin cuộc gọi vào database
        $call = Call::create([
            'call_id' => $callId,
            'caller_id' => $callerId,
            'receiver_id' => $receiverId,
            'call_type' => $callType,
            'status' => 'initiating'
        ]);

        return response()->json([
            'success' => true,
            'call_id' => $callId,
            'caller' => [
                'id' => $caller->user_id,
                'name' => $caller->hoten ?? $caller->username,
                'avatar' => $caller->hinhanh ? base64_encode($caller->hinhanh) : null
            ],
            'receiver' => [
                'id' => $receiver->user_id,
                'name' => $receiver->hoten ?? $receiver->username,
                'avatar' => $receiver->hinhanh ? base64_encode($receiver->hinhanh) : null
            ],
            'call_type' => $callType
        ]);
    }

    public function answerCall(Request $request)
    {
        $request->validate([
            'call_id' => 'required|string',
            'action' => 'required|in:accept,decline'
        ]);

        $callId = $request->call_id;
        $action = $request->action;

        $call = Call::where('call_id', $callId)->first();

        if (!$call) {
            return response()->json(['error' => 'Cuộc gọi không tồn tại'], 404);
        }

        if ($action === 'accept') {
            $call->update([
                'status' => 'connected',
                'started_at' => now()
            ]);
        } else {
            $call->update([
                'status' => 'declined',
                'ended_at' => now()
            ]);
        }

        return response()->json(['success' => true, 'status' => $action]);
    }

    public function endCall(Request $request)
    {
        $request->validate([
            'call_id' => 'required|string'
        ]);

        $callId = $request->call_id;

        $call = Call::where('call_id', $callId)->first();
        if ($call) {
            $call->update([
                'status' => 'ended',
                'ended_at' => now()
            ]);

            // Calculate duration if call was connected
            if ($call->started_at) {
                $duration = $call->started_at->diffInSeconds(now());
                $call->update(['duration_seconds' => $duration]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function getCallStatus(Request $request, $callId)
    {
        $call = Call::where('call_id', $callId)->first();

        if (!$call) {
            return response()->json(['error' => 'Cuộc gọi không tồn tại'], 404);
        }

        return response()->json(['call_data' => $call]);
    }

    public function callPage(Request $request, $callId)
    {
        $call = Call::with(['caller', 'receiver'])->where('call_id', $callId)->first();

        if (!$call) {
            return redirect()->route('home')->with('error', 'Cuộc gọi không tồn tại');
        }

        $currentUserId = Session::get('user_id');

        // Convert to array format for view compatibility
        $callData = [
            'caller_id' => $call->caller_id,
            'receiver_id' => $call->receiver_id,
            'call_type' => $call->call_type,
            'status' => $call->status
        ];

        return view('calls.call', compact('callData', 'callId', 'currentUserId', 'call'));
    }
}
