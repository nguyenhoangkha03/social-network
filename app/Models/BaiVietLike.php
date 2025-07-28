<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaiVietLike extends Model
{
    protected $table = 'bai_viet_like';
    public $timestamps = false;
    public $incrementing = false;
    // protected $primaryKey = ['user_id', 'id_baiviet'];

    protected $fillable = [
        'user_id',
        'id_baiviet'
    ];

    // Relationship với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relationship với BaiViet
    public function baiviet()
    {
        return $this->belongsTo(BaiViet::class, 'id_baiviet', 'id_baiviet');
    }
}
