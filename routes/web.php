<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\BaiViet;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendController;
use App\Models\TinNhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/profile/show', function () {
    return view('profiles.show');
})->name('profiles.show');

Route::get('/profile/edit', function () {
    return view('profiles.edit');
})->name('profiles.edit');

Route::post('/logout', function () {
    Session::forget('user_id');
    return redirect()->route('home');
})->name('logout');

// Routes cho bài viết
Route::get('/post', [PostController::class, 'showCreateForm'])->name('post.create');
Route::post('/post', [PostController::class, 'store'])->name('post.store');
Route::delete('/post/draft/{id}', [PostController::class, 'deleteDraft'])->name('post.deleteDraft');
Route::delete('/post/{id}', [PostController::class, 'delete'])->name('post.delete');
Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');
Route::post('/post/{id}/like', [PostController::class, 'toggleLike'])->name('post.like');
Route::post('/post/{id}/comment', [App\Http\Controllers\PostController::class, 'addComment'])->name('post.comment');
Route::delete('/comment/{id}', [App\Http\Controllers\PostController::class, 'deleteComment'])->name('comment.delete');
Route::patch('/comment/{id}', [App\Http\Controllers\PostController::class, 'editComment'])->name('comment.edit');
Route::post('/comment/{id}/pin', [App\Http\Controllers\PostController::class, 'pinComment'])->name('comment.pin');

Route::post('/user/{id}/follow', [UserController::class, 'toggleFollow'])->name('user.follow');
Route::get('/user/{id}/profile', [UserController::class, 'showProfile'])->name('user.profile');

