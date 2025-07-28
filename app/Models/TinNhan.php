<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinNhan extends Model
{
    use HasFactory;

    protected $table = 'tinnhan';
    protected $primaryKey = 'id_tinnhan';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'id_chanel',
        'receiver_id',
        'noidung',
        'thoigiantao',
        'thoigiancapnhat',
        'trangthaixoa',
        'hinhanh'
    ];

    protected $casts = [
        'thoigiantao' => 'datetime',
        'thoigiancapnhat' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'user_id');
    }
}
