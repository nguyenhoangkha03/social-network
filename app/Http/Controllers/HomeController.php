<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\BaiViet;
use App\Models\Category;

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
        $baiviets = BaiViet::with(['user', 'category'])
            ->where('is_draft', false)
            ->orderByDesc('thoigiandang')
            ->get();

        // Lấy bài viết nổi bật (>= 10 like)
        $featuredPosts = BaiViet::with(['user', 'category'])
            ->where('is_draft', false)
            ->where('soluotlike', '>=', 10)
            ->orderByDesc('soluotlike')
            ->orderByDesc('thoigiandang')
            ->limit(3)
            ->get();

        // Lấy bài viết cho phần hero (2 bài viết có nhiều like nhất hoặc mới nhất)
        $heroPosts = BaiViet::with('user')
            ->where('is_draft', false)
            ->orderByDesc('soluotlike')
            ->orderByDesc('thoigiandang')
            ->limit(2)
            ->get();

        // Lấy danh sách categories
        $categories = Category::active()->ordered()->withCount('publishedBaiViets as posts_count')->get();

        // Kiểm tra user đã like bài viết nào chưa
        $userLikedPosts = [];
        if ($user) {
            $userLikedPosts = \App\Models\BaiVietLike::where('user_id', $user->user_id)
                ->pluck('id_baiviet')
                ->toArray();
        }

        return view('home', compact('user', 'baiviets', 'featuredPosts', 'heroPosts', 'userLikedPosts', 'categories'));
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
                $users = \App\Models\User::where(function ($q) use ($query) {
                    $q->where('hoten', 'like', "%{$query}%")
                        ->orWhere('username', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                })
                    ->when($currentUser, function ($q) use ($currentUser) {
                        $q->where('user_id', '!=', $currentUser->user_id);
                    })
                    ->limit(10) // Limit for AJAX requests
                    ->get();
            }

            // Return JSON for AJAX requests
            if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'users' => $users,
                    'type' => $type,
                    'query' => $query
                ]);
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
            ->where(function ($q) use ($query, $filter) {
                if ($filter === 'user') {
                    $q->whereHas('user', function ($userQuery) use ($query) {
                        $userQuery->where('hoten', 'like', "%{$query}%")
                            ->orWhere('username', 'like', "%{$query}%");
                    });
                } elseif ($filter === 'title') {
                    $q->where('tieude', 'like', "%{$query}%");
                } else {
                    $q->where('tieude', 'like', "%{$query}%")
                        ->orWhere('noidung', 'like', "%{$query}%")
                        ->orWhere('mota', 'like', "%{$query}%")
                        ->orWhereHas('user', function ($userQuery) use ($query) {
                            $userQuery->where('hoten', 'like', "%{$query}%")
                                ->orWhere('username', 'like', "%{$query}%");
                        });
                }
            });

        if ($user && $liked) {
            if ($liked === 'liked') {
                $baiviets = $baiviets->whereHas('likes', function ($likeQ) use ($user) {
                    $likeQ->where('user_id', $user->user_id);
                });
            } elseif ($liked === 'not_liked') {
                $baiviets = $baiviets->whereDoesntHave('likes', function ($likeQ) use ($user) {
                    $likeQ->where('user_id', $user->user_id);
                });
            }
        }

        if ($user && $friendPosts === '1') {
            $friendIds = \App\Models\DanhSachBanBe::where('user_id_1', $user->user_id)
                ->orWhere('user_id_2', $user->user_id)
                ->get()
                ->map(function ($row) use ($user) {
                    return $row->user_id_1 == $user->user_id ? $row->user_id_2 : $row->user_id_1;
                })->toArray();
            $baiviets = $baiviets->whereIn('user_id', $friendIds);
        }

        $baiviets = $baiviets->orderByDesc('thoigiandang')->get();

        $userLikedPosts = [];
        if ($user) {
            $userLikedPosts = \App\Models\BaiVietLike::where('user_id', $user->user_id)
                ->pluck('id_baiviet')
                ->toArray();
        }

        return view('search', compact('user', 'baiviets', 'userLikedPosts', 'query', 'filter', 'liked', 'commented', 'friendPosts', 'type'));
    }

    public function community()
    {
        // Lấy thông tin user nếu đã đăng nhập
        $user = null;
        if (Session::has('user_id')) {
            $user = User::find(Session::get('user_id'));
        }

        // Lấy thống kê cộng đồng
        $totalUsers = User::count();
        $totalPosts = BaiViet::where('is_draft', false)->count();
        $totalLikes = BaiViet::sum('soluotlike');
        $activeUsersToday = User::whereDate('updated_at', today())->count();

        // Lấy top users (theo số bài viết)
        $topWriters = User::withCount(['baiviets' => function($query) {
            $query->where('is_draft', false);
        }])
        ->having('baiviets_count', '>', 0)
        ->orderByDesc('baiviets_count')
        ->limit(10)
        ->get();

        // Lấy bài viết mới nhất từ cộng đồng
        $recentPosts = BaiViet::with('user')
            ->where('is_draft', false)
            ->orderByDesc('thoigiandang')
            ->limit(5)
            ->get();

        // Lấy người dùng mới tham gia
        $newMembers = User::orderByDesc('ngaytao')
            ->limit(8)
            ->get();

        return view('community.index', compact('user', 'totalUsers', 'totalPosts', 'totalLikes', 'activeUsersToday', 'topWriters', 'recentPosts', 'newMembers'));
    }

    public function about()
    {
        // Lấy thông tin user nếu đã đăng nhập
        $user = null;
        if (Session::has('user_id')) {
            $user = User::find(Session::get('user_id'));
        }

        // Thống kê tổng quan
        $stats = [
            'users' => User::count(),
            'posts' => BaiViet::where('is_draft', false)->count(),
            'categories' => Category::count(),
            'total_likes' => BaiViet::sum('soluotlike')
        ];

        return view('about.index', compact('user', 'stats'));
    }
}
