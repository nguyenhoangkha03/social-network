<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';

    // Khai báo lại tên cột thời gian nếu không dùng created_at / updated_at mặc định
    // const CREATED_AT = 'ngaytao';
    // const UPDATED_AT = 'ngaycapnhat';
    // public $timestamps = true;

    protected $fillable = [
        'username',
        'password',
        'hoten',
        'diachi',
        'gioitinh',
        'hinhanh',
        'ngaytao',
        'ngaycapnhat',
        'email',
        'sodienthoai',
        'trangthai'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Các quan hệ đã rất đầy đủ
    public function baiviets()
    {
        return $this->hasMany(BaiViet::class, 'id_user', 'id_user');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'follower_id', 'id_user');
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id', 'id_user');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id', 'id_user', 'id_user');
    }

    public function followersList()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id', 'id_user', 'id_user');
    }

    public function isFollowing($userId)
    {
        return $this->follows()->where('following_id', $userId)->exists();
    }

    public function isFollowedBy($userId)
    {
        return $this->followers()->where('follower_id', $userId)->exists();
    }

    public function myNotifications()
    {
        return $this->hasMany(\App\Models\Notification::class, 'user_id', 'id_user');
    }
}
