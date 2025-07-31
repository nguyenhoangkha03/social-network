<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
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
        'trangthai',
        'theme',
        'language',
        'notifications_enabled',
        'email_notifications',
        'privacy_mode'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'notifications_enabled' => 'boolean',
        'email_notifications' => 'boolean',
        'privacy_mode' => 'boolean',
    ];

    // Các quan hệ đã rất đầy đủ
    public function baiviets()
    {
        return $this->hasMany(BaiViet::class, 'user_id', 'user_id');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'follower_id', 'user_id');
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id', 'user_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id', 'user_id', 'user_id');
    }

    public function followersList()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id', 'user_id', 'user_id');
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
        return $this->hasMany(\App\Models\Notification::class, 'user_id', 'user_id');
    }

    // Messaging relationships
    public function sentMessages()
    {
        return $this->hasMany(TinNhan::class, 'user_id', 'user_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(TinNhan::class, 'receiver_id', 'user_id');
    }
}
