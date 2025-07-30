<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\BaiViet;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $drafts = \App\Models\BaiViet::where('user_id', $user->user_id)->where('is_draft', true)->orderByDesc('thoigiancapnhat')->get();
        $published = \App\Models\BaiViet::where('user_id', $user->user_id)->where('is_draft', false)->orderByDesc('thoigiandang')->get();

        // Lấy danh sách categories
        $categories = Category::active()->ordered()->get();

        // Nếu có query edit, lấy bài viết để sửa
        $editPost = null;
        if ($request->has('edit')) {
            $editPost = \App\Models\BaiViet::where('id_baiviet', $request->query('edit'))
                ->where('user_id', $user->user_id)
                ->first();
        }

        return view('post', compact('user', 'drafts', 'published', 'editPost', 'categories'));
    }

    public function store(Request $request)
    {
        // Debug: Log session user_id và toàn bộ request
        Log::info('DEBUG_POST: Session user_id: ' . json_encode(Session::get('user_id')));
        Log::info('DEBUG_POST: Request all: ' . json_encode($request->except(['noidung']))); // Exclude noidung to avoid large logs
        Log::info('DEBUG_POST: Content length: ' . strlen($request->input('noidung', '')));

        // Kiểm tra user đã đăng nhập chưa
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đăng bài viết');
        }

        // Validation - Relaxed validation for content with HTML
        try {
            $request->validate([
                'tieude' => 'required|string|min:10|max:255',
                'category_id' => 'nullable|exists:categories,id',
                'mota' => 'nullable|string|max:2000',
                'noidung' => 'required|string|min:10', // Reduced min length for HTML content
                'anh_bia' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB, added webp
                'dinhkhem' => 'nullable|string|max:500',
            ], [
                'tieude.required' => 'Tiêu đề không được để trống',
                'tieude.min' => 'Tiêu đề phải có ít nhất 10 ký tự',
                'tieude.max' => 'Tiêu đề không được vượt quá 255 ký tự',
                'noidung.required' => 'Nội dung không được để trống',
                'noidung.min' => 'Nội dung phải có ít nhất 10 ký tự',
                'anh_bia.image' => 'File phải là hình ảnh',
                'anh_bia.mimes' => 'Chỉ chấp nhận file: jpeg, png, jpg, gif, webp',
                'anh_bia.max' => 'Kích thước file không được vượt quá 10MB',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed: ' . json_encode($e->errors()));
            return back()->withErrors($e->errors())->withInput();
        }

        try {
            // Sử dụng transaction để đảm bảo tính toàn vẹn dữ liệu
            DB::beginTransaction();

            // Kiểm tra xem có phải edit bài viết không
            $isEdit = $request->filled('edit_id');
            $editPost = null;
            
            if ($isEdit) {
                $editPost = BaiViet::where('id_baiviet', $request->edit_id)
                    ->where('user_id', Session::get('user_id'))
                    ->first();
                
                if (!$editPost) {
                    throw new \Exception('Không tìm thấy bài viết để chỉnh sửa');
                }
            }

            // Tạo ID bài viết ngẫu nhiên nếu là bài viết mới
            $id_baiviet = $isEdit ? $editPost->id_baiviet : null;
            if (!$isEdit) {
                do {
                    $id_baiviet = 'BV' . strtoupper(Str::random(8));
                    $exists = BaiViet::where('id_baiviet', $id_baiviet)->exists();
                } while ($exists);
            }

            // Xử lý upload ảnh bìa
            $anh_bia_path = null;
            if ($request->hasFile('anh_bia')) {
                $file = $request->file('anh_bia');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $uploadPath = public_path('uploads/posts');

                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                try {
                    $file->move($uploadPath, $fileName);
                    $anh_bia_path = 'uploads/posts/' . $fileName;
                    Log::info('File uploaded successfully: ' . $anh_bia_path);
                } catch (\Exception $e) {
                    Log::error('File upload failed: ' . $e->getMessage());
                    throw new \Exception('Không thể upload ảnh bìa: ' . $e->getMessage());
                }
            }

            // Tạo hoặc cập nhật bài viết
            if ($isEdit) {
                // Cập nhật bài viết hiện có
                $baiviet = $editPost;
                $baiviet->category_id = $request->category_id ?: null;
                $baiviet->tieude = $request->tieude;
                $baiviet->mota = $request->mota;
                $baiviet->noidung = $request->noidung;
                if ($anh_bia_path) {
                    // Xóa ảnh cũ nếu có
                    if ($baiviet->anh_bia && file_exists(public_path($baiviet->anh_bia))) {
                        unlink(public_path($baiviet->anh_bia));
                    }
                    $baiviet->anh_bia = $anh_bia_path;
                }
                $baiviet->dinhkhem = $request->dinhkhem;
                $baiviet->thoigiancapnhat = now();
                $baiviet->is_draft = $request->has('save_draft') ? true : false;
            } else {
                // Tạo bài viết mới
                $baiviet = new BaiViet();
                $baiviet->id_baiviet = $id_baiviet;
                $baiviet->user_id = Session::get('user_id');
                $baiviet->category_id = $request->category_id ?: null; // Nếu không chọn thì để null
                $baiviet->tieude = $request->tieude;
                $baiviet->mota = $request->mota;
                $baiviet->noidung = $request->noidung;
                $baiviet->anh_bia = $anh_bia_path;
                $baiviet->dinhkhem = $request->dinhkhem;
                $baiviet->thoigiandang = now();
                $baiviet->thoigiancapnhat = now();
                $baiviet->soluotlike = 0;
                $baiviet->is_draft = $request->has('save_draft') ? true : false;
            }

            $result = $baiviet->save();

            if (!$result) {
                throw new \Exception('Không thể lưu bài viết');
            }

            DB::commit();

            if ($baiviet->is_draft) {
                $message = $isEdit ? 'Đã cập nhật nháp bài viết!' : 'Đã lưu nháp bài viết!';
                return redirect()->route('post.create')->with('success', $message);
            }
            
            $message = $isEdit ? 'Cập nhật bài viết thành công!' : 'Đăng bài viết thành công!';
            return redirect()->route('home')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollback();

            // Log lỗi để debug
            Log::error('Lỗi khi tạo bài viết: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

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
            $userLiked = \App\Models\BaiVietLike::where('user_id', session('user_id'))
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
            'user_id' => session('user_id'),
            'id_baiviet' => $id,
            'noidung' => $request->noidung,
            'thoigiantao' => now(),
            'parent_id' => $request->input('parent_id')
        ]);
        $comment->load('user');
        // Tạo notification cho chủ bài viết (nếu không phải tự comment bài của mình)
        if ($post->user_id != session('user_id')) {
            \App\Models\Notification::create([
                'user_id' => $post->user_id,
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
        if ($comment->user_id != $userId) {
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
            ->where('user_id', $userId)
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
            ->where('user_id', $userId)
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
            $deleted = \App\Models\BaiVietLike::where('user_id', $userId)
                ->where('id_baiviet', $id)
                ->delete();

            if ($deleted) {
                // Nếu đã từng like, thì đây là unlike
                $post->decrement('soluotlike');
                $isLiked = false;
            } else {
                // Nếu chưa like, thì tạo mới
                \App\Models\BaiVietLike::create([
                    'user_id' => $userId,
                    'id_baiviet' => $id,
                ]);
                $post->increment('soluotlike');
                $isLiked = true;
                if ($post->user_id != $userId) {
                    \App\Models\Notification::create([
                        'user_id' => $post->user_id,
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
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Create directory if not exists
                $uploadPath = public_path('uploads/posts');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $file->move($uploadPath, $fileName);
                $url = asset('uploads/posts/' . $fileName);

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'filename' => $fileName
                ]);
            }

            return response()->json(['error' => 'No file uploaded'], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadMultipleImages(Request $request)
    {
        try {
            $request->validate([
                'images' => 'required|array|max:10',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            $uploadedFiles = [];
            $uploadPath = public_path('uploads/posts');

            // Create directory if not exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            foreach ($request->file('images') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $fileName);

                $uploadedFiles[] = [
                    'url' => asset('uploads/posts/' . $fileName),
                    'filename' => $fileName
                ];
            }

            return response()->json([
                'success' => true,
                'files' => $uploadedFiles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
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
        $isOwner = $comment->user_id == $userId;
        $isPostOwner = $comment->post && $comment->post->user_id == $userId;
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
        if (!$post || $post->user_id != $userId) {
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
