<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Công Nghệ',
                'slug' => Str::slug('Công Nghệ'),
                'description' => 'Khám phá xu hướng công nghệ mới',
                'icon' => 'fas fa-laptop-code',
                'color' => '#667eea',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phát triển bản thân',
                'slug' => Str::slug('Phát triển bản thân'),
                'description' => 'Nâng cao kỹ năng và tư duy',
                'icon' => 'fas fa-brain',
                'color' => '#ec4899',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thiết Kế',
                'slug' => Str::slug('Thiết Kế'),
                'description' => 'Sáng tạo và nghệ thuật số',
                'icon' => 'fas fa-paint-brush',
                'color' => '#06b6d4',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kinh Doanh',
                'slug' => Str::slug('Kinh Doanh'),
                'description' => 'Khởi nghiệp và đầu tư',
                'icon' => 'fas fa-chart-line',
                'color' => '#10b981',
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Giáo Dục',
                'slug' => Str::slug('Giáo Dục'),
                'description' => 'Kiến thức và học tập',
                'icon' => 'fas fa-graduation-cap',
                'color' => '#f59e0b',
                'sort_order' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sức Khỏe',
                'slug' => Str::slug('Sức Khỏe'),
                'description' => 'Chăm sóc sức khỏe và đời sống',
                'icon' => 'fas fa-heart',
                'color' => '#ef4444',
                'sort_order' => 6,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Du Lịch',
                'slug' => Str::slug('Du Lịch'),
                'description' => 'Khám phá thế giới xung quanh',
                'icon' => 'fas fa-plane',
                'color' => '#8b5cf6',
                'sort_order' => 7,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ẩm Thực',
                'slug' => Str::slug('Ẩm Thực'),
                'description' => 'Văn hóa ẩm thực đa dạng',
                'icon' => 'fas fa-utensils',
                'color' => '#f97316',
                'sort_order' => 8,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}