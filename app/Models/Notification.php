<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'data', 'is_read'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
    ];

    public function getMessage()
    {
        switch ($this->type) {
            case 'friend_request':
                return ($this->data['from_user_name'] ?? 'Ai đó') . ' đã gửi lời mời kết bạn cho bạn';
            case 'like':
                return ($this->data['from_user_name'] ?? 'Ai đó') . ' đã thích bài viết của bạn';
            case 'message':
                $fromUser = $this->data['from_user_name'] ?? 'Ai đó';
                $preview = $this->data['message_preview'] ?? 'đã gửi tin nhắn cho bạn';
                return $fromUser . ': ' . $preview;
            case 'comment':
                return ($this->data['from_user_name'] ?? 'Ai đó') . ' đã bình luận bài viết của bạn';
            default:
                return 'Bạn có một thông báo mới';
        }
    }
}
