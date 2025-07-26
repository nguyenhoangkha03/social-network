<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinNhan extends Model
{
    use HasFactory;

    protected $fillable = [
    'id_user', 'id_chanel', 'receiver_id', 'noidung', 'thoigiantao', 'thoigiancapnhat', 'trangthaixoa', 'image_path'
];

    protected $table = 'tinnhan';
}
