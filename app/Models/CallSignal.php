<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CallSignal extends Model
{
    use HasFactory;

    protected $fillable = [
        'call_id',
        'sender_id',
        'signal_type',
        'signal_data',
        'processed'
    ];

    protected $casts = [
        'signal_data' => 'array',
        'processed' => 'boolean'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }

    public function call()
    {
        return $this->belongsTo(Call::class, 'call_id', 'call_id');
    }

    public function scopeUnprocessed($query)
    {
        return $query->where('processed', false);
    }

    public function scopeForCall($query, $callId)
    {
        return $query->where('call_id', $callId);
    }

    public function scopeNotFromSender($query, $senderId)
    {
        return $query->where('sender_id', '!=', $senderId);
    }

    public function markAsProcessed()
    {
        $this->update(['processed' => true]);
    }
}
