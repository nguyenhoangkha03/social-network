<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhSachBanBe;

class DanhSachBanBeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id_1' => 'required|integer',
            'user_id_2' => 'required|integer|different:user_id_1',
        ]);
        $a = $request->input('user_id_1');
        $b = $request->input('user_id_2');
        if ($a > $b) {
            [$a, $b] = [$b, $a];
        }
        $friend = DanhSachBanBe::firstOrCreate([
            'user_id_1' => $a,
            'user_id_2' => $b,
        ]);
        return response()->json($friend, 201);
    }
} 