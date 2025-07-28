<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Call extends Model
{
    use HasFactory;

    protected $fillable = [
        'call_id',
        'caller_id',
        'receiver_id',
        'call_type',
        'status',
        'started_at',
        'ended_at',
        'duration_seconds',
        'signaling_data'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'signaling_data' => 'array'
    ];

    public function caller()
    {
        return $this->belongsTo(User::class, 'caller_id', 'user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'user_id');
    }

    public function signals()
    {
        return $this->hasMany(CallSignal::class, 'call_id', 'call_id');
    }

    public function getDurationAttribute()
    {
        if ($this->started_at && $this->ended_at) {
            return $this->started_at->diffInSeconds($this->ended_at);
        }
        return 0;
    }

    public function isActive()
    {
        return in_array($this->status, ['initiating', 'ringing', 'connected']);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['initiating', 'ringing', 'connected']);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('caller_id', $userId)->orWhere('receiver_id', $userId);
        });
    }
}
