<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Follow;
use App\Models\BaiViet;

class UserController extends Controller
{
    public function toggleFollow($id)
    {
        if (!Session::has('user_id')) {
            return response()->json(['error' => 'Vui lòng đăng nhập'], 401);
        }

        $followerId = Session::get('user_id');
        $followingId = $id;

        // Không thể follow chính mình
        if ($followerId == $followingId) {
            return response()->json(['error' => 'Không thể follow chính mình'], 400);
        }

        $existingFollow = Follow::where('follower_id', $followerId)
            ->where('following_id', $followingId)
            ->first();

        if ($existingFollow) {
            // Unfollow
            $existingFollow->delete();
            $isFollowing = false;
        } else {
            // Follow
            Follow::create([
                'follower_id' => $followerId,
                'following_id' => $followingId
            ]);
            $isFollowing = true;
        }

        return response()->json([
            'success' => true,
            'isFollowing' => $isFollowing
        ]);
    }

    public function showProfile($id)
    {
        $user = User::find($id);
        if (!$user) {
            abort(404);
        }

        $currentUser = null;
        $isFollowing = false;
        if (Session::has('user_id')) {
            $currentUser = User::find(Session::get('user_id'));
            if ($currentUser) {
                $isFollowing = $currentUser->isFollowing($id);
            }
        }

        // Lấy bài viết đã đăng của user
        $posts = BaiViet::with('user')
            ->where('user_id', $id)
            ->where('is_draft', false)
            ->orderByDesc('thoigiandang')
            ->get();

        // Lấy số lượng followers và following
        $followersCount = $user->followers()->count();
        $followingCount = $user->follows()->count();

        // Lấy danh sách user followers và following
        $followers = $user->followersList()->get();
        $following = $user->following()->get();

        return view('user.profile', compact('user', 'currentUser', 'isFollowing', 'posts', 'followersCount', 'followingCount', 'followers', 'following'));
    }

    // Hiển thị form chỉnh sửa hồ sơ cá nhân
    public function edit($id)
    {
        if (!Session::has('user_id') || Session::get('user_id') != $id) {
            abort(403, 'Bạn không có quyền chỉnh sửa hồ sơ này.');
        }
        $user = User::findOrFail($id);
        return view('profiles.edit', compact('user'));
    }

