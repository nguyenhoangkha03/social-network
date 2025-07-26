<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DanhSachBanBe;

class DanhSachBanBeSeeder extends Seeder
{
    public function run(): void
    {
        $friendPairs = [
            [1, 2],
            [2, 3],
            [3, 1],
            [4, 2],
        ];
        foreach ($friendPairs as [$a, $b]) {
            if ($a > $b) {
                [$a, $b] = [$b, $a];
            }
            DanhSachBanBe::firstOrCreate([
                'user_id_1' => $a,
                'user_id_2' => $b,
            ]);
        }
    }
} 