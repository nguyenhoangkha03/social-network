<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'follower_id',
        'following_id'
    ];

    // Relationship với User (follower)
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id', 'id_user');
    }

    // Relationship với User (following)
    public function following()
    {
        return $this->belongsTo(User::class, 'following_id', 'id_user');
    }
} 