    // Xử lý cập nhật hồ sơ cá nhân
    public function update(Request $request, $id)
    {
        if (!Session::has('user_id') || Session::get('user_id') != $id) {
            abort(403, 'Bạn không có quyền chỉnh sửa hồ sơ này.');
        }
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'hoten' => 'required|string|max:200',
            'username' => 'required|string|max:200|unique:users,username,' . $id . ',user_id',
            'email' => 'required|email|max:200|unique:users,email,' . $id . ',user_id',
            'sodienthoai' => 'nullable|numeric',
            'diachi' => 'nullable|string|max:200',
            'gioitinh' => 'nullable|in:0,1,2',
            'hinhanh' => 'nullable|image|max:2048',
        ]);
        $user->hoten = $validated['hoten'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->sodienthoai = $validated['sodienthoai'] ?? null;
        $user->diachi = $validated['diachi'] ?? null;
        $user->gioitinh = $validated['gioitinh'] ?? null;
        if ($request->hasFile('hinhanh')) {
            $image = $request->file('hinhanh');
            $user->hinhanh = file_get_contents($image->getRealPath());
        }
        $user->save();
        return redirect()->route('user.profile', $user->user_id)->with('success', 'Cập nhật hồ sơ thành công!');
    }

    // Tìm kiếm bạn bè
    public function searchFriends(Request $request)
    {
        $query = $request->get('q', '');
        $users = [];
        if (!empty($query)) {
            $users = User::where('hoten', 'like', "%{$query}%")
                ->orWhere('username', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->get();
        }
        $currentUser = Session::has('user_id') ? User::find(Session::get('user_id')) : null;
        return view('friends.search', compact('users', 'query', 'currentUser'));
    }

    // Danh sách bạn bè
    public function friendList()
    {
        $currentUser = Session::has('user_id') ? User::find(Session::get('user_id')) : null;
        $friends = [];
        $friendIds = [];
        if ($currentUser) {
            $friendIds = \App\Models\DanhSachBanBe::where('user_id_1', $currentUser->user_id)
                ->orWhere('user_id_2', $currentUser->user_id)
                ->get()
                ->map(function ($row) use ($currentUser) {
                    return $row->user_id_1 == $currentUser->user_id ? $row->user_id_2 : $row->user_id_1;
                })->toArray();
            $friends = User::where('user_id', '!=', $currentUser->user_id)->get();
        }
        return view('friends.list', compact('friends', 'currentUser', 'friendIds'));
    }

    // Thêm bạn
    public function addFriend(Request $request)
    {
        $currentUser = Session::has('user_id') ? Session::get('user_id') : null;
        $friendId = $request->input('friend_id');
        if (!$currentUser || !$friendId || $currentUser == $friendId) {
            return response()->json(['success' => false, 'message' => 'Không hợp lệ']);
        }
        $a = min($currentUser, $friendId);
        $b = max($currentUser, $friendId);
        $friend = \App\Models\DanhSachBanBe::firstOrCreate([
            'user_id_1' => $a,
            'user_id_2' => $b,
        ]);
        // Tạo thông báo cho người được gửi kết bạn
        \App\Models\Notification::create([
            'user_id' => $friendId,
            'type' => 'friend_request',
            'data' => [
                'from_user_id' => $currentUser,
                'from_user_name' => \App\Models\User::find($currentUser)->hoten ?? 'Người dùng',
            ],
            'is_read' => false,
        ]);
        return response()->json(['success' => true, 'friend' => $friend]);
    }

    // Giao diện nhắn tin với bạn bè
    public function chatWithFriend($friend_id)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để sử dụng tin nhắn');
        }

        $currentUser = User::find(Session::get('user_id'));
        $friend = User::find($friend_id);

        if (!$friend) {
            abort(404, 'Không tìm thấy người dùng');
        }

        // Lấy lịch sử tin nhắn giữa 2 user
        $messages = \App\Models\TinNhan::where(function ($q) use ($currentUser, $friend_id) {
            $q->where('user_id', $currentUser->user_id)->where('receiver_id', $friend_id);
        })->orWhere(function ($q) use ($currentUser, $friend_id) {
            $q->where('user_id', $friend_id)->where('receiver_id', $currentUser->user_id);
        })
            ->orderBy('thoigiantao', 'asc')
            ->get();

        return view('friends.chat', compact('friend', 'currentUser', 'messages'));
    }

    // API trả về danh sách followers của user hiện tại
    public function apiFollowers()
    {
        if (!session()->has('user_id')) {
            return response()->json(['error' => 'Chưa đăng nhập'], 401);
        }
        $user = \App\Models\User::find(session('user_id'));
        $followers = $user->followersList()->get()->map(function ($u) {
            return [
                'user_id' => $u->user_id,
                'hoten' => $u->hoten,
                'avatar' => $u->hinhanh ? 'data:image/jpeg;base64,' . base64_encode($u->hinhanh) : null,
            ];
        });
        return response()->json(['followers' => $followers]);
    }
    // API trả về danh sách following của user hiện tại
    public function apiFollowing()
    {
        if (!session()->has('user_id')) {
            return response()->json(['error' => 'Chưa đăng nhập'], 401);
        }
        $user = \App\Models\User::find(session('user_id'));
        $following = $user->following()->get()->map(function ($u) {
            return [
                'user_id' => $u->user_id,
                'hoten' => $u->hoten,
                'avatar' => $u->hinhanh ? 'data:image/jpeg;base64,' . base64_encode($u->hinhanh) : null,
            ];
        });
        return response()->json(['following' => $following]);
    }
}
