<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\BaiViet;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function showCreateForm(Request $request)
    {
        // Kiểm tra user đã đăng nhập chưa
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đăng bài viết');
        }

        $user = User::find(Session::get('user_id'));
        if (!$user) {
            Session::forget('user_id');
            return redirect()->route('login')->with('error', 'Phiên đăng nhập đã hết hạn');
        }

        // Lấy danh sách bản nháp và bài đã đăng của user
        $drafts = \App\Models\BaiViet::where('id_user', $user->id_user)->where('is_draft', true)->orderByDesc('thoigiancapnhat')->get();
        $published = \App\Models\BaiViet::where('id_user', $user->id_user)->where('is_draft', false)->orderByDesc('thoigiandang')->get();

        // Nếu có query edit, lấy bài viết để sửa
        $editPost = null;
        if ($request->has('edit')) {
            $editPost = \App\Models\BaiViet::where('id_baiviet', $request->query('edit'))
                ->where('id_user', $user->id_user)
                ->first();
        }

        return view('post', compact('user', 'drafts', 'published', 'editPost'));
    }

    public function store(Request $request)
    {
        // Debug: Log session user_id và toàn bộ request
        \Log::info('DEBUG_POST: Session user_id: ' . json_encode(Session::get('user_id')));
        \Log::info('DEBUG_POST: Request all: ' . json_encode($request->all()));
        // Kiểm tra user đã đăng nhập chưa
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đăng bài viết');
        }

        // Validation
        $request->validate([
            'tieude' => 'required|string|min:10|max:255',
            'mota' => 'nullable|string|max:1000',
            'noidung' => 'required|string|min:50',
            'anh_bia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
            'dinhkhem' => 'nullable|string|max:255',
        ], [
            'tieude.required' => 'Tiêu đề không được để trống',
            'tieude.min' => 'Tiêu đề phải có ít nhất 10 ký tự',
            'tieude.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'noidung.required' => 'Nội dung không được để trống',
            'noidung.min' => 'Nội dung phải có ít nhất 50 ký tự',
            'anh_bia.image' => 'File phải là hình ảnh',
            'anh_bia.mimes' => 'Chỉ chấp nhận file: jpeg, png, jpg, gif',
            'anh_bia.max' => 'Kích thước file không được vượt quá 5MB',
        ]);

        try {
            // Sử dụng transaction để đảm bảo tính toàn vẹn dữ liệu
            DB::beginTransaction();

            // Tạo ID bài viết ngẫu nhiên và đảm bảo không trùng lặp
            do {
                $id_baiviet = 'BV' . strtoupper(Str::random(8));
                $exists = BaiViet::where('id_baiviet', $id_baiviet)->exists();
            } while ($exists);

            // Xử lý upload ảnh bìa
            $anh_bia_path = null;
            if ($request->hasFile('anh_bia')) {
                $file = $request->file('anh_bia');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $uploadPath = public_path('uploads/posts');
                
                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $file->move($uploadPath, $fileName);
                $anh_bia_path = 'uploads/posts/' . $fileName;
            }

            // Tạo bài viết mới
            $baiviet = new BaiViet();
            $baiviet->id_baiviet = $id_baiviet;
            $baiviet->id_user = Session::get('user_id');
            $baiviet->tieude = $request->tieude;
            $baiviet->mota = $request->mota;
            $baiviet->noidung = $request->noidung;
            $baiviet->anh_bia = $anh_bia_path;
            $baiviet->dinhkhem = $request->dinhkhem;
            $baiviet->thoigiandang = now();
            $baiviet->thoigiancapnhat = now();
            $baiviet->soluotlike = 0;
            $baiviet->is_draft = $request->has('save_draft') ? true : false;
            
            $result = $baiviet->save();

            if (!$result) {
                throw new \Exception('Không thể lưu bài viết');
            }

            DB::commit();

            if ($baiviet->is_draft) {
                return redirect()->route('post.create')->with('success', 'Đã lưu nháp bài viết!');
            }
            return redirect()->route('home')->with('success', 'Đăng bài viết thành công!');

        } catch (\Exception $e) {
            DB::rollback();
            
            // Log lỗi để debug
            \Log::error('Lỗi khi tạo bài viết: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->withInput()->with('error', 'Có lỗi xảy ra khi đăng bài viết: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $post = \App\Models\BaiViet::with(['user', 'pinnedComment.user'])->where('id_baiviet', $id)->where('is_draft', false)->first();
        if (!$post) abort(404);

        $user = null;
        $userLiked = false;
        if (session()->has('user_id')) {
            $user = \App\Models\User::find(session('user_id'));
            $userLiked = \App\Models\BaiVietLike::where('id_user', session('user_id'))
                ->where('id_baiviet', $id)
                ->exists();
        }

        // Lấy bình luận cha và replies (1 cấp)
        $comments = \App\Models\BinhLuan::with(['user', 'replies.user'])
            ->where('id_baiviet', $id)
            ->whereNull('parent_id')
            ->orderBy('thoigiantao', 'asc')
            ->get();

        return view('post_detail', compact('post', 'userLiked', 'comments', 'user'));
    }

    public function addComment(Request $request, $id)
    {
        if (!session()->has('user_id')) {
            return response()->json(['error' => 'Vui lòng đăng nhập'], 401);
        }
        $request->validate([
            'noidung' => 'required|string|min:1|max:1000'
        ]);
        $post = \App\Models\BaiViet::where('id_baiviet', $id)->where('is_draft', false)->first();
        if (!$post) {
            return response()->json(['error' => 'Không tìm thấy bài viết'], 404);
        }
        $comment = \App\Models\BinhLuan::create([
            'id_user' => session('user_id'),
            'id_baiviet' => $id,
            'noidung' => $request->noidung,
            'thoigiantao' => now(),
            'parent_id' => $request->input('parent_id')
        ]);
        $comment->load('user');
        // Tạo notification cho chủ bài viết (nếu không phải tự comment bài của mình)
        if ($post->id_user != session('user_id')) {
            \App\Models\Notification::create([
                'user_id' => $post->id_user,
                'type' => 'comment',
                'data' => [
                    'from_user_id' => session('user_id'),
                    'from_user_name' => $comment->user->hoten ?? $comment->user->username ?? 'Người dùng',
                    'post_id' => $post->id_baiviet,
                    'post_title' => $post->tieude,
                ],
                'is_read' => false,
            ]);
        }
        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id_binhluan,
                'content' => $comment->noidung,
                'user_name' => $comment->user->hoten ?? $comment->user->username ?? 'Tác giả',
                'created_at' => $comment->thoigiantao->diffForHumans(),
                'parent_id' => $comment->parent_id
            ]
        ]);
    }

    public function editComment(Request $request, $id)
    {
        if (!session()->has('user_id')) {
            return response()->json(['error' => 'Vui lòng đăng nhập'], 401);
        }
        $userId = session('user_id');
        $comment = \App\Models\BinhLuan::find($id);
        if (!$comment) {
            return response()->json(['error' => 'Không tìm thấy bình luận'], 404);
        }
        if ($comment->id_user != $userId) {
            return response()->json(['error' => 'Bạn không có quyền chỉnh sửa bình luận này'], 403);
        }
        $request->validate([
            'noidung' => 'required|string|min:1|max:1000'
        ]);
        $comment->noidung = $request->noidung;
        $comment->save();
        return response()->json(['success' => true, 'noidung' => $comment->noidung]);
    }

    public function deleteDraft($id)
    {
        $userId = Session::get('user_id');
        $draft = \App\Models\BaiViet::where('id_baiviet', $id)
            ->where('id_user', $userId)
            ->where('is_draft', true)
            ->first();

        if ($draft) {
            $draft->delete();
            return redirect()->route('post.create')->with('success', 'Đã xóa bản nháp!');
        }
        return redirect()->route('post.create')->with('error', 'Không tìm thấy bản nháp!');
    }

    public function delete($id)
    {
        $userId = Session::get('user_id');
        $post = \App\Models\BaiViet::where('id_baiviet', $id)
            ->where('id_user', $userId)
            ->where('is_draft', false)
            ->first();

        if ($post) {
            $post->delete();
            return redirect()->route('post.create')->with('success', 'Đã gỡ bài viết!');
        }
        return redirect()->route('post.create')->with('error', 'Không tìm thấy bài viết!');
    }

    public function toggleLike($id)
    {
        try {
            if (!Session::has('user_id')) {
                return response()->json(['success' => false, 'message' => 'Bạn cần đăng nhập']);
            }
            $userId = Session::get('user_id');
            $id = (string)$id;
            $post = \App\Models\BaiViet::findOrFail($id);

            // Xóa mọi like cũ (nếu có)
            $deleted = \App\Models\BaiVietLike::where('id_user', $userId)
                ->where('id_baiviet', $id)
                ->delete();

            if ($deleted) {
                // Nếu đã từng like, thì đây là unlike
                $post->decrement('soluotlike');
                $isLiked = false;
            } else {
                // Nếu chưa like, thì tạo mới
                \App\Models\BaiVietLike::create([
                    'id_user' => $userId,
                    'id_baiviet' => $id,
                ]);
                $post->increment('soluotlike');
                $isLiked = true;
                if ($post->id_user != $userId) {
                    \App\Models\Notification::create([
                        'user_id' => $post->id_user,
                        'type' => 'like',
                        'data' => [
                            'from_user_id' => $userId,
                            'from_user_name' => \App\Models\User::find($userId)->hoten ?? 'Người dùng',
                            'post_id' => $post->id_baiviet,
                            'post_title' => $post->tieude,
                        ],
                        'is_read' => false,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'isLiked' => $isLiked,
                'likeCount' => $post->soluotlike,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/posts', $fileName, 'public');
            $url = asset('storage/' . $path);
            return response()->json(['url' => $url]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function deleteComment($id)
    {
        if (!session()->has('user_id')) {
            return response()->json(['error' => 'Vui lòng đăng nhập'], 401);
        }
        $userId = session('user_id');
        $comment = \App\Models\BinhLuan::with('post')->find($id);
        if (!$comment) {
            return response()->json(['error' => 'Không tìm thấy bình luận'], 404);
        }
        $isOwner = $comment->id_user == $userId;
        $isPostOwner = $comment->post && $comment->post->id_user == $userId;
        if (!$isOwner && !$isPostOwner) {
            return response()->json(['error' => 'Bạn không có quyền xóa bình luận này'], 403);
        }
        // Nếu là bình luận cha, xóa luôn các reply con
        if ($comment->parent_id === null) {
            \App\Models\BinhLuan::where('parent_id', $comment->id_binhluan)->delete();
        }
        $comment->delete();
        return response()->json(['success' => true]);
    }

    public function pinComment(Request $request, $id)
    {
        if (!session()->has('user_id')) {
            return response()->json(['error' => 'Vui lòng đăng nhập'], 401);
        }
        $userId = session('user_id');
        $comment = \App\Models\BinhLuan::find($id);
        if (!$comment || $comment->parent_id !== null) {
            return response()->json(['error' => 'Chỉ có thể ghim bình luận cha'], 400);
        }
        $post = \App\Models\BaiViet::find($comment->id_baiviet);
        if (!$post || $post->id_user != $userId) {
            return response()->json(['error' => 'Bạn không có quyền ghim bình luận này'], 403);
        }
        // Nếu đã ghim bình luận này thì bỏ ghim, ngược lại thì ghim
        if ($post->pinned_comment_id == $comment->id_binhluan) {
            $post->pinned_comment_id = null;
            $post->save();
            return response()->json(['success' => true, 'pinned' => false]);
        } else {
            $post->pinned_comment_id = $comment->id_binhluan;
            $post->save();
            return response()->json(['success' => true, 'pinned' => true]);
        }
    }
} 