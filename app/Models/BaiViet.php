<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    protected $table = 'baiviet';
    protected $primaryKey = 'id_baiviet';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_baiviet',
        'user_id',
        'category_id',
        'tieude',
        'mota',
        'noidung',
        'anh_bia',
        'dinhkhem',
        'thoigiandang',
        'thoigiancapnhat',
        'soluotlike',
        'is_draft'
    ];

    protected $casts = [
        'thoigiandang' => 'datetime',
        'thoigiancapnhat' => 'datetime',
        'soluotlike' => 'integer',
        'is_draft' => 'boolean'
    ];

    // Relationship với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relationship với Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relationship với BaiVietLike
    public function likes()
    {
        return $this->hasMany(BaiVietLike::class, 'id_baiviet', 'id_baiviet');
    }

    // Bình luận được ghim
    public function pinnedComment()
    {
        return $this->belongsTo(BinhLuan::class, 'pinned_comment_id', 'id_binhluan');
    }

    // Scope để lấy bài viết mới nhất
    public function scopeLatest($query)
    {
        return $query->orderBy('thoigiandang', 'desc');
    }

    // Scope để lấy bài viết theo user
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Accessor để lấy URL ảnh bìa
    public function getAnhBiaUrlAttribute()
    {
        if ($this->anh_bia) {
            return asset($this->anh_bia);
        }
        return null;
    }

    // Accessor để lấy thời gian đăng dạng "cách đây..."
    public function getThoiGianDangFormattedAttribute()
    {
        return $this->thoigiandang->diffForHumans();
    }

    // Method để tăng số lượt like
    public function incrementLikes()
    {
        $this->increment('soluotlike');
    }

    // Method để giảm số lượt like
    public function decrementLikes()
    {
        $this->decrement('soluotlike');
    }
}