// Thêm route chỉnh sửa và cập nhật profile
Route::get('/profile/{id}/edit', [UserController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{id}', [UserController::class, 'update'])->name('profile.update');

// Tìm kiếm bạn bè
Route::get('/friends/search', [UserController::class, 'searchFriends'])->name('friends.search');
// Danh sách bạn bè
Route::get('/friends/list', function (\Illuminate\Http\Request $request) {
    if ($request->has('api')) {
        $currentUser = session()->has('user_id') ? \App\Models\User::find(session('user_id')) : null;
        $friends = [];
        if ($currentUser) {
            $friendIds = \App\Models\DanhSachBanBe::where('user_id_1', $currentUser->id_user)
                ->orWhere('user_id_2', $currentUser->id_user)
                ->get()
                ->map(function ($row) use ($currentUser) {
                    return $row->user_id_1 == $currentUser->id_user ? $row->user_id_2 : $row->user_id_1;
                })->toArray();
            $friends = \App\Models\User::whereIn('id_user', $friendIds)->get()->map(function ($u) {
                return [
                    'id_user' => $u->id_user,
                    'hoten' => $u->hoten,
                    'avatar' => $u->hinhanh ? 'data:image/jpeg;base64,' . base64_encode($u->hinhanh) : null,
                ];
            })->values();
        }
        return response()->json(['friends' => $friends]);
    }
    return app(\App\Http\Controllers\UserController::class)->friendList($request);
});
// Thêm bạn
Route::post('/friends/add', [UserController::class, 'addFriend'])->name('friends.add');
// Nhắn tin cá nhân
Route::get('/messages/{friend_id}', [UserController::class, 'chatWithFriend'])->name('friends.chat');
// Route gửi tin nhắn
Route::post('/messages/send', [App\Http\Controllers\TinNhanController::class, 'sendMessage'])->name('messages.send');

// Đánh dấu tất cả thông báo là đã đọc
Route::post('/notifications/mark-read', function () {
    $user = auth()->user() ?? (session('user_id') ? \App\Models\User::find(session('user_id')) : null);
    if (!$user) return response()->json(['success' => false]);
    $user->myNotifications()->where('is_read', false)->update(['is_read' => true]);
    return response()->json(['success' => true]);
})->name('notifications.markRead');

Route::get('/friends', [FriendController::class, 'index']);
Route::post('/upload-image', [App\Http\Controllers\PostController::class, 'uploadImage']);
Route::post('/upload-multiple-images', [App\Http\Controllers\PostController::class, 'uploadMultipleImages']);

// API lấy danh sách followers/following cho user hiện tại
Route::get('/api/followers', [App\Http\Controllers\UserController::class, 'apiFollowers'])->name('api.followers');
Route::get('/api/following', [App\Http\Controllers\UserController::class, 'apiFollowing'])->name('api.following');

// API lấy danh sách user (1-1) và group chat cho sidebar
Route::get('/api/chat/users', [App\Http\Controllers\TinNhanController::class, 'apiChatUsers']);
Route::get('/api/chat/groups', [App\Http\Controllers\TinNhanController::class, 'apiChatGroups']);
// API lấy tin nhắn 1-1 và group
Route::get('/api/messages/{id}', [App\Http\Controllers\TinNhanController::class, 'apiMessages']);
Route::get('/api/messages/group/{id}', [App\Http\Controllers\TinNhanController::class, 'apiGroupMessages']);
// Route trả về giao diện chat
Route::get('/chat', function () {
    return view('friends.chat');
})->name('chat');

// API lấy danh sách bạn bè (tất cả bạn bè)
Route::get('/api/friends', function () {
    try {
        if (!session()->has('user_id')) {
            return response()->json(['error' => 'Chưa đăng nhập'], 401);
        }

        $currentUser = \App\Models\User::find(session('user_id'));
        if (!$currentUser) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $friendIds = \App\Models\DanhSachBanBe::where('user_id_1', $currentUser->id_user)
            ->orWhere('user_id_2', $currentUser->id_user)
            ->get()
            ->map(function ($row) use ($currentUser) {
                return $row->user_id_1 == $currentUser->id_user ? $row->user_id_2 : $row->user_id_1;
            })->toArray();

        $friends = \App\Models\User::whereIn('id_user', $friendIds)->get()->map(function ($u) {
            return [
                'id_user' => $u->id_user,
                'hoten' => $u->hoten,
                'avatar' => $u->hinhanh ? 'data:image/jpeg;base64,' . base64_encode($u->hinhanh) : null,
            ];
        })->values();

        return response()->json(['friends' => $friends]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
    }
});

// API lấy lịch sử tin nhắn 1-1
Route::get('/api/chat/messages/{friend_id}', function ($friend_id) {
    try {
        if (!session()->has('user_id')) {
            return response()->json(['error' => 'Chưa đăng nhập'], 401);
        }

        $userId = session('user_id');
        $messages = \App\Models\TinNhan::where(function ($q) use ($userId, $friend_id) {
            $q->where('id_user', $userId)->where('receiver_id', $friend_id);
        })->orWhere(function ($q) use ($userId, $friend_id) {
            $q->where('id_user', $friend_id)->where('receiver_id', $userId);
        })
            ->orderBy('thoigiantao')
            ->get()
            ->map(function ($m) use ($userId) {
                return [
                    'id' => $m->id_tinnhan,
                    'me' => $m->id_user == $userId,
                    'user_id' => $m->id_user,
                    'noidung' => $m->noidung,
                    'hinhanh' => $m->hinhanh,
                    'thoigiantao' => $m->thoigiantao,
                ];
            });

        return response()->json(['messages' => $messages]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
    }
});

// API gửi tin nhắn 1-1
Route::post('/api/chat/send', function (Request $request) {
    try {
        if (!session()->has('user_id')) {
            return response()->json(['error' => 'Chưa đăng nhập'], 401);
        }

        $request->validate([
            'receiver_id' => 'required|integer|exists:users,id_user',
            'noidung' => 'required|string',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        $id_nguoi_gui = session('user_id');
        $receiver_id = $request->receiver_id;
        // Tìm hoặc tạo channel 1-1
        $userIds = [$id_nguoi_gui, $receiver_id];
        sort($userIds);
        $chanel = DB::table('chanel')
            ->join('user_chanel as uc1', 'chanel.id_chanel', '=', 'uc1.id_chanel')
            ->join('user_chanel as uc2', 'chanel.id_chanel', '=', 'uc2.id_chanel')
            ->where('uc1.id_user', $userIds[0])
            ->where('uc2.id_user', $userIds[1])
            ->groupBy('chanel.id_chanel')
            ->havingRaw('COUNT(DISTINCT uc1.id_user) = 1 AND COUNT(DISTINCT uc2.id_user) = 1')
            ->select('chanel.id_chanel')
            ->first();
        if ($chanel) {
            $id_chanel = $chanel->id_chanel;
        } else {
            $id_chanel = DB::table('chanel')->insertGetId([
                'tenkenh' => '',
                'nguoisohuu' => $id_nguoi_gui,
                'thoigiantao' => now(),
                'thoigiancapnhat' => now(),
                'loaikenh' => 0,
            ]);
            DB::table('user_chanel')->insert([
                ['id_user' => $id_nguoi_gui, 'id_chanel' => $id_chanel],
                ['id_user' => $receiver_id, 'id_chanel' => $id_chanel],
            ]);
        }

        $messageContent = $request->noidung;
        $imagePath = null;

        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            try {
                $file->move(public_path('uploads/messages'), $fileName);
                $imagePath = 'uploads/messages/' . $fileName;
                $tinNhan = \App\Models\TinNhan::create([
                    'id_user' => $id_nguoi_gui,
                    // 'id_chanel' => $id_chanel,
                    'receiver_id' => $receiver_id,
                    'noidung' => $messageContent,
                    'hinhanh' => $imagePath,
                    'thoigiantao' => now()
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Không thể lưu ảnh: ' . $e->getMessage()], 500);
            }
        } else {
            $tinNhan = \App\Models\TinNhan::create([
                'id_user' => $id_nguoi_gui,
                // 'id_chanel' => $id_chanel,
                'receiver_id' => $receiver_id,
                'noidung' => $messageContent,
                'thoigiantao' => now()
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Đã gửi tin nhắn!', 'msg' => $tinNhan]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error sending message: ' . $e->getMessage()], 500);
    }
});

Route::get('/admin', function (Request $request) {
    if (!$request->session()->has('admin_logged_in')) {
        return redirect('/admin-login');
    }
    return view('admin.admin');
});

Route::get('/admin-login', function () {
    return view('admin.login');
});

Route::post('/admin-login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');
    $admins = config('admins.accounts');
    $keyContent = null;
    if ($request->hasFile('admin_key')) {
        $file = $request->file('admin_key');
        $keyContent = trim(file_get_contents($file->getRealPath()));
    }
    $requiredKey = 'Dha pe hqpi oic izp ddkhqx xll cye dkgzr. Cfl nls hr jkmr qdC fzf go rijs zcv iilgk kfue dnwty ugxvb';
    if (!($keyContent && $keyContent === $requiredKey)) {
        return back()->with('error', 'File .key không hợp lệ hoặc sai nội dung!');
    }
    if (isset($admins[$username]) && $admins[$username] === $password) {
        $request->session()->put('admin_logged_in', true);
        return redirect('/admin');
    }
    return back()->with('error', 'Sai tài khoản hoặc mật khẩu');
});

Route::post('/admin/upload-bg', function (Request $request) {
    if (!$request->session()->has('admin_logged_in')) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    if ($request->hasFile('bg')) {
        $file = $request->file('bg');
        $fileName = 'bg_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/bg'), $fileName);
        // Lưu tên file vào storage
        Storage::disk('local')->put('bg_image.txt', $fileName);
        return response()->json(['success' => true, 'file' => $fileName, 'url' => asset('images/bg/' . $fileName)]);
    }
    return response()->json(['error' => 'No file uploaded'], 400);
});

Route::post('/admin-upload-banner', function (Request $request) {
    if ($request->hasFile('banner')) {
        $file = $request->file('banner');
        $name = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/topbanner'), $name);
        Storage::disk('local')->put('topbanner.txt', $name);
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
});
Route::post('/admin-set-bgcolor', function (Request $request) {
    $color = $request->input('color');
    if ($color) {
        Storage::disk('local')->put('bgcolor.txt', $color);
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
});

Route::post('/admin-upload-banner-album', function (Request $request) {
    $albumFile = 'topbanner_album.json';
    $dir = public_path('images/topbanner');
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $album = Storage::disk('local')->exists($albumFile) ? json_decode(Storage::disk('local')->get($albumFile), true) : [];
    $files = $request->file('banners', []);
    if (count($album) + count($files) > 5) {
        return response()->json(['success' => false, 'error' => 'Tối đa 5 ảnh banner!']);
    }
    foreach ($files as $file) {
        $name = 'banner_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $name);
        $album[] = $name;
    }
    Storage::disk('local')->put($albumFile, json_encode($album));
    return response()->json(['success' => true]);
});
Route::get('/admin-banner-album-list', function () {
    $albumFile = 'topbanner_album.json';
    $album = Storage::disk('local')->exists($albumFile) ? json_decode(Storage::disk('local')->get($albumFile), true) : [];
    return response()->json(['album' => $album]);
});
Route::post('/admin-delete-banner', function (Request $request) {
    $albumFile = 'topbanner_album.json';
    $file = $request->input('file');
    $album = Storage::disk('local')->exists($albumFile) ? json_decode(Storage::disk('local')->get($albumFile), true) : [];
    $album = array_values(array_filter($album, fn($f) => $f !== $file));
    if (file_exists(public_path('images/topbanner/' . $file))) @unlink(public_path('images/topbanner/' . $file));
    Storage::disk('local')->put($albumFile, json_encode($album));
    return response()->json(['success' => true]);
});
