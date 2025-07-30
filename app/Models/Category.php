<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Relationship với BaiViet
    public function baiViets()
    {
        return $this->hasMany(BaiViet::class, 'category_id');
    }

    // Relationship với BaiViet đã publish
    public function publishedBaiViets()
    {
        return $this->hasMany(BaiViet::class, 'category_id')->where('is_draft', false);
    }

    // Scope để lấy categories active
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope để sắp xếp theo thứ tự
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Accessor để lấy số lượng bài viết
    public function getPostsCountAttribute()
    {
        return $this->publishedBaiViets()->count();
    }

    // Method để lấy URL category
    public function getUrlAttribute()
    {
        return route('category.show', $this->slug);
    }
}