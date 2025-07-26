<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\BaiViet;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy thông tin user nếu đã đăng nhập
        $user = null;
        if (Session::has('user_id')) {
            $user = User::find(Session::get('user_id'));
        }

        // Lấy danh sách bài viết mới nhất
        $baiviets = BaiViet::with('user')
            ->where('is_draft', false)
            ->orderByDesc('thoigiandang')
            ->get();

        // Lấy bài viết nổi bật (>= 10 like)
        $featuredPosts = BaiViet::with('user')
            ->where('is_draft', false)
            ->where('soluotlike', '>=', 10)
            ->orderByDesc('soluotlike')
            ->orderByDesc('thoigiandang')
            ->limit(3)
            ->get();

        // Kiểm tra user đã like bài viết nào chưa
        $userLikedPosts = [];
        if ($user) {
            $userLikedPosts = \App\Models\BaiVietLike::where('id_user', $user->id_user)
                ->pluck('id_baiviet')
                ->toArray();
        }

        return view('home', compact('user', 'baiviets', 'featuredPosts', 'userLikedPosts'));
    }

    public function search(Request $request)
    {
        $type = $request->get('type', 'post');
        $query = $request->get('q', '');
        $filter = $request->get('filter', 'all');
        $liked = $request->get('liked', null); // 'liked', 'not_liked', null
        $commented = $request->get('commented', null); // 'commented', 'not_commented', null
        $friendPosts = $request->get('friend_posts', null); // '1' hoặc null

        if (empty($query)) {
            return redirect()->route('home');
        }

        if ($type === 'user') {
            // Tìm kiếm bạn bè
            $users = [];
            $currentUser = \Illuminate\Support\Facades\Session::has('user_id') ? \App\Models\User::find(\Illuminate\Support\Facades\Session::get('user_id')) : null;
            if (!empty($query)) {
                $users = \App\Models\User::where(function($q) use ($query) {
                        $q->where('hoten', 'like', "%{$query}%")
                          ->orWhere('username', 'like', "%{$query}%")
                          ->orWhere('email', 'like', "%{$query}%");
                    })
                    ->when($currentUser, function($q) use ($currentUser) {
                        $q->where('id_user', '!=', $currentUser->id_user);
                    })
                    ->get();
            }
            return view('search', compact('users', 'query', 'type', 'currentUser'));
        }

        // Tìm kiếm bài viết như cũ
        $user = null;
        if (\Illuminate\Support\Facades\Session::has('user_id')) {
            $user = \App\Models\User::find(\Illuminate\Support\Facades\Session::get('user_id'));
        }

        $baiviets = \App\Models\BaiViet::with('user')
            ->where('is_draft', false)
            ->where(function($q) use ($query, $filter) {
                if ($filter === 'user') {
                    $q->whereHas('user', function($userQuery) use ($query) {
                        $userQuery->where('hoten', 'like', "%{$query}%")
                                  ->orWhere('username', 'like', "%{$query}%");
                    });
                } elseif ($filter === 'title') {
                    $q->where('tieude', 'like', "%{$query}%");
                } else {
                    $q->where('tieude', 'like', "%{$query}%")
                      ->orWhere('noidung', 'like', "%{$query}%")
                      ->orWhere('mota', 'like', "%{$query}%")
                      ->orWhereHas('user', function($userQuery) use ($query) {
                          $userQuery->where('hoten', 'like', "%{$query}%")
                                    ->orWhere('username', 'like', "%{$query}%");
                      });
                }
            });

        if ($user && $liked) {
            if ($liked === 'liked') {
                $baiviets = $baiviets->whereHas('likes', function($likeQ) use ($user) {
                    $likeQ->where('id_user', $user->id_user);
                });
            } elseif ($liked === 'not_liked') {
                $baiviets = $baiviets->whereDoesntHave('likes', function($likeQ) use ($user) {
                    $likeQ->where('id_user', $user->id_user);
                });
            }
        }

        if ($user && $friendPosts === '1') {
            $friendIds = \App\Models\DanhSachBanBe::where('user_id_1', $user->id_user)
                ->orWhere('user_id_2', $user->id_user)
                ->get()
                ->map(function($row) use ($user) {
                    return $row->user_id_1 == $user->id_user ? $row->user_id_2 : $row->user_id_1;
                })->toArray();
            $baiviets = $baiviets->whereIn('id_user', $friendIds);
        }

        $baiviets = $baiviets->orderByDesc('thoigiandang')->get();

        $userLikedPosts = [];
        if ($user) {
            $userLikedPosts = \App\Models\BaiVietLike::where('id_user', $user->id_user)
                ->pluck('id_baiviet')
                ->toArray();
        }

        return view('search', compact('user', 'baiviets', 'userLikedPosts', 'query', 'filter', 'liked', 'commented', 'friendPosts', 'type'));
    }
} 