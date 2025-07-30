<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\BaiViet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index()
    {
        // Lấy thông tin user nếu đã đăng nhập
        $user = null;
        if (Session::has('user_id')) {
            $user = User::find(Session::get('user_id'));
        }

        $categories = Category::active()->ordered()->withCount('publishedBaiViets as posts_count')->get();
        
        return view('categories.index', compact('categories', 'user'));
    }

    public function show($slug)
    {
        // Lấy thông tin user nếu đã đăng nhập
        $user = null;
        if (Session::has('user_id')) {
            $user = User::find(Session::get('user_id'));
        }

        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        $baiviets = BaiViet::where('category_id', $category->id)
            ->where('is_draft', false)
            ->with(['user', 'category'])
            ->latest()
            ->paginate(12);

        // Lấy categories khác để hiển thị sidebar
        $otherCategories = Category::active()
            ->where('id', '!=', $category->id)
            ->ordered()
            ->withCount('publishedBaiViets as posts_count')
            ->limit(8)
            ->get();

        // Lấy bài viết nổi bật trong category này
        $featuredPosts = BaiViet::where('category_id', $category->id)
            ->where('is_draft', false)
            ->where('soluotlike', '>', 5)
            ->with(['user', 'category'])
            ->latest()
            ->limit(3)
            ->get();

        // Kiểm tra user đã like bài viết nào chưa
        $userLikedPosts = [];
        if ($user) {
            $userLikedPosts = \App\Models\BaiVietLike::where('user_id', $user->user_id)
                ->pluck('id_baiviet')
                ->toArray();
        }

        return view('categories.show', compact('category', 'baiviets', 'otherCategories', 'featuredPosts', 'user', 'userLikedPosts'));
    }

    public function posts($slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        $baiviets = BaiViet::where('category_id', $category->id)
            ->where('is_draft', false)
            ->with(['user', 'category'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $baiviets,
            'category' => $category
        ]);
    }
}