<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    protected $table = 'binhluan';
    protected $primaryKey = 'id_binhluan';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'id_baiviet',
        'noidung',
        'thoigiantao',
        'parent_id'
    ];

    protected $casts = [
        'thoigiantao' => 'datetime'
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Quan hệ với BaiViet
    public function post()
    {
        return $this->belongsTo(BaiViet::class, 'id_baiviet', 'id_baiviet');
    }

    // Quan hệ replies (chỉ 1 cấp)
    public function replies()
    {
        return $this->hasMany(BinhLuan::class, 'parent_id', 'id_binhluan');
    }
}
