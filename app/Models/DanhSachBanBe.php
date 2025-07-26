<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhSachBanBe extends Model
{
    protected $table = 'danhsachbanbe';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['user_id_1', 'user_id_2'];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->user_id_1 > $model->user_id_2) {
                [$model->user_id_1, $model->user_id_2] = [$model->user_id_2, $model->user_id_1];
            }
        });
    }
} 