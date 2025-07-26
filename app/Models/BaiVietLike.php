<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaiVietLike extends Model
{
    protected $table = 'bai_viet_like';
    public $timestamps = false;
    public $incrementing = false;
    // protected $primaryKey = ['id_user', 'id_baiviet'];

    protected $fillable = [
        'id_user',
        'id_baiviet'
    ];

    // Relationship với User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relationship với BaiViet
    public function baiviet()
    {
        return $this->belongsTo(BaiViet::class, 'id_baiviet', 'id_baiviet');
    }
} 